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
  // utile si le résultat d'une interrogation doit être parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des élèves et des matières

?>

	
<div align="center"><h2>GeekProducts : la boutique en ligne</h2></div>

<div id="menu">
	<a href="#">Accueil</a>
	<ul>
		<li>blabla
			<ul>Catégorie 1</ul>
			<ul>Catégorie 2</ul>
		</li>
	</ul>
</div>

<div id="contenu">
	Voici le contenu du site. Nous vendons des produits informatique
</div>


<div align="center">	
	<div id="bas">
		<div align="center">GNU GPL V3 Créateurs Eric Dvorsak, Maël Clesse</div>
	</div>
</div>
</body>
</html>
