<?php
include "header.php";
include "functions.php";
?>
				<h2>Login</h2>

				<?php	
				
				if ($auth->getAuth()) {
				// if logged in
					if ($_GET['action'] == "logout" && $auth->checkAuth()) {
					// if user attempting to log out
						$auth->logout();
						$auth->start();
						echo "You have successfully logged out.";
					}
					else 
					{
						// if user is logged in successfully
						redirect("browser.php");
					}
				}
				else {
				// if not logged in
					echo "<form method=\"post\" action=\"".$thisPage."?login=1\"><table>";
					echo "<tr><td>Username: </td><td><input type=\"text\" name=\"username\"></td></tr>";
					echo "<tr><td>Password: </td><td><input type=\"password\" name=\"password\"></td></tr>";
					echo "</table><input type=\"submit\" value=\"Sign in\" />";
					echo "</form>";
				}

				?>
<?php
include "footer.php";
?>
