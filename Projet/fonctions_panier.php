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

//Fonction de modification de la quantité d'un article
//Produit position est la position du produit dans le tableau panier
function modifierQTeArticle($produits_Position,$produits_Quantite){
	//Si la quantité est positive on modifie
	if ($produits_Quantite > 0)
		$_SESSION['panier']['produits_Quantite'][$produits_Position] = $produits_Quantite;
}

//Fonction de suppression d'un article du panier
function supprimerArticle($i){
 	unset($_SESSION['panier']['produits_Reference'][$i]);
 	unset($_SESSION['panier']['produits_Quantite'][$i]);
}


//Fonction de suppression du panier
function supprimePanier(){
   unset($_SESSION['panier']);
}

?>