<?php
	include ("redirection.php");
?>
	
<?php
	//On g�re les actions de modifications du panier qui ont pu �tre sollicit�es par l'utilisateur en cliquant sur le bouton correspondant
	if(isset($_POST['action'])){
		if ($_POST['action']=="effacer"){
			supprimePanier();
			creationPanier();
		}
		elseif ($_POST['action']=="supprimer")
			supprimerArticle(intval($_POST['produit']));
		elseif ($_POST['action']=="modifier")
			//On s'assure que ce sont bien des entiers qui sont transmis (si l'utilisateur �crit n'importe quoi intval renvoit 0 et rien ne se passe)
			modifierQTeArticle(intval($_POST['produit']),intval($_POST['qte']));
	}
	//On g�re l'�ventuel ajout d'un produit par l'utilisateur
	if(isset($_GET['produit'])){ 
	   //r�cuperation de l'id du produit � ajouter
	   $produit = intval($_GET['produit']);
	
	   //On v�rifie que le produit existe et on l'ajoute si c'est le cas
	   $result = RequeteSQL("SELECT * FROM `produits` WHERE `produits_Reference` = ".$produit);
			if ($row=mysql_fetch_assoc($result)){
				ajouterArticle($produit);
				echo "<br /><div class='alert'>".$row['produits_Libelle']." a �t� ajout� � votre panier</div>";
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
			<th>Libell�</th>
			<th>Prix � l'unit�</th>
			<th>Quantit�</th>
			<th>Action</th>
		</tr>
<?php 
      	$_SESSION['panier']['total'] = 0;
      	//On effectue une requ�te SQL qui renvoit la ligne de la table produits de tout les produits du panier
		$requete = "SELECT * FROM `produits` WHERE 0";
		foreach($_SESSION['panier']['produits_Reference'] as $reference){
			$requete .= "|| `produits_Reference` = ".$reference;			
		}
		$result=RequeteSQL($requete);
		//On exploite le r�sultat de la requ�te pour afficher le contenu du panier
		while($row=mysql_fetch_assoc($result)){
			echo "<tr>";
			echo "<td><a href='index.php?type=produit&id=".$row['produits_Reference']."'>".$row['produits_Libelle']."</a></td>";
			echo "<td>".$row['produits_Prix']." &euro;</td>";
			//On recherche la r�f�rence du produit dans le tableau panier pour pouvoir afficher la bonne quantit�
			$i = array_search($row['produits_Reference'],  $_SESSION['panier']['produits_Reference']);
			echo '<form method="post" action="index.php?type=panier">';
			echo "<td><input type='text' value='".$_SESSION['panier']['produits_Quantite'][$i]."' name='qte' style='text-align:center; width:50px;' maxlength='3'/>";
			echo "<br /><input type='submit' value='Modifier quantit�' /><input type='hidden' name='action' value='modifier'/><input type='hidden' name='produit' value='$i'/></td>";
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