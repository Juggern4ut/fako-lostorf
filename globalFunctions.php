<?php
/**
	* Provides functions and variables that are available over the whole project.
	* @author Lukas Meier
*/
	$GLOBALS['version'] = "Beta 1.2.8";

	$GLOBALS['cmsImagePath'] = "cms/img/";
	$GLOBALS['cmsCssPath'] = "cms/css/";
	$GLOBALS['cmsJsPath'] = "cms/js/";

	$GLOBALS['imagePath'] = "templates/web/img/";
	$GLOBALS['cssPath'] = "templates/web/css/";
	$GLOBALS['jsPath'] = "templates/web/js/";

	/**
	* Returns an Image based on the mimeType of a given file. If the mimeType is not 
	* linked to an image, the function looks for an image based on the file-extension
	*
	* @param string $filepath Path to the file of which the type should be determined. 
	*/
	function getFiletypeIcon($filepath){
		if(file_exists($filepath)){
			$mimeType = mime_content_type($filepath);
		}else{
			$mimeType = "unknown";
		}
		$path = "/".$GLOBALS['cmsImagePath']."filetypes/";
		$return = "unknown.png";
		switch ($mimeType) {
			case 'application/x-7z-compressed': $return = "zip.png"; break;
			case 'application/zip': $return = "zip.png"; break;
			case 'application/pdf': $return = "pdf.png"; break;
			case 'image/png': $return = "png.png"; break;
			case 'image/jpg': $return = "jpg.png"; break;
			case 'image/jpeg': $return = "jpg.png"; break;
			case 'text/plain': $return = "txt.png"; break;
			case 'application/msword': $return = "doc.png"; break;
			case 'audio/mpeg': $return = "mp3.png"; break;
			case 'directory': $return = "folder.png"; break;
			default: $return = "unknown.png"; break;
		}

		if($return == "unknown.png"){
			$tmp = explode(".", $filepath);
			$extension = $tmp[count($tmp)-1];

			switch ($extension) {
				case 'mp3': $return = "mp3.png"; break;
				default: $return = "unknown.png"; break;
			}
		}
		return $path.$return;
	}

	/**
	* Generates a link to the previous page in the correct language.
	*/
	function cms_back(){
		echo "<p class='back'><a href='javascript:window.history.back();'>".$GLOBALS["coreTranslate"]->get('global_back')."</a></p>";
	}

	/**
	* Displays a status message on the top of the screen
	*
	* @param string $message The message that will be displayed
	* @param string $color The background-color of the message-box
	* @param boolean $autohide If set to false, the message will not disappear unless the user clicks it
	* @param int $displayduration Time in miliseconds until the message disappears (ignored if $autohide is set to false)
	*/
	function cms_status($message, $color="#080", $autohide=true, $displayduration=2500){
		$autohide = $autohide ? "true" : "false";
		echo "<script>";
			echo "displayStatusMessage('$message', '$color', $autohide, $displayduration);";
		echo "</script>";
	}

	/**
	* Converts a given byte-value into a human readable format, for example "125.42 GB"
	*
	* @param int $bytes The amount of bytes that should be converted.
	* @return string the human readable value.
	*/
	function convertBytesToHumanReadable($bytes){
		$base = 1024;
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
	}

	/**
	* Returns the true IP-Address of the user visiting the website
	*
	* @return string the ip address of the client connecting to the website
	*/
	function getUserData(){
		$visitorData = array();
		
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)){
		    $ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP)){
		    $ip = $forward;
		}
		else{
		    $ip = $remote;
		}

		$visitorData["ip"] = $ip;

		$useragent=$_SERVER['HTTP_USER_AGENT'];

		$browser = new BrowserDetection();
		$visitorData["browserInfo"]["userAgent"] = $useragent;
		$visitorData["browserInfo"]["isMobile"] = $browser->isMobile() ? "1" : "0";

		$visitorData["browserInfo"]["browserName"] = $browser->getName();
		$visitorData["browserInfo"]["browserVersion"] = $browser->getVersion();

		$visitorData["browserInfo"]["platformName"] = $browser->getPlatform();
		$visitorData["browserInfo"]["platformVersion"] = $browser->getPlatformVersion();

		return $visitorData;
	}
?>