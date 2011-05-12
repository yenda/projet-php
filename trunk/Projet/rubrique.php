<?php
	//affiche le chemin de la rubrique
	//cherche si des rubriques appartiennent à la rubrique et les affiche
	$result = RequeteSQL("SELECT * FROM `rubriques`,`produit_rubrique` WHERE `rubrique_id` = ".$_ENV['rubrique_id']);
	
	//cherche si des produits appartiennent à la rubrique et les affiche
?>
