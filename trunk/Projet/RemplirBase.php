<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>enregistrement de la bdd</title>
		<meta http-equiv="Content-Type" content="text/html ; charset=iso-8859-1"/>
	</head>

<body>
<?php
	//Possibilit� d'ajouter ici des conditions si le xml contient des unit�s de vente particuli�res
	//ici sont reconnu l'unit� et tout ce qui contient un nombre, ce nombre �tant l'unit� de vente
	function ConvertirUniteDeVente($Attribut){
		if ($Attribut == "l'unit�")
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
	
	/**Cette fonction parcourt l'ensemble des Attributs d'un produit et les place dans des variables �ponymes
	 * Une fois la collecte termin�e il effectue une requ�te INSERT INTO pour ajouter le produit � la base
	 * REPLACE INTO est inutile dans la mesure o� on fait ici le remplissage initial de la base avec une r�f�rence diff�rente
	 * pour chaque nouveau produit
	 */
	function AjouterProduitBase($Produit){
		foreach($Produit as $Attribut){
			if ($Attribut->getname() == "Propriete"){
				$Propriete = $Attribut->attributes();
				$Attribut = utf8_decode($Attribut);
				if ($Propriete == "Libelle")
					$Libelle=($Attribut);
				elseif ($Propriete == "Prix")
					$Prix=ConvertirPrix($Attribut);
				elseif ($Propriete == "UniteDeVente")
					$UniteDeVente=ConvertirUniteDeVente($Attribut);
				elseif ($Propriete == "Photo")
					$Photo=$Attribut;
				else
					echo ("La propri�t� $Attribut est inconnue est ne peut �tre ajout�e � la base<br>");																			
			}
			elseif ($Attribut->getname() == "Descriptif")
				$Descriptif = $Attribut;
		}
		$query = "INSERT INTO Produit VALUES (NULL, '$Libelle', '$Prix', '$UniteDeVente', '$Photo', '$Descriptif', '2011-03-23 16:18:58');";
		$result = mysql_query($query)
			or die(mysql_error());
			
		echo("<br>L'objet suivant a �t� ajout� � la base : $Libelle<br>");
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

	//on parcourt les rubriques
	if (!sizeof($xmlRubriques))
		echo ("aucune rubrique<br>");	
	else{
		echo ("il y a des rubriques<br>");
	}
	
	//on parcourt les produits
	if (!sizeof($xmlProduits))
		echo ("aucun produit<br>");
	else{
		foreach ($xmlProduits as $Produit){
			AjouterProduitBase($Produit);
		}
	}


?>

</body>
</html>