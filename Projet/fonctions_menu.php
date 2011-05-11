<?php
	function ConstruireMenu(&$menu,$rubrique_id){	
		$result = RequeteSQL("SELECT * FROM `rubriques` WHERE `rubrique_id` in (SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id` = ".$rubrique_id.") ORDER BY `rubrique_nom`");
		$menu .= "<ul>";
		while ($row=mysql_fetch_assoc($result)){
			$menu .= "<li class="toggleSubMenu">".$row["rubrique_nom"]."</li>";
			ConstruireMenu($menu,$row["rubrique_id"]);
		}
		$menu .= "</ul>";
	}
	
	function Menu(){
		$menu = "";
		ConstruireMenu($menu,0);
		return $menu;
	}
?>