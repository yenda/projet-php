<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Initialisation de la base de donnée</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>
	<?php
		$connect = mysql_connect("localhost","root","root")
			or die(mysql_error());
		
		$result = mysql_query("DROP DATABASE IF EXISTS geekproduct")
			or die(mysql_error());
		if ($result)
			echo("La base a été supprimée <br />");
		else
			echo("Aucune base n'a été supprimée<br />");
			
		$result = mysql_query("CREATE DATABASE geekproduct") 
			or die(mysql_error());
		if (!$result)
			echo("La base n'a pas été créée<br />");
		else
			echo("La base a été créée<br />");
			
		$result = mysql_select_db("geekproduct",$connect);
		if ($result)
			echo("Connection réussie<br />");
		else
			echo("Connection échouée<br />");		
	
		$query = "CREATE TABLE `geekproduct`.`produits` (
					`produits_Reference` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`produits_Libelle` VARCHAR( 255 ) NOT NULL ,
					`produits_Prix` FLOAT NOT NULL ,
					`produits_UniteDeVente` VARCHAR( 100 ) NOT NULL ,
					`produits_Photo` VARCHAR( 255 ) NOT NULL ,
					`produits_Descriptif` TEXT NOT NULL ,
					`produits_DateAjout` DATE NOT NULL) ENGINE = MYISAM ;";
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Produits n'a pas été créée<br />");
		else
			echo("La table Produits a été créée<br />");
			
		$query = "CREATE TABLE `geekproduct`.`rubriques` (
					`rubrique_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
					`rubrique_nom` VARCHAR(100) NOT NULL) ENGINE = MyISAM;";
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Rubriques n'a pas été créée<br />");
		else
			echo("La table Rubriques a été créée<br />");
			
		$query = "INSERT INTO `geekproduct`.`rubriques` (
						`rubrique_id`, 
						`rubrique_nom`) 
				VALUES (
						NULL, 
						'Divers');";
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La rubrique Divers a été ajoutée à la table Rubrique");
		else
			echo("La rubrique Divers a été ajoutée à la table Rubrique<br />");
			
		$query = "CREATE TABLE `geekproduct`.`rubrique_rubriquesup` (
					`rubrique_id` INT NOT NULL, 
					`rubriquesup_id` INT NOT NULL) ENGINE = MyISAM;";		
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Rubriques_RubriqueSup n'a pas été créée<br />");
		else
			echo("La table Rubriques_RubriqueSup a été créée<br />");
									
		$query = "CREATE TABLE `geekproduct`.`produit_rubrique` (
					`ID_produit` INT NOT NULL, 
					`ID_rubrique` INT NOT NULL) ENGINE = MyISAM;";		
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Produit_Rubrique n'a pas été créée<br />");
		else
			echo("La table Produit_Rubrique a été créée<br />");
			
		$query = "CREATE TABLE `geekproduct`.`clients` (
					`client_login` VARCHAR(20) NOT NULL, 
					`client_mdp` VARCHAR(20) NOT NULL, 
					`client_nom` VARCHAR(30) NOT NULL, 
					`client_prenom` VARCHAR(30) NOT NULL, 
					`client_datenaissance` DATE NOT NULL, 
					`client_num` SMALLINT NOT NULL, 
					`client_rue` INT NOT NULL, 
					`client_codepostal` INT NOT NULL, 
					`client_bancaire` BIGINT NOT NULL, 
					`client_telephone` VARCHAR(10) NOT NULL, 
					`client_mail` VARCHAR(50) NOT NULL) ENGINE = MyISAM;";
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Clients n'a pas été créée<br />");
		else
			echo("La table Clients a été créée<br />");
			
		$result = mysql_close($connect);
		if ($result)
			echo("Fermeture de la connection<br />");
		else
			echo("Echec de la fermeture de connection<br />");
	?>

</body>
</html>