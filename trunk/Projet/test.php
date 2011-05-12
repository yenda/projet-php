<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<title>Document sans titre</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
</head> 
 
<body> 
<?php  
 
// Configuration  
// Nombre total de menus  
$nbr = 4;  
 
// Ci-dessous lister vos menus en mettant le titre en premiere place dans le array, les autres seront les sous-menus...  
$menu[1] = array ('Accueil',  
 
);  
 
$menu[2] =array('Virus et Spywares',  
'Virus MSN',  
'Norton et McAfee', 
 
);  
 
$menu[3] = array ('Windows Vista',  
'Activation de Vista',  
'Raccourcis clavier',  
'Point de restauration', 
'Effet Aéro', 
'Compatibilite', 
);  
 
$menu[4] = array ('Astuces',  
'Limiter la connexion d un compte utilisateur',  
); 
 
// On définis le style des menus  
$menu_tpl = '<div style="padding: 2px"><a href="{lien}">{element}</a></div>';  
 
// On boucle pour afficher tout les menus  
for ($i=1; $i<=$nbr; $i++) {  
      
    // On selectionne le nom du Menu  
    $element = $menu[ $i ][0];  
      
    // On prevoit de refermer le menu en cliquant sur le lien (si menu ouvert)  
     
    if ($_GET['to'] == $i) $lien = "";  
    else $lien = '?to='.$i;  
      
    // On applique le style  
    $in = array ('{element}', '{lien}');  
    $out = array ($element, $lien);  
      
    $menus = str_replace ($in, $out, $menu_tpl);  
      
    // On affiche le Menu stylé  
    echo '<p>'.$menus.'</p>';  
      
    // Si les sous-menus sont demandés, on les affiche en fonction...  
    if (isset($_GET['to']) && $_GET['to'] != '') {  
          
        // On vérifie le N° de Menu demandé pour limiter à 1 affichage les sous menus...  
        if ($i == $_GET['to']) {  
              
            // On boucle les sous-menus en fonctions des elements de l'array correspondant.  
            for ($j=1; $j<=count($menu[ $i ])-1; $j++) {  
                  
                // On affiche le lien des sous-menus  
                echo  '><a href="?to='.$i.'goto='.$j.' ">'.$menu[ $i ][ $j ].'</a><br />';  
              
            }  
          
        }  
      
    }  
 
}  
 
?>  
 
</body> 
</html>