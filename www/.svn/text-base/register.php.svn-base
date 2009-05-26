<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';

echo "<h2>Register new user account</h2>\n";

if ($auth->getAuth() && $_GET['action'] != "logout") 
{
	// if user is authenticated
	echo '<p>You are already signed up!</p>';
}
else
{
	if (!isset($_POST['Register']))
	{
		// if not dealing with post
		// print form to add new user			
		echo 	'<br />
			<form id="register" name="register" enctype="multipart/form-data" method="post" action="">
			<table>
				<tr>
					<td width="200"><label>Username:</td>
					<td><input type="text" name="username" /></label></td>
					<td width="100"></td>
					<td>/* Enter your desired username here */ </td>
				</tr>
				<tr><td>&nbsp;</td><td></td></tr><tr><td>&nbsp;</td><td></td></tr>
				<tr>
					<td width="200"><label>Password:</td>
					<td><input type="password" name="password1" /></label></td>
					<td width="100"></td>
					<td>/* Enter your password here */ </td>
				</tr>
				<tr><td>&nbsp;</td><td></td></tr>
				<tr>
					<td width="200"><label>Confirm password:</td>
					<td><input type="password" name="password2" /></label></td>
					<td width="100"></td>
					<td>/* Enter your password again */ </td>
				</tr>
				<tr><td>&nbsp;</td><td></td></tr><tr><td>&nbsp;</td><td></td></tr>
				<tr>
					<td width="200"><label>Email address:</td>
					<td><input type="text" name="email" /></label></td>
					<td width="100"></td>
					<td>/* Enter your email address here */ </td>
				</tr>
				<tr><td>&nbsp;</td><td></td></tr><tr><td>&nbsp;</td><td></td></tr>
				<tr>
					<td><label><input type="submit" name="Register" value="Register" /></label>
					</td>
				</tr>
			</table></form>';

	}
	else	// if the user is posting to the page
	{	
		
		// check that the same password was entered twice
		if($_POST['password1'] != $_POST['password2'])
			echo 'Passwords did not match!';
		else
		{
			// insert the new user
			$res = $auth->addUser($_POST['username'],$_POST['password1']);

			// insert a log entry for the user
			$db->query('INSERT INTO logs (uid, message) VALUES ("-1", "User \"'.$_POST['username'].'\" signed up with email address \"'.$_POST['email'].'\"");');

			if (PEAR::isError($res))
			{
				echo 	'An error occurred while trying to run your query.<br />
					Error message: '.$res->getMessage().'<br />';
			} else {
				$sql = 'update auth set email = "'.$_POST['email'].'", class = "Normal" where username = "'.$_POST['username'].'" limit 1;';
				$res = $db->query($sql);
				
				if (PEAR::isError($res))
				{
					echo 	'An error occurred while trying to run your query.<br />
						Error message: '. $res->getMessage() .'<br />';
				} else {
					echo 	'<p>Thank you, your new user account was created successfully.</p>
						<p><a href="login.php">Login</a>.</p>';
				}
			}
		}
	}
}

include 'footer.php';

?>
