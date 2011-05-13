<?php
	
	//affiche le chemin de la rubrique
	//cherche si des rubriques appartiennent à la rubrique et les affiche
	$result = RequeteSQL("SELECT `rubrique_nom` FROM `rubriques` INNER JOIN `rubrique_rubriquesup` ON `rubriques`.`rubrique_id`=`rubrique_rubriquesup`.`rubrique_id` WHERE `rubriquesup_id`=".$_ENV['rubrique_id']." GROUP BY `rubrique_nom`");
	while($row=mysql_fetch_assoc($result)){
		echo $row["rubrique_nom"]."<br />";
	}
	
	//cherche si des produits appartiennent à la rubrique et les affiche
	$result = RequeteSQL("SELECT `produits`.* FROM `produits`INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference`=`produit_rubrique`.`produit_reference` WHERE `rubrique_id`=".$_ENV['rubrique_id']);
	while($row=mysql_fetch_assoc($result)){
		echo $row["produits_Libelle"]."<br />";
	}
?>
