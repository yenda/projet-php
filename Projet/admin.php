<?php
	//Les pages réservées à l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_ENV['type']))||(!isset($_SESSION['login']))&&($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>

	<h1>Administration</h1>
	
	Choisissez l'action que vous souhaitez effectuer :
	
	<br /><br />
	
	<ul>
		<li><a href='index.php?type=initialiser'><b>Initialiser la base</b></a></li>
		<li><a href='index.php?type=remplir_base'><b>Remplir la base</b></a></li>
		<li><a href='index.php?type=supprimer_produit'><b>Supprimer un produit</b></a></li>			
	</ul>

<?php 
	}
?>