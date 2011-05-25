<?php
	include ("redirection.php");
?>

<?php 
$nbArticles=count($_SESSION['panier']['produits_Reference']);
if ($nbArticles <= 0)
	echo "<br /><br />Votre panier est vide";
else{
//On vérifie que tout les champs on été remplis correctement par l'utilisateur
$validation=false;
echo "<div class='alert'>";
if((empty($_POST['nom'])) || (!is_string($_POST['nom'])))
	echo "Le champ nom n'est pas correctement rempli";
else if((empty($_POST['prenom'])) || (!is_string($_POST['prenom'])))
	echo "Le champ prenom n'est pas correctement rempli";
else if((empty($_POST['adresse'])) || (!is_string($_POST['adresse'])))
	echo "Le champ adresse n'est pas correctement rempli";
else if((empty($_POST['codepostal'])) || (!is_numeric($_POST['codepostal'])))
	echo "Le champ code postal n'est pas correctement rempli";
else if((empty($_POST['ville'])) || (!is_string($_POST['ville'])))
	echo "Le champ ville n'est pas correctement rempli";
else if((empty($_POST['livraison'])))
	echo "Vous n'avez pas choisi de type de livraison";
else if((empty($_POST['carte'])) || (!is_numeric($_POST['carte'])))
	echo "Le champ carte bancaire n'est pas correctement rempli";
else
	$validation=true;
echo "</div>";
if ($validation){
?>

<h1>Votre commande a été validée !</h1>
<table class="caddie">
	<tr>
		<th>Libellé</th>
		<th>Prix à l'unité</th>
		<th>Quantité</th>
	</tr>
	
<?php
	$_SESSION['panier']['total'] = 0;
	//On effectue une requête SQL qui renvoit la ligne de la table produits de tout les produits du panier
	$requete = "SELECT * FROM `produits` WHERE 0";
	foreach($_SESSION['panier']['produits_Reference'] as $reference){
		$requete .= "|| `produits_Reference` = ".$reference;			
	}
	$result=RequeteSQL($requete);
	//On exploite le résultat de la requête pour afficher le contenu du panier
	while($row=mysql_fetch_assoc($result)){
		echo "<tr>";
		echo "<td><a href='index.php?type=produit&id=".$row['produits_Reference']."'>".$row['produits_Libelle']."</a></td>";
		echo "<td>".$row['produits_Prix']." &euro;</td>";
		//On recherche la référence du produit dans le tableau panier pour pouvoir afficher la bonne quantité
		$i = array_search($row['produits_Reference'],  $_SESSION['panier']['produits_Reference']);
		echo "<td>".$_SESSION['panier']['produits_Quantite'][$i]."</td>";

		$_SESSION['panier']['total'] += $row['produits_Prix']*$_SESSION['panier']['produits_Quantite'][$i];
		echo "</tr>";
	}
?>
	<tr>
		<td>
		</td>
		<td>
			Total : <?php echo $_SESSION['panier']['total'];?> &euro;
			</td>
			<td>
			</td>
		</tr>
		
</table>

<form method="post" action="index.php?type=validation_commande">

<h3>Type de livraison</h3>

<?php
	if ($_POST['livraison']=="colissimo"){
		$livraison = "Colissimo";
		$total = $_SESSION['panier']['total']+10;
	}
	else{
		$livraison = "Chronopost";
		$total = $_SESSION['panier']['total']+20;
	}
	echo $livraison;
?>

<h3>Adresse de livraison</h3>

<?php
	echo $_POST['nom'];
	echo "<br />";
	echo $_POST['prenom'];
	echo "<br />";
	echo $_POST['adresse'];
	echo "<br />";
	echo $_POST['codepostal'];
	echo "<br />";
	echo $_POST['ville'];
?>
		
<h3>Numéro de carte bancaire</h3>

<?php 
	echo $_POST['carte'];
?>

</form>
<h3>Total de la commande</h3>

<?php
	echo $total." &euro;";
	
	$login = mysql_real_escape_string($_SESSION['login']);
	$nom = mysql_real_escape_string($_POST['nom']);
	$prenom = mysql_real_escape_string($_POST['prenom']);
	$adresse = mysql_real_escape_string($_POST['adresse']);
	$codepostal = mysql_real_escape_string($_POST['codepostal']);
	$ville = mysql_real_escape_string($_POST['ville']);
	$carte = mysql_real_escape_string($_POST['carte']);
	$livraison = mysql_real_escape_string($_POST['livraison']);
	$date = date("Y-m-d");
	//On ajoute le panier à la base
	RequeteSQL("INSERT INTO `geekproduct`.`panier_client` VALUES (NULL, '$total', '$login', '$nom', '$prenom', '$adresse', '$codepostal', '$ville', '$carte', '$livraison','$date');");
	$id=mysql_insert_id();
	foreach ($_SESSION['panier']['produits_Reference'] as $i=>$produit){
		$produit;
		$qte = $_SESSION['panier']['produits_Quantite'][$i];
		RequeteSQL("INSERT INTO `geekproduct`.`panier_produit` VALUES ($id, '$produit', '$qte');");
	}
	supprimePanier();
?>

<h1>
	<form method="post" action="index.php">
		<input type="submit" value="Retourner à l'accueil"/>
	</form>
</h1>

<?php
	//Si il n'y a pas de commande à valider (le client a accédé à la page via l'URL)
}	
else{
?>
		<h4><a href="index.php?type=finalisation_commande">Retourner à la confirmation de la commande</a><br /></h4>
<?php
}}
?>