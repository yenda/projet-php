<?php
	include ("redirection.php");
?>

<?php 
	//On recherche les informations qui concernent le produit
	$result_produit = RequeteSQL("SELECT * FROM `produits` WHERE `produits_reference`=".$_ENV['id']);
	if (mysql_fetch_assoc($result_produit)){
		mysql_data_seek($result_produit,0);		
	
	//On affiche les informations obtenues
		$produit=mysql_fetch_assoc($result_produit);
		echo "\n\t\t\t<h1>".$produit["produits_Libelle"]."<br /><br />\n\t\t\t";
		echo "<img src='images/produits/".$produit["produits_Photo"]."'></h1>\n\t\t\t";
		echo "<table class = 'produit'>\n\t\t\t\t";
		echo "<tr><th>Prix</th><td>".$produit["produits_Prix"]."&euro;</td></tr>\n\t\t\t\t";
		echo "<tr><th>Référence</th><td>".$produit["produits_Reference"]."</td></tr>\n\t\t\t\t";
		echo "<tr><th>Description</th><td>".$produit["produits_Descriptif"]."</td></tr>\n\t\t\t\t";
		echo "<tr><th>Unité de vente</th><td>".$produit["produits_UniteDeVente"]."</td></tr>\n\t\t\t\t";
		echo "<tr><th>Date d'ajout au catalogue</th><td>".$produit["produits_DateAjout"]."</td></tr>\n\t\t\t";
		echo "</table>\n\t\t\t";
		echo "<h4><a href='index.php?type=panier&produit=".$produit['produits_Reference']."'>Ajouter au panier<br /><img src='images/minipanier.jpg'></a></h4>";
		if ((isset($_SESSION['login']))&&($_SESSION['login']=="admin")){
	?>		
	<h4>
		<form method="get" action="index.php">
			<input type='hidden' value="supprimer_produit" name="type" />
			<?php echo "<input type='hidden' value='".$_ENV['id']."' name='ref' />\n";?>
			<input type='submit' value='Supprimer le produit' />
		</form>
	</h4>
<?php 
		}
	}
	else
		include("404.php");
?>


