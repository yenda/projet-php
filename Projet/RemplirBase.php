<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>enregistrement de la bdd</title>
		<meta http-equiv="Content-Type" content="text/html ; charset=iso-8859-1"/>
	</head>

<body>
<?php
	function ConvertirPrix($Attribut){
		preg_match("/([0-9]+)[;.,]([0-9]{2})/", $Attribut,$regs);
		$Prix = $regs[1]*100+$regs[2];
		return $Prix;
	}
	
	/**Cette fonction parcourt l'ensemble des attributs d'un produit et les place dans des variables éponymes
	 * Une fois la collecte terminée il effectue une requête INSERT INTO pour ajouter le produit à  la base
	 * REPLACE INTO est inutile dans la mesure où on fait ici le remplissage initial de la base avec une référence différente
	 * pour chaque nouveau produit
	 */
	function AjouterProduitBase($Produit){
		foreach($Produit as $Attribut){
			if ($Attribut->getname() == "Propriete"){
				$Propriete = $Attribut->attributes();
				$Attribut = utf8_decode(mysql_real_escape_string($Attribut));
				if ($Propriete == "Libelle")
					$Libelle=($Attribut);
				elseif ($Propriete == "Prix")
					$Prix=ConvertirPrix($Attribut);
				elseif ($Propriete == "UniteDeVente")
					$UniteDeVente=$Attribut;
				elseif ($Propriete == "Photo")
					$Photo=$Attribut;
				else
					echo ("La propriété $Attribut est inconnue est ne peut être ajoutée à la base<br />");																			
			}
			elseif ($Attribut->getname() == "Descriptif")
				$Descriptif = utf8_decode(mysql_real_escape_string($Attribut));;
				
		}
		
		$query = "INSERT INTO Produits VALUES (NULL, '$Libelle', '$Prix', '$UniteDeVente', '$Photo', '$Descriptif', '2011-03-23 16:18:58');";
		$result = mysql_query($query)
			or die(mysql_error());
			
		echo("<br />L'objet suivant a été ajouté à la base : $Libelle<br />");
		echo("&nbsp;&nbsp;&nbsp;- $Prix centimes<br />");
		echo("&nbsp;&nbsp;&nbsp;- vendu par lots de $UniteDeVente<br />");
		
	}
	
	/**Cette fonction prend les noms des rubriques et les ajoute dans la base rubrique
	 * Elle associe les rubriques qu'elle ajoute à leurs rubriques supérieures dans la base
	 * rubrique_rubriquesup.
	 * Le remplissage se fait toujours avec INSERT INTO comme pour les produits
	 */
	
	function AjouterRubriqueBase($Rubrique){
		foreach($Rubrique as $Attribut){
			if($Attribut->getname() == "Nom"){
				$Nom = utf8_decode(mysql_real_escape_string($Attribut));
				echo ("Rubrique : $Nom<br />");
			}
			else{
				foreach($Attribut as $RubriqueSup){
					$NomSup = utf8_decode(mysql_real_escape_string($RubriqueSup));
					echo ("Rubrique Sup : $NomSup<br />");
				}
					
				}
			}
				
		
	}
	//on charge le fichier xml
	$xmlParametres = simplexml_load_file("Parametres.xml");
	
	if (!sizeof($xmlParametres))
		echo ("Le document est vide<br />");
	
	//cette variable pour le parcours des produits
	$xmlListeProduits = $xmlParametres->ListeProduits;
	//cette variable pour le parcours des rubriques
	$xmlListeRubriques = $xmlParametres->ListeRubriques;
	
	$xmlProduits = $xmlListeProduits->children();
	$xmlRubriques = $xmlListeRubriques->children();
	
	$connect = mysql_connect("127.0.0.1","root","root")
		or die(mysql_error());
	
	$result = mysql_select_db("GeekProduct",$connect)
		or die(mysql_error());

	//on parcourt les rubriques
	if (!sizeof($xmlRubriques))
		echo ("aucune rubrique<br />");	
	else{
		foreach ($xmlRubriques as $Rubrique){
			AjouterRubriqueBase($Rubrique);
		}
	}
	
	//on parcourt les produits
	if (!sizeof($xmlProduits))
		echo ("aucun produit<br />");
	else{
		foreach ($xmlProduits as $Produit){
			AjouterProduitBase($Produit);
		}
	}


?>

</body>
</html>