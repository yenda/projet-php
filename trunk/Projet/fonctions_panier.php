<?php

function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['produits_Reference'] = array();
      $_SESSION['panier']['produits_Quantite'] = array();
   }
   return true;
}


function ajouterArticle($produits_Reference,$produits_Quantite){

   //Si le panier existe
   if (creationPanier())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($produits_Reference,  $_SESSION['panier']['produits_Reference']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['produits_Quantite'][$positionProduit] += $produits_Quantite;
      }
      else
      {
         //Sinon on ajoute le produit
         $produits_Quantite=1;
         array_push( $_SESSION['panier']['produits_Reference'],$produits_Reference);
         array_push( $_SESSION['panier']['produits_Quantite'],$produits_Quantite);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function libelleProduit (){
	
}

function modifierQTeArticle($produits_Reference,$produits_Quantite){
   //Si le panier éxiste
   if (creationPanier())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($produits_Quantite > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($produits_Reference,  $_SESSION['panier']['produits_Reference']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['produits_Quantite'][$positionProduit] = $produits_Quantite;
         }
      }
      else
      supprimerArticle($produits_Reference);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function supprimerArticle($produits_Reference){
   //Si le panier existe
   if (creationPanier())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['produits_Reference'] = array();
      $tmp['produits_Quantite'] = array();

      for($i = 0; $i < count($_SESSION['panier']['produits_Reference']); $i++)
      {
         if ($_SESSION['panier']['produits_Reference'][$i] !== $produits_Reference)
         {
            array_push( $tmp['produits_Reference'],$_SESSION['panier']['produits_Reference'][$i]);
            array_push( $tmp['produits_Quantite'],$_SESSION['panier']['produits_Quantite'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
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