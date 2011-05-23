<?php
	//Les pages réservées à l'administrateur renvoient une erreur 404 lorsque quelqu'un essaye de les atteindre en passant par l'URL
	if ((!isset($_ENV['type']))||(!isset($_SESSION['login']))||($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
?>
<h1>Suppression d'un produit</h1>
<?php
	
//demander confirmation pour supprimer ce produit
//supprimer ce produit de la base : supprimer le produit de la base produit produit rubrique panier produit

	if(empty($_GET['ref'])){
?>
	<p>Pour supprimer un produit indiquez la référence du produit dans le champs ci-dessous ou rendez-vous sur la page du produit que vous voulez supprimer</p>
	
	<form method="get" action="index.php">
		<input type='hidden' value="supprimer_produit" name="type" />
		<input type='text' name='ref' />
		<input type='submit' value='Supprimer le produit' />
	</form>
<?php 
	}
	else {
		$ref=$_GET['ref'];
		$result = RequeteSQL("SELECT `produits_Libelle` FROM `produits` WHERE `produits_Reference`=".$ref);
		if (mysql_fetch_assoc($result)){
			mysql_data_seek($result,0);
		$produit=mysql_fetch_assoc($result);		
		$result = RequeteSQL("DELETE FROM `produits` WHERE `produits_reference`=".$ref);		
		echo "Le produit suivant : 	<b>&quot;".$produit['produits_Libelle']."&quot;</b> ayant pour référence $ref a été supprimé";
		}
		else{
?>
	<div class='alert'>Il n'y a pas de produit correspondant à cette référence</div>
<?php 				
		}
?>
	<h4><a href="index.php?type=supprimer_produit">Supprimer un autre produit</a></h4>
<?php 
	}
?>	
	<h4><a href="index.php?type=admin">Retour à la page d'administration</a></h4>
<?php 
	
	}
?>

