<h1>Bienvenue sur notre site</h1>
<?php 
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
		
	echo "Nous vous proposons de naviguer parmi nos <b>$nbrubrique rubrique$s</b> qui contien$nent un total de <b>$nbproduit produit$ss</b> à découvrir !";
?>
<p>Pour commencer à naviguer dans notre boutique choisissez une rubrique dans le menu latéral où cliquer sur la photographie du produit qui vous intéresse ci dessous</p>

<table class = 'liste_produits'>
<?php 
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
?>
</table>