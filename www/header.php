<?php
	require_once "PEAR.php";
	require_once "DB.php";
	require_once "Auth.php";
//	require_once "Log.php";
	include "config.php";
	
	$database_uri =  $db_type."://".$db_user.":".$db_pass."@".$db_host."/".$db_name;

	function loginFunction()
	{
	
	}
	
	if (isset($_GET['login']) && $_GET['login'] == 1) {
		 $optional = true;
	} else {
		 $optional = false;
	}
	
	$options = array(
	  'dsn' => $database_uri,
	  );
	$auth = new Auth("DB", $options, "loginFunction", $optional);
	
	$conf = array('error_prepend' => '<font color="#ff0000"><tt>',
				  'error_append'  => '</tt></font>');
	//$auth->logger = &Log::singleton('display', '', '', $conf, PEAR_LOG_DEBUG);
	//$auth->enableLogging = false;
	$auth->start();
	
//	$auth->addUser("jeff","swap.avi");
//	$auth->addUser("paul","test");

	
	// connect to database host and select correct database
	$db =& DB::connect($database_uri);
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>
<title>Centrifuge</title>
<script language="JavaScript" src="slider.js"></script>
</head>

<body>

<div class="wrapper">
	<div class="container">

       	<div class="main">	
       		<?php
			include "block-menu.php";
			?> 
			<div class="content">
 		
				<div class="title">
					<h1><a href="./">Centrifuge</a><p class="olive">your media, quick and easy</p></h1>
				</div>

