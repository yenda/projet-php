<?php 
function VerifierAdresseMail($adresse) 
{ 
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$adresse)) 
      return true; 
   else 
     return false; 
}
?>

<?php 
if (isset($_POST['login']))
{
	if ((empty($_POST['login'])) || (!is_string($_POST['login'])))
	{
		echo "Le champ nom d'utilisateur n'est pas correctement rempli";
		if ((empty($_POST['pass'])) || (empty($_POST['pass2'])) || ($_POST['pass']!=$_POST['pass2']))
		{
			echo "Le mot de passe n'est pas correctement saisi";
		}
		else if ((empty($_POST['mail'])) || (VerifierAdresseMail($_POST['mail']==false)))
		{
			echo "Le champ adresse e-mail n'est pas correctement rempli";
		}
		else if ((empty($_POST['telmain'])) || (str_len($_POST['telmain']!=10)))
		{
			echo "Le champ numéro de téléphone n'est pas correctement rempli";
		}
		else if((empty($_POST['nom'])) || (!is_string($_POST['nom'])))
		{
			echo "Le champ nom n'est pas correctement rempli";
		}
		else if((empty($_POST['prenom'])) || (!is_string($_POST['prenom'])))
		{
			echo "Le champ prenom n'est pas correctement rempli";
		}
		else if((empty($_POST['rue1'])) || (!is_string($_POST['rue1'])) || (isset($_POST['rue2']) and (!is_string($_POST['rue2'])) || (strlen($POST['rue2'])>35)))
		{
			echo "Le champ adresse n'est pas correctement rempli";
		}
		else if((empty($_POST['cp'])) || (!is_int($_POST['cp'])))
		{
			echo "Le champ code postal n'est pas correctement rempli";
		}
		else if((empty($_POST['ville'])) || (!is_string($_POST['ville'])))
		{
			echo "Le champ ville n'est pas correctement rempli";
		}
		else if (!isset($_POST['verif']))
		{
			echo "Vous devez cocher la case pour certifier l'exactitude des renseignements fournis";
		}
	}
	else 
	{
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		$mail=$_POST['mail'];
		$telmain=$_POST['telmain'];
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$rue1=$_POST['rue1'];
		$rue2=$_POST['rue2'];
		$cp=$_POST['cp'];
		$ville=$_POST['ville'];
		//Faire le remplissage de la base après avoir rajouté les champs manquants dans la base
	}
}


