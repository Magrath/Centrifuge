<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';


echo '<h2>TV Episodes</h2>';

// print a table containing all TV episodes in the database
echo    '<table class="thin">
		<th class="thin">Title</th>
		<th class="thin">TV show</th>
		<th class="thin" width="80">Season</th>
		<th class="thin" width="80">Episode</th>
		<th class="thin" width="80">Duration</th>
		<th class="thin" width="40"></th>';

$data = $db->getAll('select v.videoid, v.videotitle, v.length, tv.tvshow, tv.season, tv.episodenumber from video as v, video_tv as tv where v.videoid = tv.videoid order by v.videotitle asc;', DB_FETCHMODE_ASSOC);
echo '<script type="text/javascript"> 
		function show (vid) { 
			p = document.createElement (\'td\') 
			strong = document.createElement (\'STRONG\') 
			p.appendChild (strong) 
			strong.appendChild (document.createTextNode (\'screenshots:\')) 
			img = document.createElement(\'img\')
			img.src = "screenshots/"+vid+".1.png"
			strong.appendChild ( img)
			br = document.createElement (\'BR\') 
			p.appendChild (br) 
			p.appendChild (document.createTextNode (\'you like?\')) 
			document.getElementById (\'video\'+vid).appendChild (p)

			link = document.getElementById (\'link\'+vid)
			link.parentNode.removeChild(link.parentNode.firstChild)
		} 
		</script> ';
foreach($data as $row)
{
	// shorten lengthly strings
	if(strlen($row['videotitle']) > 40)
		$videotitle = substr($row['videotitle'], 0, 40).'...';
	else
		$videotitle = $row['videotitle'];
		
	if(strlen($row['tvshow']) > 25)
	        $tvshow = substr($row['tvshow'], 0, 25).'...';
	else
		$tvshow = $row['tvshow'];



	echo '	<tr>
			<td class="thin"><a href="player.php?videoid='.$row['videoid'].'" text="'.$row['videotitle'].'" alt="'.$row['videotitle'].'">'.$videotitle.'</a></td>
			<td class="thin">'.$tvshow.'</td>
			<td class="thin">'.$row['season'].'</td>
			<td class="thin">'.$row['episodenumber'].'</td>
			<td class="thin">'.formatDuration($row['length']).'</td>
			<td class="thin"><a id="link'.$row['videoid'].'" onclick="show(\''.$row[videoid].'\')">details</a></td>
		</tr><tr id="video'.$row['videoid'].'"></tr>';
	
}

echo '</table><br />';

echo '<h2>Movies</h2>';

// print a table containing all movies in the database
echo    '<table class="thin">
                <th class="thin">Title</th>
                <th class="thin" width="100">Director</th>
                <th class="thin" width="100">IMDB rating</th>
                <th class="thin" width="80">Duration</th>';

$data = $db->getAll('select v.videoid, v.videotitle, v.length, m.director, m.imdbid, m.imdbrating from video as v, video_movies as m where v.videoid = m.videoid order by v.videotitle asc;', DB_FETCHMODE_ASSOC);

foreach($data as $row)
{
        echo '  <tr>
                        <td class="thin"><a href=player.php?videoid='.$row['videoid'].'>'.$row['videotitle'].'</a></td>
                        <td class="thin">'.$row['director'].'</td>
                        <td class="thin"><a href="http://imdb.com/title/'.$row['imdbid'].'">'.$row['imdbrating'].'</a></td>
                        <td class="thin">'.formatDuration($row['length']).'</td>
                </tr>';

}

echo '</table><br />
	<h2>Clips</h2>';

// print a table containing all clips in the database
echo    '<table class="thin">
                <th class="thin">Title</th>
                <th class="thin" width="80">Source</th>
                <th class="thin" width="80">Duration</th>';

$data = $db->getAll('select v.videoid, v.videotitle, v.length, c.clipsource from video as v, video_clips as c where v.videoid = c.videoid order by v.videotitle asc;', DB_FETCHMODE_ASSOC);

foreach($data as $row)
{
        echo '  <tr>
                        <td class="thin"><a href=player.php?videoid='.$row['videoid'].'>'.$row['videotitle'].'</a></td>
                        <td class="thin">'.$row['clipsource'].'</td>
                        <td class="thin">'.formatDuration($row['length']).'</td>
                </tr>';

}

echo '	</table><br />
	</body></html>';

include 'footer.php';

?>


