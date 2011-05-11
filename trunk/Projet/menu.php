<?php
	include 'fonctions.php';
	
	$connect = ConnexionDB();
	
	$result = RequeteSQL("SELECT `rubrique_nom` FROM `rubriques` WHERE `rubrique_id` in (SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id` = 0) ORDER BY `rubrique_nom`");
	while ($row=mysql_fetch_assoc($result)){
		$rubrique_nom = $row["rubrique_nom"];
		echo "$rubrique_nom<br />";
	}
	
	DeconnexionDB($connect);
?>