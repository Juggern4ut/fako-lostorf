<?php
/**
* plugin_navigation.php - contains the plugin_navigation class
* @author Lukas Meier
* @copyright Lukas Meier
*/

	/**
	* plugin_navigation - Manages the public and async functions for the navigation plugin
	* @author Lukas Meier
	* @copyright Lukas Meier
	*/
	class plugin_navigation extends plugin{

		public function getContactForm(){
			ob_start();
			echo "<form id='contact-form'>";
				
				echo "<div class='input-container'>";
					echo "<input id=\"name\" type=\"text\" placeholder=\"Name\" name=\"name\">";
					echo "<span class=\"focus-border\"></span>";
				echo "</div>";
				
				echo "<div class='input-container'>";
					echo "<input id=\"mail\" type=\"text\" placeholder=\"E-Mail\" name=\"email\">";
					echo "<span class=\"focus-border\"></span>";
				echo "</div>";
				
				echo "<div class='input-container'>";
					echo "<input id=\"subject\" type=\"text\" placeholder=\"Betreff\" name=\"subject\">";
					echo "<span class=\"focus-border\"></span>";
				echo "</div>";

				echo '<div class="input-container">';
					echo "<textarea id=\"message\" placeholder=\"Nachricht\"></textarea>";
					echo '<span class="focus-border">';
						echo '<i></i>';
					echo '</span>';
				echo '</div>';

				echo '<div class="g-recaptcha" data-sitekey="6LfJhXwUAAAAACk-GbDFudHNd3rkhQfuWWN4URBC"></div>';

				echo "<input type=\"submit\" value=\"Abschicken\">";
			echo "</form>";
			$ret = ob_get_contents();
			ob_end_clean();
			return $ret;
		}

		/**
		* Returns all (sub-)pages from given foreign-key.
		* @param int $navigation_fk The id of the page of which the subpages should be returned. If this is zero, the top-level navigation-points will be returned
		* @return array An array containing all information of the found pages
		*/
		public function getNavigation($navigation_fk = 0){
			$return = array();

			$stmt = $this->db->prepare("SELECT n.navigation_id, nt.title, n.is_active, n.is_invisible, nt.link FROM cms_navigation AS n LEFT JOIN cms_navigation_title AS nt ON n.navigation_id = nt.navigation_fk WHERE n.navigation_fk = ? AND is_deleted = 0 AND nt.lang_fk = ? ORDER BY sort ASC");
			$stmt->bind_param("ii", $navigation_fk, $_SESSION["lang"][0]);
			$stmt->execute();
			$stmt->bind_result($navigation_id, $title, $is_active, $is_invisible, $link);

			while($stmt->fetch()){
				$tmp["id"] = $navigation_id;
				$tmp["title"] = $title;
				$tmp["is_active"] = $is_active;
				$tmp["is_invisible"] = $is_invisible;
				$tmp["link"] = $link;
				$return[] = $tmp;
				unset($tmp);
			}

			return $return;
		}

		/**
		* Returns the content of a page
		* @param int $navigation_id The id of the page of which the content should be returned.
		* @return array An array containing all the content of the page
		*/
		public function getContent($navigation_id, $getInvisible = true){
			$return = array();

			$stmt = $this->db->prepare("SELECT a.article_id, a.is_active, ac.article_title, ac.text, ac.article_content_id, ac.timestamp FROM cms_article AS a LEFT JOIN cms_article_content AS ac ON a.article_id = ac.article_fk WHERE is_deleted = 0 AND a.navigation_fk = ? AND ac.lang_fk = ? ORDER BY a.sort ASC");
			$stmt->bind_param("ii", $navigation_id, $_SESSION["lang"][0]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($article_id, $is_active, $article_title, $text, $article_content_id, $timestamp);

			while($stmt->fetch()){
				$tmp["id"] = $article_id;
				$tmp["title"] = $article_title;
				$tmp["content"] = str_replace("../media", "/media", $text);
				$tmp["timestamp"] = $timestamp;
				$tmp["is_active"] = $is_active;

				$tmp["images"] = array();

				$stmt2 = $this->db->prepare("SELECT image, lang_fk FROM cms_article_content_image WHERE article_content_fk = ? AND lang_fk = ? ORDER BY sort ASC");
				$stmt2->bind_param("ii", $article_id, $_SESSION["lang"][0]);
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($image, $lang_fk);

				while($stmt2->fetch()){	
					if(file_exists("media/navigation/".$article_id."/".$_SESSION["lang"][1]."/".$image)){
						$tmp["images"][] = "media/navigation/".$article_id."/".$_SESSION["lang"][1]."/".$image;
					}

					if(file_exists("media/navigation_thumbs/".$article_id."/".$_SESSION["lang"][1]."/".$image)){
						$tmp["images_thumbs"][] = "media/navigation_thumbs/".$article_id."/".$_SESSION["lang"][1]."/".$image;
					}
				}
				
				$stmt2->close();

				$return[] = $tmp;
				unset($tmp);
			}

			unset($stmt);

			return $return;
		}

		/**
		* Returns the meta-information of a page
		* @param int $navigation_id The id of the page of which the meta-info should be returned.
		* @param string $field The field that should be returned. Possible values are: "image"|"title"|"description"|"keywords"
		* @return string|boolean The meta-value or false if no meta-info was found.
		*/
		public function getMeta($navigation_id, $field){
			if($field != "image"){

				$stmt = $this->db->prepare("SELECT nt.title, nt.description, nt.keywords FROM cms_navigation AS n LEFT JOIN cms_navigation_title AS nt ON n.navigation_id = nt.navigation_fk WHERE n.navigation_id = ? AND is_deleted = 0 AND nt.lang_fk = ? LIMIT 1");
				$stmt->bind_param("ii", $navigation_id, $_SESSION["lang"][0]);
				$stmt->execute();
				$stmt->bind_result($title, $description, $keywords);
				$stmt->store_result();
				$stmt->fetch();

				if($stmt->num_rows == 0){
					return false;
				}else{
					switch ($field) {
						case 'title': return $title; break;
						case 'description': return $description; break;
						case 'keywords': return $keywords; break;
						default: return false; break;
					}
				}
			}else{
				$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
				if(file_exists("media/metaimage/".$navigation_id."/".$_SESSION["lang"][1]."/share.jpg")){
					return $actual_link."/media/metaimage/".$navigation_id."/".$_SESSION["lang"][1]."/share.jpg";
				}else{
					return false;
				}
			}
		}

		/**
		* Async-Function which is called by using the url /?async=1
		*/
		public function async(){
			if(isset($_GET["displaySession"])){
				echo "<pre>";
					print_r($_SESSION);
				echo "</pre>";
			}

			if(isset($_GET["unsetSession"])){
				unset($_SESSION["translations"]);
			}

			if(isset($_GET["async"]) && isset($_POST["contact-form"])){
				$cm = new coreMailer();
				$recipient = "gian-reto.vd@gmx.ch";

				$subject = $_POST["subject"];
				$name = $_POST["name"];
				$mail = $_POST["mail"];
				$message = $_POST["message"];
				$from = "fasnacht@losdorf.ch";

				$recaptcha = $_POST["grecaptcha"];
				$secret="6LfJhXwUAAAAAPvaq0E8VpvDklcRycaaPWt0_zBJ";

				$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}");
				$captcha_success=json_decode($verify);

				if($captcha_success->success==true) {
					$body = file_get_contents("templates/mail_templates/contact_form.html");
					$body = str_replace(array("{{timestamp}}","{{name}}","{{mail}}","{{subject}}","{{message}}"), array(date("d.m.Y H:i"), $name, $mail, $subject, $message), $body);

					$cm->send($recipient, $subject, $body, $from);
					echo "1";
				}else{
					echo "0";
				}
			}
		}
	}
?>