<?php
function sous_rubriques ($rubrique_id){
	$rubriques = "`rubique_id` = $rubrique_id OR ";
	$result = RequeteSQL("SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id`='$rubrique_id'");
	while($row=mysql_fetch_assoc($result)){
		$rubriques .= sous_rubriques($row['rubrique_id']);
	}
	return $rubriques;
}


echo $rubriques = substr(sous_rubriques(0),0,-4);

?>