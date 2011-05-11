<?php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GeekProducts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	    <script type="text/javascript">
    /*
    Mise en place de la fonction
    */
     
    function Choix(formulaire) {
    i = formulaire.Box1.selectedIndex;
     
    /*
    if servant à afficher le texte ( 0= valeur par défaut)
    */
     
    if (i == 0) {
      for (i=0;i<3;i++) {
        formulaire.Box2.options[i].text="";
        }
      return;
      }
    /*
    Switch en fonction de la valeur renvoyée par la Box1
    */
     
    switch (i) {
    case 1 : var txt = new Array ('AG2R PREVOYANCE','ASTANA','BOUYGUES TELECOM','CAISSE D\'EPARGNE','COFIDIS','CREDIT AGRICOLE','DISCOVERY CHANNEL','EUSKALTEL EUSKADI','FRANCAISE DES JEUX','GEROLSTEINER','LAMPRE - FONDITAL','LIQUIGAS','PREDICTOR - LOTTO','QUICK STEP - INNERGETIC','RABOBANK','SAUNIER DUVAL - PRODIR','T-MOBILE','TEAM CSC','TEAM MILRAM','UNIBET.COM'); break;
    case 2 : var txt = new Array ('Agritubel','Liberty Seguros','VC Roubaix'); break;
     
    }
     
     
    /*
    Boucle pour afficher le texte de la Box2
    */
     
    formulaire.Box2.options[0].text="--- Choisissez une Equipe ---";
    for (i=0;i<20;i++) {
      formulaire.Box2.options[i+1].text=txt[i];
     }
    }
     
     
    </script>
</head>

<body>

<?php
		include 'fonctions.php';
		include 'fonctions_menu.php';

		$connect = ConnexionDB();	

  // Remarques :
  // L'utilisation de mysql_data_seek($resultat,0) permet de repositionner un "pointeur"
  // en début de résultat d'une interrogation Mysql et permet de re-parcourir les résultats
  // utile si le résultat d'une interrogation doit être parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des élèves et des matières

?>

<div id="page">

<div id="haut">
	<a href="index.php"></a><img src="images/geekproducts.bmp" height="101px" width="200px"></a>
	<textarea style="width=100px" style="height=30px" rows="1" maxlength="50">Recherche</textarea> 
	<input type="button" name="lien1" value="Ok" onclick="self.location.href='lien.html'" style="background-color:white" style="color:white; font-weight:bold"onclick></input> 
</div>


<div id="menu">
	<?php echo Menu();?>
</div>

<div id="contenu">
	Voici le contenu du site. Nous vendons des produits informatique
</div>


<div align="center">	
	<div id="bas">
		<div align="center">GNU GPL V3 Créateurs Eric Dvorsak, Maël Clesse</div>
	</div>
</div>
</div>
	<?php DeconnexionDB($connect);?>
</body>
</html>
