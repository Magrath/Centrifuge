<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';

		echo "<h2>Edit</h2>\n";
		
		if ($auth->getAuth() && $_GET['action'] != "logout" && isset($_GET['videoid'])) {
		
			$sql = 'select videotitle, uploaded_by, rating from video WHERE videoid = '.$_GET['videoid'].';';
			$data = $db->getRow($sql, DB_FETCHMODE_ASSOC);
		
			if (PEAR::isError($data)) 
				die($data->getMessage());
			
			$admin = isAdmin($auth->getUsername(),$db); // true if user is an admin
			$uploader = hasUid($auth->getUsername(),$data['uploaded_by'],$db); 
		
		
			if ($admin or $uploader){
			
				$tvshow = isTVShow($_GET['videoid'],$db);
				$videoclip = isVideoClip($_GET['videoid'],$db);
				$movie = isMovie($_GET['videoid'],$db);
					
				//*******************************************//
				// these if statements save settings changes //
				//*******************************************//
	
				if (isset($_POST['Save'])){
					// if dealing with result of settings change: saved new metadata

					$sth = $db->prepare(
							"UPDATE video SET videotitle = '".$_POST['title'].
								"', rating = '".$_POST['rating']."' WHERE video.videoid = '".$_GET['videoid']."'");
					$res = $db->execute($sth);
					
					if ($tvshow){
						$sth = $db->prepare(
								"UPDATE video_tv SET tvshow = '".$_POST['tvshow'].
									"', season = '".$_POST['season'].
									"', episodenumber = '".$_POST['episodenumber'].
									"' WHERE videoid = '".$_GET['videoid']."'");
					}
					else if ($videoclip){
						$sth = $db->prepare(
								"UPDATE video_tv SET tvshow = '".$_POST['tvshow'].
									"', season = '".$_POST['season'].
									"', episodenumber = '".$_POST['episodenumber'].
									"' WHERE videoid = '".$_GET['videoid']."'");
					}
					else if ($movie){
						$sth = $db->prepare(
								"UPDATE video_movies SET director = '".$_POST['director'].
									"', imdbif = '".$_POST['imdbid'].
									"' WHERE videoid = '".$_GET['videoid']."'");
					}
					$res2 = $db->execute($sth);
	
					if (PEAR::isError($res) or PEAR::isError($res2)) {
						echo "An error occurred while trying to run your query.<br>\n";
						echo "Error message: " . $res->getMessage() . "<br>\n";
						echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
					} else {
						echo '<p>Thank you, the new metadata was saved successfully.</p>';
						echo '<p><a href="player.php?videoid='.$_GET['videoid'].'">Play</a></p>';
						echo '<p><a href="browser.php">Browse</a></p>';
					}
					
				}
				
				else if (isset($_POST['SaveMultiple']) and $tvshow){
					// if dealing with result of settings change: saved new metadata
					
					$sql = 'select tvshow from video_tv WHERE videoid = '.$_GET['videoid'].';';
					$data2 = $db->getRow($sql, DB_FETCHMODE_ASSOC);
				
					if (PEAR::isError($data2)) {
						die($data2->getMessage());
					}
					
					$sth = $db->prepare(
							"UPDATE video_tv SET tvshow = '".$_POST['tvshow'].
								"', season = '".$_POST['season'].
								"' WHERE tvshow = '".$data2['tvshow']."'");

					$res2 = $db->execute($sth);
	
					if (PEAR::isError($res) or PEAR::isError($res2)) {
						echo "An error occurred while trying to run your query.<br>\n";
						echo "Error message: " . $res->getMessage() . "<br>\n";
						echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
					} else {
						echo '<p>Thank you, the new metadata was saved successfully.</p>';
						echo '<p><a href="player.php?videoid='.$_GET['videoid'].'">Play</a></p>';
						echo '<p><a href="browser.php">Browse</a></p>';
					}
					
				}
				
				//************************************//
				// start of the main part of the page //
				//************************************//
				
				else {
				
					if ($tvshow){
						$sql = 'select * from video_tv WHERE videoid = '.$_GET['videoid'].';';
						$data2 = $db->getRow($sql, DB_FETCHMODE_ASSOC);
					
						if (PEAR::isError($data2)) {
							die($data2->getMessage());
						}
					}
					else if ($videoclip){
						$sql = 'select * from video_clips WHERE videoid = '.$_GET['videoid'].';';
						$data2 = $db->getRow($sql, DB_FETCHMODE_ASSOC);
					
						if (PEAR::isError($data2)) {
							die($data2->getMessage());
						}
					}
					else if ($movie){
						$sql = 'select * from video_movies WHERE videoid = '.$_GET['videoid'].';';
						$data2 = $db->getRow($sql, DB_FETCHMODE_ASSOC);
					
						if (PEAR::isError($data2)) {
							die($data2->getMessage());
						}
					}
				
					// print form to set metadata
					echo '<h3>Edit this instance</h3>';
					echo '<form id="settings" name="settings" enctype="multipart/form-data" method="post" action="">';
					echo "<table>
								<tr>
									<td><label>Title:</td>	
									<td><input type=\"text\" name=\"title\" value=\"".$data['videotitle']."\" length=\"500\" /></label></td>	
								</tr>";
					
					if ($tvshow){
						echo "	<tr>
									<td><label>TV Show:</td>	
									<td><input type=\"text\" name=\"tvshow\" value=\"".$data2['tvshow']."\" length=\"500\" /></label></td>
								</tr>
								<tr>
									<td><label>Season Number:</td>	
									<td><input type=\"text\" name=\"season\" value=\"".$data2['season']."\" length=\"100\" /></label></td>
								</tr>
								<tr>
									<td><label>Episode Number:</td>	
									<td><input type=\"text\" name=\"episodenumber\" value=\"".$data2['episodenumber']."\" length=\"100\" /></label></td>
								</tr>";
					}
					else if ($videoclip){
						echo "	<tr>
									<td><label>Clip Source:</td>	
									<td><input type=\"text\" name=\"clipsource\" value=\"".$data2['clipsource']."\" length=\"500\" /></label></td>
								</tr>";
					}
					else if ($movie){
						echo "	<tr>
									<td><label>Director:</td>	
									<td><input type=\"text\" name=\"director\" value=\"".$data2['director']."\" length=\"500\" /></label></td>
								</tr>
								<tr>
									<td><label>IMDB ID:</td>	
									<td><input type=\"text\" name=\"imdbid\" value=\"".$data2['imdbid']."\" length=\"100\" /></label></td>
								</tr>";
					}
					
					echo	"<tr><td><label><input type=\"submit\" name=\"Save\" value=\"Save\" /></label></td>			</tr>
							</table>
							</form><br />";
							
					if ($tvshow){
						echo '<h3>Edit multiple</h3>';	
						echo '<p>Metadata entered here will be applied to all TV episodes which matched this episode\'s previous TV show tag.</p>';
						echo '<form id="settings" name="settings2" enctype="multipart/form-data" method="post" action="">';
						echo '<table>';
						echo "	<tr>
									<td><label>TV Show:</td>	
									<td><input type=\"text\" name=\"tvshow\" value=\"".$data2['tvshow']."\" length=\"500\" /></label></td>
								</tr>
								<tr>
									<td><label>Season Number:</td>	
									<td><input type=\"text\" name=\"season\" value=\"".$data2['season']."\" length=\"100\" /></label></td>
								</tr>";
						echo	"<tr><td><label><input type=\"submit\" name=\"SaveMultiple\" value=\"Save\" /></label></td>			</tr>
								</table>
								</form><br />";
					}
				}
			}
			else {
				echo "<p>You aren't allowed to edit metadata for this media. Sorry!</p>\n";
			}
		}
		else {
			echo "<p>You aren't allowed to edit metadata for this media. Sorry!</p>\n";
		}

include 'footer.php';
?>
