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
<?php if (0) { ?>	
			<div id="login">
						<form method="post" action="index.php?type=login">
									<div class="ElemtMandat">Login</div>
									<div>
										<input name="login" type="text" id="login" style="height:12px; font-size:10px; width:150px;" value="" maxlength="20" />
									</div>

									<div class="ElemtMandat">Mot de passe</div>
									<div>
										<input name="pass" type="password" id="pass" style="height:12px; font-size:10px; width:150px;" value="" maxlength="30";" />
									</div>
									<div>
										<input type="submit" value="Se connecter" style="margin-top:10px; float:middle;" />
									</div>
						</form>
			</div>
<?php }?>	