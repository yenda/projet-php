<?php
	//Cette fonction construit le menu et le revoit sous forme d'une chaîne
	//Le menu est construit de façon récursive
	function Menu(){
		$rubrique_id = $_ENV['rubrique_id'];
		
		$menu="<ul>";
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
		$menu .= "\n\t</ul>";
		return $menu;
	}
	

	
	function Chemin($rubrique_id){
		if (($_ENV['type']=="rubrique")||($_ENV['type']=="produit")){
			if ($rubrique_id != 0) {
				$chemin = "";			
				$result = RequeteSQL("SELECT `rubriques` . * , `rubrique_rubriquesup`.`rubriquesup_id` FROM `rubriques` INNER JOIN `rubrique_rubriquesup` ON `rubriques`.`rubrique_id` = `rubrique_rubriquesup`.`rubrique_id` WHERE `rubriques`.`rubrique_id` =".$rubrique_id);
				while($row = mysql_fetch_array($result)){
					$chemin .= Chemin($row['rubriquesup_id']);
					$chemin .= ' > <a href="index.php?type=rubrique&id='.$rubrique_id.'">'.$row['rubrique_nom'].'</a>';
				}
			}
			else {
				if ($_ENV['type']=="rubrique")
					$chemin = '<br /><a href="index.php">Accueil</a> > <a href="index.php?type=rubrique">Rubriques</a>';
				else
					$chemin = '<br /><a href="index.php">Accueil</a>';
			}
			// renvoie le chemin complet
			return $chemin;
		}
		elseif ($_ENV['type']=="index")
			return "<br /><a href='index.php'>Accueil</a>";
		else 
			return "<br /><a href='index.php'>Accueil</a> > <a href='index.php?type=".$_ENV['type']."'>".strtr(ucfirst($_ENV['type']),'_',' ')."</a>";
	}
?>