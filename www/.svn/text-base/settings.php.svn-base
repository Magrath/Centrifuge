<?php

require_once 'DB.php';
include 'header.php';
include 'functions.php';

		echo "<h2>Settings</h2>\n";
		
		if ($auth->getAuth() && $_GET['action'] != "logout") {
		// if user is authenticated
		
			$admin = isAdmin($auth->getUsername(),$db); // true if user is an admin
		
			//*******************************************//
			// these if statements save settings changes //
			//*******************************************//
		
                        if ($admin && isset($_POST['Add'])){
                                // if dealing with result of settings change: added crawler directory

                                $fields_values = array(
                                        'file_location' => $_POST['file_location'],
                                        'web_alias'     => $_POST['web_alias'],
                                        'tag_as'                => $_POST['tag_as']
                                );


                                $res = $db->autoExecute('crawler_directories', $fields_values,
                        DB_AUTOQUERY_INSERT);

                                if (PEAR::isError($res)) {
                                        echo "An error occurred while trying to run your query.<br>\n";
                                        echo "Error message: " . $res->getMessage() . "<br>\n";
                                        echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
                                } else {
                                        echo '<p>Thank you, the new crawler directory was saved successfully.</p>';
                                }
                        }


			else if ($admin && isset($_GET['removeCD'])){
				// if dealing with result of settings change: removed crawler directory
				
				$stmt = "DELETE FROM crawler_directories WHERE id = '".$_GET['removeCD']."';";
				$res = $db->query($stmt);

				if (PEAR::isError($res)) {
					echo "An error occurred while trying to run your query.<br>\n";
					echo "Error message: " . $res->getMessage() . "<br>\n";
					echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
				} else {
					echo '<p>Thank you, the crawler directory was removed successfully.</p>';
				}
				
			}
			
			else if ($admin && isset($_GET['makeAdmin'])){
				// if dealing with result of settings change: make user an admin
				
				$stmt = "UPDATE auth SET class = 'Admin' WHERE uid = '".$_GET['makeAdmin']."';";
				$res = $db->query($stmt);

				if (PEAR::isError($res)) {
					echo "An error occurred while trying to run your query.<br>\n";
					echo "Error message: " . $res->getMessage() . "<br>\n";
					echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
				} else {
					echo "<p>Thank you, the user's class was updated successfully.</p>";
				}
				
			}
			
                        else if ($admin && isset($_GET['makeNormal'])){
                                // if dealing with result of settings change: make user a normal (ie not an admin).

                                $stmt = "UPDATE auth SET class = 'Normal' WHERE uid = '".$_GET['makeNormal']."' AND username !='".$auth->getUsername()."';";
                                $res = $db->query($stmt);

                                if (PEAR::isError($res)) {
                                        echo "An error occurred while trying to run your query.<br>\n";
                                        echo "Error message: " . $res->getMessage() . "<br>\n";
                                        echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
                                } else if ($res != ''){
					echo "<p>Thank you, the user's class was updated successfully.</p>";

				}
                        }

			else if ($admin && isset($_GET['killUser'])){
				// if dealing with result of settings change: kill user
				
				$stmt = "DELETE FROM auth WHERE uid = '".$_GET['killUser']."' AND username !='".$auth->getUsername()."';";
				$res = $db->query($stmt);

				if (PEAR::isError($res)) {
					echo "An error occurred while trying to run your query.<br>\n";
					echo "Error message: " . $res->getMessage() . "<br>\n";
					echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
				} else {
					echo '<p>Thank you, the user was removed successfully.</p>';
				}
				
			}
			
			else if (isset($_POST['Save'])){
				// if dealing with result of settings change: saved new personal preferences
				if (isset($_POST['Autoplay'])){
					$autoplay = $_POST['Autoplay'];
				}
				else {
					$autoplay = "0";
				}
				$sth = $db->prepare(
						"UPDATE auth SET autoplay_media = '".$autoplay.
							"' WHERE auth.username = '".$auth->getUsername()."'");
				$res = $db->execute($sth);

                		if (PEAR::isError($res)) {
					echo "An error occurred while trying to run your query.<br>\n";
					echo "Error message: " . $res->getMessage() . "<br>\n";
					echo "A more detailed error description: " . $res->getDebugInfo() . "<br>\n";
				} else {
					echo '<p>Thank you, the new personal preferences were saved successfully.</p>';
				}
				
			}
			
			//************************************//
			// start of the main part of the page //
			//************************************//
			
			// personal preferences
			echo '<h3>My Preferences</h3>';
			echo '<form id="prefs" name="prefs" enctype="multipart/form-data" method="post" action="">';
			echo '<input type="checkbox" name="Autoplay" value="1"';
			if ($db->getOne("SELECT auth.autoplay_media from auth WHERE auth.username = '".$auth->getUsername()."';")){
				echo ' checked';
			}
			echo '> Autoplay Media<br /><br />';
			echo '<p><label><input type="submit" name="Save" value="Save" /></label></p>';
			echo '</form>';
			
					
			// crawler directories
			echo '<h3>Crawler Directories</h3>';

			// print a table containing all directories crawler currently set to crawl in the database
			echo    '<table class="thin">
					<th class="thin">Disk Location</th>
					<th class="thin">Web Location</th>
					<th class="thin">Tag As</th>
					<th class="thin">&nbsp;</th>
					<th class="thin">&nbsp;</th>';
			$data = $db->getAll('select t.id, t.file_location, t.web_alias, t.tag_as from crawler_directories as t;', DB_FETCHMODE_ASSOC);
			foreach($data as $row)
			{
				echo '	<tr>
						<td class="thin">'.$row['file_location'].'</td>
						<td class="thin">'.$row['web_alias'].'</td>
						<td class="thin">'.$row['tag_as'].'</td>
						<td class="thin">';
				if ($admin){
					echo	'<a href="settings.php?removeCD='.$row['id'].'">Remove</a>';
				}
				echo	'</td>
						<td class="thin"><a href="crawl.php?crawlid='.$row['id'].'">Crawl</a></td>
						</tr>';
				
			}
			echo "</table><br />\n";
			
		    if ($admin)
			{

				// print form to add new directory			
				echo '<form id="settings" name="settings" enctype="multipart/form-data" method="post" action="">';
				echo "<table>
					<tr><td><label>File Location:</td>	<td><input type=\"text\" name=\"file_location\" length=\"500\" /></label></td>	</tr>
					<tr><td><label>Web Alias:</td>		<td><input type=\"text\" name=\"web_alias\" length=\"500\" /></label></td>	</tr>
					<tr><td><label>Tag As:</td>		<td><select name=\"tag_as\">
											<option value=\"movie\">Movies</option>
											<option value=\"tv\">TV</option>
											<option value=\"clip\">Clips</option>
											<option value=\"audio\">Audio</option>
											<option value=\"Don't Tag\" selected=\"selected\">Don't Tag</option>
										    </select></label></td>					</tr>
					<tr><td><label><input type=\"submit\" name=\"Add\" value=\"Add\" /></label></td>			</tr>
					</table>
				        </form><br />";
				
				
				// user administration
				echo '<h3>User Administration</h3>';
				echo    '<table class="thin">
						<th class="thin">Username</th>
						<th class="thin">Email</th>
						<th class="thin">Class</th>
						<th class="thin">&nbsp;</th>
						<th class="thin">&nbsp;</th>';
				$data = $db->getAll(
							'select u.uid, u.username, u.email, u.class from auth as u ORDER BY username asc;', 
							DB_FETCHMODE_ASSOC);
				foreach($data as $row)
				{
					echo '	<tr>
							<td class="thin">'.$row['username'].'</td>
							<td class="thin">'.$row['email'].'</td>
							<td class="thin">'.$row['class'].'</td>
							<td class="thin">';
					if ($row['username']!=$auth->getUsername()){
						if ($row['class']=='Admin'){
							echo '	<a href="settings.php?makeNormal='.$row['uid'].'">Make Normal</a>';
						}
						else{
							echo '	<a href="settings.php?makeAdmin='.$row['uid'].'">Make Admin</a>';
						}
					}
					echo '</td><td class="thin">';
					if ($row['username']!=$auth->getUsername()){
						echo	 '<a href="settings.php?killUser='.$row['uid'].'">Delete</a>';
					}
					echo '</td></tr>';
					
				}
				echo "</table><br />\n";
			}
		}
		else {
			echo "<p>You need to be logged in to change settings. Sorry!</p>\n";
			redirect("login.php");
		}

include 'footer.php';
?>
