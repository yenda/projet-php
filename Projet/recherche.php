<?php
	include ("redirection.php");
?>

<?php 
include_once 'fonctions.php';
 
if(!isset($_POST['recherche']))
{
	echo "<h1>Recherche</h1>";
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
	echo "<h1>Résultat de la recherche</h1>";
	if ((empty($_POST['recherche']))||(!is_string($_POST['recherche'])))
	{
		echo "Vous devez saisir des mots clés pour votre recherche";
	}
	else 
	{
		//faire une requête MySQL qui trouve les produits dont le nom contient un ou plusieurs
		//mot(s)-clé(s) et les afficher
		$recherche=mysql_real_escape_string($_POST['recherche']);
		$result_produit = RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` WHERE `produits_Libelle` LIKE '%$recherche%' OR `produits_Descriptif` LIKE '%$recherche'");
		if (mysql_fetch_assoc($result_produit)){
			mysql_data_seek($result_produit,0);
			echo "<table class = 'liste_produits'><tr><th></th><th>Nom</th><th>Prix TTC</th></tr>";
			while($row=mysql_fetch_assoc($result_produit)){
				echo "<tr>";
				echo "<td class='photo'><a href='index.php?type=produit&id=".$row["produits_Reference"]."'><img src='images/thumbs/".$row["produits_Photo"]."'></a></td>";
				echo "<td><a href='index.php?type=produit&id=".$row["produits_Reference"]."'>".$row["produits_Libelle"]."</a></td>";
				echo "<td>".$row["produits_Prix"]." &euro;</td>";
			}
			echo "</table>";
		}
	}
}
?>