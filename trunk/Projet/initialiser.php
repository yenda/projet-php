<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Initialisation de la base de donnée</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>
	<?php
		include 'fonctions.php';
		$connect = mysql_connect("localhost","root","")
			or die(mysql_error());
		
		//Suppression de la base de donnée si elle existe
		$result=RequeteSQL("DROP DATABASE IF EXISTS geekproduct");

		//Création de la base de donnée
		$result=RequeteSQL("CREATE DATABASE geekproduct");

		//Connexion à la base de donnée
		$result = mysql_select_db("geekproduct",$connect);	
	
		//Création de la table Produits
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`produits` (
					`produits_Reference` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`produits_Libelle` VARCHAR( 255 ) NOT NULL ,
					`produits_Prix` FLOAT NOT NULL ,
					`produits_UniteDeVente` VARCHAR( 100 ) NOT NULL ,
					`produits_Photo` VARCHAR( 255 ) NOT NULL ,
					`produits_Descriptif` TEXT NOT NULL ,
					`produits_DateAjout` DATE NOT NULL) ENGINE = MYISAM ;");

		//Création de la table Rubrique
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`rubriques` (
					`rubrique_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
					`rubrique_nom` VARCHAR(100) NOT NULL) ENGINE = MyISAM;");
			
		//Ajout de la rubrique Divers à la table Rubrique
		$result=RequeteSQL("INSERT INTO `geekproduct`.`rubriques` (
						`rubrique_id`, 
						`rubrique_nom`) 
				VALUES (
						NULL, 
						'Divers');");
		
		//Création de la table Rubriques_RubriqueSup
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`rubrique_rubriquesup` (
					`rubrique_id` INT NOT NULL, 
					`rubriquesup_id` INT NOT NULL) ENGINE = MyISAM;");

		//Création de la table Produit_Rubrique
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`produit_rubrique` (
					`produit_reference` BIGINT NOT NULL, 
					`rubrique_id` INT NOT NULL) ENGINE = MyISAM;");
		
		//Création de la table Clients
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`clients` (
					`client_login` VARCHAR(20) NOT NULL PRIMARY KEY, 
					`client_mdp` VARCHAR(20) NOT NULL, 
					`client_nom` VARCHAR(30) NOT NULL, 
					`client_prenom` VARCHAR(30) NOT NULL, 
					`client_datenaissance` DATE NOT NULL, 
					`client_adresse` VARCHAR(100) NOT NULL, 
					`client_codepostal` INT NOT NULL,
					`client_ville` VARCHAR(30) NOT NULL,  
					`client_telephone` VARCHAR(10) NOT NULL, 
					`client_mail` VARCHAR(50) NOT NULL,
					`client_cartebancaire` INT NOT NULL) ENGINE = MyISAM;");
		$result=RequeteSQL("INSERT INTO `geekproduct`.`clients` (`client_login`, `client_mdp`, `client_nom`, `client_prenom`, `client_datenaissance`, `client_adresse`, `client_codepostal`, `client_ville`, `client_telephone`, `client_mail`, `client_cartebancaire`) VALUES ('admin', 'admin', 'Administrateur', 'Administrateur', '', '', '', '', '', '', '');");
		
		//Création de la table Panier_Client
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`panier_client` (
					`panier_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					`client_login` VARCHAR(20) NOT NULL) ENGINE = MyISAM;");
		
		//Création de la table Panier_Client
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`panier_produit` (
					`panier_id` BIGINT NOT NULL, 
					`produit_reference` BIGINT NOT NULL) ENGINE = MyISAM;");
		
		$result = mysql_close($connect)
			or die(mysql_error());
		
	?>
	
</body>
</html>