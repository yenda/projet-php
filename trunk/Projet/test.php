<?php
	foreach ($_SESSION['panier']['produits_Reference'] as $i=>$produit){
		echo $produit;
		echo "<br />";
		echo $_SESSION['panier']['produits_Quantite'][$i];
		echo "<br />";
	}
?>