<?php
	include ("redirection.php");
?>

<?php 
	//On v�rifie que le client est loggu� avant de le laisser finaliser sa commande
	if (isset($_SESSION['login'])){
?>

<?php	
	//On affiche le panier sauf si il est vide
	$nbArticles=count($_SESSION['panier']['produits_Reference']);
	if ($nbArticles <= 0)
		echo "<br /><br />Il n'y a aucun produit dans le panier";
	else{
?>
	<h1>Votre commande a �t� valid�e !</h1>
	<table class="caddie">
		<tr>
			<th>Libell�</th>
			<th>Prix � l'unit�</th>
			<th>Quantit�</th>
		</tr>
<?php 
      	$_SESSION['panier']['total'] = 0;
      	//On effectue une requ�te SQL qui renvoit la ligne de la table produits de tout les produits du panier
		$requete = "SELECT * FROM `produits` WHERE 0";
		foreach($_SESSION['panier']['produits_Reference'] as $reference){
			$requete .= "|| `produits_Reference` = ".$reference;			
		}
		$result=RequeteSQL($requete);
		//On exploite le r�sultat de la requ�te pour afficher le contenu du panier
		while($row=mysql_fetch_assoc($result)){
			echo "<tr>";
			echo "<td><a href='index.php?type=produit&id=".$row['produits_Reference']."'>".$row['produits_Libelle']."</a></td>";
			echo "<td>".$row['produits_Prix']." &euro;</td>";
			//On recherche la r�f�rence du produit dans le tableau panier pour pouvoir afficher la bonne quantit�
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
<h3>Type de livraison</h3>
<?php
	if ($_POST['livraison']=="colissimo"){
		$livraison = "Colissimo";
		$total = $_SESSION['panier']['total']+10;
	}
	else{
		$livraison = "Chronopost";
		$total = $_SESSION['panier']['total']+20;
	}
	echo $livraison;
?>
<h3>Adresse de livraison</h3>
<?php
	echo $_POST['nom'];
	echo "<br />";
	echo $_POST['prenom'];
	echo "<br />";
	echo $_POST['adresse'];
	echo "<br />";
	echo $_POST['codepostal'];
	echo "<br />";
	echo $_POST['ville'];
?>
		
<h3>Num�ro de carte bancaire</h3>
<?php 
	echo $_POST['carte'];
?>
</form>

<h3>Total de la commande</h3>
<?php
	echo $total." &euro;";
?>

<h1>
	<form method="post" action="index.php">
		<input type="submit" value="Retourner � l'accueil"/>
	</form>
</h1>
<?php 
	}}
	//Si il n'y a pas de commande � valider (le client a acc�d� � la page via l'URL)
	else{
?>
		<div class='alert'>Aucune commande � valider</div>
		<h4><a href="index.php?type=inscription">Retourner � l'accueil</a><br />
<?php
	}
?>
