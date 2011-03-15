<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Enregistrement d'un résultat</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>

<?php
	$eleve = $_POST['eleve'];
	$matiere = $_POST['matiere'];
	
	$connect = mysql_connect("localhost","root","root")
		or die(mysql_error());
	
	$result = mysql_select_db("partiel",$connect)
		or die(mysql_error());
	
	$query = "DELETE FROM RESULTAT WHERE eleve=\"$eleve\" AND matiere=\"$matiere\"";
	$result = mysql_query($query)
		or die(mysql_error());
	
	if(mysql_affected_rows()==1)
		echo "La note de ".$eleve." en ".$matiere." a été supprimée";
	else
		echo "Aucune note n'a été supprimée";
?>

</body>
</html>