<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GeekProducts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<script type="text/javascript" src="jquery-1.3.2.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	
<script type="text/javascript"> 
<!-- 
$(document).ready( function () { 
    // On cache les sous-menus 
    // sauf celui qui porte la classe "open_at_load" : 
    $(".navigation ul.subMenu:not('.open_at_load')").hide(); 
    // On sélectionne tous les items de liste portant la classe "toggleSubMenu" 
 
    // et on remplace l'élément span qu'ils contiennent par un lien : 
    $(".navigation li.toggleSubMenu span").each( function () { 
        // On stocke le contenu du span : 
        var TexteSpan = $(this).text(); 
        $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ; 
    } ) ; 
 
    // On modifie l'évènement "click" sur les liens dans les items de liste 
    // qui portent la classe "toggleSubMenu" : 
    $(".navigation li.toggleSubMenu > a").click( function () { 
        // Si le sous-menu était déjà ouvert, on le referme : 
        if ($(this).next("ul.subMenu:visible").length != 0) { 
            $(this).next("ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") } ); 
        } 
        // Si le sous-menu est caché, on ferme les autres et on l'affiche : 
        else { 
            $(".navigation ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") }); 
            $(this).next("ul.subMenu").slideDown("normal", function () { $(this).parent().addClass("open") } ); 
        } 
        // On empêche le navigateur de suivre le lien : 
        return false; 
    }); 
 
} ) ; 
// --> 
 
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
