<?php
	//Connexion � la BDD
	function ConnexionDB(){
		$connect = mysql_connect("localhost","root","")
			or die("erreur de connexion au serveur");
		
		mysql_select_db("geekproduct",$connect)
			or die("erreur de connexion � la base de donn�e");
			
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
	
	// R�cup�re les informations de la page concern�e ainsi que les r�sultats des requ�tes n�cessaires � la construction de la page
	function Recuperation_infos() {
		//On r�cup�re le type de page � afficher, qui sera index par d�faut
		if (isset($_GET['type'])){
				$_ENV['type'] = ($_GET['type']);
				$contenu = $_ENV['type'].".php";
				if (!file_exists("$contenu"))
					$_ENV['type'] = 404;
		}
		else {
			$_ENV['type'] = "index";
		}
		
		//On r�cup�re l'id de la page qui sera 0 par d�faut
		if (isset($_GET['id']))
			$_ENV['id'] = intval($_GET['id']);
		else
			$_ENV['id'] = 0;
		
		//On r�cup�re l'id et le nom de la rubrique si on est sur une page rubrique pour l'affichage du menu
		//Si elle n'existe pas o� si on est sur une page d'un autre type l'id est 0 et le nom de la rubrique "principale"
		//Ces variables sont importantes pour la construction du menu lat�ral
		if ($_ENV['type']=="rubrique"){
			$_ENV['rubrique_id'] = $_ENV['id'];
			$result = RequeteSQL("SELECT * FROM `rubriques` WHERE `rubrique_id` = ".$_ENV['rubrique_id']);
				if ($row=mysql_fetch_assoc($result))
					$_ENV['rubrique_nom']=$row["rubrique_nom"];
				else{
					$_ENV['rubrique_id'] = 0;
					$_ENV['rubrique_nom']="principale";
				}
		}
		else{
			$_ENV['rubrique_id'] = 0;
			$_ENV['rubrique_nom']="principale";
		}
	}
?>