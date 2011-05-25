<?php
	//Les pages r�serv�es � l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_ENV['type']))||(!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>

<h1>Remplissage de la base</h1>

<?php

	/*Cette fonction parcourt l'ensemble des attributs d'un produit et les place dans des variables �ponymes
	 * Une fois la collecte termin�e il effectue une requ�te INSERT INTO pou*r ajouter le produit � la base
	 * REPLACE INTO est inutile dans la mesure o� on fait ici le remplissage initial de la base avec une r�f�rence diff�rente
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
					echo ("La propri�t� $Attribut est inconnue et ne peut �tre ajout�e � la base<br />");
			}																			
			elseif ($Attribut->getname() == "Descriptif")
				$Descriptif = utf8_decode(mysql_real_escape_string($Attribut));
			//on regarde si le produit appartient a des rubriques, si une rubrique n'est pas dans la base elle est
			//ajout�e, dans tout les cas on revoit l'ID de la rubrique et on la stocke dans un tableau
			elseif ($Attribut->getname() == "Rubriques"){
				foreach($Attribut as $rubrique_nom){
					$rubrique_id[] = RubriqueID(utf8_decode(mysql_real_escape_string($rubrique_nom)));					
				}
			}				
		}
		
		//Gestion des donn�es manquantes
		if(empty($Libelle))
			echo "Le produit n�$nbProduitsParcourus n'a pas de Libell� et n'a pas pu �tre ajout� � la base<br />";
		elseif (empty($Prix))
			echo "Le prix du produit n�$nbProduitsParcourus : $Libelle n'est pas d�fini, il n' a pas pu �tre ajout� � la base<br />";
		elseif (empty($UniteDeVente))
			echo "L'unit� de vente du produit n�$nbProduitsParcourus : $Libelle n'est pas d�finie, il n'a pas pu �tre ajout� � la base<br />";
		else{
			$Date = date("Y-m-d");
			
			if ((!isset($Photo))||(!file_exists("images/produits/$Photo")))
				$Photo = "defaut.jpg";
			if (!isset($Descriptif))
				$Descriptif = '';
			
			//Ajout du produit � la base
			$result=RequeteSQL("INSERT INTO `geekproduct`.`produits` VALUES (NULL, '$Libelle', '$Prix', '$UniteDeVente', '$Photo', '$Descriptif', '$Date');");
			$produit_id = mysql_insert_id();
			
			//La rubrique par d�faut du produit est Divers
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
	
	/**Cette fonction prend le nom d'une rubrique en param�tre
	 * Si cette rubrique est d�j� dans la base elle retourne son id
	 * Sinon elle l'ajoute et elle retourne l'id de la rubrique. 
	 */
	
	function RubriqueID($rubrique_nom){
		global $nbRubriquesAjoutes;
		//on cherche si cette rubrique est d�j� dans la base
		//le cas o� la rubrique serait plusieurs fois dans la base n'est pas pr�vu puisque cette fonction d'ajout ne le permet pas
		$result=RequeteSQL("SELECT rubrique_id FROM rubriques WHERE rubrique_nom = '$rubrique_nom'");	
		
		//si elle n'y est pas on la rajoute dans la base et on r�cup�re son id
		if (mysql_num_rows($result)==0){
					$result=RequeteSQL("INSERT INTO `geekproduct`.`rubriques` VALUES (NULL,'$rubrique_nom');");					
			$nbRubriquesAjoutes++;
			return mysql_insert_id();
		}
		//sinon on se contente de r�cup�rer son id
		else{
			return mysql_result($result, 0,"rubrique_id");
			
		}
	}


	/**Cette fonction prend les noms des rubriques et les ajoute dans la base rubrique
	 * Elle associe les rubriques qu'elle ajoute � leurs rubriques sup�rieures dans la base
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
				//La condition suivante v�rifie si la pair de rubrique / rubrique sup�rieure n'est pas d�j� dans la base et l'ajoute si elle n'y est pas
				if(mysql_num_rows(mysql_query("SELECT * FROM rubrique_rubriquesup WHERE (rubrique_id = '$rubrique_id' AND rubriquesup_id = '$rubriquesup_id')"))==0){		
					$result=RequeteSQL("INSERT INTO `geekproduct`.`rubrique_rubriquesup` VALUES ('$rubrique_id','$rubriquesup_id');");
				}
			}
				
	}
	
?>

<?php 
	if(isset($_GET['xml'])){
		$xml = $_GET['xml'];
		if(file_exists($xml)){
			if (preg_match("/.xml$/",$xml)){
				//on charge le fichier xml
				$nbProduitsParcourus = 0 ; $nbProduitsAjoutes = 0 ; $nbRubriquesAjoutes = 0;
				$xmlParametres = simplexml_load_file("$xml");
				
				if (!sizeof($xmlParametres))
					echo ("Le document est vide<br />");
				
				//cette variable pour le parcours des produits
				$xmlListeProduits = $xmlParametres->ListeProduits;
				//cette variable pour le parcours des rubriques
				$xmlListeRubriques = $xmlParametres->ListeRubriques;
				
				$xmlProduits = $xmlListeProduits->children();
				$xmlRubriques = $xmlListeRubriques->children();
			
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
				//on supprime les �ventuelles rubriques de plus haut niveau de la table rubrique rubrique sup car elles ne le sont peut-�tre plus
				//si le xml contient des rubriques de niveau sup�rieur
				$result=RequeteSQL("DELETE FROM  `rubrique_rubriquesup` WHERE `rubriquesup_id` = 0");
				
				//on d�termine les rubrique de plus haut niveau dans la hierarchie et on leur attribue 0 comme id de rubrique sup�rieure dans la table rubrique_rubriquesup
				$result=RequeteSQL("SELECT rubriques.rubrique_id FROM rubriques LEFT JOIN rubrique_rubriquesup ON rubriques.rubrique_id = rubrique_rubriquesup.rubrique_id WHERE rubrique_rubriquesup.rubrique_id IS NULL");
				
					
				while ($row=mysql_fetch_assoc($result)){
					$rubrique_id = $row["rubrique_id"];
					RequeteSQL("INSERT INTO `geekproduct`.`rubrique_rubriquesup` VALUES ('$rubrique_id','0');");
				}
	
				echo "$nbProduitsParcourus produits ont �t� parcourus<br />";
				echo "$nbProduitsAjoutes produits ont �t� ajout�s � la base<br />";
				echo $nbProduitsParcourus-$nbProduitsAjoutes." produits n'ont pas pu �tre ajout�s car le description �tait incompl�te<br />";
				echo "$nbRubriquesAjoutes rubriques ont �t� ajout�s � la base";
			}
			else
				echo "<div class='alert'>Le fichier n'est pas dans le bon format</div>";
		}
		else
			echo "<div class='alert'>Fichier introuvable</div>";
?>
<h4><a href='index.php?type=remplir_base'>Choisir un autre fichier</a></h4>
<?php 
	}
	
	if((!isset($_GET['xml']))||(!file_exists($_GET['xml']))){
?>
	<form method="get" action="index.php">
		<input type='hidden' value="remplir_base" name="type" />
		<input type='file' name='xml'/>
		<input type='submit' value='Remplir la base' />
	</form>

<?php		
	}
?>
<h4><a href="index.php?type=admin">Retour � la page d'administration</a></h4>

<?php 
	}
?>