?>
<form method="post" action="inscription.php">
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
										<input name="pass" type="password" id="pass" style="height:12px; font-size:10px; width:150px;" value="" maxlength="30" onkeyup="PasswdStrength(this);" onchange="PasswdStrength(this);" />
										<div id="PassMessage"></div>
									</div>
									<div class="ElemtMandat">Confirmation du mot de passe</div>
									<div>
										<input name="pass2" type="password" id="pass2" style="height:12px; font-size:10px; width:150px;"value="" maxlength="30" />

									</div>
									<div class="ElemtMandat">Mon adresse e-mail : </div>
									<div>
										<input name="mail" type="text" id="mail" style="height:12px; font-size:10px; width:150px;" value="" /> 									</div>

									<div class="ElemtFac">Date de naissance</div>
									<select name="dnjour" id="dnjour">
										<option></option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
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
										<option></option>
										<option value="2011">2011</option>
										<option value="2010">2010</option>
										<option value="2009">2009</option>
										<option value="2008">2008</option>
										<option value="2007">2007</option>
										<option value="2006">2006</option>
										<option value="2005">2005</option>
										<option value="2004">2004</option>
										<option value="2003">2003</option>
										<option value="2002">2002</option>
										<option value="2001">2001</option>
										<option value="2000">2000</option>
										<option value="1999">1999</option>
										<option value="1998">1998</option>
										<option value="1997">1997</option>
										<option value="1996">1996</option>
										<option value="1995">1995</option>
										<option value="1994">1994</option>
										<option value="1993">1993</option>
										<option value="1992">1992</option>
										<option value="1991">1991</option>
										<option value="1990">1990</option>
										<option value="1989">1989</option>
										<option value="1988">1988</option>
										<option value="1987">1987</option>
										<option value="1986">1986</option>
										<option value="1985">1985</option>
										<option value="1984">1984</option>
										<option value="1983">1983</option>
										<option value="1982">1982</option>
										<option value="1981">1981</option>
										<option value="1980">1980</option>
										<option value="1979">1979</option>
										<option value="1978">1978</option>
										<option value="1977">1977</option>
										<option value="1976">1976</option>
										<option value="1975">1975</option>
										<option value="1974">1974</option>
										<option value="1973">1973</option>
										<option value="1972">1972</option>
										<option value="1971">1971</option>
										<option value="1970">1970</option>
										<option value="1969">1969</option>
										<option value="1968">1968</option>
										<option value="1967">1967</option>
										<option value="1966">1966</option>
										<option value="1965">1965</option>
										<option value="1964">1964</option>
										<option value="1963">1963</option>
										<option value="1962">1962</option>
										<option value="1961">1961</option>
										<option value="1960">1960</option>
										<option value="1959">1959</option>
										<option value="1958">1958</option>
										<option value="1957">1957</option>
										<option value="1956">1956</option>
										<option value="1955">1955</option>
										<option value="1954">1954</option>
										<option value="1953">1953</option>
										<option value="1952">1952</option>
										<option value="1951">1951</option>
										<option value="1950">1950</option>
										<option value="1949">1949</option>
										<option value="1948">1948</option>
										<option value="1947">1947</option>
										<option value="1946">1946</option>
										<option value="1945">1945</option>
										<option value="1944">1944</option>
										<option value="1943">1943</option>
										<option value="1942">1942</option>
										<option value="1941">1941</option>
										<option value="1940">1940</option>
										<option value="1939">1939</option>
										<option value="1938">1938</option>
										<option value="1937">1937</option>
										<option value="1936">1936</option>
										<option value="1935">1935</option>
										<option value="1934">1934</option>
										<option value="1933">1933</option>
										<option value="1932">1932</option>
										<option value="1931">1931</option>
										<option value="1930">1930</option>
										<option value="1929">1929</option>
										<option value="1928">1928</option>
										<option value="1927">1927</option>
										<option value="1926">1926</option>
										<option value="1925">1925</option>
										<option value="1924">1924</option>
										<option value="1923">1923</option>
										<option value="1922">1922</option>
										<option value="1921">1921</option>
										<option value="1920">1920</option>
										<option value="1919">1919</option>
										<option value="1918">1918</option>
										<option value="1917">1917</option>
										<option value="1916">1916</option>
										<option value="1915">1915</option>
										<option value="1914">1914</option>
										<option value="1913">1913</option>
										<option value="1912">1912</option>
										<option value="1911">1911</option>
										<option value="1910">1910</option>
										<option value="1909">1909</option>
										<option value="1908">1908</option>
										<option value="1907">1907</option>
										<option value="1906">1906</option>
										<option value="1905">1905</option>
										<option value="1904">1904</option>
										<option value="1903">1903</option>
										<option value="1902">1902</option>
										<option value="1901">1901</option>
										<option value="1900">1900</option>

																			</select>
																																							<div>
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

									<div class="ElemtMandat">Nom : </div>
									<div>
										<input name="nom" type="text" id="nom" style="height:12px; font-size:10px; width:150px;" value="" /> 									</div>

									<div class="ElemtMandat">Prénom : </div>
									<div>
										<input name="prenom" type="text" id="prenom" style="height:12px; font-size:10px; width:150px;" value="" /> 									</div>

									<div class="ElemtMandat" id="SocieteBlock" style="display:none;">
										<div class="ElemtFac"  id="labelsociete"></div>
										<div>
											<input name="societe" type="text" id="societe" style="height:12px; font-size:10px; width:150px;" value="" />

										</div>
									</div>

									<div class="ElemtMandat">Adresse <br /> <span class="ElemtFac">(n° rue et libellé rue): </span></div>
									<div>
										<input name="rue1" type="text" id="rue1" style="height:12px; font-size:10px; width:150px;" maxlength="60" value="" />
									</div>
									<div class="ElemtFac">Complément d'adresse<br />(N° bât, étage, appt, digicode...) :</div>
									<div>
										<input name="rue2" type="text" id="rue2" style="height:12px; font-size:10px; width:150px;" maxlength="35" value="" />
									</div>
									<div style="color:#888888; margin-top:1px;">(35 caractères max.)</div>
									<div class="ElemtMandat">Code postal : </div>
									<div>
										<input name="cp" type="text" id="cp" style="height:12px; font-size:10px; width:150px;" value="" maxlength="5" />
									</div>

									<div class="ElemtMandat">Ville : </div>
									<div>
										<input name="ville" type="text" id="ville" style="height:12px; font-size:10px; width:150px;" value="" />
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


							<th width="715" align="left">Validation <img width="8" height="11" alt="" style="display: inline;"/></th>
							<tr>
								<td class="Inner" width="625" valign="top" height="100" align="left" style="padding: 10px;" colspan="3">
									<input type="checkbox" name="verif" id="verif"/><label for="verif"> Je certifie exactes les informations renseignées dans les champs ci-dessus.</label>
									<br/>

									<input name="back" type="hidden" id="back" value="">
									<input name="op" type="hidden" id="op" value="register" />
									<input type="image" name="imageField" src="/images/gui/main/BtnContinueGreen.jpg" style="margin-top:10px; float:right;" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</form>



</body>
</html>