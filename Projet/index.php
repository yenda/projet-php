<?php 
	session_start();
	include_once 'fonctions.php';
	include_once 'fonctions_menu.php';
	include_once 'fonctions_panier.php';
	

	$connect = ConnexionDB();
	$result = Recuperation_infos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GeekProducts</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	</head>

	<body>

		<div id="page">
				
		<div id="haut">
			<table  class="tableau_entete">
				<tr>
					<td width="100px">
						<a href="index.php"><img src="images/logo.gif" width="100px" height="50px" alt="GeekProducts" title="GeekProducts"></a>
					</td>
					<td width="700px">
						<form method="post" action="index.php?type=recherche">
							<input name="recherche" type="text" id="recherche" style="height:20px; font-size:13px; width:200px;" value="" maxlength="50" />
							<input type="submit" name="Submit" value="OK"/> 
						</form>
					</td> 
					<td>
						<div align="right">						
							<?php if (!isset($_SESSION['login'])){?>
							<a href="index.php?type=inscription">Inscription</a> | 
							<a href="index.php?type=login">Connexion</a>
							<?php } else {if ($_SESSION['login']="admin"){?>
							<a href="index.php?type=admin">Administration</a>
							<?php } else { ?>
							<a href="index.php?type=compte">Mon Compte</a>
							<?php } ?>
							<a href="deconnexion.php">| Deconnexion</a>
							<?php } ?></div>
					</td>
				</tr>
			</table>
		</div>
		<table class="tableau_page">
		<tr>
			<td height="1px">
				<div id="menu">
					<div class="menu"><a href="index.php" class="menu-special">Menu</a></div>
					<ul>
						<li><a href='index.php'><b>Accueil</b></a></li>
						<li><a href='index.php?type=recherche'><b>Recherche</b></a></li>
						<li><a href='index.php?type=conditions_de_vente'><b>Conditions de Vente</b></a></li>
						<li><a href='index.php?type=a_propos'><b>À Propos</b></a></li>					
					</ul>
				</div>				
			</td>
	
			<td rowspan="2">	
						
			<?php 
				if ($_ENV['type']!="panier"){
			?>
			<div class="panier">
				<table cellpadding="0" cellspacing="0" class="tableaupanier">
					<tr>
						<td>
							<strong>Panier</strong>
						</td>								
						<td>
							<div align="right"><?php echo "Total panier : ".$_SESSION['panier']['total']." &euro;";?></div>
						</td>
						
						<td>									
							<div align="right"><a href="index.php?type=panier">Afficher le panier <img src="images/fleche2.gif" class="fleche"></a></div>	
						</td>			
					</tr>				
				</table>
			</div>
			<?php 
				}	
			?>
		
		
		<div id="contenu">
		
			<?php
				if ($_ENV['type']=="produit")
					$chemin = CheminProduit($_ENV['id']);
				else
					$chemin = Chemin($_ENV['rubrique_id']);
				echo substr($chemin,6);
				if ($_ENV['type']=="index")
					$contenu ="accueil";
				else
					$contenu = $_ENV['type'];
				$contenu .= ".php";
				include ("$contenu");
				
			?>	
		</div>
		</td>
		</tr>
		
		<tr>
			<td>
				<div id="menu">
					<div class="menu"><a href="index.php?type=rubrique" class="menu-special">Catégories</a></div>
					<?php
						echo Menu();
					?> 
				</div>
			</td>
		</tr></table>

		
		<div id="bas" align="center">
			GNU GPL V3 Créateurs Eric Dvorsak, Maël Clesse
		</div>
			<?php DeconnexionDB($connect);?>
		</div>
	</body>
</html>
