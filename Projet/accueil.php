<?php
	include ("redirection.php");
?>

<h1>Bienvenue sur notre site</h1>
<?php 
	//S�lection de tous les produits et de toutes les rubriques de la base
	$resultproduit= RequeteSQL("SELECT * FROM `produits`");
	$nbproduit = mysql_num_rows($resultproduit);
	$resultrubrique = RequeteSQL("SELECT * FROM `rubriques`");
	$nbrubrique = mysql_num_rows($resultrubrique);
	
	$s="";$nent="t";$ss="";
		
	if ($nbrubrique>1){
		$s="s";
		$nent="nent";
	}
	if ($nbproduit>1)
		$ss="s";
		
	echo "Nous vous proposons de naviguer parmi nos <b>$nbrubrique rubrique$s</b> qui contien$nent un total de <b>$nbproduit produit$ss</b> � d�couvrir !";
?>
<p>Pour commencer � naviguer dans notre boutique choisissez une rubrique dans le menu lat�ral o� cliquez sur la photographie du produit qui vous int�resse ci dessous</p>

<table class = 'liste_photos'>
<?php
//Affichage al�atoire de produits du site sur la page d'accueil 
	if ($nbproduit>0){
		for($i=0; $i<5;$i++){
			echo "<tr>";
			for($j=0; $j<5;$j++){
				$rand=mt_rand(1,$nbproduit-1);
				$photo=mysql_result($resultproduit,$rand,"produits_Photo");
				$reference=mysql_result($resultproduit,$rand,"produits_Reference");
				$libelle=mysql_result($resultproduit,$rand,"produits_Libelle");
				echo "<td>";
				echo "<a href='index.php?type=produit&id=".$reference."'><img src='images/thumbs/$photo' title='$libelle'></a></td>";
				echo "</td>";
			}
			echo "</tr>";
		}
	}
?>
</table>