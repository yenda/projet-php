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
	
	// Récupère les informations de la page concernée ainsi que les résultats des requêtes nécessaires à la construction de la page
	function Recuperation_infos() {
		//On récupère le type de page à afficher, qui sera index par défaut
		if (isset($_GET['type'])){
				$_ENV['type'] = ($_GET['type']);
				$contenu = $_ENV['type'].".php";
				if (!file_exists("$contenu"))
					$_ENV['type'] = 404;
		}
		else {
			$_ENV['type'] = "index";
		}
		
		//On récupère l'id de la page qui sera 0 par défaut
		if (isset($_GET['id']))
			$_ENV['id'] = intval($_GET['id']);
		else
			$_ENV['id'] = 0;
		
		//On récupère l'id de la rubrique si on est sur une page rubrique pour l'affichage du menu
		//sinon on met 0
		if ($_ENV['type']=="rubrique")
			$_ENV['rubrique_id'] = $_ENV['id'];
		else
			$_ENV['rubrique_id'] = 0;
			
		$result = RequeteSQL("SELECT * FROM `rubriques` WHERE `rubrique_id` = ".$_ENV['rubrique_id']);
		if ($row=mysql_fetch_assoc($result))
			$_ENV['rubrique_nom']=$row["rubrique_nom"];
		else{
			$_ENV['rubrique_id'] = 0;
			$_ENV['rubrique_nom']="principale";
		}
	}
?>