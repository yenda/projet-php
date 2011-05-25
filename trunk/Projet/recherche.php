<?php
	include ("redirection.php");
	
	//cette fonction va servir pour la formulation de la requ�te SQL
	//elle permet d'englober toutes les sous-rubriques lorsque l'utilisateur demande une rubrique de niveau sup�rieur
	function sous_rubriques ($rubrique_id){
	$rubriques = "`rubrique_id` = $rubrique_id OR ";
	$result = RequeteSQL("SELECT `rubrique_id` FROM `rubrique_rubriquesup` WHERE `rubriquesup_id`='$rubrique_id'");
	while($row=mysql_fetch_assoc($result)){
		$rubriques .= sous_rubriques($row['rubrique_id']);
	}
	return $rubriques;
}
?>

<?php 
include_once 'fonctions.php';
$req = RequeteSQL ("SELECT * FROM `rubriques`");
//On affiche le formulairede recherche, si l'utilisateur vient de faire une recherche il est d�j� pr�-rempli avec ses crit�res
?>
<h1>Recherche</h1>
<p>Saisissez les termes � rechercher sur le site (vous pouvez r�duire la recherche � une cat�gorie, choisir un prix maximum et ordonner les r�sultats)</p>

<table class='recherche'>
	<tr>
		<td colspan='2'>
				<form method="post" action="index.php?type=recherche">
					<label for="recherche">Mot cl�s</label><br />
					<input name="recherche" type="text" id="recherche" style="height:20px; font-size:13px; width:200px;" value="<?php if (!empty($_POST['recherche'])) echo htmlentities($_POST['recherche']);?>" maxlength="50" />
		</td>
	</tr>
		<td>
					<label for="tri_recherche">Trier par</label><br />
					<select name="tri_recherche" size="1">
					    <option value="produits_Prix" selected>Trier par prix</option>
					    <option value="produits_Libelle">Trier par nom de produit</option>
					</select>
		</td>
		<td>
					<label for="categorie_recherche">Cat�gorie</label><br />
					<select name="categorie_recherche" size="1">
						<option value="<?php if (!empty($_POST['categorie_recherche'])) echo intval($_POST['categorie_recherche']);?>" selected><?php if (!empty($_POST['categorie_recherche'])) echo mysql_result($req,intval($_POST['categorie_recherche']-1),"rubrique_nom");?></option>
	<?php
						while($row=mysql_fetch_assoc($req)){
							echo'<option value='.$row["rubrique_id"].'>'.$row["rubrique_nom"].'</option>';
						}
	?>
					</select>
		</td>
	<tr>
		<td>
					<label for="prix_min">Prix minimum</label><br />
					<input name="prix_min" type="text" id="prix_max" style="height:20px; font-size:13px; width:100px;" value="<?php if (!empty($_POST['prix_min'])) echo intval($_POST['prix_min']);?>" maxlength="5" />
		</td>
		<td>
					<label for="prix_max">Prix maximum</label><br />
					<input name="prix_max" type="text" id="prix_max" style="height:20px; font-size:13px; width:100px;" value="<?php if (!empty($_POST['prix_max'])) echo intval($_POST['prix_max']);?>" maxlength="5" />
		</td>
	</tr>
	<tr>
		<td>
					<input type="submit" name="Submit" value="Rechercher"/> 
				</form>
		</td>
		<td>
				<form method=post action="index.php?type=recherche">
					<input type="submit" name="" value="Remettre � z�ro"/> 
				</form>
		</td>
	</tr>
