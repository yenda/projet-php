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
	<form method="get" action="index.php">
		<input type='hidden' value="ajouter_produit" name="type" />
		<input type='file' name='xml' />
		<input type='submit' value='Remplir la base' />
	</form>
<?php 
	}
?>
<h4><a href="index.php?type=admin">Retour à la page d'administration</a></h4>
