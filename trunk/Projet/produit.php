<?php 
	//On recherche les informations qui concernent le produit
	$result_produit = RequeteSQL("SELECT * FROM `produits` WHERE `produits_reference`=".$_ENV['id']);
	if (mysql_fetch_assoc($result_produit)){
		mysql_data_seek($result_produit,0);		
	
	//On affiche les informations obtenues
	$produit=mysql_fetch_assoc($result_produit);
	echo "<h1>".$produit["produits_Libelle"]."<br /><br />";
	echo "<img src='images/produits/".$produit["produits_Photo"]."'></h1>";
	echo "<table class = 'produit'>";
	echo "<tr><th>Prix</th><td>".$produit["produits_Prix"]."&euro;</td></tr>";
	echo "<tr><th>Référence</th><td>".$produit["produits_Reference"]."</td></tr>";
	echo "<tr><th>Description</th><td>".$produit["produits_Descriptif"]."</td></tr>";
	echo "<tr><th>Unité de vente</th><td>".$produit["produits_UniteDeVente"]."</td></tr>";
	echo "<tr><th>Date d'ajout au catalogue</th><td>".$produit["produits_DateAjout"]."</td></tr>";
	echo "</table>";
	echo "<h4><a href='index.php?type=panier&action=ajout&amp;l=".$produit['produits_Reference']."&amp;q=1' onclick='window.open(this.href, '', 
'toolbar=no, location=no, directories=no, status=yes, scrollbars=yes, resizable=yes, copyhistory=no, width=600, height=350'); return false;'>Ajouter au panier<br /><img src='images/minipanier.jpg'></a></h4>";
	}
	else
		include("404.php");
?>


