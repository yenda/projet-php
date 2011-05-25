<?php
session_start();  
session_unset(); //Fin de session utilisateur 
session_destroy();  
header('Location: index.php');  
quit();
?>