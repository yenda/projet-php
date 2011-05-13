<?php
	
	
	//on cherche les rubriques qui appartiennent à la rubrique et on les affiche
	$result_rubrique = RequeteSQL("SELECT `rubrique_nom`,`rubriques`.`rubrique_id` FROM `rubriques` INNER JOIN `rubrique_rubriquesup` ON `rubriques`.`rubrique_id`=`rubrique_rubriquesup`.`rubrique_id` WHERE `rubriquesup_id`=".$_ENV['rubrique_id']." GROUP BY `rubrique_nom`");
	
	if (mysql_fetch_assoc($result_rubrique)){
		mysql_data_seek($result_rubrique,0);
		$cat = "";
		while($row=mysql_fetch_assoc($result_rubrique)){
			$result_nb_produits = RequeteSQL("SELECT * FROM `produits`INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference`=`produit_rubrique`.`produit_reference` WHERE `rubrique_id`=".$row["rubrique_id"]);
			$result_nb_rubriques = RequeteSQL("SELECT * FROM `rubrique_rubriquesup` WHERE `rubriquesup_id`=".$row['rubrique_id']);
			$cat .= '<a href="index.php?type=rubrique&id='.$row['rubrique_id'].'">'.$row['rubrique_nom'].'</a> (';
			$cat .= mysql_num_rows($result_nb_produits)." objet";
			if (mysql_num_rows($result_nb_produits)>1)
				$cat .= "s";
			$cat .= ", ".mysql_num_rows($result_nb_rubriques)." rubrique";
			if (mysql_num_rows($result_nb_rubriques)>1)
				$cat .= "s";
			$cat .= "), ";	
		}
	}
	if (isset($cat))
		echo substr($cat, 0, -2).".";
	else
		echo "Il n'y a aucune sous-rubrique dans cette rubrique."
?>
<br /><br />
<?php
	//cherche si des produits appartiennent à la rubrique et les affiche
	$result_produit = RequeteSQL("SELECT `produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits`INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference`=`produit_rubrique`.`produit_reference` WHERE `rubrique_id`=".$_ENV['rubrique_id']);
	if (mysql_fetch_assoc($result_produit)){
		mysql_data_seek($result_produit,0);
		echo "<table class = 'liste_produits'><tr><th></th><th>Nom</th><th>Prix TTC</th></tr>";
		while($row=mysql_fetch_assoc($result_produit)){
			echo "<tr><td width='100px' height='100px'>";
			echo "<img src='images/thumbs/".$row["produits_Photo"]."'>";
			echo "</td>";
			echo "<td>".$row["produits_Libelle"]."</td>";
			echo "<td>".$row["produits_Prix"]." &euro;</td>";
		}
		echo "</table>";
	}
?>
