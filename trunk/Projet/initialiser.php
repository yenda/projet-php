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
		
		$result = mysql_query("DROP DATABASE IF EXISTS GeekProduct")
			or die(mysql_error());
		if (!$result)
			echo("La base a été supprimée <br>");
		else
			echo("Aucune base n'a été supprimée<br>");
			
		$result = mysql_query("CREATE DATABASE GeekProduct") 
			or die(mysql_error());
		if (!$result)
			echo("La base n'a pas été créée<br>");
		else
			echo("La base a été créée<br>");
			
		$result = mysql_select_db("GeekProduct",$connect);
		if ($result)
			echo("Connection réussie<br>");
		else
			echo("Connection échouée<br>");		
					
		$query = "CREATE TABLE `GeekProduct`.`Produits` (`Reference` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`Libelle` VARCHAR( 255 ) NOT NULL ,`Prix` INT NOT NULL ,`UniteDeVente` TINYINT NOT NULL ,`Photo` VARCHAR( 255 ) NOT NULL ,`Descriptif` TEXT NOT NULL ,`DateAjout` DATETIME NOT NULL) ENGINE = MYISAM ;" ;
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Produits n'a pas été créée<br>");
		else
			echo("La table Produits a été créée<br>");
			
		$query = "CREATE TABLE `GeekProduct`.`Clients` (`login` VARCHAR(20) NOT NULL, `mdp` VARCHAR(20) NOT NULL, `nom` VARCHAR(30) NOT NULL, `prenom` VARCHAR(30) NOT NULL, `datenaissance` DATE NOT NULL, `num` SMALLINT NOT NULL, `rue` INT NOT NULL, `codepostal` INT NOT NULL, `bancaire` BIGINT NOT NULL, `telephone` VARCHAR(10) NOT NULL, `mail` VARCHAR(50) NOT NULL) ENGINE = MyISAM;";
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table Clients n'a pas été créée<br>");
		else
			echo("La table Clients a été créée<br>");
	?>

</body>
</html>