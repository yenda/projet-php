<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Ceci est une page de test avec des balises PHP</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
    
    <body>
    	<?php
    	include ("entete.php");
    	?>
        <h2>Page de test</h2>
        
        <p>
        	ŽŽŽŽ
            Cette page contient du code (x)HTML avec des balises PHP.<br />
            <?php /* InsŽrer du code PHP ici */ ?>
            Voici quelques petits tests :
        </p>
        
        <ul>
        <li style="color: blue;">Texte en bleu</li>
        <li style="color: red;">Texte en rouge</li>
        <li style="color: green;">Texte en vert</li>
        </ul>
        
        <?php
        include ("menu.php");
        ?>
        
        <?php 
        include ("pied_de_page.php");
        ?>
    </body>
</html>