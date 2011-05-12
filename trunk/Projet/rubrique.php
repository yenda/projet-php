<?php
	//affiche le chemin de la rubrique
	//cherche si des rubriques appartiennent à la rubrique et les affiche
	$result = RequeteSQL("SELECT `produit`.* FROM `produits`INNER JOIN `produit_rubrique` ON `produits.produit_Reference`='produit_rubrique.produit_reference` WHERE `produit_rubrique.rubrique_id` = ".$_ENV['rubrique_id']);
	while($row=mysql_fetch_assoc($result)){
		echo $row["produit_nom"]."<br />";
	}
	
	//cherche si des produits appartiennent à la rubrique et les affiche
?>
