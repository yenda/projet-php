<?php
	if (!isset($_SESSION['login'])){
		header('Location: index.php&type=404');  
		exit();
	}
	else{
		
function VerifierAdresseMail($adresse) 
{ 
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$adresse)) 
      return true; 
   else 
     return false; 
}

$modification=false;
$result = RequeteSQL("SELECT * FROM `clients` WHERE `client_login` = '".$_SESSION['login']."'");
if (isset($_POST['pass']))
{
		echo"<div class='alert'>";
		if ((empty($_POST['pass'])) || (empty($_POST['pass2'])) || ($_POST['pass']!=$_POST['pass2']))
			echo "Le mot de passe n'est pas correctement saisi";
		else if ((empty($_POST['mail'])) || (VerifierAdresseMail($_POST['mail']==false)))
			echo "Le champ adresse e-mail n'est pas correctement rempli";
		else if (empty($_POST['telmain']))
			echo "Le champ numéro de téléphone n'est pas correctement rempli";
		else if((empty($_POST['nom'])) || (!is_string($_POST['nom'])))
			echo "Le champ nom n'est pas correctement rempli";
		else if((empty($_POST['prenom'])) || (!is_string($_POST['prenom'])))
			echo "Le champ prenom n'est pas correctement rempli";
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
			$pass=$_POST['pass'];
			$mail=$_POST['mail'];
			$telmain=$_POST['telmain'];
			$nom=$_POST['nom'];
			$prenom=$_POST['prenom'];
			$date_naissance=$_POST['dnannee']."-".$_POST['dnmois']."-".$_POST['dnjour'];
			$adresse=$_POST['adresse'];
			$cp=$_POST['cp'];
			$ville=$_POST['ville'];
			$cb=$_POST['cartebancaire'];
			$modification=true;
			
			//Ajout de l'utilisateur à la base de données
			$result=RequeteSQL("UPDATE `geekproduct`.`clients` SET client_mdp='$pass', client_nom='$nom', client_prenom='$prenom', client_datenaissance='$date_naissance', client_adresse='$adresse', client_codepostal='$cp', client_ville='$ville', clent_telephone='$telmain', client_mail='$mail', client_cartebancaire='$cb' WHERE client_login='$login';");
			echo "\nLa modification a été effectuée";
		}
		echo"</div>";
	}
}
	if($modification==false)
	{
		while ($row = mysql_fetch_assoc($result)) { 
			$mail=$row['client_mail'];
			$nom=$row['client_nom'];
			$prenom=$row['client_prenom'];
			$adresse=$row['client_adresse'];
			$cp=$row['client_codepostal'];
			$ville=$row['client_ville'];
			$tel=$row['client_telephone'];
			$cb=$row['client_cartebancaire'];
			$date=$row['client_datenaissance'];
?>

<form method="post" action="index.php?type=compte">
			<table style="margin-left:10px;" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" style="vertical-align:top;">
						<table style="margin:0;" width="350px" border="0" cellspacing="0" cellpadding="0" class="ToolBox2">
							<tr>
								<td class="Inner" width="100%" height="100" colspan="3" align="left" valign="top" style="padding:5px 10px 10px 10px;">

									<div class="ElemtMandat">Mon nouveau mot de passe</div>
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
										<input name="mail" type="text" id="mail" style="height:12px; font-size:10px; width:150px;" value="<?php echo $mail;?>" /> 									
									</div>
									<?php $jour=explode("-" ,$date);?>
									<div class="ElemtFac">Date de naissance</div>
									<select name="dnjour" id="dnjour">';
									<?php
									$jours = "option value='".$jour[2]."' selected></option>";
											for($i=1;$i<=31;$i++){
												$jours .= "\t\t\t\t\t\t\t\t\t\t<option value='".$i."'>".$i."</option>\n";
											}
											echo $jours;	
									?>	
									</select>
									
									<select name="dnmois" id="dnmois">
										<option></option>
										<option value="1">Janvier</option>
										<option value="2">Février</option>
										<option value="3">Mars</option>
										<option value="4">Avril</option>
										<option value="5">Mai</option>
										<option value="6">Juin</option>
										<option value="7">Juillet</option>
										<option value="8">Aout</option>
										<option value="9">Septembre</option>
										<option value="10">Octobre</option>
										<option value="11">Novembre</option>
										<option value="12">Décembre</option>

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
																																							
										<div class="ElemtMandat">Téléphone : </div>
										<div>
											<input name="telmain" type="text" id="telmain" style="height:12px; font-size:10px; width:150px;" value="<?php echo $tel ?>" />
										</div>

									</td>

							</tr>
						</table>
					</td>
					<td width="50%" style="vertical-align:top;padding-left:2px">
						<table class="ToolBox2" width="350px" border="0" cellspacing="0" cellpadding="0" style="margin:0;">
							<tr>
							
							</tr>
							<tr>
								<td class="Inner" width="100%" height="100" colspan="3" align="left" valign="top" style="padding:5px 10px 10px 10px;background:url(/images/gui/main/CptAddrIco.jpg) center right no-repeat;">

									<div class="ElemtMandat">Nom</div>
									<div>
										<input name="nom" type="text" id="nom" style="height:12px; font-size:10px; width:150px;" value="<?php echo $nom;?>" /> 									</div>

									<div class="ElemtMandat">Prénom</div>
									<div>
										<input name="prenom" type="text" id="prenom" style="height:12px; font-size:10px; width:150px;" value="<?php echo $prenom;?>" /> 									</div>

									<div class="ElemtMandat" id="SocieteBlock" style="display:none;">
										<div class="ElemtFac"  id="labelsociete"></div>
										<div>
											<input name="societe" type="text" id="societe" style="height:12px; font-size:10px; width:150px;" value="" />

										</div>
									</div>

									<div class="ElemtMandat">Adresse <br /> <span class="ElemtFac">(n° rue et libellé rue)</span></div>
									<div>
										<input name="rue1" type="text" id="rue1" style="height:12px; font-size:10px; width:150px;" maxlength="60" value="<?php echo $adresse;?>" />
									</div>
									<div class="ElemtMandat">Code postal</div>
									<div>
										<input name="cp" type="text" id="cp" style="height:12px; font-size:10px; width:150px;" value="<?php echo $cp;?>" maxlength="5" />
									</div>

									<div class="ElemtMandat">Ville</div>
									<div>
										<input name="ville" type="text" id="ville" style="height:12px; font-size:10px; width:150px;" value="<?php echo $ville;?>" />
									</div>
									
									<div class="ElemtMandat">Numéro de carte bancaire</div>
									<div>
										<input name="cartebancaire" type="text" id="cartebancaire" style="height:12px; font-size:10px; width:150px;" value=<?php echo $cb;?> />
									</div>

								</td>
							</tr>
						</table>
						<?php }?>

						<table class="ToolBox2" style="margin-top:10px;" width="350px" border="0" cellspacing="0" cellpadding="0">

						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table class="ToolBox2" width="725px" cellspacing="0" cellpadding="0" border="0" style="margin-top: 10px;">
							<tr>
								<td>
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