<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GeekProducts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>


<?php
		$connect = mysql_connect("localhost","root","root")
			or die(mysql_error());
		
		$result = mysql_select_db("geekproduct",$connect);	

  // Remarques :
  // L'utilisation de mysql_data_seek($resultat,0) permet de repositionner un "pointeur"
  // en début de résultat d'une interrogation Mysql et permet de re-parcourir les résultats
  // --> utile si le résultat d'une interrogation doit être parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des élèves et des matières

?>

	
<?php include ('entete.php') ?>

<div align="center"><a href="#"><h3 class="lien"><u>Entrer sur le site</u></h3></a></div>

	
<?php include ('pied_de_page.php') ?>



</body>
</html>
