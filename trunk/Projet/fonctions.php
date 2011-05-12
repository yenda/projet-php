<?php
	//Connexion à la BDD
	function ConnexionDB(){
		$connect = mysql_connect("localhost","root","")
			or die("erreur de connexion au serveur");
		
		mysql_select_db("geekproduct",$connect)
			or die("erreur de connexion à la base de donnée");
			
		return $connect;
	}
	
	//Deconnexion de la BDD
	function DeconnexionDB($connect){
		mysql_close($connect)
			or die(mysql_error());
	}
	
	//Requete SQL retournant un message en cas d'erreur
	function RequeteSQL($query){
		$result = mysql_query($query)
			or die("$query :".mysql_error());
		return $result;
	}
	
	// Récupère les informations de la page concernée
	function Recuperation_infos() {
		if (isset($_GET['type']))
			$_ENV['type'] = ($_GET['type']);
		else {
			$_ENV['type'] = "index";
		}
			if (isset($_GET['id']))
			$_ENV['id'] = ($_GET['id']);
		else {
			$_ENV['id'] = "";
		}	
		/*$strSQL = 'SELECT * FROM `pages` WHERE `Id_page` = '.$_ENV['id_page'];
		$resultat = requete_SQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		$_ENV['mots_cles'] = $tabl_result['Mots_cles'];
		$_ENV['description'] = $tabl_result['Description'];
		$_ENV['titre'] = $tabl_result['Titre'];
		$_ENV['contenu'] = $tabl_result['Contenu'];
		$_ENV['id_parent'] = $tabl_result['Id_parent'];*/
	}
?>