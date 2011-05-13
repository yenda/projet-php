<?php
	
	
	//on cherche les rubriques qui appartiennent à la rubrique et on les affiche
	$result_rubrique = RequeteSQL("SELECT `rubrique_nom`,`rubriques`.`rubrique_id` FROM `rubriques` INNER JOIN `rubrique_rubriquesup` ON `rubriques`.`rubrique_id`=`rubrique_rubriquesup`.`rubrique_id` WHERE `rubriquesup_id`=".$_ENV['rubrique_id']." GROUP BY `rubrique_nom`");
	while($row=mysql_fetch_assoc($result_rubrique)){
		$result_nb_produits = RequeteSQL("SELECT * FROM `produits`INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference`=`produit_rubrique`.`produit_reference` WHERE `rubrique_id`=".$row["rubrique_id"]);
		echo '<a href="index.php?type=rubrique&id='.$row['rubrique_id'].'">'.$row['rubrique_nom'].'</a> (';
		echo mysql_num_rows($result_nb_produits)." objets, ";
		echo mysql_num_rows($result_rubrique)." rubriques)<br />";
		
	}
	
	//cherche si des produits appartiennent à la rubrique et les affiche
	$result_produit = RequeteSQL("SELECT `produits`.`produits_Libelle`,`produits`.`produits_Prix` FROM `produits`INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference`=`produit_rubrique`.`produit_reference` WHERE `rubrique_id`=".$_ENV['rubrique_id']);
	while($row=mysql_fetch_assoc($result_produit)){
		echo $row["produits_Libelle"];
		echo " ";
		echo $row["produits_Prix"]." &euro;";
		echo "<br />";
	}
?>
