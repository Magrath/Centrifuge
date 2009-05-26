<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';


echo '<h2>TV Episodes</h2>';

// print a table containing all TV episodes in the database
echo    '<table class="thin">
		<th class="thin">Title</th>
		<th class="thin" width="150">TV show</th>
		<th class="thin" width="80">Season</th>
		<th class="thin" width="80">Episode</th>
		<th class="thin" width="80">Duration</th>
		<th class="thin" width="80"></th>
	</table>';

$data = $db->getAll('select v.videoid, v.videotitle, v.length, tv.tvshow, tv.season, tv.episodenumber from video as v, video_tv as tv where v.videoid = tv.videoid order by v.videotitle asc;', DB_FETCHMODE_ASSOC);

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



	echo '	<table class="thin"><tr>
			<td class="thin"><a href="player.php?videoid='.$row['videoid'].'" text="'.$row['videotitle'].'" alt="'.$row['videotitle'].'">'.$videotitle.'</a></td>
			<td class="thin" width="150">'.$tvshow.'</td>
			<td class="thin" width="80">'.$row['season'].'</td>
			<td class="thin" width="80">'.$row['episodenumber'].'</td>
			<td class="thin" width="80">'.formatDuration($row['length']).'</td>
			<td class="thin" width="80"><a id="scrollButton" href="javascript:;" onmousedown="toggleSlide(\'moreStatsVideo'.$row['videoid'].'\');">Show&nbsp;details</a></td>
			</tr></table>

			<table><tr><td>
				<div id="moreStatsVideo'.$row['videoid'].'"
					style="display:none;
					overflow:hidden;
					height:300px">
				<table class="thin"><tr><td><img src="screenshots/'.$row['videoid'].'.1.png" /></td></tr></table>

				</div>
			</td></tr></table>';
	
}


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


