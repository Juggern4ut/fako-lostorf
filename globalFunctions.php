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
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			$visitorData["isMobile"] = "1";
		}else{
			$visitorData["isMobile"] = "0";
		}

		$visitorData["userAgent"] = $useragent;
		return $visitorData;
	}
?>