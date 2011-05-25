<?php
	include ("redirection.php");
?>

<?php
//Fonction qui v�rifie que le login choisit n'est pas d�j� utilis� par quelqu'un d'autre
function VerifierExistenceLogin ($login)
{
	$result = RequeteSQL("SELECT * FROM clients WHERE client_login='$login'");
	if (mysql_num_rows($result)==1)
		return true;
	else 
		return false;
}

//Fonction qui teste si le mot de passe correspond au login
function TesterMotDePasse ($login,$pass)
{
	$pass = $pass.$login.'geekproduct';
	$pass = md5($pass);
	$result = RequeteSQL("SELECT * FROM clients WHERE client_login='$login'&&client_mdp='$pass'");
	if (mysql_num_rows($result)==1)
		return true;
	else 
		return false;
}

?>
<?php 
if (!isset($_SESSION['login'])) { 
	if (isset($_POST['login'])){
		$login=mysql_real_escape_string($_POST['login']);
		if (!VerifierExistenceLogin($login)){
			$login="";
			echo "<div class='alert'><br />Login inexistant</div><br />";
		}
		elseif (isset($_POST['pass'])){
			$pass=mysql_real_escape_string($_POST['pass']);
			if (!TesterMotDePasse($login,$pass))
				echo "<div class='alert'><br />Mot de passe �ronn�</div><br />";
			else{
				$_SESSION['login']=$login;
				header('Location: index.php');  
				exit(); 
			}
		}
		else
			echo "<div class='alert'><br />Mot de passe non renseign�</div><br />";
	}
	else
		$login="";
?>	
			<div id="login">
						<form method="post" action="index.php?type=login">
									<div>Login</div>
									<div>
										<input name="login" type="text" id="login" style="height:12px; font-size:10px; width:150px;" value="<?php echo htmlentities(trim($login)) ?>" maxlength="20" />
									</div>

									<div>Mot de passe</div>
									<div>
										<input name="pass" type="password" id="pass" style="height:12px; font-size:10px; width:150px;" value="" maxlength="30";" />
									</div>
									<div>
										<input type="submit" value="Se connecter" style="margin-top:10px; float:middle;" />
									</div>
						</form>
			</div>
<?php }?>	