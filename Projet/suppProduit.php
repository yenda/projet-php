<?php
	//Les pages réservées à l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>

<?php 
//Demander la référence d'un produit
//demander confirmation pour supprimer ce produit
//supprimer ce produit de la base : supprimer le produit de la base produit produit rubrique panier produit
?>

<?php 
	}
?>