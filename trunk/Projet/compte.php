<?php
	if ((!isset($_SESSION['login']))&&($_SESSION['login']!="admin")){
		header('Location: index.php&type=404');  
		exit();
	}
	else{

$result = RequeteSQL("SELECT * FROM `clients` WHERE `client_login` = '".$_SESSION['login']."'");
$row=mysql_fetch_assoc($result);
?>

<form method="post" action="index.php?type=compte">
			<table style="margin-left:10px;" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" style="vertical-align:top;">
						<table style="margin:0;" width="350px" border="0" cellspacing="0" cellpadding="0" class="ToolBox2">
							<tr>
								<td class="Inner" width="100%" height="100" colspan="3" align="left" valign="top" style="padding:5px 10px 10px 10px;">

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
									<select name="dnjour" id="dnjour">';
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
											<input name="telmain" type="text" id="telmain" style="height:12px; font-size:10px; width:150px;" value="" />
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
										<input name="nom" type="text" id="nom" style="height:12px; font-size:10px; width:150px;" value="" /> 									</div>

									<div class="ElemtMandat">Prénom</div>
									<div>
										<input name="prenom" type="text" id="prenom" style="height:12px; font-size:10px; width:150px;" value="" /> 									</div>

									<div class="ElemtMandat" id="SocieteBlock" style="display:none;">
										<div class="ElemtFac"  id="labelsociete"></div>
										<div>
											<input name="societe" type="text" id="societe" style="height:12px; font-size:10px; width:150px;" value="" />

										</div>
									</div>

									<div class="ElemtMandat">Adresse <br /> <span class="ElemtFac">(n° rue et libellé rue)</span></div>
									<div>
										<input name="rue1" type="text" id="rue1" style="height:12px; font-size:10px; width:150px;" maxlength="60" value="" />
									</div>
									<div class="ElemtFac">Complément d'adresse<br />(N° bât, étage, appt, digicode...)</div>
									<div>
										<input name="rue2" type="text" id="rue2" style="height:12px; font-size:10px; width:150px;" maxlength="35" value="" />
									</div>
									<div style="color:#888888; margin-top:1px;">(35 caractères max.)</div>
									<div class="ElemtMandat">Code postal</div>
									<div>
										<input name="cp" type="text" id="cp" style="height:12px; font-size:10px; width:150px;" value="" maxlength="5" />
									</div>

									<div class="ElemtMandat">Ville</div>
									<div>
										<input name="ville" type="text" id="ville" style="height:12px; font-size:10px; width:150px;" value="" />
									</div>
									
									<div class="ElemtMandat">Numéro de carte bancaire</div>
									<div>
										<input name="cartebancaire" type="text" id="cartebancaire" style="height:12px; font-size:10px; width:150px;" value="" />
									</div>

								</td>
							</tr>
						</table>

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