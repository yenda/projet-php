<?php
	include ("redirection.php");
	$inscrit=false;//Bool�en pass� � vrai si les informations saisies sont exactes
?>

<?php 
function VerifierAdresseMail($adresse) 
{ 
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$adresse)) 
      return true; 
   else 
     return false; 
}

function VerifierDisponibiliteLogin ($login)
{
	$result = RequeteSQL("SELECT * FROM clients WHERE client_login='$login'");
	if (mysql_num_rows($result)==0)
		return true;
	else 
		return false;
}
?>

<?php 
if (isset($_POST['login']))
{
	if (VerifierDisponibiliteLogin($_POST['login'])==false)
			echo "Login non disponible, veuillez en choisir un autre";
	else 
	{
		echo"<div class='alert'>";
		if ((empty($_POST['login'])) || (!is_string($_POST['login'])))
			echo "Le champ nom d'utilisateur n'est pas correctement rempli";
		else if ((empty($_POST['pass'])) || (empty($_POST['pass2'])) || ($_POST['pass']!=$_POST['pass2']))
			echo "Le mot de passe n'est pas correctement saisi";
		else if ((empty($_POST['mail'])) || (VerifierAdresseMail($_POST['mail']==false)))
			echo "Le champ adresse e-mail n'est pas correctement rempli";
		else if (empty($_POST['telmain']))
			echo "Le champ num�ro de t�l�phone n'est pas correctement rempli";
		else if((empty($_POST['nom'])) || (!is_string($_POST['nom'])))
			echo "Le champ nom n'est pas correctement rempli";
		else if((empty($_POST['prenom'])) || (!is_string($_POST['prenom'])))
			echo "Le champ pr�nom n'est pas correctement rempli";
		else if((empty($_POST['adresse'])) || (!is_string($_POST['adresse'])))
			echo "Le champ adresse n'est pas correctement rempli";
		else if((empty($_POST['cp'])) || (!is_numeric($_POST['cp'])))
			echo "Le champ code postal n'est pas correctement rempli";
		else if((empty($_POST['ville'])) || (!is_string($_POST['ville'])))
			echo "Le champ ville n'est pas correctement rempli";
		else if (!isset($_POST['verif']))
			echo "Vous devez cocher la case pour certifier l'exactitude des renseignements fournis";
		else 
		{
			$login=$_POST['login'];
			//On ajoute le login du client et un salt avant de crypter le mot de passe pour �viter que le hash soit plus difficile � contourner
			$pass = $_POST['pass'].$login.'geekproduct';
			$pass = md5($pass);
			$mail=$_POST['mail'];
			$telmain=$_POST['telmain'];
			$nom=$_POST['nom'];
			$prenom=$_POST['prenom'];
			$date_naissance=$_POST['dnannee']."-".$_POST['dnmois']."-".$_POST['dnjour'];
			$adresse=$_POST['adresse'];
			$cp=$_POST['cp'];
			$ville=$_POST['ville'];
			$cb=$_POST['cartebancaire'];
			$inscrit=true;
			
			//Ajout de l'utilisateur � la base de donn�es
			$result=RequeteSQL("INSERT INTO `geekproduct`.`clients` VALUES ('$login', '$pass', '$nom', '$prenom', '$date_naissance', '$adresse', '$cp', '$ville', '$telmain', '$mail', '$cb');");
			echo "\nVous �tes inscrit";
		}
		echo"</div>";
	}
}
	if($inscrit==false)
	{
	//Si l'utilisateur a mal renseign� ses informations, il doit recommencer
?>
			<form method="post" action="index.php?type=inscription">
			<table style="margin-left:10px;" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" style="vertical-align:top;">
						<table style="margin:0;" width="350px" border="0" cellspacing="0" cellpadding="0" class="ToolBox2">
							<tr>
								<td class="Inner" width="100%" height="100" colspan="3" align="left" valign="top" style="padding:5px 10px 10px 10px;">
									<div class="ElemtMandat">Mon nom d'utilisateur</div>
									<div>
										<input name="login" type="text" id="login" style="height:12px; font-size:10px; width:150px;" value="" maxlength="20" />
									</div>

									<div class="ElemtMandat">Mon mot de passe</div>
									<div>
										<input name="pass" type="password" id="pass" style="height:12px; font-size:10px; width:150px;" value="" maxlength="30" />
										<div id="PassMessage"></div>
									</div>
									<div class="ElemtMandat">Confirmation du mot de passe</div>
									<div>
										<input name="pass2" type="password" id="pass2" style="height:12px; font-size:10px; width:150px;"value="" maxlength="30" />

									</div>
									<div class="ElemtMandat">Mon adresse e-mail : </div>
									<div>
										<input name="mail" type="text" id="mail" style="height:12px; font-size:10px; width:150px;" value="" /> 									
									</div>
									<div class="ElemtFac">Date de naissance</div>
									<select name="dnjour" id="dnjour">
										<?php
											$jours = "<option></option>\n";
											for($i=1;$i<=31;$i++){
												$jours .= "\t\t\t\t\t\t\t\t\t\t<option value='".$i."'>".$i."</option>\n";
											}
											echo $jours;
										?>	
									</select>
									
									<select name="dnmois" id="dnmois">
										<option></option>
										<option value="1">Janvier</option>
										<option value="2">F�vrier</option>
										<option value="3">Mars</option>
										<option value="4">Avril</option>
										<option value="5">Mai</option>
										<option value="6">Juin</option>
										<option value="7">Juillet</option>
										<option value="8">Aout</option>
										<option value="9">Septembre</option>
										<option value="10">Octobre</option>
										<option value="11">Novembre</option>
										<option value="12">D�cembre</option>

									</select>
									<select name="dnannee" id="dnannee">
										<?php 
											$annees = "<option></option>\n";
											for($i=date("Y");$i>=1900;$i--){
												$annees .= "\t\t\t\t\t\t\t\t\t\t<option value='".$i."'>".$i."</option>\n";
											}
											echo $annees;
										?>										
									</select>
																																							
										<div>T�l�phone : </div>
										<div>
											<input name="telmain" type="text" id="telmain" style="height:12px; font-size:10px; width:150px;" value="" />
										</div>

									</td>

							</tr>
						</table>
					</td>
					<td width="50%" style="vertical-align:top;padding-left:2px">
						<table width="350px" border="0" cellspacing="0" cellpadding="0" style="margin:0;">
							<tr>
							
							</tr>
							<tr>
								<td>
									<div>Nom</div>
									<div>
										<input name="nom" type="text" id="nom" style="height:12px; font-size:10px; width:150px;" value="" /> 
									</div>

									<div>Pr�nom</div>
									<div>
										<input name="prenom" type="text" id="prenom" style="height:12px; font-size:10px; width:150px;" value="" />
									</div>

									<div>Adresse <br /> <span class="ElemtFac">(n� rue et libell� rue)</span></div>
									<div>
										<input name="adresse" type="text" id="adresse" style="height:12px; font-size:10px; width:150px;" maxlength="60" value="" />
									</div>
									<div>Code postal</div>
									<div>
										<input name="cp" type="text" id="cp" style="height:12px; font-size:10px; width:150px;" value="" maxlength="5" />
									</div>

									<div>Ville</div>
									<div>
										<input name="ville" type="text" id="ville" style="height:12px; font-size:10px; width:150px;" value="" />
									</div>
									
									<div>Num�ro de carte bancaire</div>
									<div>
										<input name="cartebancaire" type="text" id="cartebancaire" style="height:12px; font-size:10px; width:150px;" maxlength="16" value="" />
									</div>

								</td>
							</tr>
						</table>

						<table style="margin-top:10px;" width="350px" border="0" cellspacing="0" cellpadding="0">

						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="725px" cellspacing="0" cellpadding="0" border="0" style="margin-top: 10px;">

							<tr>
								<th width="715" align="left">Validation <img width="8" height="11" alt="" style="display: inline;"/></th>
							</tr>
							<tr>
								<td>
									<input type="checkbox" name="verif" id="verif"/><label for="verif"> Je certifie exactes les informations renseign�es dans les champs ci-dessus.</label>
									<br/>

									<input name="back" type="hidden" id="back" value="">
									<input name="op" type="hidden" id="op" value="register" />
									<input type="submit" value="Valider et envoyer" style="margin-top:10px; float:right;" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</form>
<?php }?>