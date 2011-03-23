<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Enregistrement d'un résultat</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>

<?php
	function AjouterProduitBase($Produit)
	{
	    echo ("Produit ajouté<br>");
	}
	
	//$eleve = $_POST['eleve'];
	//$matiere = $_POST['matiere'];
	//$note = $_POST['note'];
	
	$connect = mysql_connect("localhost","root","root")
		or die(mysql_error());
	
	$result = mysql_select_db("GeekProduct",$connect)
		or die(mysql_error());
		
	$xmlParametres = simplexml_load_file("Parametres.xml");
	
?>

<?php
	if (!sizeof($xmlParametres))
		echo ("Le document est vide<br>");
		
	$xmlListeProduits = $xmlParametres->ListeProduits;
	$xmlListeRubriques = $xmlParametres->ListeRubriques;
	
	$xmlProduits = $xmlListeProduits->children();
	$xmlRubriques = $xmlListeRubriques->children();
	
	if (!sizeof($xmlProduits))
		echo ("aucun produit<br>");
	else{
		foreach ($xmlProduits as $Produit){
			AjouterProduitBase($Produit);
		}
	}
	if (!sizeof($xmlRubriques))
		echo ("aucune rubrique<br>");	
	else{
		echo ("il y a des rubriques<br>");
	}


	
	/*$query = "REPLACE INTO Produit VALUES ('NULL' , 'Barre de Faire', '3333', '1', 'barredefer.jpg', 'qdhqioghmqoisghqoighmoisdqgh', '2011-03-23 16:18:58')";
	$result = mysql_query($query)
		or die(mysql_error());
	
	if(mysql_affected_rows()==1)
		echo "La  a été ajoutée";
	else
		echo "La  a été modifiée";*/
?>

</body>
</html>