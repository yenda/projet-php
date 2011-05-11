<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GeekProducts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>

<?php
		include 'fonctions.php';
		include 'fonctions_menu.php'
		$connect = mysql_connect("localhost","root","")
			or die(mysql_error());
		
		$result = ConnexionDB();	

  // Remarques :
  // L'utilisation de mysql_data_seek($resultat,0) permet de repositionner un "pointeur"
  // en début de résultat d'une interrogation Mysql et permet de re-parcourir les résultats
  // utile si le résultat d'une interrogation doit être parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des élèves et des matières

?>

<div id="page">

<div id="haut">
	<a href="index.php"></a><img src="images/geekproducts.bmp" height="101px" width="200px"></a>
	<textarea style="width=100px" style="height=30px" rows="1" maxlength="50">Recherche</textarea> 
	<input type="button" name="lien1" value="Ok" onclick="self.location.href='lien.html'" style="background-color:white" style="color:white; font-weight:bold"onclick></input> 
</div>


<div id="menu">
	<?php echo Menu();?>
</div>

<div id="contenu">
	Voici le contenu du site. Nous vendons des produits informatique
</div>


<div align="center">	
	<div id="bas">
		<div align="center">GNU GPL V3 Créateurs Eric Dvorsak, Maël Clesse</div>
	</div>
</div>
</div>
</body>
</html>
