<?php
	//Cette fonction construit le menu et le revoit sous forme d'une chaîne
	//Le menu est construit de façon récursive
	function Menu(){
		$rubrique_id = $_ENV['rubrique_id'];
		
		$menu="<ul>\n\t\t<li><a href='index.php'><b>Accueil</b></a></li>";
		//on effectue une requête pour obtenir l'ID des rubriques ayant pour rubrique supérieure celle qui
		//est en paramètre, 0 lors du premier appel de la fonction
		$result = RequeteSQL("SELECT * FROM `rubriques` WHERE `rubrique_id` in (SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id` = ".$rubrique_id.") ORDER BY `rubrique_nom`");
		//on ajoute les résultats au menu en recherchant aussi les sous-rubriques de chaque rubrique trouvée
		$menu .= "\n\t\t<li><a href='index.php?type=rubrique&id=$rubrique_id'><b>Rubrique ".$_ENV['rubrique_nom']."</b></a>";
		$menu .= "\n\t\t<ul>";
		while ($row=mysql_fetch_assoc($result)){
			$menu .= "\n\t\t\t<li><a href='index.php?type=rubrique&id=".$row["rubrique_id"]."&rubrique=$rubrique_id'>".$row["rubrique_nom"]."</a></li>";
		}
		$menu .= "\n\t\t</ul></li>";
		$menu .= "\n\t\t<li><a href='index.php?type=recherche'><b>Recherche</b></a></li>";
		$menu .= "\n\t</ul>";
		return $menu;
	}
	

	
	function Chemin(){
		$chemin = "";
		if ($_ENV['id'] != 0) {
			// on récupère les informations de la page en cours dans la DB
			$result = RequeteSQL('SELECT *, `rubriques` INNER JOIN `rubrique_rubriquesup` ON `rubriques`.`rubrique_id`=`rubrique_rubriquesup`.`rubrique_id` WHERE');
			$resultat = requete_SQL($strSQL);
			$tabl_result = mysql_fetch_array($resultat);
			
			$titrepage = $tabl_result['Titre'];
			$idparent = $tabl_result['Id_parent'];
			
			// création du lien vers la page en cours
			$chemin_page_en_cours = ' -> <a href="index.php?id_page='.$idpage.'">'.$titrepage.'</a>';
			
			// Concaténation du lien de la page N-1 et
			// du lien de la page en cours
			$chemin_complet = affiche_chemin_fer($idparent).$chemin_page_en_cours;
		}
		// renvoie le chemin complet
		return $chemin_complet;
	}
?>