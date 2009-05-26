<?php

// Start sidebar
echo 	'<div class="sidenav"><h2>My Centrifuge</h2>';

// Login field
include 'block-login.php';


// Recently Added section
echo '<h2>Recently Added</h2>';
$result = $db->getAll('SELECT videoid, videotitle FROM video ORDER BY ctime DESC LIMIT 0,5;', DB_FETCHMODE_ASSOC);
foreach($result as $data)
	echo '<ul><li><a href="player.php?videoid='.$data['videoid'].'">'.$data['videotitle'].'</a></li></ul>';

// Recently Played section
echo 	'<h2>Recently Played</h2>';
$result = $db->getAll('SELECT videoid, videotitle FROM video ORDER BY lastplayed DESC LIMIT 0,5;', DB_FETCHMODE_ASSOC);
foreach($result as $data)
	echo '<ul><li><a href="player.php?videoid='.$data['videoid'].'">'.$data['videotitle'].'</a></li></ul>';

// Most Played section
echo 	'<h2>Most Played</h2>';
$result = $db->getAll('SELECT videoid, videotitle, playcount FROM video ORDER BY playcount DESC LIMIT 0,5;', DB_FETCHMODE_ASSOC);
foreach($result as $data)
	echo '<ul><li><a href="player.php?videoid='.$data['videoid'].'">'.$data['videotitle'].' ('.$data['playcount'].')</a></li></ul>';

// Top Rated section
echo 	'<h2>Top Rated</h2>';
$result = $db->getAll('SELECT videoid, videotitle, rating FROM video ORDER BY rating DESC LIMIT 0,5;', DB_FETCHMODE_ASSOC);
foreach($result as $data)
	echo '<ul><li><a href="player.php?videoid='.$data['videoid'].'">'.$data['videotitle'].' ('.round($data['rating'], 1).')</a></li></ul>';

// end sidebar
echo	'</div>';

?>

