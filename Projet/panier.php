<?php
	include ("redirection.php");
?>
	
<?php
	//On gère les actions de modifications du panier qui ont pu être sollicitées par l'utilisateur en cliquant sur le bouton correspondant
	if(isset($_POST['action'])){
		if ($_POST['action']=="effacer"){
			supprimePanier();
			creationPanier();
		}
		elseif ($_POST['action']=="supprimer")
			supprimerArticle(intval($_POST['produit']));
		elseif ($_POST['action']=="modifier")
			//On s'assure que ce sont bien des entiers qui sont transmis (si l'utilisateur écrit n'importe quoi intval renvoit 0 et rien ne se passe)
			modifierQTeArticle(intval($_POST['produit']),intval($_POST['qte']));
	}
	//On gère l'éventuel ajout d'un produit par l'utilisateur
	if(isset($_GET['produit'])){ 
	   //récuperation de l'id du produit à ajouter
	   $produit = intval($_GET['produit']);
	
	   //On vérifie que le produit existe et on l'ajoute si c'est le cas
	   $result = RequeteSQL("SELECT * FROM `produits` WHERE `produits_Reference` = ".$produit);
			if ($row=mysql_fetch_assoc($result)){
				ajouterArticle($produit);
				echo "<br /><div class='alert'>".$row['produits_Libelle']." a été ajouté à votre panier</div>";
			}
			else{
				echo "<div class='alert'><br />Le produit que vous essayez d'ajouter n'existe pas</div>";
			}
	}
	
	//On affiche le panier sauf si il est vide
	$nbArticles=count($_SESSION['panier']['produits_Reference']);
	if ($nbArticles <= 0)
		echo "<br /><br />Votre panier est vide";
	else{
?>
	<h1>Votre panier</h1>
	<table class="caddie">
		<tr>
			<th>Libellé</th>
			<th>Prix à l'unité</th>
			<th>Quantité</th>
			<th>Action</th>
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
			echo '<form method="post" action="index.php?type=panier">';
			echo "<td><input type='text' value='".$_SESSION['panier']['produits_Quantite'][$i]."' name='qte' style='text-align:center; width:50px;' maxlength='3'/>";
			echo "<br /><input type='submit' value='Modifier quantité' /><input type='hidden' name='action' value='modifier'/><input type='hidden' name='produit' value='$i'/></td>";
			echo "</form>";
			$_SESSION['panier']['total'] += $row['produits_Prix']*$_SESSION['panier']['produits_Quantite'][$i];
			echo '<form method="post" action="index.php?type=panier">';
			echo "<td><input type='submit' value='Supprimer produit'/><input type='hidden' name='action' value='supprimer'/><input type='hidden' name='produit' value='$i'/></td>";
			echo "</form>";
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
			<td>
				<form method="post" action="index.php?type=panier">
					<input type="submit" value="Effacer panier"/>
					<input type="hidden" name="action" value="effacer"/>
				</form>
			</td>
		</tr>
		
</table>

<h1>
	<form method="post" action="index.php?type=finalisation_commande">
		<input type="submit" value="Finaliser la commande"/>
	</form>
</h1>
<?php 
	}	
?>