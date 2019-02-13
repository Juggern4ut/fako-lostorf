<?php
/**
	* Contains all logic for the Backend which is executed asynchronously
	* @author Lukas Meier
*/

	$coreUser = $GLOBALS["user"];
	$cT = $GLOBALS["coreTranslate"];
	
	$user = $coreUser->getUser();
	
	$modules = $GLOBALS['cmh']->getModules();

	if(isset($_GET["module"]) && $user){
		$tmp = $coreModuleHandler->get("admin_".$_GET["module"]);
		$tmp->controller();
		$tmp->view();
		echo "<script>init();</script>";
	}else{

		/*CMS ASYNC*/
		if(isset($_GET["cms_logout"])){
			unset($_COOKIE["userLoginCookie"]);
			setcookie('userLoginCookie', null, -1, '/');
			unset($_SESSION["cms_user"]);
		}

		if(isset($_GET["isDir"])){
			$file = str_replace("/media", "media", $_GET["isDir"]);
			$return = is_dir($file) ? "1" : "0";
			echo trim($return);
		}

		if(isset($_GET["login"]) && $_SERVER["REQUEST_METHOD"] === "POST"){
			$return = array();

			if(strlen($_POST["username"]) <= 0 || strlen($_POST["password"]) <= 0){
				$return = array("status_code"=>"-2", "status_message"=>$cT->get("login_no_input"));
			}elseif($coreUser->login($_POST["username"], $_POST["password"])){
				$return = array("status_code"=>"1", "status_message"=>$cT->get("login_success"));

				if(isset($_POST["stayLoggedIn"])){
					setcookie("userLoginCookie", $_SESSION["cms_user"], time() + (86400 * 30), "/");
				}
				
			}else{
				$return = array("status_code"=>"-1", "status_message"=>$cT->get("login_error"));
			}

			echo json_encode($return);
		}

		if(isset($_GET["getConfirmDialogButtons"])){
			echo "<div class=\"dialogButtons\">";
				echo "<button class=\"no\">".$cT->get("global_no")."</button><button class=\"yes\">".$cT->get("global_yes")."</button>";
			echo "</div>";
		}

		//RESET PASSWORD
		if(isset($_GET["reset_password"]) && $_SERVER["REQUEST_METHOD"] === "POST"){
			header('Content-Type: application/json');
			$status = 0;
			$message = "";

			if($_POST["new_password"] == $_POST["repeat_new_password"] && strlen($_POST["new_password"]) >= 6){
				$query = "SELECT username, timestamp, password_reset_id, used FROM cms_password_reset WHERE hash = '".$_GET["hash"]."' LIMIT 1";
				$q = $db->query($query);
				$res = $q->fetch_row();
				$checkHash =  sha1($res[0].strtotime($res[1]));
				if($_GET["hash"] == $checkHash && $res[3] == 0){
					$db->query("DELETE FROM cms_password_reset WHERE password_reset_id = '".$res[2]."'");
					$db->query("UPDATE cms_user SET password = '".password_hash($_POST["new_password"], PASSWORD_DEFAULT)."' WHERE username = '".$res[0]."'");
					$status = 1;
					$message = $cT->get("login_password_reset_success");
				}else{
					$status = -2;
					$message = $cT->get("login_password_reset_error");
				}
			}else{
				$status = -1;
				$message = $cT->get("login_password_short_error");
			}

			echo json_encode(array("status_code"=>$status, "status_message"=>$message));
		}

		//FORGOT PASSWORD
		if(isset($_GET["forgot_password"]) && $_SERVER["REQUEST_METHOD"] === "POST"){
			
			header('Content-Type: application/json');
			$status = 0;
			$message = "";

			$query = "SELECT user_id FROM cms_user WHERE username = '".$_POST["username"]."' LIMIT 1";
			$q = $db->query($query);
			if($q->num_rows == 1){
				$query = "SELECT email FROM cms_user WHERE username = '".$_POST["username"]."' LIMIT 1";
				$q = $db->query($query);
				$email = $q->fetch_row()[0];

				if($email != ""){

					$ts = date("Y-m-d H:i:s");
					$hash = sha1($_POST["username"].strtotime($ts));
					$query = "INSERT INTO cms_password_reset (username, hash, used, timestamp) VALUES ('".$_POST["username"]."', '".$hash."', '0', '".$ts."')";
					$db->query($query);

					$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

					$body = file_get_contents("cms/mail_templates/reset_password_".$_SESSION["lang"][1].".html");
					$body = str_replace("{{link}}", $protocol."://$_SERVER[HTTP_HOST]/?admin=1&reset_password=1&hash=".$hash, $body);
		
					$cm = new coreMailer();

					if($cm->send($email, $cT->get('login_password_reset'), $body, "info@weble-cms.ch", "Info - Weble CMS" )){
						$status = 1;
						$message = $cT->get("login_password_reset_success");
					}else{
						$status = -2;
						$message = $cT->get("login_error_mailserver");
					}
					
				}

			}else{
				$status = -1;
				$message = $cT->get("login_password_reset_not_found");
			}
			echo json_encode(array("status_code"=>$status, "status_message"=>$message));
		}		

		if(isset($_GET["richtext_images"])){
			echo "<form enctype=\"multipart/form-data\" method=\"POST\" action=\"/?async=1&uploadImage=1\">";
				echo "<input id=\"cms-richtext-image\" type=\"file\" name=\"cms-richtext-upload\"/>";
				echo "<label for=\"cms-richtext-image\">Select File</label>";
			echo "</form>";
			$images = scandir("media/richtext");
			foreach ($images as $image) {
				if($image != ".." && $image != "."){
					echo "<div docpath=\"/media/richtext/".$image."\" class=\"cms-image-preview tiny-mce-image\" style=\"background-image: url('/media/richtext/".$image."');\"></div>";
				}
			}
		}

		if(isset($_GET["richtext_files"])){

			if(isset($_GET["path"])){
				$subpath = str_replace("/media/userdocuments/", "/", $_GET["path"]);
				$files = scandir("media/userdocuments/".$subpath);
			}else{
				$subpath = "/";
				$files = scandir("media/userdocuments");
			}

			if($subpath != "/"){
				$prevPath = explode("/", $subpath);
				unset($prevPath[count($prevPath)-1],$prevPath[count($prevPath)-1]);
				$prevPath = implode("/", $prevPath);
				echo "<div docpath=\"/media/userdocuments".$prevPath."\" class=\"cms-file-preview tiny-mce-image\"><img src=\"/cms/img/filetypes/folder_up.png\" /><span>..</span></div>";
			}

			foreach ($files as $file) {
				if($file != ".." && $file != "."){
					echo "<div docpath=\"/media/userdocuments".$subpath.$file."\" class=\"cms-file-preview tiny-mce-image\"><img src=\"".getFiletypeIcon("media/userdocuments/".$subpath.$file)."\" /><span>".$file."</span></div>";
				}
			}
		}

		if(isset($_GET["uploadImage"])){
			move_uploaded_file($_FILES["cms-richtext-upload"]["tmp_name"], "media/richtext/".$_FILES["cms-richtext-upload"]["name"]);
		}

		if(isset($_GET["imageSettings"])){
			echo "<div>";
				echo "<h3>Bildkonfiguration</h3>";
				echo "<input class='showInSlideshow' id='showInSlideshow' type='checkbox' name='showInSlideshow'><label for='showInSlideshow'>In Slideshow anzeigen</label>";
				
				echo "<div class='image-align'>";
					echo "<img src='".$_GET["imageSettings"]."' />";
					echo "<span></span>";
				echo "</div>";

				echo "<button class='save-image-align'>Speichern</button>";
				echo "<br>";
				echo "<button onclick='cmsRemoveImage(\"".$_GET["imageSettings"]."\",\"".$_GET["image_id"]."\")' class='delete-image'>Bild löschen</button>";
			echo "</div>";
		}

		if(isset($_GET["getImageSettings"])){
			header('Content-Type: application/json');
			$stmt = $db->prepare('SELECT cms_align_percentage, show_in_slideshow FROM cms_article_content_image WHERE article_content_image_id = ? LIMIT 1');
			$stmt->bind_param('i', $_GET["getImageSettings"]);
			$stmt->execute();
			$stmt->bind_result($percentage, $show_in_slideshow);
			$stmt->fetch();
			echo json_encode(array("percentage"=>$percentage, "show_in_slideshow"=>$show_in_slideshow));
		}

		if(isset($_GET["alignImage"])){
			$stmt = $db->prepare('UPDATE cms_article_content_image SET image_align_percentage = ?, show_in_slideshow = ?, cms_align_percentage = ? WHERE article_content_image_id = ?');
			$stmt->bind_param('sisi', number_format($_GET["percentage"],2), $_GET["showInSlideshow"], $_GET["cmsViewPercentage"], $_GET["alignImage"]);
			$stmt->execute();
		}

		//CHANGE CALENDAR SESSION
		if(isset($_GET["calendarMonth"])){
			if($_SESSION["calendarMonth"] == 1 && $_GET["calendarMonth"] == -1){
				$_SESSION["calendarYear"]--;
				$_SESSION["calendarMonth"] = 12;
			}elseif($_SESSION["calendarMonth"] == 12 && $_GET["calendarMonth"] == 1){
				$_SESSION["calendarYear"]++;
				$_SESSION["calendarMonth"] = 1;
			}else{
				$_SESSION["calendarMonth"] += $_GET["calendarMonth"];
			}
		}

		foreach ($modules as $module) {
			$moduleName = get_class($module);
			if(strpos($moduleName, "plugin_") !== false){
				$tmp = $GLOBALS['cmh']->get($moduleName);
				$tmp->async();
			}
		}
	}
?>