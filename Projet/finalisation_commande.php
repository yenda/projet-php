<?php
	include ("redirection.php");
?>

<?php 
	//On vérifie que le client est loggué avant de le laisser finaliser sa commande
	if (isset($_SESSION['login'])){
?>

<?php	
	//On affiche le panier sauf si il est vide
	$nbArticles=count($_SESSION['panier']['produits_Reference']);
	if ($nbArticles <= 0)
		echo "<br /><br />Il n'y a aucun produit dans le panier";
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
	$infos=RequeteSQL("SELECT `client_adresse`,`client_codepostal`,`client_ville`,`client_cartebancaire` FROM `clients` WHERE `client_login` = '".$_SESSION['login']."'");
	if($adresse=mysql_result($infos,0,"client_adresse")){
		$adresse.=" ";
		$adresse.=mysql_result($infos,0,"client_codepostal");
		$adresse.=" ";
		$adresse.=mysql_result($infos,0,"client_ville");
	}
		echo '<input type="radio" name="adresse" value="'.$adresse.'" id="adresse1" /> <label for="adresse1">'.$adresse.'</label><br />';
?>	
	<input type="radio" name="adresse" value="" id="adresse2" /> <label for="adresse2">Choisir adresse</label><br />
		
<h3>Choisissez le type de paiement</h3>
<?php 
	if($carte=mysql_result($infos,0,"client_cartebancaire"))
		echo '<input type="radio" name="carte" value="'.$carte.'" id="carte1" /> <label for="carte1">'.$carte.'</label><br />';
?>
	<input type="radio" name="carte" value="" id="carte2" /> <label for="carte1">Choisir carte</label><br />
</form>

<h1>
	
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
