<?php 
	include 'fonctions.php';
	include 'fonctions_menu.php';

	$connect = ConnexionDB();
	$result = Recuperation_infos();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GeekProducts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	

</head>

<body>

<div id="page">

<div id="haut">
	<table cellpadding="0" cellspacing="0" class="tableau">
	<tr>
	<td>
	<a href="index.php"><img src="images/logo.gif" width="100px" height="50px" alt="GeekProducts" title="GeekProducts"></a>
	</td>
	<td>
	<input type="text" value="" /> 
	<input type="submit" name="lien1" value="Ok" onclick="self.location.href='page_a_definir.php'" style="background-color:white" style="color:white; font-weight:bold"onclick></input></td> 
	<td><div align="right"></div><a href="index.php?type=inscription">Inscription</a> | <a href="login.php">Connexion</a></div></td>
	</tr></table>
</div>

		<div id="menu">

			<div class="categories">Catégories</div>
			<?php
				echo Menu();
			?> 
		
			<br/><br/>
			<div class="menu">Menu</div>
				<ul>
					<li><a href="index.php">Accueil</a></li>
				</ul>
		</div>
				
		<?php 
		if ($_ENV['type']!="panier"){
				echo '<div class="panier">
					<table cellpadding="0" cellspacing="0" class="tableaupanier">
					<tr>
					<td>
						<form>
						<strong>Panier</strong>
					</td>
					
					<td>
						<div align="right">Total 0.00€</div>
					</td>
					
					<td>									
					<div align="right"><a href="index.php?type=panier" class="txtviewCart" id="flashBasket">Afficher le panier <img src="images/cartarrow.gif" class="fleche"></a></div>
						</form>
		
					</td>
		

					</tr>
		
				</table>
			</div>';
		}	
	?>


<div id="contenu">

	<?php
		if ($_ENV['type']=="index")
			include("accueil.php");
		elseif ($_ENV['type']=="rubrique")
			include("rubrique.php");
		elseif ($_ENV['type']=="produit")
			include("produit.php");
		elseif ($_ENV['type']=="recherche")
			include("recherche.php");
		elseif ($_ENV['type']=="inscription")
			include("inscription.php");
		else
			include("404.php");
	?>

	
	<div id="bas" align="center">
		GNU GPL V3 Créateurs Eric Dvorsak, Maël Clesse
	</div>
</div>
	<?php DeconnexionDB($connect);?>
</body>
</html>
