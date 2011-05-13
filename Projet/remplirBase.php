<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Remplir la base à partir d'un fichier XML</title>
		<meta http-equiv="Content-Type" content="text/html ; charset=iso-8859-1"/>
	</head>

<body>
<?php
	include 'fonctions.php';
	/**Améliorations a apporter :
	*  Supprimer les echos et remplacer par du texte final de type :
	*  X Produits et X catégories parcourus
	*  X Produits et X Catégories ajoutés
	*  Les produits X X et X et les catégories X, X et X sont incomplets et n'ont pas pu être ajoutés
	*/


	/*Cette fonction parcourt l'ensemble des attributs d'un produit et les place dans des variables éponymes
	 * Une fois la collecte terminée il effectue une requête INSERT INTO pou*r ajouter le produit à  la base
	 * REPLACE INTO est inutile dans la mesure où on fait ici le remplissage initial de la base avec une référence différente
	 * pour chaque nouveau produit
	 */
	function AjouterProduitBase($Produit){
		global $nbProduitsAjoutes; global $nbProduitsParcourus;
		foreach($Produit as $Attribut){			
			
			if ($Attribut->getname() == "Propriete"){
				$Propriete = $Attribut->attributes();
				$Attribut = utf8_decode(mysql_real_escape_string($Attribut));
				if ($Propriete == "Libelle")
					$Libelle=$Attribut;
				elseif ($Propriete == "Prix")
					$Prix=$Attribut;
				elseif ($Propriete == "UniteDeVente")
					$UniteDeVente=$Attribut;
				elseif ($Propriete == "Photo")
					$Photo=$Attribut;
				else
					echo ("La propriété $Attribut est inconnue et ne peut être ajoutée à la base<br />");
			}																			
			elseif ($Attribut->getname() == "Descriptif")
				$Descriptif = utf8_decode(mysql_real_escape_string($Attribut));
			//on regarde si le produit appartient a des rubriques, si une rubrique n'est pas dans la base elle est
			//ajoutée, dans tout les cas on revoit l'ID de la rubrique et on la stocke dans un tableau
			elseif ($Attribut->getname() == "Rubriques"){
				foreach($Attribut as $rubrique_nom){
					$rubrique_id[] = RubriqueID(utf8_decode(mysql_real_escape_string($rubrique_nom)));					
				}
			}				
		}
		
		//Gestion des données manquantes
		if(empty($Libelle))
			echo "Le produit n°$nbProduitsParcourus n'a pas de Libellé et n'a pas pu être ajouté à la base<br />";
		elseif (empty($Prix))
			echo "Le prix du produit n°$nbProduitsParcourus : $Libelle n'est pas défini, il n' a pas pu être ajouté à la base<br />";
		elseif (empty($UniteDeVente))
			echo "L'unité de vente du produit n°$nbProduitsParcourus : $Libelle n'est pas définie, il n'a pas pu être ajouté à la base<br />";
		else{
			$Date = date("Y-m-d");
			
			if ((!isset($Photo))||(!file_exists("images/produits/$Photo")))
				$Photo = "defaut.jpg";
			if (!isset($Descriptif))
				$Descriptif = '';
			
			//Ajout du produit à la base
			$result=RequeteSQL("INSERT INTO `geekproduct`.`produits` VALUES (NULL, '$Libelle', '$Prix', '$UniteDeVente', '$Photo', '$Descriptif', '$Date');");
			$produit_id = mysql_insert_id();
			
			//La rubrique par défaut du produit est Divers
			if (!isset($rubrique_id))
				$rubrique_id[] = 1;
			//Ajout des liens produit/rubriques
			foreach ($rubrique_id as $rubrique_id){
				$result=RequeteSQL("INSERT INTO `geekproduct`.`produit_rubrique` VALUES ('$produit_id','$rubrique_id');");
			}
			$nbProduitsAjoutes++;	
		}
		$nbProduitsParcourus++;
		
	}
	
	/**Cette fonction prend le nom d'une rubrique en paramètre
	 * Si cette rubrique est déjà dans la base elle retourne son id
	 * Sinon elle l'ajoute et elle retourne l'id de la rubrique. 
	 */
	
	function RubriqueID($rubrique_nom){
		global $nbRubriquesAjoutes;
		//on cherche si cette rubrique est déjà dans la base
		//le cas où la rubrique serait plusieurs fois dans la base n'est pas prévu puisque cette fonction d'ajout ne le permet pas
		$result=RequeteSQL("SELECT rubrique_id FROM rubriques WHERE rubrique_nom = '$rubrique_nom'");	
		
		//si elle n'y est pas on la rajoute dans la base et on récupère son id
		if (mysql_num_rows($result)==0){
					$result=RequeteSQL("INSERT INTO `geekproduct`.`rubriques` VALUES (NULL,'$rubrique_nom');");					
			$nbRubriquesAjoutes++;
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
					$result=RequeteSQL("INSERT INTO `geekproduct`.`rubrique_rubriquesup` VALUES ('$rubrique_id','$rubriquesup_id');");
				}
			}
				
	}
	
	//on charge le fichier xml
	$nbProduitsParcourus = 0 ; $nbProduitsAjoutes = 0 ; $nbRubriquesAjoutes = 0;
	$xmlParametres = simplexml_load_file("parametres.xml");
	
	if (!sizeof($xmlParametres))
		echo ("Le document est vide<br />");
	
	//cette variable pour le parcours des produits
	$xmlListeProduits = $xmlParametres->ListeProduits;
	//cette variable pour le parcours des rubriques
	$xmlListeRubriques = $xmlParametres->ListeRubriques;
	
	$xmlProduits = $xmlListeProduits->children();
	$xmlRubriques = $xmlListeRubriques->children();
	
	$connect = ConnexionDB();

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

	//on détermine les rubrique de plus haut niveau dans la hierarchie et on leur attribue 0 comme id de rubrique supérieure dans la table rubrique_rubriquesup
	$result=RequeteSQL("SELECT rubriques.rubrique_id FROM rubriques LEFT JOIN rubrique_rubriquesup ON rubriques.rubrique_id = rubrique_rubriquesup.rubrique_id WHERE rubrique_rubriquesup.rubrique_id IS NULL");
	
		
	while ($row=mysql_fetch_assoc($result)){
		$rubrique_id = $row["rubrique_id"];
		RequeteSQL("INSERT INTO `geekproduct`.`rubrique_rubriquesup` VALUES ('$rubrique_id','0');");
	}
	
	echo "$nbProduitsParcourus produits ont été parcourus<br />";
	echo "$nbProduitsAjoutes produits ont été ajoutés à la base<br />";
	echo $nbProduitsParcourus-$nbProduitsAjoutes." produits n'ont pas pu être ajoutés car le description était incomplète<br />";
	echo "$nbRubriquesAjoutes rubriques ont été ajoutés à la base";
	
	DeconnexionDB($connect);

?>

</body>
</html>