<?php
	function ConnexionDB(){
		$connect = mysql_connect("localhost","root","")
			or die("erreur de connexion au serveur");
		
		mysql_select_db("geekproduct",$connect)
			or die("erreur de connexion � la base de donn�e");
			
		return $connect;
	}
	
	function DeconnexionDB($connect){
		mysql_close($connect)
			or die(mysql_error());
	}
	
	function RequeteSQL($query){
		$result = mysql_query($query)
			or die("$query :".mysql_error());
		return $result;
	}
?>