<?php
	//Les pages réservées à l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>
<h1>Suppression d'un produit</h1>
<p>Pour supprimer un produit indiquez la référence du produit dans le champs ci-dessous ou rendez-vous sur la page du produit que vous voulez supprimer</p>
<?php
	
//Demander la référence d'un produit
//demander confirmation pour supprimer ce produit
//supprimer ce produit de la base : supprimer le produit de la base produit produit rubrique panier produit
?>
	<form method="get" action="index.php">
		<input type='hidden' value="supprimer_produit" name="type">
		<input type='text' name='ref' />
		<input type='submit' value='Supprimer le produit' />
	</form>
	
	<h4><a href="index.php?type=admin">Retour à la page d'administration</a></h4>
<?php 
	
	}
?>

