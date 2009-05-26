<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';


echo '<h2>Log</h2>';

// check if user is logged in
if($auth->getAuth() && isset($_GET['crawlid']))
{
	$crawlid = $_GET['crawlid'];
	
	$result = $db->query('SELECT uid from auth WHERE username = "'.$auth->getUsername().'";');
	$user = $result->fetchRow(DB_FETCHMODE_ASSOC);

	$result = $db->query('SELECT file_location, web_alias, tag_as from crawler_directories where id = '.$crawlid.';');
	$crawldata = $result->fetchRow(DB_FETCHMODE_ASSOC);

	if($crawldata)
	{
		$command = 'start "python indexer.py -r '.$crawldata['file_location'].' -u '.$user['uid'].' -t '.$crawldata['tag_as'].' -w '.$crawldata['web_alias'].'"';
		exec($command, $return);
		echo $command.'<br /><br />'.$return;
	}


//	redirect("settings.php");
}else{
	echo 'Log in!';
}


include 'footer.php';

?>


