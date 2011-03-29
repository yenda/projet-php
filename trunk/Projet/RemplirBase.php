<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Remplir la base à partir d'un fichier XML</title>
		<meta http-equiv="Content-Type" content="text/html ; charset=iso-8859-1"/>
	</head>

<body>
<?php
	function ConvertirPrix($Attribut){
		preg_match("/([0-9]+)[;.,]([0-9]{2})/", $Attribut,$regs);
		$Prix = $regs[1]*100+$regs[2];
		return $Prix;
	}
	
	/*Cette fonction parcourt l'ensemble des attributs d'un produit et les place dans des variables éponymes
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
		$Date = date("Y-m-d");
		
		$query = "INSERT INTO `geekproduct`.`produits` VALUES (NULL, '$Libelle', '$Prix', '$UniteDeVente', '$Photo', '$Descriptif', '$Date');";
		$result = mysql_query($query)
			or die(mysql_error());
		$ID = mysql_insert_id();
					
		echo("<br />L'objet suivant a été ajouté à la base : $Libelle<br />");
		echo("&nbsp;&nbsp;&nbsp;- $Prix centimes<br />");
		echo("&nbsp;&nbsp;&nbsp;- vendu par lots de $UniteDeVente<br />");
		echo "&nbsp;&nbsp;&nbsp;- $ID<br />";
		
		
	}
	
	/**Cette fonction prend le nom d'une rubrique en paramètre
	 * Si cette rubrique est déjà dans la base elle retourne son id
	 * Sinon elle l'ajoute et elle retourne l'id de la rubrique. 
	 */
	
	function RubriqueID($rubrique_nom){
		//on cherche si cette rubrique est déjà dans la base
		//le cas où la rubrique serait plusieurs fois dans la base n'est pas prévu puisque cette fonction d'ajout ne le permet pas
		$query = "SELECT rubrique_id FROM rubriques WHERE rubrique_nom = '$rubrique_nom'";		
		$result = mysql_query($query)
			or die("$query : ".mysql_error()) ;			
		
		//si elle n'y est pas on la rajoute dans la base et on récupère son id
		if (mysql_num_rows($result)==0){
					$query = "INSERT INTO `geekproduct`.`rubriques` VALUES (NULL,'$rubrique_nom');";					
					$result = mysql_query($query)
						or die("$query : ".mysql_error()) ;
					
			echo ("<br />Rubrique : $rubrique_nom ajoutée à la base<br />");
			return mysql_insert_id();
		}
		//sinon on se contente de récupérer son id
		else{
			return mysql_result($result, 0,"rubrique_id");
			
		}
	}


	/**Cette fonction prend les noms des rubriques et les ajoute dans la base rubrique
	 * Elle associe les rubriques qu'elle ajoute à leurs rubriques supérieures dans la base
	 * rubrique_rubriquesup.
	 * Le remplissage se fait toujours avec INSERT INTO comme pour les produits
	 */	
	function AjouterRubriqueBase($Rubrique){
		$rubrique_nom = $Rubrique->Nom;
		$rubriquessup_noms = $Rubrique->RubriquesSuperieures->children();
				
		$rubrique_nom = utf8_decode(mysql_real_escape_string($rubrique_nom));


		$rubrique_id = RubriqueID($rubrique_nom);

		
			foreach($rubriquessup_noms as $rubriquesup_nom){
				$rubriquesup_nom = utf8_decode(mysql_real_escape_string($rubriquesup_nom));
				$rubriquesup_id = RubriqueID($rubriquesup_nom);
				//La condition suivante vérifie si la pair de rubrique / rubrique supérieure n'est pas déjà dans la base et l'ajoute si elle n'y est pas
				if(mysql_num_rows(mysql_query("SELECT * FROM rubrique_rubriquesup WHERE (rubrique_id = '$rubrique_id' AND rubriquesup_id = '$rubriquesup_id')"))==0){		
					$query = "INSERT INTO `geekproduct`.`rubrique_rubriquesup` VALUES ('$rubrique_id','$rubriquesup_id');";
					$result = mysql_query($query)
						or die("$query : ".mysql_error()) ;
					echo ("$rubriquesup_nom	ajoutée en tant que rubrique supérieure de $rubrique_nom<br />");
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
	
	$connect = mysql_connect("localhost","root","root")
		or die(mysql_error());
	
	$result = mysql_select_db("geekproduct",$connect)
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

	$result = mysql_close($connect);
	if ($result)
		echo("Fermeture de la connection<br />");
	else
		echo("Echec de la fermeture de connection<br />");
?>

</body>
</html>