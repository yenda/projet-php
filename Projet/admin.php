<?php
	if ((!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
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
		<li><a href='index.php?type=remplirBase'><b>Remplir la base</b></a></li>			
	</ul>

<?php 
	}
?>