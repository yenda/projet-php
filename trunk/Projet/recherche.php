<?php 
include_once 'fonctions.php';

if(!isset($_POST['recherche']))
{
	echo '<p>Saisissez les termes à rechercher sur le site</p>
	
	<div id="recherche">
		<form method="post" action="index.php?type=recherche">
			<input name="recherche" type="text" id="recherche" style="height:20px; font-size:13px; width:200px;" value="" maxlength="50" />
			<input type="submit" name="Submit" value="Rechercher"/> 
		</form>
	</div>';
}

else if (isset($_POST['recherche']))
{
	if ((empty($_POST['recherche']))||(!is_string($_POST['recherche'])))
	{
		echo "Vous devez saisir des mots clés pour votre recherche";
	}
	else 
	{
		//faire une requête MySQL qui trouve les produits dont le nom contient un ou plusieurs
		//mot(s)-clé(s) et les afficher
		$recherche=$_POST['recherche'];
		$result_produit = RequeteSQL("SELECT `produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` WHERE `produits_Libelle` LIKE '%$recherche%'");
		if (mysql_fetch_assoc($result_produit)){
			mysql_data_seek($result_produit,0);
			echo "<table class = 'liste_produits'><tr><th></th><th>Nom</th><th>Prix TTC</th></tr>";
			while($row=mysql_fetch_assoc($result_produit)){
				echo "<tr><td width='100px' height='100px'>";
				echo "<img src='images/thumbs/".$row["produits_Photo"]."'>";
				echo "</td>";
				echo "<td>".$row["produits_Libelle"]."</td>";
				echo "<td>".$row["produits_Prix"]." &euro;</td>";
			}
			echo "</table>";
		}
	}
}
?>