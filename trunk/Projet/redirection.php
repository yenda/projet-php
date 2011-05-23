<?php
	if (!isset($_ENV['type'])){ 
  		header('Location: index.php&type=404');  
		exit();
	}   
?>