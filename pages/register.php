<?php
if(!empty($_POST))
{
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
		$captcha = md5($_POST["captcha"]);
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
		}
		else if($password != $confirm_pass)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		if(!isValidEmail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				$user = new User($username,$password,$email);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
					if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				}
				else
				{
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
					if(!$user->userCakeAddUser())
					{
						
					}
		}
	}
?> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<div id="login-holder">
	<div id="loginbox">
		<center>
		</center>
		<div id="login-inner">
<table border="0" cellpadding="0" cellspacing="0">	
	<tr>
		<td>
			<input name="username" type="text" class="field" placeholder="Desired Username"/>
		</td>
	</tr>
	<tr>
		<td>
			<input type="password" id="password1" name="password" class="field" placeholder="Password" onkeyup="passwordStrength(this.value)"/>
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit" class="blues"/>
		</td>
	</tr>
</table>
</div>
</div>
</div>
</body>
</html>