<?php
	include ("redirection.php");
?>

<?php echo "<h1>Rubrique ".$_ENV['rubrique_nom']."</h1>"?>

<h4>Rubriques</h4>

<?php
	//on cherche les rubriques qui appartiennent � la rubrique et on les affiche
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
		echo "Il n'y a aucune sous-rubrique dans cette rubrique.";
?>
<br /><h4>Produits</h4>
<?php
	//on cherche si des produits appartiennent � la rubrique et on les affiche
	if (isset($_GET['ordre'])&&($_GET['ordre']="prix"))
		$ordre="`produits_Prix`";
	else 
		$ordre="`produits_Libelle`";
		
	$result_produit = RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits`INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference`=`produit_rubrique`.`produit_reference` WHERE `rubrique_id`=".$_ENV['rubrique_id']." ORDER BY ".$ordre);
	if (mysql_fetch_assoc($result_produit)){
		mysql_data_seek($result_produit,0);
		echo "<table class = 'liste_produits'>\n\t";
		echo "<tr>\n\t\t<th></th>\n\t\t";
		echo "<th><a href='index.php?type=rubrique&id=".$_ENV['rubrique_id']."'>Nom</a></th>\n\t\t";
		echo "<th><a href='index.php?type=rubrique&id=".$_ENV['rubrique_id']."&ordre=prix'>Prix TTC</a></th>\n\t</tr>\n";
		while($row=mysql_fetch_assoc($result_produit)){
			echo "\t<tr>\n\t\t<td class='photo'><a href='index.php?type=produit&id=".$row["produits_Reference"]."'><img src='images/thumbs/".$row["produits_Photo"]."'></a></td>\n\t\t";
			echo "<td><a href='index.php?type=produit&id=".$row["produits_Reference"]."'>".$row["produits_Libelle"]."</a></td>\n\t\t";
			echo "<td class='prix'>".$row["produits_Prix"]." &euro;<a href='index.php?type=panier&produit=".$row['produits_Reference']."'><br /><img src='images/minipanier.jpg'></a></td></tr>\n";
		}
		echo "</table>";
	}
	else
		echo "Il n'y a aucun produit dans cette rubrique."
?>
