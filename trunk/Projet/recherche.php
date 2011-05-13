<?php 
if (isset($_POST['recherche']))
{
	if ((empty($_POST['recherche']))||(!is_string($_POST['recherche'])))
	{
		echo "Vous devez saisir des mots clés pour votre recherche";
	}
	else 
	{
		//faire une requête MySQL qui trouve les produits dont le nom contient un ou plusieurs
		//mot(s)-clé(s) et les afficher
	}
}
?>

<p>Saisissez les termes à rechercher sur le site</p>

<div id="recherche">
	<form method="post" action="recherche.php">
		<input name="recherche" type="text" id="recherche" style="height:20px; font-size:13px; width:200px;" value="" maxlength="50" />
		<input type='submit' name='Submit' value='Rechercher'/> 
	</form>
</div>