<?php
	include ("redirection.php");
?>

<?php 
include_once 'fonctions.php';
$req = RequeteSQL ("SELECT * FROM `rubriques`");
 
if(!isset($_POST['recherche']))
{
	echo "<h1>Recherche</h1>";
	echo '<p>Saisissez les termes à rechercher sur le site (vous pouvez réduire la recherche à une catégorie, choisir un prix maximum et ordonner les résultats)</p>
	
	<div id="recherche">
		<form method="post" action="index.php?type=recherche">
		Mots-clés&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
			<input name="recherche" type="text" id="recherche" style="height:20px; font-size:13px; width:200px;" value="" maxlength="50" />
				<select name="tri_recherche" size="1">
				    <option value="produits_Prix" selected>Trier par prix</option>
				    <option value="produits_Libelle">Trier par nom de produit</option>
				</select><br /><br />';
				echo'Catégories&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prix max&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
					<select name="categorie_recherche" size="1">
						<option value="" selected></option>';
				while($row=mysql_fetch_assoc($req)){
					echo'<option value='.$row["rubrique_id"].'>'.$row["rubrique_nom"].'</option>';
				}
				echo'</select>
				<input name="prix_max" type="text" id="prix_max" style="height:20px; font-size:13px; width:100px;" value="" maxlength="5" />';
			echo '<input type="submit" name="Submit" value="Rechercher"/> 
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
		if ($_POST['categorie_recherche']=="" and $_POST['prix_max']=="")
			$result_produit = RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference` = `produit_rubrique`.`produit_reference` WHERE `produits_Libelle` LIKE '%$recherche%' OR `produits_Descriptif` LIKE '%$recherche%' GROUP BY `produits`.`produits_Reference` ORDER BY ".$_REQUEST["tri_recherche"]." ASC;");
		else if ($_POST['prix_max']=="" and $_POST['categorie_recherche']!="") {
			$rubrique=$_POST['categorie_recherche'];
			$result_produit = RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference` = `produit_rubrique`.`produit_reference` WHERE `rubrique_id` = $rubrique AND `produits_Libelle` LIKE '%$recherche%' OR `produits_Descriptif` LIKE '%$recherche%' GROUP BY `produits`.`produits_Reference` ORDER BY ".$_REQUEST["tri_recherche"]." ASC;");}
		else if ($_POST['categorie_recherche']=="" and $_POST['prix_max']!=""){
			$prix_max=$_POST['prix_max'];
			$result_produit = RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` WHERE `produits_Prix`<= '.$prix_max.' AND `produits_Libelle` LIKE '%$recherche%' OR `produits_Descriptif` LIKE '%$recherche%' GROUP BY `produits`.`produits_Reference` ORDER BY ".$_REQUEST["tri_recherche"]." ASC;");}
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
		else 	
			echo "<div class='alert'>Votre recherche n'a retourné aucun résultat. Veuillez réessayer avec d'autres mots-clés</div>";
	}
}
?>