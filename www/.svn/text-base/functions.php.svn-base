<?php

function isAdmin($username,$db)
{
	$stmt = "select username from auth where username = '".$username."' and class = 'Admin';";
	$result = $db->getOne($stmt);

	if ($result == $username){
		return true;
	}
	else{
		return false;
	}
}

function hasUid($username,$uid,$db)
{
	$stmt = "select username from auth where uid = '".$uid."';";
	$result = $db->getOne($stmt);

	if ($result == $username){
		return true;
	}
	else{
		return false;
	}
}

function isVideoClip($videoid,$db)
{
	$stmt = "select videoid from video_clip where videoid = '".$videoid."';";
	$result = $db->getOne($stmt);

	if ($result == $videoid){
		return true;
	}
	else{
		return false;
	}
}

function isTVShow($videoid,$db)
{
	$stmt = "select videoid from video_tv where videoid = '".$videoid."';";
	$result = $db->getOne($stmt);

	if ($result == $videoid){
		return true;
	}
	else{
		return false;
	}
}

function isMovie($videoid,$db)
{
	$stmt = "select videoid from video_movies where videoid = '".$videoid."';";
	$result = $db->getOne($stmt);

	if ($result == $videoid){
		return true;
	}
	else{
		return false;
	}
}

function redirect($url)
{
	echo '<script type="text/javascript">
						<!--
						window.location = "'.$url.'"
						//-->
						</script>
			<a href="'.$url.'">Continue</a>';
}

// duration string formatter
function formatDuration($len)
{
	// calculate hours
	if($len >= 3600)
		$hours = floor($len/3600);
	
	$len = $len - $hours*3600;
	
	// calculate minutes
	if($len >= 60)
		$mins = floor($len/60);
	
	$len = $len - $mins*60;
	
	// calculate seconds
	$secs = $len;

	if($hours)
	{
		if($mins < 10)
			$mins = '0'.$mins;
		if($secs < 10)
			$secs = '0'.$secs;

		return $hours.':'.$mins.':'.$secs;

	}

	else if($mins)
	{
		if($secs < 10)
			$secs = '0'.$secs;
		
		return $mins.':'.$secs;
	}

	else
		return $secs.' secs';	

}

/*  return a string containing a video player object - takes an associative array 
 *  containing videotitle, filepath, width, height, format parameters ($data)
 */
function getPlayer($data, $autoplay)
{
	/* matches formats with players - this should probably be put into a database table and
	 * pulled out each time, to allow for user set players per file format
	 */
	$formats_stage6 = array('video/x-msvideo');// array('video/x-msvideo');
	$formats_flash = array('flv');
	$formats_wmplayer = array('wmv');
	$formats_quicktime = array('mpeg', 'quicktime');
	$formats_vlc = array();

	if($autoplay)
		$autoplay_bool = 'true';
	else
		$autoplay_bool = 'false';
	
	// divx web player - divx & xvid
	if(in_array($data['format'], $formats_stage6))
	{
		$player = '<object classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="'.$data['width'].'" height="'.$data['height'].'" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">

			<param name="custommode" value="Stage6" />
			<param name="autoPlay" value="'.$autoplay_bool.'" />
			<param name="src" value="'.$data['webpath'].'" />

			<embed type="video/divx" src="'.$data['webpath'].'" custommode="Stage6" width="'.$data['width'].'" height="'.$data['height'].'" autoPlay="'.$autoplay_bool.'"  pluginspage="http://go.divx.com/plugin/download/">
			</embed>
			</object>';
	}
	
	// flash video player - quicktime & flv
	else if(in_array($data['format'], $formats_flash))
	{

		$player = 	'<embed
					src="flashvideoplayer.swf"
					width="'.$data['width'].'"
					height="'.$data['height'].'"
					allowscriptaccess="always"
					allowfullscreen="true"
					autostart="'.$autoplay_bool.'"
					flashvars="height='.$data['height'].'&width='.$data['width'].'&file='.$data['webpath'].'"
				/>';
	}
	
	// wmplayer
	else if(in_array($data['format'], $formats_wmplayer))
	{
		$player = 	'<OBJECT ID="MediaPlayer" WIDTH="192" HEIGHT="190" CLASSID="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"
				STANDBY="Loading Windows Media Player components..." TYPE="application/x-oleobject">
				<PARAM NAME="FileName" VALUE="'.$data['filepath'].'">
				<PARAM NAME="autostart" VALUE="'.$autoplay_bool.'">
				<PARAM NAME="ShowControls" VALUE="true">
				<PARAM NAME="ShowStatusBar" value="true">
				<PARAM NAME="ShowDisplay" VALUE="true">
				<EMBED TYPE="application/x-mplayer2" SRC="'.$data['webpath'].'" NAME="MediaPlayer"
				WIDTH="'.$data['width'].'" HEIGHT="'.$data['height'].'" ShowControls="1" ShowStatusBar="1" ShowDisplay="1" autostart="'.$autoplay.'"> </EMBED>
				</OBJECT>'; 
	}

	// quicktime
	else if(in_array($data['format'], $formats_quicktime))
	{
		$player =	'<object CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="'.$data['width'].'" height="'.$data['height'].'" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">
				<param name="src" value="'.$data['webpath'].'">
				<param name="autoplay" value="'.$autoplay_bool.'">
				<param name="loop" value="false">
				<param name="controller" value="true">
				<embed src="'.$data['webpath'].'" width="'.$data['width'].'" height="'.$data['height'].'" autoplay="'.$autoplay_bool.'" loop="false" controller="true" pluginspage="http://www.apple.com/quicktime/"></embed>
				</object>';
	}

	// VLC
	else if(in_array($data['format'], $formats_vlc))
	{
		$player = '<table><tr><td>
				<embed 	type="application/x-vlc-plugin"
		         		name="video1"
			          	autoplay="yes" loop="no" width="'.$data['width'].'" height="'.$data['height'].'" 
					target="'.$data['webpath'].'" />
			</td></tr>
			<tr><td>
				<a href="javascript:;" onclick=\'document.video1.play()\'>Play</a> 
				<a href="javascript:;" onclick=\'document.video1.pause()\'>Pause</a> 
				<a href="javascript:;" onclick=\'document.video1.stop()\'>Stop</a> 				     
				<a href="javascript:;" onclick="document.video1.fullscreen()">Fullscreen</a>
			</td></tr></table>'; 


	}

	// otherwise, invalid or unsupported
	else
	{
		$player =	'Unsupported video format or invalid db entry';
	}
	
	return $player;
}

?>


