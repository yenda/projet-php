<?php
	//Cette fonction construit le menu et le revoit sous forme d'une cha�ne
	//Le menu est construit de fa�on r�cursive
	function Menu($rubrique_id=0,$rubrique_nom="principale"){
		$menu="<ul>\n\t\t<li><a href='index.php'>Acceuil</a></li>";
		//on effectue une requ�te pour obtenir l'ID des rubriques ayant pour rubrique sup�rieure celle qui
		//est en param�tre, 0 lors du premier appel de la fonction
		$result = RequeteSQL("SELECT * FROM `rubriques` WHERE `rubrique_id` in (SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id` = ".$rubrique_id.") ORDER BY `rubrique_nom`");
		//on ajoute les r�sultats au menu en recherchant aussi les sous-rubriques de chaque rubrique trouv�e
		$menu .= "\n\t\t<li><a href='index.php?type=rubrique&id=$rubrique_id'>Rubrique $rubrique_nom</a>";
		$menu .= "\n\t\t<ul>";
		while ($row=mysql_fetch_assoc($result)){
			$menu .= "\n\t\t\t<li><a href='index.php?type=rubrique&id=".$row["rubrique_id"]."'>".$row["rubrique_nom"]."</a></li>";
		}
		$menu .= "\n\t\t</ul></li>";
		$menu .= "\n\t</ul>";
		return $menu;
	}
	

	
	function Chemin($rubrique_id){
		$chemin = "";
	}
?>