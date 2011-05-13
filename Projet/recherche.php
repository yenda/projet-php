<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Recherche</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>

<?php
	$connect = mysql_connect("localhost","root","")
		or die(mysql_error());
	
	$result = mysql_select_db("GeekProduct",$connect)
		or die(mysql_error());
	
?>

<?php 
if (isset($_POST['recherche']))
{
	if ((empty($_POST['recherche']))||(!is_string($_POST['recherche'])))
	{
		echo "Vous devez saisir des mots clés pour votre recherche";
	}
	else 
	{
		//faire une requête MySQL qui trouves les produits dont le nom contient un ou plusieurs
		//mot(s)-clé(s) et les afficher
	}
}
?>

<p>Saisissez les termes à rechercher sur le site</p>

<div id="recherche">
	<form method="post" action="recherche.php">
		<input name="recherche" type="text" id="recherche" style="height:20px; font-size:13px; width:200px;" value="" maxlength="50" />
		<input type='submit' name='Submit' value='Rechercher'/> 
	</form>
</div>