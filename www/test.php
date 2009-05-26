<?php
include "header.php";
include "functions.php";

	echo "Starting test script<br>";
	exec('python test.py 1> /dev/null &');
	echo "Ran test script:";
?>
