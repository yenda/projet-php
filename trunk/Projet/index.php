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
  // en d�but de r�sultat d'une interrogation Mysql et permet de re-parcourir les r�sultats
  // utile si le r�sultat d'une interrogation doit �tre parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des �l�ves et des mati�res

?>

	
<div align="center"><h1>GeekProducts : la boutique en ligne</h1></div>

<?php include ('menu.php') ?>



	

GNU GPL V3 Cr�ateurs Eric Dvorsak, Ma�l Clesse


</body>
</html>
