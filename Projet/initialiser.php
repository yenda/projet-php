<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Initialisation de la base de donn�e</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>
	<?php
		$connect = mysql_connect("localhost","root","root")
			or die(mysql_error());
		
		$result = mysql_query("DROP DATABASE IF EXISTS GeekProduct")
			or die(mysql_error());
		if (!$result)
			echo("La base a �t� supprim�e <br>");
		else
			echo("Aucune base supprim�e<br>");
			
		$result = mysql_query("CREATE DATABASE GeekProduct") 
			or die(mysql_error());
		if (!$result)
			echo("La base n'a pas �t� cr��e<br>");
		else
			echo("La base a �t� cr��e<br>");
			
		$result = mysql_select_db("GeekProduct",$connect);
		if ($result)
			echo("Connection r�ussie<br>");
		else
			echo("Connection �chou�e<br>");		
					
		$query = "CREATE TABLE `GeekProduct`.`RESULTAT` (
					`eleve` VARCHAR( 15 ) NOT NULL ,
					`matiere` VARCHAR( 25 ) NOT NULL ,
					`note` FLOAT( 4, 2 ) NOT NULL ,
					PRIMARY KEY ( `eleve` , `matiere` )
				) ENGINE = MYISAM ;" ;
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table GeekProduct n'a pas �t� cr��e<br>");
		else
			echo("La table GeekProduct a �t� cr��e<br>");
			
		$query = "CREATE TABLE `GeekProduct`.`MATIERE` (
					`intitule` VARCHAR( 25 ) NOT NULL ,
					PRIMARY KEY ( `intitule` )
				) ENGINE = MYISAM ;" ;
		mysql_query($query)
			or die("$query : ".mysql_error()) ;
		if (!$result)
			echo("La table matiere n'a pas �t� cr��e<br>");
		else
			echo("La table matiere a �t� cr��e<br>");
					
		$query = "CREATE TABLE `GeekProduct`.`ELEVE` (
					`prenom` VARCHAR( 15 ) NOT NULL ,
					PRIMARY KEY ( `prenom` )
				) ENGINE = MYISAM ;" ;
		if (!$result)
			echo("La table eleve n'a pas �t� cr��e<br>");
		else
			echo("La table eleve a �t� cr��e<br>");
		mysql_query($query)
			or die("$query : ".mysql_error()) ;

	?>

</body>
</html>