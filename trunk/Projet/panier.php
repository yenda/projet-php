<?php
if(isset($_POST['action'])){
	if ($_POST['action']=="effacer"){
		supprimePanier();
		creationPanier();
	}
	elseif ($_POST['action']=="supprimer")
		supprimerArticle($_POST['produit']);
}

if(isset($_GET['produit'])){ 
   //récuperation de l'id du produit à ajouter
   $produit = intval($_GET['produit']);

   $result = RequeteSQL("SELECT * FROM `produits` WHERE `produits_Reference` = ".$produit);
		if ($row=mysql_fetch_assoc($result)){
			ajouterArticle($produit);
			echo "<br /><div class='alert'>".$row['produits_Libelle']." a été ajouté à votre panier</div>";
		}
		else{
			echo "<div class='alert'><br />Le produit que vous essayez d'ajouter n'existe pas</div>";
		}
}
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
      	$_SESSION['panier']['quant'] = 0;
		$requete = "SELECT * FROM `produits` WHERE 0";
		foreach($_SESSION['panier']['produits_Reference'] as $reference){
			$requete .= "|| `produits_Reference` = ".$reference;			
		}
		$result=RequeteSQL($requete);
		$i=$nbArticles;
		while($row=mysql_fetch_assoc($result)){
			echo "<tr>";
			echo "<td><a href='index.php?type=produit&id=".$row['produits_Reference']."'>".$row['produits_Libelle']."</a></td>";
			echo "<td>".$row['produits_Prix']." &euro;</td>";
			$i = array_search($row['produits_Reference'],  $_SESSION['panier']['produits_Reference']);
			echo "<td>".$_SESSION['panier']['produits_Quantite'][$i]."</td>";
			$_SESSION['panier']['quant'] += $_SESSION['panier']['produits_Quantite'][$i];
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
				<?php
					$s="";
					if ($_SESSION['panier']['quant']>1)
						$s="s"; 
					echo $_SESSION['panier']['quant']." produit$s";?> 
			</td>
			<td>
				<form method="post" action="index.php?type=panier">
					<input type="submit" value="Effacer panier"/>
					<input type="hidden" name="action" value="effacer"/>
				</form>
			</td>
		</tr>
		
</table>
</form>
<?php 
	}	
?>