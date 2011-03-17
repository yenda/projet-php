<html>
<head>
	<title>Interface de gestion des notes de partiels</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>

<body>



<?php
		$connect = mysql_connect("localhost","root","root")
			or die(mysql_error());
		
		$result = mysql_select_db("partiel",$connect);	

  // Remarques :
  // L'utilisation de mysql_data_seek($resultat,0) permet de repositionner un "pointeur"
  // en début de résultat d'une interrogation Mysql et permet de re-parcourir les résultats
  // --> utile si le résultat d'une interrogation doit être parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des élèves et des matières

?>

	
<h1 align="center">Gestion des résultats de partiels</h1>
	

	
<h2>Fonctionnalités d'accès</h2>
		
	<!-- 1ere ligne -->
	
	<form method="post" target="Resultat" action="initialiser.php">
	<table width="640" border="1">
	<tr><td>
		<table border="0">
		<tr>
		    <td width="170" align="center">&nbsp;</td>
		    <td width="230" align="center">&nbsp;</td>
		    <td width="120" align="center">&nbsp;</td>
		    <td width="110" align="center">
		        <input type="submit" width="100" value="  Initialiser  ">	
		    </td>
		</tr>
		</table>
	</td></tr>
	</table>	
	</form>


	
	<!-- 2eme ligne -->

	<form method="post" target="Resultat" action="enregistrer.php">
	<table width="640" border="1">
	<tr><td>

		<table border="0">
		<tr>
		    <td width="170" align="left"> &Eacute;lève : 
              <select name="eleve" size="1">

<?php
	$query = "SELECT * FROM ELEVE";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<option value=\"".$row["prenom"]."\">".$row["prenom"]."</option>\n";
	}
?>

			</select>
		    </td>
		    <td width="230" align="left"> Matière : 
              <select name="matiere" size="1">
	
				
<?php
	$query = "SELECT * FROM MATIERE";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<option value=\"".$row["intitule"]."\">".$row["intitule"]."</option>";
	}
?>



			</select>
		    </td>
		    <td width="120" align="center">		    
		        Note : <input type="text" size="2" maxlength="2" name="note">	
		    </td>
		    
		    <td width="110" align="center">		    
		        <input type="submit" width="100" value="Enregistrer">	
		    </td>
		</tr>
		</table>
	</td></tr>
	</table>	
	</form>
		


        <!-- 3eme ligne -->

	<form method="post" target="Resultat" action="supprimer.php">
	<table width="640" border="1">
	<tr><td>
		<table border="0">
		<tr>
		    <td width="170" align="left"> &Eacute;lève : 
              <select name="eleve" size="1">
				
<?php
	$query = "SELECT * FROM ELEVE";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<option value=\"".$row["prenom"]."\">".$row["prenom"]."</option>";
	}
?>

			</select>
		    </td>
		    <td width="230" align="left"> Matière : 
              <select name="matiere" size="1">

				
<?php
	$query = "SELECT * FROM MATIERE";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<option value=\"".$row["intitule"]."\">".$row["intitule"]."</option>";
	}
?>
		
			</select>
		    </td>
		    <td width="120" align="center">&nbsp;		    
		        	
		    </td>
		    
		    <td width="110" align="center">		    
		        <input type="submit" width="100" value="Supprimer">	
		    </td>
		</tr>
		</table>
	</td></tr>
	</table>	
	</form>	
		                            
			
	<!-- 4eme ligne -->

	<form method="post" target="Resultat" action="afficher.php">
	<table width="640" border="1">
	<tr><td>
		<table border="0">
		<tr>
		    <td width="70" valign="top" align="left"> &Eacute;lèves : </td>
		    <td width="100">
<?php
	$query = "SELECT * FROM ELEVE";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<input type=\"checkbox\" name=\"".$row["prenom"]." value=\"".$row["prenom"]."\">".$row["prenom"]."<br>";
	}
?>

			
		    </td>
		    <td width="80" valign="top" align="left"> Matières : </td>
		    <td width="150">
<?php
	$query = "SELECT * FROM MATIERE";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<input type=\"checkbox\" name=\"".$row["intitule"]." value=\"".$row["intitule"]."\">".$row["intitule"]."<br>";
	}
?>

		    </td>
		    <td width="30">&nbsp;</td> 
		    <td width="90" valign="top" align="left">Trié par :<br />		    		    
		        <input name="tri" type="radio" value="eleve"    checked="checked">&Eacute;lèves
		        <br />
           		<input name="tri" type="radio" value="matiere"         >Matières
		    <td width="110" valign="top" align="center">		    
		        <input type="submit" width="100" value="Afficher">	
		    </td>
		</tr>
		</table>
	</td></tr>
	</table>	
	</form>


</body>
</html>
