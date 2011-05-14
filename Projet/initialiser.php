<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Initialisation de la base de donn�e</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>
	<?php
		include 'fonctions.php';
		$connect = mysql_connect("localhost","root","")
			or die(mysql_error());
		
		//Suppression de la base de donn�e si elle existe
		$result=RequeteSQL("DROP DATABASE IF EXISTS geekproduct");

		//Cr�ation de la base de donn�e
		$result=RequeteSQL("CREATE DATABASE geekproduct");

		//Connexion � la base de donn�e
		$result = mysql_select_db("geekproduct",$connect);	
	
		//Cr�ation de la table Produits
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`produits` (
					`produits_Reference` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`produits_Libelle` VARCHAR( 255 ) NOT NULL ,
					`produits_Prix` FLOAT NOT NULL ,
					`produits_UniteDeVente` VARCHAR( 100 ) NOT NULL ,
					`produits_Photo` VARCHAR( 255 ) NOT NULL ,
					`produits_Descriptif` TEXT NOT NULL ,
					`produits_DateAjout` DATE NOT NULL) ENGINE = MYISAM ;");

		//Cr�ation de la table Rubrique
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`rubriques` (
					`rubrique_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
					`rubrique_nom` VARCHAR(100) NOT NULL) ENGINE = MyISAM;");
			
		//Ajout de la rubrique Divers � la table Rubrique
		$result=RequeteSQL("INSERT INTO `geekproduct`.`rubriques` (
						`rubrique_id`, 
						`rubrique_nom`) 
				VALUES (
						NULL, 
						'Divers');");
		
		//Cr�ation de la table Rubriques_RubriqueSup
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`rubrique_rubriquesup` (
					`rubrique_id` INT NOT NULL, 
					`rubriquesup_id` INT NOT NULL) ENGINE = MyISAM;");

		//Cr�ation de la table Produit_Rubrique
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`produit_rubrique` (
					`produit_reference` INT NOT NULL, 
					`rubrique_id` INT NOT NULL) ENGINE = MyISAM;");
		
		//Cr�ation de la table Clients
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`clients` (
					`client_login` VARCHAR(20) NOT NULL, 
					`client_mdp` VARCHAR(20) NOT NULL, 
					`client_nom` VARCHAR(30) NOT NULL, 
					`client_prenom` VARCHAR(30) NOT NULL, 
					`client_datenaissance` DATE NOT NULL, 
					`client_adresse` VARCHAR(70) NOT NULL, 
					`client_codepostal` INT NOT NULL,
					`client_ville` VARCHAR(30) NOT NULL,  
					`client_telephone` VARCHAR(10) NOT NULL, 
					`client_mail` VARCHAR(50) NOT NULL) ENGINE = MyISAM;");
			
		$result = mysql_close($connect)
			or die(mysql_error());
	?>

</body>
</html>