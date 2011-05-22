<?php
	if ((!isset($_SESSION['login']))&&($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>

<?php 
	}
?>