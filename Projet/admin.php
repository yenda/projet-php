<?php
	//Les pages r�serv�es � l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_ENV['type']))||(!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
	//Permettre � l'administrateur de g�rer la base de donn�es et les commandes
?>

	<h1>Administration</h1>
	
	Choisissez l'action que vous souhaitez effectuer :
	
	<br /><br />
	
	<ul>
		<li><a href='index.php?type=compte'><b>G�rer le compte administrateur</b></a></li>
		<li><a href='index.php?type=visualiser_commandes'><b>Visualiser les commandes des clients</b></a></li>
		<li><a href='index.php?type=initialiser'><b>Initialiser la base</b></a></li>
		<li><a href='index.php?type=remplir_base'><b>Remplir la base</b></a></li>
		<li><a href='index.php?type=supprimer_produit'><b>Supprimer un produit</b></a></li>			
	</ul>

<?php 
	}
?>