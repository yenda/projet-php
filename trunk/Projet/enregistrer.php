<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>enregistrement de la bdd</title>
		<meta http-equiv="Content-Type" content="text/html ; charset=iso-8859-1"/>
	</head>

<body>

<?php
$test = "pêde";
echo ("$test");
html_entity_decode($test);
echo ("$test");
	//PossibilitÃ© d'ajouter ici des conditions si le xml contient des unitÃ©s de vente particuliÃ¨res
	//ici sont reconnu l'unitÃ© et tout ce qui contient un nombre, ce nombre Ã©tant l'unitÃ© de vente
	function ConvertirUniteDeVente($Attribut){
		if ($Attribut == "l'unité")
			$UniteDeVente = "1";
		else{
			preg_match("/[0-9]+/", $Attribut,$regs);
			$UniteDeVente = $regs[0];
		}
		return $UniteDeVente; 
	}
	
	function ConvertirPrix($Attribut){
		preg_match("/([0-9]+)[;.,]([0-9]{2})/", $Attribut,$regs);
		$Prix = $regs[1]*100+$regs[2];
		return $Prix;
	}
	
	/**Cette fonction parcourt l'ensemble des Attributs d'un produit et les place dans des variables Ã©ponymes
	 * Une fois la collecte terminÃ©e il effectue une requÃªte INSERT INTO pour ajouter le produit Ã  la base
	 * REPLACE INTO est inutile dans la mesure oÃ¹ on fait ici le remplissage initial de la base avec une rÃ©fÃ©rence diffÃ©rente
	 * pour chaque nouveau produit
	 */
	function AjouterProduitBase($Produit){
		foreach($Produit as $Attribut){
			if ($Attribut->getname() == "Propriete"){
				$Propriete = $Attribut->attributes();
				if ($Propriete == "Libelle")
					$Libelle=html_entity_decode($Attribut);
				elseif ($Propriete == "Prix")
					$Prix=ConvertirPrix($Attribut);
				elseif ($Propriete == "UniteDeVente")
					$UniteDeVente=ConvertirUniteDeVente($Attribut);
				elseif ($Propriete == "Photo")
					$Photo=$Attribut;
				else
					echo ("La propriété $Attribut est inconnue est ne peut être ajoutée à la base<br>");																			
			}
			elseif ($Attribut->getname() == "Descriptif")
				$Descriptif = html_entity_decode($Attribut);
		}
		$query = "INSERT INTO Produit VALUES (NULL, '$Libelle', '$Prix', '$UniteDeVente', '$Photo', '$Descriptif', '2011-03-23 16:18:58');";
		$result = mysql_query($query)
			or die(mysql_error());
			
		echo("<br>L'objet suivant a été ajouté à la base : $Libelle<br>");
		echo("&nbsp&nbsp&nbsp- $Prix centimes<br>");
		echo("&nbsp&nbsp&nbsp- vendu par lots de $UniteDeVente<br>");
		
	}
	//on charge le fichier xml
	$xmlParametres = simplexml_load_file("Parametres.xml");
	
	if (!sizeof($xmlParametres))
		echo ("Le document est vide<br>");
	
	//cette variable pour le parcours des produits
	$xmlListeProduits = $xmlParametres->ListeProduits;
	//cette variable pour le parcours des rubriques
	$xmlListeRubriques = $xmlParametres->ListeRubriques;
	
	$xmlProduits = $xmlListeProduits->children();
	$xmlRubriques = $xmlListeRubriques->children();
	
	$connect = mysql_connect("localhost","root","root")
		or die(mysql_error());
	
	$result = mysql_select_db("GeekProduct",$connect)
		or die(mysql_error());
	
	//on parcours les produits
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

?>

</body>
</html>