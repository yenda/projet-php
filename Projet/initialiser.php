<?php
	//Ces lignes permettent lors de la première execution du script sur un serveur
	//d'initialiser la base de donnée en lançant la page intialiser.php dans la barre d'URL
	//Une fois que la base de donnée a été créée il n'est plus possible d'initialiser de cette manière, l'utilisateur
	//doit alors avoir des droits d'administrateur
	include_once ('fonctions.php');
	$connect = mysql_connect("localhost","root","");
	if ((mysql_select_db("geekproduct",$connect))&&((!isset($_SESSION['login']))||($_SESSION['login']!="admin"))){
		header('Location: index.php&type=404');  
		exit();
	}
?>
<h1>Initialisation de la base</h1>
<?php
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
		$result=RequeteSQL("INSERT INTO `geekproduct`.`clients` (`client_login`, `client_mdp`, `client_nom`, `client_prenom`, `client_datenaissance`, `client_adresse`, `client_codepostal`, `client_ville`, `client_telephone`, `client_mail`, `client_cartebancaire`) VALUES ('admin', 'admin', '', '', '', '', '', '', '', '', '');");
		
		//Création de la table Panier_Client
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`panier_client` (
					`panier_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					`client_login` VARCHAR(20) NOT NULL) ENGINE = MyISAM;");
		
		//Création de la table Panier_Client
		$result=RequeteSQL("CREATE TABLE `geekproduct`.`panier_produit` (
					`panier_id` BIGINT NOT NULL, 
					`produits_Reference` BIGINT NOT NULL,
					`produits_Quantite` INT NOT NULL) ENGINE = MyISAM;");
	
		
	?>
	
	<div class='alert'>La base de donnée a été initialisée</div>
	<br />
	<h4><a href="index.php?type=admin">Retour à la page d'administration</a></h4>

<?php 
	if (!isset($_SESSION['login'])){
		header('Location: index.php?type='.$_GET["type"].'');  
		exit();
	}
?>