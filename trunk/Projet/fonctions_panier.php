<?php
creationPanier();
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['total'] = 0;
      $_SESSION['panier']['quant'] = 0;
      $_SESSION['panier']['produits_Reference'] = array();
      $_SESSION['panier']['produits_Quantite'] = array();
   }
}


function ajouterArticle($produits_Reference,$produits_Quantite=1){
	//Si le produit existe déjà on ajoute seulement la quantité
	$positionProduit = array_search($produits_Reference,  $_SESSION['panier']['produits_Reference']);
	if ($positionProduit !== false){
		$_SESSION['panier']['produits_Quantite'][$positionProduit] += $produits_Quantite;
	}
	else{
		//Sinon on ajoute le produit
		$produits_Quantite=1;
		array_push( $_SESSION['panier']['produits_Reference'],$produits_Reference);
		array_push( $_SESSION['panier']['produits_Quantite'],$produits_Quantite);
	}
}

function modifierQTeArticle($produits_Reference,$produits_Quantite){
	//Si la quantité est positive on modifie sinon on supprime l'article
	if ($produits_Quantite > 0){
		//Recherche du produit dans le panier
		$positionProduit = array_search($produits_Reference,  $_SESSION['panier']['produits_Reference']);

		if ($positionProduit !== false){
			$_SESSION['panier']['produits_Quantite'][$positionProduit] = $produits_Quantite;
		}
	}
	else
	supprimerArticle($produits_Reference);
}

function supprimerArticle($i){
 	unset($_SESSION['panier']['produits_Reference'][$i]);
 	unset($_SESSION['panier']['produits_Quantite'][$i]);
}

/*function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['produits_Reference']); $i++)
   {
      $total += $_SESSION['panier']['produits_Quantite'][$i] * $_SESSION['panier']['produits_Prix'][$i];
   }
   return $total;
}*/

function supprimePanier(){
   unset($_SESSION['panier']);
}


function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['produits_Reference']);
   else
   return 0;
}

?>