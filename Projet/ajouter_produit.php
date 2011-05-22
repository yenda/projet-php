<?php
	//Les pages réservées à l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>
<h1>Ajout d'un produit</h1>
<?php
	
	//Les fonctions de cette page sont similaires à celle de remplir base
?>
	<form method="post" action="index.php?type=ajouter_produit">
		<label for="pseudo">Libelle du produit (255 caractères maximum) :</label><br />
		<input type='text' name="produits_Libelle" size="100" maxlenght="255"/><br />
		<label for="pseudo">Prix du produit :</label><br />
		<input type='text' name="produits_Prix" size="35" maxlenght="20"/><br />
		<label for="pseudo">Unité de vente (100 caractères maximum) :</label><br />
		<input type='text' name="produits_UniteDeVente" size="100" maxlenght="100"/><br />
		<label for="pseudo">Photo du produit (attention ne mettez pas le chemin du fichier, les photos doivent être dans le bon dossier) :</label><br />
		<input type='text' name="produits_Photo" size="100" maxlenght="255"/><br />
		<label for="pseudo">Description du produit :</label><br />
		<textarea type='text' name="produits_Descriptif" rows="10" cols="75"></textarea><br /><br />
		<input type='submit' value='Ajouter le produit' /><br />
	</form>
<?php 
	}
?>
<h4><a href="index.php?type=admin">Retour à la page d'administration</a></h4>
