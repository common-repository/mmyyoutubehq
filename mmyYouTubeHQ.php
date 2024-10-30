<?php
/*
Plugin Name: mmyYouTubeHQ
Plugin URI: http://www.mkswork.de/mmyYouTubeHQ
Description: This plugin allows you to insert high quality YouTube videos and also videos in normal quality.
Version: 1.1
Author: Markus Kau&szlig;en
Author URI: http://www.mkswork.de
*/

add_filter('the_content', 'mmyYouTubeHQ');
add_filter('the_content', 'mmyYouTube');
add_filter('the_content', 'mmyYouTubeHQL');

add_action('admin_menu', 'mmyYouTubeHQ_add_pages');

function mmyYouTubeHQ_add_pages() {
    add_options_page('mmyYouTubeHQ Options', 'mmyYouTubeHQ', 8, 'mmyYouTubeHQoptions', 'mmyYouTubeHQ_options_page');
}

function mmyYouTubeHQ_options_page() {
if ($_POST){
$vheight = $_POST["vheight"];
$vwidth = $_POST["vwidth"];
$vlinktext = $_POST["vlinktext"];
$vtext = $_POST["vtext"];

	$test = mmyYouTubeHQcheckUpdate('mmyYouTubeheight' , $_POST["vheight"]);
		if ($test == true) {
			update_option('mmyYouTubeheight', $vheight);
		}
		
	$test = mmyYouTubeHQcheckUpdate('mmyYouTubewidth' , $_POST["vwidth"]);
		if ($test == true) {
			update_option('mmyYouTubewidth', $vwidth);
		}
	$test = mmyYouTubeHQcheckUpdate('mmyYouTubetext' , $_POST["vtext"]);
		if ($test == true) {
			update_option('mmyYouTubetext', $vtext);
		}
	$test = mmyYouTubeHQcheckUpdate('mmyYouTubeLinktext' , $_POST["vlinktext"]);
		if ($test == true) {
			update_option('mmyYouTubeLinktext', $vlinktext);
		}
	
}
$youtube_height = get_option(mmyYouTubeheight);
$youtube_width = get_option(mmyYouTubewidth);
$youtube_text = get_option(mmyYouTubetext);
$youtube_linktext = get_option(mmyYouTubeLinktext);

	echo '<div class="wrap"><h2>mmyYouTubeHQ Video Settings</h2>';
		echo "<form name='form1' method='post' action=''>
		  <table width='100%'  border='0' cellspacing='0' cellpadding='0'>
			<tr>
			  <td width='50%'>Video Height: </td>
			  <td width='50%'><input name='vheight' type='text' id='vheight' value='$youtube_height'></td>
			</tr>
			<tr><td><p>&nbsp;</p></td></tr>
			<tr>
			  <td>Video Width: </td>
			  <td><input name='vwidth' type='text' id='vwidth' value='$youtube_width'></td>
			</tr>
			<tr><td><p>&nbsp;</p></td></tr>
			<tr>
			  <td>If you use the tag [youtubehql]code[/youtubehql] a text is displayed below the video. The text tells the user that this is a high quality video and offers a link to the YouTube website. On the website the user can watch the video on standard quality (because of the internet connectivity). Here you can specify the text: </td>
			  <td><input name='vtext' type='text' id='vtext' value='$youtube_text'></td>
			</tr>
			<tr><td><p>&nbsp;</p></td></tr>
			<tr>
			  <td>Here you can specify the link text: </td>
			  <td><input name='vlinktext' type='vlinktext' id='vlinktext' value='$youtube_linktext'></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><input type='submit' name='Submit' value='Update'></td>
			</tr>
		  </table></form>";
	echo '</div>';	
}

function mmyYouTubeHQcheckUpdate($option_name , $new_value){
		$return = true;
		$oldvalue = get_option($option_name);
		if ( $newvalue == $oldvalue ) {
			$return = false;
		}
		if ( $new_value == "" ) {
			$return =  false;
		}
		return $return;
	}

function mmyYouTubeHQ($content) {
		$height = get_option(mmyYouTubeheight);
		$width = get_option(mmyYouTubewidth);
        preg_match_all('/\[youtubehq\](.*?)\[\/youtubehq\]/is', $content, $matches);

        for ($i=0; $i < count($matches['0']); $i++) {
				$video =  $matches['1'][$i];
				$replace = $matches['0'][$i];
				$new = "<object width='$width' height='$height'><param name='movie' value='http://www.youtube.com/v/$video&hl=de&fs=1&rel=0&ap=%2526fmt%3D18'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/$video&hl=de&fs=1&rel=0&ap=%2526fmt%3D18' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='$width' height='$height'></embed></object>";
				        
				$content = str_replace($replace, $new, $content);
				}
		return $content;
}

function mmyYouTube($content) {
		$height = get_option(mmyYouTubeheight);
		$width = get_option(mmyYouTubewidth);
        preg_match_all('/\[youtube\](.*?)\[\/youtube\]/is', $content, $matches);

        for ($i=0; $i < count($matches['0']); $i++) {
				$video =  $matches['1'][$i];
				$replace = $matches['0'][$i];
				$new = "<object width='$width' height='$height'><param name='movie' value='http://www.youtube.com/v/$video&hl=de&fs=1&rel=0'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/$video&hl=de&fs=1&rel=0' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='$width' height='$height'></embed></object>";
				        
				$content = str_replace($replace, $new, $content);
				}
		return $content;
}
function mmyYouTubeHQL($content) {
		$height = get_option(mmyYouTubeheight);
		$width = get_option(mmyYouTubewidth);
		$text = get_option(mmyYouTubetext);
		$linktext = get_option(mmyYouTubeLinktext);
        preg_match_all('/\[youtubehql\](.*?)\[\/youtubehql\]/is', $content, $matches);

        for ($i=0; $i < count($matches['0']); $i++) {
				$video =  $matches['1'][$i];
				$replace = $matches['0'][$i];
				$new = "<object width='$width' height='$height'><param name='movie' value='http://www.youtube.com/v/$video&hl=de&fs=1&rel=0&ap=%2526fmt%3D18'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/$video&hl=de&fs=1&rel=0&ap=%2526fmt%3D18' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='$width' height='$height'></embed></object><p>$text <a href='http://www.youtube.com/watch?v=$video&amp;fmt=18' title='http://www.youtube.com/watch?v=$video&amp;fmt=18' target='_blank'>$linktext</a></p>";
				        
				$content = str_replace($replace, $new, $content);
				}
		return $content;
}
	  
//setup options
if(get_option(mmyYouTubeHQ_version) != "1.1"){
//youtube
	  update_option('mmyYouTubeHQ_version', 1.1);
      update_option('mmyYouTubewidth', 425);
      update_option('mmyYouTubeheight', 344);
      update_option('mmyYouTubetext', 'This video is embedded in high quality. To watch the video in standard quality (because of the internet connectivity) use the following link:');
      update_option('mmyYouTubeLinktext', 'Watch the video in normal quality');

	  	 
}
?>