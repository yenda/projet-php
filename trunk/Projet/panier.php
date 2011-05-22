<?php
include_once("fonctions_panier.php");
session_start();

$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
   $erreur=true;

   //récuperation des variables en POST ou GET
   $l = (isset($_POST['l'])? $_POST['produit']:  (isset($_GET['produit'])? $_GET['produit']:null )) ;
   $p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
   $q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;

   //Suppression des espaces verticaux
   $l = preg_replace('#\v#', '',$produit);
   //On verifie que $p soit un float
   $p = floatval($p);

   //On traite $q qui peut etre un entier simple ou un tableau d'entier
    
   if (is_array($q)){
      $produits_Quantite = array();
      $i=0;
      foreach ($q as $contenu){
         $produits_Quantite[$i++] = intval($contenu);
      }
   }
   else
   $q = intval($q);
    
}

if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($produit,$q);
         break;

      Case "suppression":
         supprimerArticle($produit);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($produits_Quantite) ; $i++)
         {
            modifierQTeArticle($_SESSION['panier']['produits_Reference'][$i],round($produits_Quantite[$i]));
         }
         break;

      Default:
         break;
   }
}

echo '<?xml version="1.0" encoding="utf-8"?>';?>

<form method="post" action="panier.php">
<table style="width: 400px" border="1">
	<tr>
		<td colspan="4">Votre panier</td>
	</tr>
	<tr>
		<td>Libellé</td>
		<td>Quantité</td>
		<td>Action</td>
	</tr>


	<?php
	if (creationPanier())
	{
	   $nbArticles=count($_SESSION['panier']['produits_Reference']);
	   if ($nbArticles <= 0)
	   echo "<tr><td>Votre panier est vide </td></tr>";
	   else
	   {
	      for ($i=0 ;$i < $nbArticles ; $i++)
	      {
	         echo "<tr>";
	         echo "<td>".htmlspecialchars($_SESSION['panier']['produits_Reference'][$i])."</td>";
	         echo "<td><input type=\"text\" size=\"4\" name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['produits_Quantite'][$i])."\"/></td>";
	         //echo "<td>".htmlspecialchars($_SESSION['panier']['produits_Prix'][$i])."</td>";
	         echo "<td><a href=\"".htmlspecialchars("index.php?type=panier&action=suppression&l=".rawurlencode($_SESSION['panier']['produits_Reference'][$i]))."\">Supprimer</a></td>";
	         echo "</tr>";
	      }

	      echo "<tr><td colspan=\"2\"> </td>";
	      echo "<td colspan=\"2\">";
	      //echo "Total : ".MontantGlobal();
	      echo "</td></tr>";

	      echo "<tr><td colspan=\"4\">";
	      echo "<input type=\"submit\" value=\"Rafraichir\"/>";
	      echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

	      echo "</td></tr>";
	   }
	}	
	?>
</table>
</form>