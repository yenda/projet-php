<?php
include_once("fonctions_panier.php");
echo "</br>";
echo count($_SESSION['panier']['produits_Reference']);
echo "</br>";
print_r($_SESSION['panier']['produits_Reference'] );
echo "</br>";
print_r($_SESSION['panier']['produits_Quantite'] );
echo "</br>";

?>