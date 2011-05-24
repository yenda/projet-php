<?php
	//Les pages réservées à l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_ENV['type']))||(!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
	if (isset($_GET['panier'])){
		$panier=intval($_GET['panier']);		
		$produits = RequeteSQL("SELECT `produits`.`produits_Reference`,`produits_Libelle`,`produits_Quantite` FROM `produits` INNER JOIN `panier_produit` ON `panier_produit`.`produits_Reference`=`produits`.`produits_Reference` WHERE `panier_id`=$panier");
	
	echo "<h1>Commande n° $panier</h1>";
?>
<h4>Liste des produits</h4>
<table class='caddie'>
	<tr>
		<th>Référence du produit</th>
		<th>Nom du produit</th>
		<th>Quantité</th>
	</tr>
<?php 	
		//On affiche les produits qui sont dans la commande
		while ($produit=mysql_fetch_assoc($produits)){
			echo "<tr>";
			echo "<td>".$produit["produits_Reference"]."</td>";
			echo "<td>".$produit["produits_Libelle"]."</td>";
			echo "<td>".$produit["produits_Quantite"]."</td>";
			echo "<tr>";
		}
?>
</table>
<h4>Information commande</h4>
<?php 
	//On affiche les informations qui concernent le panier
	$panier=RequeteSQL("SELECT * FROM `panier_client` WHERE `panier_id`=$panier");
	echo "<b>ID du client :</b> ".mysql_result($panier,0,'client_login')."<br /><br />";
	echo "<b>Montant total de la commande :</b> ".mysql_result($panier,0,'total')." &euro;";
	echo "<br /><br />";
	echo "<b>Addresse de livraison :</b><br />";
	echo mysql_result($panier,0,'client_nom')."<br />";
	echo mysql_result($panier,0,'client_prenom')."<br />";
	echo mysql_result($panier,0,'client_adresse')."<br />";
	echo mysql_result($panier,0,'client_codepostal')." ".mysql_result($panier,0,'client_ville');
	echo "<br /><br />";
	echo "<b>Mode de livraison :</b><br />";
	echo mysql_result($panier,0,'livraison');
	echo "<br /><br />";
	echo "<b>Mode de payement :</b><br />";
	echo mysql_result($panier,0,'client_cartebancaire');
	
	 
?>
<h4><a href="index.php?type=visualiser_commandes">Retour commandes</a></h4>
<?php
	}
	else{
?>

	<h1>Visualisation des commandes</h1>
<?php 
		//On récupère tout les paniers et on les classe par date
		$paniers = RequeteSQL("SELECT `client_login`,`panier_id`,`total`,`date` FROM `panier_client` ORDER BY `date` DESC");
		if (mysql_fetch_assoc($paniers)){
			mysql_data_seek($paniers,0);
?>
Cliquer sur le prix pour afficher le panier<br /><br />
<table class='caddie'>
	<tr>
		<th>Date</th>
		<th>Client</th>
		<th>Total</th>
	</tr>
<?php 
			//On affiche les paniers avec un lien vers le panier correspondant sur le prix
			while($panier=mysql_fetch_assoc($paniers)){
					echo "<tr>";
					$date=explode("-" ,$panier["date"]);
					echo "<td>".$date[2]."-".$date[1]."-".$date[0]."</td>";
					echo "<td>".$panier["client_login"]."</td>";
					echo "<td><a href='index.php?type=visualiser_commandes&panier=".$panier["panier_id"]."'>".$panier["total"]." &euro;</a></td>";
					echo "</tr>";
			}
?>
</table>
<?php
		}
		else
			echo "<div class='alert'>Il n'y a aucune commande</div>";
	}}
?>
<h4><a href="index.php?type=admin">Retour administration</a></h4>