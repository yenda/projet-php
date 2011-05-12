<?php 
	include 'fonctions.php';
	include 'fonctions_menu.php';

	$connect = ConnexionDB();
	Recuperation_infos();
?>

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
    // On s�lectionne tous les items de liste portant la classe "toggleSubMenu" 
 
    // et on remplace l'�l�ment span qu'ils contiennent par un lien : 
    $(".navigation li.toggleSubMenu span").each( function () { 
        // On stocke le contenu du span : 
        var TexteSpan = $(this).text(); 
        $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ; 
    } ) ; 
 
    // On modifie l'�v�nement "click" sur les liens dans les items de liste 
    // qui portent la classe "toggleSubMenu" : 
    $(".navigation li.toggleSubMenu > a").click( function () { 
        // Si le sous-menu �tait d�j� ouvert, on le referme : 
        if ($(this).next("ul.subMenu:visible").length != 0) { 
            $(this).next("ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") } ); 
        } 
        // Si le sous-menu est cach�, on ferme les autres et on l'affiche : 
        else { 
            $(".navigation ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") }); 
            $(this).next("ul.subMenu").slideDown("normal", function () { $(this).parent().addClass("open") } ); 
        } 
        // On emp�che le navigateur de suivre le lien : 
        return false; 
    }); 
 
} ) ; 
// --> 
 
</script>
</head>

<body>

<div id="page">

<div id="haut">
	<a href="index.php"><img src="images/logo.gif" height="101px" width="200px" alt="GeekProducts" title="GeekProducts"></a>
	<input type="text" value= /> 
	<input type="submit" name="lien1" value="Ok" onclick="self.location.href='page_a_definir.php'" style="background-color:white" style="color:white; font-weight:bold"onclick></input> 
</div>


<div id="menu">
	<div class="boxTitleRight">Cat�gories</div>
	<?php echo Menu();?>
	
</div>

<div id="contenu">
	<?php
		if ($_ENV['type']=="index")
			include("accueil.php");
		elseif ($_ENV['type']=="rubrique")
			include("rubrique.php");
		elseif ($_ENV['type']=="rubrique")
			include("produit.php");
		else
			include("404.php");

	?>
</div>

	
	<div id="bas" align="center">
		GNU GPL V3 Cr�ateurs Eric Dvorsak, Ma�l Clesse
	</div>
</div>
	<?php DeconnexionDB($connect);?>
</body>
</html>
