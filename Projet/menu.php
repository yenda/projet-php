<table width="250" border="1">
	<tr><td>
		<table border="0">
		<tr>
		    <td width="170" align="left"> &Eacute;l�ve : 
              <select name="eleve" size="1">
				
<?php
	$query = "SELECT * FROM PRODUITS";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)){
		echo "<option value=\"".$row["prenom"]."\">".$row["prenom"]."</option>";
	}
?>
	
			</select>
		   </td></tr></table>
		  </table>
		  