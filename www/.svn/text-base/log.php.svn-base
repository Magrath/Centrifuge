<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';


echo '<h2>Log</h2>';

// check if user is logged in
if($auth->getAuth())
{
	$sql = 'SELECT uid, username, class from auth WHERE username = "'.$auth->getUsername().'";';
	$user = $db->getRow($sql, DB_FETCHMODE_ASSOC);

	// if indices have been passed
	if(isset($_GET['startat']) and isset($_GET['num']))
	{
		$startat = $_GET['startat'];
		$num = $_GET['num'];
	// otherwise start from 0 and show 30
	}else{
		$startat = 0;
		$num = 30;
	}

	// if admin, show all in logs!
	if($user['class'] == 'Admin')
		$sql = 'SELECT u.username, l.time, l.message from auth as u, logs as l WHERE u.uid = l.uid ORDER BY l.logid DESC LIMIT '.$startat.', '.$num.';';
	else
	// otherwise, select logs regarding the current user
		$sql = 'SELECT u.username, l.time, l.message from auth as u, logs as l where u.username = "'.$user['username'].'" AND u.uid = l.uid ORDER BY l.logid DESC LIMIT '.$startat.', '.$num.';';

//echo $sql;

	// open the table
	echo '<table class="thin">
		<th width="200" class="thin">Time</th>
		<th width="150" class="thin">Username</th>
		<th class="thin">message</th>';

	// execute the query - return as a 2D associative array
	$logdata = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC);

//	print_r($logdata);

	// echo each row in the table
	foreach($logdata as $row)
		echo '<tr class="thin">
			<td class="thin">'.$row['time'].'</td>
			<td class="thin">'.$row['username'].'</td>
			<td class="thin">'.$row['message'].'</td>';

	// close the table
	echo '</table>';

}else{
	echo 'Log in!';
}


include 'footer.php';

?>


