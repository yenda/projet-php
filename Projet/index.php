<?php 
	include 'fonctions.php';
	include 'fonctions_menu.php';

	$connect = ConnexionDB();
	Recuperation_infos();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GeekProducts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<script type="text/javascript" src="jquery-1.3.2.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	

</head>

<body>

<div id="page">

<div id="haut">
	<a href="index.php"><img src="images/logo.gif" height="101px" width="200px" alt="GeekProducts" title="GeekProducts"></a>
	<input type="text" value= /> 
	<input type="submit" name="lien1" value="Ok" onclick="self.location.href='page_a_definir.php'" style="background-color:white" style="color:white; font-weight:bold"onclick></input> 
</div>


<div id="menu">
	<div class="boxTitleRight">Catégories</div>
	<?php echo Menu();?>
	
</div>

<div id="contenu">
	<?php
		if ($_ENV['type']=="index")
			include("accueil.php");
		elseif ($_ENV['type']=="rubrique")
			include("rubrique.php");
		elseif ($_ENV['type']=="rubrique")
			include("produit.php");
		else
			include("404.php");

	?>
</div>

	
	<div id="bas" align="center">
		GNU GPL V3 Créateurs Eric Dvorsak, Maël Clesse
	</div>
</div>
	<?php DeconnexionDB($connect);?>
</body>
</html>