</table>
<?php
if(isset($_POST['recherche'])){
	echo "<h1>R�sultat de la recherche</h1>";
	if (empty($_POST['recherche'])){
		echo "<div class='alert'>Vous devez saisir des mots cl�s pour votre recherche</div>";
		echo "<h4><a href='index.php?type=recherche'>Retour � la recherche</a></h4>";
	}
	else{
		//On pr�pare les valeurs pour la requ�te en fonction de ce qui a �t� demand� par l'utilisateur
		$recherche="AND (`produits_Libelle` LIKE '%".mysql_real_escape_string($_POST['recherche'])."%' OR `produits_Descriptif` LIKE '%".mysql_real_escape_string($_POST['recherche'])."%')";
		if (((isset($_POST['prix_max']))&&(!empty($_POST['prix_max']))))
			$prix_max = "AND `produits_Prix`<= ".intval($_POST['prix_max']);
		else
			$prix_max = "";
		if ((isset($_POST['prix_min']))&&(!empty($_POST['prix_min'])))
			$prix_min = "AND `produits_Prix`<= ".intval($_POST['prix_min']);
		else
			$prix_min = "";
		if ((isset($_POST['categorie_recherche'])&&(!empty($_POST['categorie_recherche']))))
			$rubriques = "AND (".substr(sous_rubriques(intval($_POST['categorie_recherche'])),0,-4).")";
		else
			$rubriques = "";
		if ((isset($_POST['tri_recherche']))&&($_POST['tri_recherche']=="produits_Libelle"))
			$tri = "ORDER BY `produits_Libelle`";
		else
			$tri = "ORDER BY `produits_Prix`";
		

		//on fait la requ�te
		$nb=mysql_num_rows($result=RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference` = `produit_rubrique`.`produit_reference` WHERE 1 $recherche $rubriques $prix_max $prix_min GROUP BY `produits`.`produits_Reference` $tri"));
		//Gestion du pluriel dans la phrase qui va �tre affich�e
		$s="";
		if ($nb>1)
			$s="s";
		echo "$nb r�sultat$s trouv�$s avec vos crit�res de recherche<br />\n";
		
		//Si la requ�te ne retourne pas de r�sultat
		if ($nb==0){
			//On regarde si il n'y a pas de r�sultats sans prendre en compte les mots cl�s � condition que l'utilisateur ait choisi une rubrique et un crit�re de prix
			if ((!empty($prix_max)||(!empty($prix_min)))&&(!empty($rubriques))&&($nb=mysql_num_rows($result=RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference` = `produit_rubrique`.`produit_reference` WHERE 1 $rubriques $prix_max $prix_min GROUP BY `produits`.`produits_Reference` $tri"))))
				echo "$nb r�sultat$s trouv�$s parmis les produits de la rubrique que vous avez choisi dans vos crit�res de prix<br /><br />\n";
			//Sinon on regarde si il y a un produit correspondant aux mots cl�s mais en dehors des crit�res de prix dans la rubrique
			elseif ((!empty($rubriques))&&($nb=mysql_num_rows($result=RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference` = `produit_rubrique`.`produit_reference` WHERE 1 $recherche $rubriques GROUP BY `produits`.`produits_Reference` $tri"))))
				echo "$nb r�sultat$s trouv�$s parmis les produits de la rubrique en dehors de vos crit�res de prix<br /><br />\n";
			//Enfin on regarde si globalement sur le site il n'y a pas de produits correspondant aux crit�res de la recherche
			elseif ($nb=mysql_num_rows($result=RequeteSQL("SELECT `produits_Reference`,`produits_Libelle`,`produits_Prix`,`produits_Photo` FROM `produits` INNER JOIN `produit_rubrique` ON `produits`.`produits_Reference` = `produit_rubrique`.`produit_reference` WHERE 1 $recherche GROUP BY `produits`.`produits_Reference` $tri")))
				echo "$nb r�sultat$s trouv�$s parmis l'ensemble des produits du site avec vos mot-cl�s<br /><br />\n";
		}
		if ($nb>0)
			echo "<table class = 'liste_produits'><tr><th></th><th>Nom</th><th>Prix TTC</th></tr>\n\t";
		while($row=mysql_fetch_assoc($result)){
			echo "<tr>\n\t\t";
			echo "<td class='photo'><a href='index.php?type=produit&id=".$row["produits_Reference"]."'><img src='images/thumbs/".$row["produits_Photo"]."'></a></td>\n\t\t";
			echo "<td><a href='index.php?type=produit&id=".$row["produits_Reference"]."'>".$row["produits_Libelle"]."</a></td>\n\t\t";
			echo "<td class='prix'>".$row["produits_Prix"]." &euro;<a href='index.php?type=panier&produit=".$row['produits_Reference']."'><br /><img src='images/minipanier.jpg'></a></td></tr>";
			echo "</tr>\n\t";
		}
		if ($nb>0)
			echo "</table>\n";
		echo "<h4><a href='index.php?type=recherche'>Retour � la page de recherche</a></h4>";
	}
}
?>
