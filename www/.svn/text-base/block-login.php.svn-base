<?php

if ($auth->getAuth()) {
// logged in
	if ($_GET['action'] == "logout" && $auth->checkAuth()) {
	// attempting to log out
		$auth->logout();
		$auth->start();
		echo '	<ul>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
			</ul>';
}
    else {
    // logged in and browsing site
		echo "<ul>
			<li>Hi ".ucfirst($auth->getUsername())."!</li>
			<li>You are currently logged in.\n</li>
			<li><a href=\"?action=logout";
		if (isset($_GET['videoid']))
		{
			echo "&videoid=".$_GET['videoid'];
		}
			echo "\">Log out</a></li>\n";
		echo '<li><a href="settings.php">Settings</a></li></ul>';
	}
}
else {
	// guest browsing
	echo '	<ul>
			<li><a href="login.php">Login</a></li>
			<li><a href="register.php">Register</a></li>
		</ul>';
}

?>

