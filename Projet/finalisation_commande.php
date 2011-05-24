<?php
	include ("redirection.php");
?>

<?php 
	//On vérifie que le client est loggué avant de le laisser finaliser sa commande
	if (isset($_SESSION['login'])){
		$nbArticles=count($_SESSION['panier']['produits_Reference']);
		if ($nbArticles <= 0)
			echo "<br /><br />Votre panier est vide";
	else{	
?>

	<h1>Votre commande</h1>
	<table class="caddie">
		<tr>
			<th>Libellé</th>
			<th>Prix à l'unité</th>
			<th>Quantité</th>
		</tr>
<?php 
      	$_SESSION['panier']['total'] = 0;
      	//On effectue une requête SQL qui renvoit la ligne de la table produits de tout les produits du panier
		$requete = "SELECT * FROM `produits` WHERE 0";
		foreach($_SESSION['panier']['produits_Reference'] as $reference){
			$requete .= "|| `produits_Reference` = ".$reference;			
		}
		$result=RequeteSQL($requete);
		//On exploite le résultat de la requête pour afficher le contenu du panier
		while($row=mysql_fetch_assoc($result)){
			echo "<tr>";
			echo "<td><a href='index.php?type=produit&id=".$row['produits_Reference']."'>".$row['produits_Libelle']."</a></td>";
			echo "<td>".$row['produits_Prix']." &euro;</td>";
			//On recherche la référence du produit dans le tableau panier pour pouvoir afficher la bonne quantité
			$i = array_search($row['produits_Reference'],  $_SESSION['panier']['produits_Reference']);
			echo "<td>".$_SESSION['panier']['produits_Quantite'][$i]."</td>";

			$_SESSION['panier']['total'] += $row['produits_Prix']*$_SESSION['panier']['produits_Quantite'][$i];
			echo "</tr>";
		}
?>
		<tr>
			<td>
			</td>
			<td>
				Total : <?php echo $_SESSION['panier']['total'];?> &euro;
			</td>
			<td>
			</td>
		</tr>
		
</table>

<form method="post" action="index.php?type=validation_commande">
<h3>Choisissez le type de livraison</h3>
	   <input type="radio" name="livraison" value="colissimo" id="colissimo" /> <label for="colissimo">Livraison par Colissimo (+ 10 &euro;)</label><br />
       <input type="radio" name="livraison" value="chronopost" id="chronopost" /> <label for="chronopost">Livraison par Chronopost (+ 20 &euro;)</label><br />
<h3>Choisissez l'adresse de livraison</h3>
<?php
	$infos=RequeteSQL("SELECT `client_adresse`,`client_nom`,`client_prenom`,`client_codepostal`,`client_ville`,`client_cartebancaire` FROM `clients` WHERE `client_login` = '".$_SESSION['login']."'");

	echo '<label for="nom">Nom</label><br />';
	echo '<input type="text" name="nom" value="'.mysql_result($infos,0,"client_nom").'" style="width:300px;" /><br />';
	echo '<label for="prenom">Prénom</label><br />';
	echo '<input type="text" name="prenom" value="'.mysql_result($infos,0,"client_prenom").'" style="width:300px;" /><br />';
	echo '<label for="adresse">Adresse</label><br />';
	echo '<input type="text" name="adresse" value="'.mysql_result($infos,0,"client_adresse").'" style="width:300px;" /><br />';
	echo '<label for="codepostal">Code Postal</label><br />';
	echo '<input type="text" name="codepostal" value="'.mysql_result($infos,0,"client_codepostal").'" style="width:300px;" /><br />';
	echo '<label for="ville">Ville</label><br />';
	echo '<input type="text" name="ville" value="'.mysql_result($infos,0,"client_ville").'" style="width:300px;" /><br />';
	
?>			
<h3>Choisissez le type de paiement</h3>
<?php 
	$carte=mysql_result($infos,0,"client_cartebancaire");
	echo '<input type="text" name="carte" value="'.$carte.'" style="width:300px;" />';
?>
<h1>
	<input type='submit' value='Valider la commande'/>
</form>
</h1>
<?php 
	}}
	//Si le client n'est pas logué
	else{
?>
		<div class='alert'>Vous devez être loggué pour pouvoir finaliser la commande</div>
		<h4><a href="index.php?type=inscription">Inscription</a><br />
		<a href="index.php?type=login">Connexion</a></h4>
<?php
	}
?>
