<?php
					$pass = 'admin'.'admin'.'geekproduct';
			$pass = md5($pass);
			echo $pass;
			
function sous_rubriques ($rubrique_id)
{
	$rubriques="`rubique_id` = $rubrique_id";
	$result = RequeteSQL("SELECT rubrique_id FROM rubrique_rubriquesup WHERE `rubriquesup_id`='$rubrique_id'");
	while($row=mysql_fetch_assoc($result))
	{
		$rubriques .= "OR rubrique_id = '.$row['rubriquesup_id'].'";
	}
	echo $rubriques;
	sous_rubriques($rubriques);
}

sous_rubrique(4);
?>