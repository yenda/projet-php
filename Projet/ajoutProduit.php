<?php
	//Les pages r�serv�es � l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>

<?php
	//Les fonctions de cette page sont similaires � celle de remplir base
?>

<?php 
	}
?>