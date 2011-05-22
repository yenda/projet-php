<?php

function VerifierExistenceLogin ($login)
{
	$result = RequeteSQL("SELECT * FROM clients WHERE client_login='$login'");
	if (mysql_num_rows($result)==1)
		return true;
	else 
		return false;
}

?>

			<div id="login">
						<form method="post" action="index.php?type=inscription">
									<div class="ElemtMandat">Mon nom d'utilisateur</div>
									<div>
										<input name="login" type="text" id="login" style="height:12px; font-size:10px; width:150px;" value="" maxlength="20" />
									</div>

									<div class="ElemtMandat">Mon mot de passe</div>
									<div>
										<input name="pass" type="password" id="pass" style="height:12px; font-size:10px; width:150px;" value="" maxlength="30" onkeyup="PasswdStrength(this);" onchange="PasswdStrength(this);" />
										<input name="back" type="hidden" id="back" value="">
										<input name="op" type="hidden" id="op" value="register" />
										<input type="submit" value="Se connecter" style="margin-top:10px; float:middle;" />
										<div id="PassMessage"></div>
									</div>
									
						</form>
			</div>