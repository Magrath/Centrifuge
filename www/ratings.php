<?php

require_once 'DB.php';
include 'functions.php';
include 'header.php';

if ($auth->getAuth())
{
	// if user is voting on a video 
	if($_GET['videoid'] && $_GET['rating'])
	{
		// get user's UID
		$sql = 'SELECT uid from auth where username = "'.$auth->getUsername().'";';
		$result = $db->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$uid = $row['uid'];

		// check if there is a ratings table entry already
		$sql = 	'SELECT rating FROM video_ratings 
			WHERE videoid = '.$_GET['videoid'].' 
			AND uid = '.$uid.';';
		$result = $db->query($sql);
		
		// if the user has already voted, change the rating
		if($row = $result->fetchRow())
		{
			$db->query('UPDATE video_ratings SET rating = '.$_GET['rating'].' WHERE uid = '.$uid.' AND videoid = '.$_GET['videoid'].';');
			echo 'Rating updated';
		}

		// else, the user has not voted - insert a new rating 
		else
		{
			$db->query('INSERT INTO video_ratings(uid, videoid, rating) VALUES ('.$uid.', '.$_GET['videoid'].', '.$_GET['rating'].');');
			echo 'Rating saved';
		}

		// update the overall rating for the video (stored in the video table)
		// using the sum of individual votes
		$sql = 'SELECT COUNT(*) from video_ratings where videoid = '.$_GET['videoid'].';';
		$result = $db->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$num_votes = $row['COUNT(*)'];
		
		$sql = 'SELECT SUM(rating) from video_ratings where videoid = '.$_GET['videoid'].';';
		$result = $db->query($sql);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$total_votes = $row['SUM(rating)'];

		$db->query('UPDATE video SET rating = '.($total_votes/$num_votes).' WHERE videoid = '.$_GET['videoid'].';');

		redirect('player.php?videoid='.$_GET['videoid']);


	}
	else
	{
		echo 'Incorrect parameters';
	}

}
else
{
	redirect('login.php');
}

?>
