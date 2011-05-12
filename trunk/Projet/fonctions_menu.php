<?php
	//Cette fonction construit le menu et le revoit sous forme d'une chaîne
	//Le menu est construit de façon récursive
	function ConstruireMenu(&$menu,$rubrique_id=0){
		//on effectue une requête pour obtenir l'ID des rubriques ayant pour rubrique supérieure celle qui
		//est en paramètre, 0 lors du premier appel de la fonction
		$result = RequeteSQL("SELECT * FROM `rubriques` WHERE `rubrique_id` in (SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id` = ".$rubrique_id.") ORDER BY `rubrique_nom`");
		$menu .= "<ul>";
		//on ajoute les résultats au menu en recherchant aussi les sous-rubriques de chaque rubrique trouvée
		while ($row=mysql_fetch_assoc($result)){
			$menu .= "<li><a href='index.php?type=rubrique&id=".$row["rubrique_id"]."'>".$row["rubrique_nom"]."</a></li>";
			ConstruireMenu($menu,$row["rubrique_id"]);
		}
		$menu .= "</ul>";
	}
	
	function Menu(){
		$menu = "";
		ConstruireMenu($menu);
		return $menu;
	}
	
	function Chemin($rubrique_id){
		$chemin = "";
	}
?>