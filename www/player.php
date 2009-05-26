<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';

// if a videoid was passed to the page
if (isset($_GET['videoid']))
{
	$sql = 'select videotitle, webpath, width, height, format, uploaded_by, rating from video WHERE videoid = '.$_GET['videoid'].';';
	$data = $db->getRow($sql, DB_FETCHMODE_ASSOC);

	if (PEAR::isError($data)) 
	    die($data->getMessage());

	$rating = $data['rating'];

	echo '<h2>'.$data['videotitle'].'</h2><br /><center>';
	
	// if logged in, get autoplay setting
	if($auth->getAuth())
	{
		$sql = 'SELECT autoplay_media from auth WHERE username = "'.$auth->getUsername().'";';
		$usersettings = $db->getRow($sql, DB_FETCHMODE_ASSOC);
		$autoplay = $usersettings['autoplay_media'];
	}


	// prints the applet code using the database results
	echo getPlayer($data, $autoplay);

	
	// update the play count and last played fields for the current video file
	$db->query('UPDATE video SET lastplayed = unix_timestamp(), playcount = playcount + 1 WHERE videoid = '.$_GET['videoid'].';')or error('Unable to update play count or last played data');

	echo '<br /><br />';
	
	for($i = 0.5; $i <= 4.5; $i++)
	{
		if($i < $rating)
			echo '<img src="img/star.png" title="'.$rating.'" alt="'.$rating.'" />';
		else
			echo ' ';
	}

	echo '<br />';

	for($i = 1; $i <= 5; $i++)
		echo '<a href="ratings.php?videoid='.$_GET['videoid'].'&rating='.$i.'">'.$i.'</a> ';

	echo '</centre><br />';
	
	if (isAdmin($auth->getUsername(),$db) or hasUid($auth->getUsername(),$data['uploaded_by'],$db)){
		// check if user is allowed to edit metadata, if so echo link to page to do so.
		echo '<br /><p align="centre"><a href="edit.php?videoid='.$_GET['videoid'].'">Edit metadata</a></p>';
	}

}

include 'footer.php';

?>


