<?php
		class admin_navigation extends plugin{

			private $_userLang;
						
			public function configure(){
				$this->setPermission(1);
				$this->setName($this->cT->get("module_navigation"));
				$this->_userLang = $this->user->getUserLanguage();
			}

			public function urlEncode($string){
				$string = str_replace(array("Ä", "ä", "Ö", "ö", "Ü", "ü"), array("Ae", "ae", "Oe", "oe", "Ue", "ue"), $string);
				$string = strtolower($string);
				$string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
				$string = str_replace(" ", "-", $string);
				return $string;
			}

			public function navigation(&$table,$fs,$stage=0,$elements=0) {

				$query = "SELECT n.navigation_id, n.navigation_fk, nt.title, n.is_active, n.is_invisible FROM cms_navigation AS n LEFT JOIN cms_navigation_title AS nt ON n.navigation_id = nt.navigation_fk WHERE n.navigation_fk = '".$fs."' AND nt.lang_fk = '".$this->_userLang."' AND n.is_deleted = 0 ORDER BY sort ASC";
				
				$q = $this->db->query($query);
				
				while($res = $q->fetch_assoc()) {					
					$space = "";
					$div_start = "<div style=\"padding-left:".($stage*20)."px\">";	
					$div_end = "</div>";
					$invisible = $res["is_invisible"] == 1 ? " <i style=\"color: #444; padding-left: 10px;\"> ".$this->cT->get("navigation_invisible")." </i>" : "";
					$inactive = $res["is_active"] == 0 ? " <i style=\"color: #444; padding-left: 10px;\"> ".$this->cT->get("navigation_inactive")." </i>" : "";

					$table->addRow(array("<a href=\"/?admin=1&module=navigation&articles=".$res["navigation_id"]."\">".$div_start.$res["title"].$invisible.$inactive.$div_end."</a>"), 
						array(
							array("link"=>"edit=".$res["navigation_id"], "name"=>$this->cT->get("global_edit")),
							array("link"=>"rmv=".$res["navigation_id"], "name"=>$this->cT->get("global_remove"), "confirmDialog"=>$this->cT->get("global_confirm_delete"), "async"=>"1")
						), $res["navigation_id"]
					);

					$elements++;
								  
					$this->navigation($table,$res["navigation_id"],$stage+1,$elements);
					$in++;
				}

				if($elements == 0){
					$table->addRow(array($this->cT->get("global_no_entry_found")));
				}
				
				return $in;
			}

			public function navigationArray($fs,$stage=0,&$arr) {
				$q = $this->db->query("SELECT n.navigation_id, n.is_active, nt.title FROM cms_navigation AS n LEFT JOIN cms_navigation_title AS nt ON n.navigation_id = nt.navigation_fk WHERE n.navigation_fk = '".$fs."' AND n.navigation_id <> '".$fs."' AND is_deleted = 0 AND nt.lang_fk = '".$this->_userLang."' ORDER BY n.sort ASC");
				while($res = $q->fetch_assoc()) {
					$space = "";
					for($i=0;$i<$stage;$i++) {
						$space.="--";
					}		
					
					$arr[$res["navigation_id"]]=$space." ".$res["title"];
								  
					$this->navigationArray($res["navigation_id"],$stage+1,$arr);
					$in++;
				}
				
				return $arr;
			}

			//CONTROLLER-FUNCTIONS
			private function removeNavigation(){
				if($_GET["rmv"]){
					$stmt = $this->db->prepare("SELECT title FROM cms_navigation_title WHERE navigation_fk = ? ORDER BY lang_fk ASC LIMIT 1");
					$stmt->bind_param("i", $_GET["rmv"]);
					$stmt->execute();
					$stmt->bind_result($title);
					$stmt->fetch();
					$stmt->close();

					$stmt = $this->db->prepare("UPDATE cms_navigation SET is_deleted = 1 WHERE navigation_id = ?");
					$stmt->bind_param("i", $_GET["rmv"]);
					$stmt->execute();

					$stmt = $this->db->prepare("UPDATE cms_article SET is_deleted = 1 WHERE navigation_fk = ?");
					$stmt->bind_param("i", $_GET["rmv"]);
					$stmt->execute();

					cms_status($this->cT->get("global_delete_success"));
					$this->logger->log($this->user->getUsername()." deleted the page '".$title."'.", $this->user->getId());
				}
			}

			private function sortNavigation(){
				if(isset($_GET["sort"]) && $_GET["table"] == "navigation"){
					foreach($_POST["sort"] AS $position=>$elementId){
						$stmt = $this->db->prepare("UPDATE cms_navigation SET sort = ? WHERE navigation_id = ?");
						$stmt->bind_param("ii", $position, $elementId);
						$stmt->execute();
					}
					$this->logger->log($this->user->getUsername()." changed the order of the pages.", $this->user->getId());
				}
			}

			private function addEditNavigation(){
				$is_active = isset($_POST["is_active"]) ? 1 : 0;
				$is_invisible = isset($_POST["is_invisible"]) ? 1 : 0;
				$child_of = (int)$_POST["child_of"];

				if(isset($_GET["add"])){
					$stmt = $this->db->prepare("INSERT INTO cms_navigation (is_active, is_deleted, navigation_fk, is_invisible) VALUES (?,'0',?,?)");
					$stmt->bind_param("iii", $is_active, $child_of, $is_invisible);
					$stmt->execute();
					$id = $this->db->insert_id;
				}else{
					$id = $_GET["edit"];
					$stmt = $this->db->prepare("UPDATE cms_navigation SET is_invisible = ?, is_active = ?, navigation_fk = ? WHERE navigation_id = ?");
					$stmt->bind_param("iiii", $is_invisible, $is_active, $_POST["child_of"], $id);
					$stmt->execute();
				}

				$query = "SELECT lang_id, name, short FROM cms_lang ORDER BY name ASC";
				$q = $this->db->query($query);
				$log = true;
				while($res = $q->fetch_assoc()){
					
					$link = $this->urlEncode($_POST["title_".$res["lang_id"]]);
					$lng = $res["lang_id"];

					$stmt = isset($_GET["add"])	? 	$this->db->prepare("INSERT INTO cms_navigation_title (navigation_fk, lang_fk, title, description, keywords, link) VALUES (?,?,?,?,?,?)")
												:	$this->db->prepare("UPDATE cms_navigation_title SET title=?, description=?, keywords=?, link=? WHERE lang_fk=? AND navigation_fk=?");

							isset($_GET["add"])	?	$stmt->bind_param("iissss", $id, $lng, $_POST["title_".$lng], $_POST["description_".$lng], $_POST["keywords_".$lng], $link)
												:	$stmt->bind_param("ssssii", $_POST["title_".$lng], $_POST["description_".$lng], $_POST["keywords_".$lng], $link, $lng, $id);

					$stmt->execute();

					if($log){
						isset($_GET["add"])	? $this->logger->log($this->user->getUsername()." created a page called '".$_POST["title_".$res["lang_id"]]."'.", $this->user->getId())
											: $this->logger->log($this->user->getUsername()." updated the page '".$_POST["title_".$res["lang_id"]]."'.", $this->user->getId());
						$log = false;
					}

					if(isset($_FILES["metaimage_".$res["short"]])){
						@mkdir("media/metaimage/".$id);
						@mkdir("media/metaimage/".$id."/".$res["short"]);

						$imageResizer = new coreImageResizer();

						$imageError = false;
						try{
							$imageResizer->resizeImage($_FILES["metaimage_".$res["short"]]["tmp_name"][0], "media/metaimage/".$id."/".$res["short"]."/share.jpg", 1000, 1000, false, "jpg");
						}catch(Exception $e) {
							$imageError = true;
						}									
					}

					isset($_GET["add"]) ? cms_status($this->cT->get("global_add_success")) : cms_status($this->cT->get("global_edit_success"));									
					
				}

				if(isset($_GET["add"])){
					unset($_POST);
				}
			}

			private function removeMetaImage(){
				if(isset($_GET["cmsRemoveImage"])){
					$file = str_replace("/media", "media", $_GET["cmsRemoveImage"]);
					$file = explode("?", $file);
					$file = $file[0];
					if(file_exists($file)){
						unlink($file);
					}
				}
			}

			private function setNavigationFieldValues(){
				$stmt = $this->db->prepare("SELECT nt.title, nt.lang_fk, n.is_active, n.navigation_fk, n.is_invisible, nt.description, nt.keywords FROM cms_navigation_title AS nt LEFT JOIN cms_navigation AS n ON nt.navigation_fk = n.navigation_id WHERE nt.navigation_fk = ?");
				$stmt->bind_param("i", $_GET["edit"]);
				$stmt->execute();
				$stmt->bind_result($title, $lang, $active, $nav_fk, $invisible, $description, $keywords);
				while($stmt->fetch()){
					$_POST["title_".$lang] = $title;
					$_POST["description_".$lang] = $description;
					$_POST["keywords_".$lang] = $keywords;
					$_POST["child_of"] = $nav_fk;
					$_POST["is_active"] = $active == 1 ? "1" : null;
					$_POST["is_invisible"] = $invisible == 1 ? "1" : null;
				}
			}

			private function removeArticle(){
				if($_GET["rmv"]){
					$stmt = $this->db->prepare("SELECT article_title FROM cms_article_content WHERE article_fk = ? ORDER BY lang_fk ASC LIMIT 1");
					$stmt->bind_param("i", $_GET["rmv"]);
					$stmt->execute();
					$stmt->bind_result($title);
					$stmt->fetch();
					$articleTitle = $title;
					$stmt->close();

					$stmt = $this->db->prepare("UPDATE cms_article SET is_deleted = 1 WHERE article_id = ?");
					$stmt->bind_param("i", $_GET["rmv"]);
					$stmt->execute();

					cms_status($this->cT->get("global_delete_success"));
					$this->logger->log($this->user->getUsername()." deleted the article '".$articleTitle."'.", $this->user->getId());
				}
			}

			private function sortArticles(){
				if(isset($_GET["sort"])){
					$stmt = $this->db->prepare("SELECT title FROM cms_navigation_title WHERE navigation_fk = ? ORDER BY lang_fk ASC LIMIT 1");
					$stmt->bind_param("i", $_GET["articles"]);
					$stmt->execute();
					$stmt->bind_result($title);
					$stmt->fetch();
					$pageTitle = $title;
					$stmt->close();

					foreach($_POST["sort"] AS $position=>$elementId){
						$stmt = $this->db->prepare("UPDATE cms_article SET sort = ? WHERE article_id = ?");
						$stmt->bind_param("ii", $position, $elementId);
						$stmt->execute();
					}

					$this->logger->log($this->user->getUsername()." changed the order of the articles in '".$pageTitle."'.", $this->user->getId());
				}
			}

			private function addEditArticle(){

				$is_active = isset($_POST["is_active"]) ? 1 : 0;
				$articles = $_GET["articles"];

				if(isset($_GET["add"])){
					$stmt = $this->db->prepare("INSERT INTO cms_article (is_active, is_deleted, navigation_fk) VALUES (?, '0', ?)");
					$stmt->bind_param("ii", $is_active, $articles);
					$stmt->execute();
					$id = $this->db->insert_id;
				}else{
					$id = $_GET["edit"];
					$stmt = $this->db->prepare("UPDATE cms_article SET is_active = ? WHERE article_id = ?");
					$stmt->bind_param("ii", $is_active, $articles);
					$stmt->execute();
				}

				$query = "SELECT lang_id, name, short FROM cms_lang ORDER BY name ASC";
				$q = $this->db->query($query);
				$log = true;
				while($res = $q->fetch_assoc()){								
					$stmt = isset($_GET["add"])	? $this->db->prepare("INSERT INTO cms_article_content (article_fk, lang_fk, article_title, text) VALUES (?, ?, ?, ?)")
												: $this->db->prepare("UPDATE cms_article_content SET article_title = ?, text = ? WHERE lang_fk = ? AND article_fk = ?");

							isset($_GET["add"]) ? $stmt->bind_param("iiss", $id, $res["lang_id"], $_POST["title_".$res["lang_id"]], $_POST["text_".$res["lang_id"]])
												: $stmt->bind_param("ssii", $_POST["title_".$res["lang_id"]], $_POST["text_".$res["lang_id"]], $res["lang_id"], $id);

					if($log){
						isset($_GET["add"]) ? $this->logger->log($this->user->getUsername()." created the article '".$_POST["title_".$res["lang_id"]]."'.", $this->user->getId())
											: $this->logger->log($this->user->getUsername()." edited the article '".$_POST["title_".$res["lang_id"]]."'.", $this->user->getId());
						$log = false;
					}

					if(isset($_FILES["image_".$res["short"]])){
						@mkdir("media/navigation/".$id);
						@mkdir("media/navigation/".$id."/".$res["short"]);

						$imageResizer = new coreImageResizer();

						$imageError = false;
						for($i = 0; $i < count($_FILES["image_".$res["short"]]["name"]); $i++){
							try{
								$imageResizer->resizeImage($_FILES["image_".$res["short"]]["tmp_name"][$i], "media/navigation/".$id."/".$res["short"]."/".$_FILES["image_".$res["short"]]["name"][$i], 1920, 1080);
								$stmt2 = $this->db->prepare("INSERT INTO cms_article_content_image (article_content_fk, lang_fk, image) VALUES (?, ?, ?)");
								$stmt2->bind_param("iis", $id, $res["lang_id"], $_FILES["image_".$res["short"]]["name"][$i]);
								$stmt2->execute();

							}catch(Exception $e) {
								$imageError = true;
							}
						}
					}

					$stmt->execute();

					if($imageError){
						cms_status($this->cT->get("wrong_filetype"), "#C00", false);
					}else{
						isset($_GET["add"]) ? cms_status($this->cT->get("global_add_success")) : cms_status($this->cT->get("global_edit_success"));									
					}	
				}

				if(isset($_GET["add"])){
					unset($_POST);
				}
			}

			private function removeArticleImage(){
				if(isset($_GET["cmsRemoveImage"])){
					$file = str_replace("/media", "media", $_GET["cmsRemoveImage"]);		
					$stmt = $this->db->prepare("DELETE FROM cms_article_content_image WHERE article_content_image_id = ?");
					$stmt->bind_param("i", $_GET["image_id"]);
					$stmt->execute();
					
					if(file_exists($file)){
						unlink($file);
					}
				}
			}

			private function sortArticleImages(){
				if(isset($_GET["sortImage"])){
					foreach ($_POST["sort"] as $position => $imageId) {
						$stmt = $this->db->prepare("UPDATE cms_article_content_image SET sort = ? WHERE article_content_image_id = ?");
						$stmt->bind_param("ii", $position, $imageId);
						$stmt->execute();
					}
					cms_status($this->cT->get("sort_success"));
				}
			}

			private function setArticleFieldValues(){
				$stmt = $this->db->prepare("SELECT ac.article_title, ac.text, ac.lang_fk, a.is_active FROM cms_article_content AS ac LEFT JOIN cms_article AS a ON ac.article_fk = a.article_id WHERE article_fk = ?");
				$stmt->bind_param("i", $_GET["edit"]);
				$stmt->execute();
				$stmt->bind_result($title, $text, $lang_fk, $is_active);

				while($stmt->fetch()){
					$_POST["title_".$lang_fk] = $title;
					$_POST["text_".$lang_fk] = $text;
					$_POST["is_active"] = $is_active == 1 ? "1" : null;
				}
			}

			//BUILDUP
			public function controller(){
				if(!isset($_GET["articles"])){
					if(!isset($_GET["edit"]) && !isset($_GET["add"])){
						$this->removeNavigation();
						$this->sortNavigation();
					}else{
						if($_SERVER["REQUEST_METHOD"] === "POST"){
							$this->addEditNavigation();
						}else{
							$this->removeMetaImage();
							$this->setNavigationFieldValues();
						}
					}
				}else{
					if(!isset($_GET["edit"]) && !isset($_GET["add"])){
						$this->removeArticle();
						$this->sortArticles();
					}else{
						if($_SERVER["REQUEST_METHOD"] === "POST"){
							$this->addEditArticle();
						}else{
							$this->removeArticleImage();
							$this->sortArticleImages();
							$this->setArticleFieldValues();
						}
					}
				}
			}

			public function view(){

				$form = new coreForm();
				$table = new coreTable();

				echo "<h1>".$this->cT->get("navigation_module_title")."</h1>";
				echo "<p>".$this->cT->get("navigation_module_description")."</p><br>";

				if(!isset($_GET["articles"])){

					if(!isset($_GET["edit"]) && !isset($_GET["add"])){

						$table->makeSortable("navigation");
						$table->addTitle(array($this->cT->get("navigation_pages")),
							array(
								array("link"=>"add=1", "name"=>"Add", "direct_link"=>true)
							)
						);
						$table->addSubtitle(array($this->cT->get("navigation_title")));
						$this->navigation($table, 0);
						echo $table->render();
					}else{

						$form->addTitle($this->cT->get("page"));
						$query = "SELECT lang_id, name, short FROM cms_lang ORDER BY name ASC";
						$q = $this->db->query($query);

						$pages = array("- NONE -");
						$pages = $this->navigationArray(0, 0, $pages);

						$form->addCheckbox("Aktiv", "is_active");
						$form->addCheckbox($this->cT->get("navigation_invisible"), "is_invisible");
						$form->addSelect($this->cT->get("navigation_child_of"), "child_of", $pages);

						while($res = $q->fetch_assoc()){
							$form->addSubtitle($res["name"]);
							$form->addText($this->cT->get("navigation_title"), "title_".$res["lang_id"], array("required"=>true));
							$form->addText($this->cT->get("navigation_description"), "description_".$res["lang_id"]);
							$form->addText($this->cT->get("navigation_keywords"), "keywords_".$res["lang_id"]);
							$form->addFileUpload($this->cT->get("navigation_meta_image"), "metaimage_".$res["short"]);
							if(file_exists("media/metaimage/".$_GET["edit"]."/".$res["short"]."/share.jpg")){
								$form->addImageGallery(array(array("path"=>"/media/metaimage/".$_GET["edit"]."/".$res["short"]."/share.jpg?v=".strtotime("now"))),false);
							}
						}

						$form->addSubmit($this->cT->get("global_submit"), "submit");
						echo $form->render();
						cms_back();

					}
				}else{
					if(!isset($_GET["edit"]) && !isset($_GET["add"])){

						$stmt = $this->db->prepare("SELECT a.article_id, ac.article_title, SUBSTRING(ac.text, 1, 50) AS article_text FROM cms_article AS a LEFT JOIN cms_article_content AS ac ON a.article_id = ac.article_fk WHERE a.is_deleted = 0 AND navigation_fk = ? AND ac.lang_fk = ? ORDER BY a.sort ASC");
						$stmt->bind_param("ii", $_GET["articles"], $this->_userLang);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($article_id, $article_title, $article_text);
						
						$table->addTitle(array($this->cT->get("navigation_articles")), array(array("link"=>"add=1", "name"=>"Add", "direct_link"=>true)));
						$table->addSubtitle(array($this->cT->get("navigation_title"), $this->cT->get("navigation_text")));

						if($stmt->num_rows == 0){
							$table->addRow(array($this->cT->get("global_no_entry_found")));
						}else{
							$table->makeSortable("articles");
						}

						while($stmt->fetch()){
							$table->addRow(array("<a href=\"/?admin=1&module=".$_GET["module"]."&articles=".$_GET["articles"]."&edit=".$article_id."\">".$article_title."</a>", strip_tags($article_text)), 
								array(
									array("link"=>"rmv=".$article_id, "async"=>"1", "direct_link"=>true, "confirmDialog"=>$this->cT->get("global_confirm_delete"))
								), $article_id
							);
						}

						echo $table->render();
						cms_back();
					}else{
						$form->addTitle($this->cT->get("navigation_articles"));
						$query = "SELECT lang_id, name, short FROM cms_lang ORDER BY name ASC";
						$q = $this->db->query($query);
						$form->addCheckbox("Aktiv", "is_active");

						while($res = $q->fetch_assoc()){
							$form->addSubtitle($res["name"]);
							$form->addText($this->cT->get("navigation_title"), "title_".$res["lang_id"]);
							$form->addRichtext($this->cT->get("navigation_content"), "text_".$res["lang_id"]);
							$form->addFileUpload($this->cT->get("navigation_images"), "image_".$res["short"]);

							if(isset($_GET["edit"])){
								$images = array();
								$dir = "media/navigation/".$_GET["edit"]."/".$res["short"];

								$stmt = $this->db->prepare("SELECT article_content_image_id, image, sort FROM cms_article_content_image WHERE article_content_fk = ? AND lang_fk = ? ORDER BY sort ASC");
								$stmt->bind_param("ii", $_GET["edit"], $res["lang_id"]);
								$stmt->execute();
								$stmt->bind_result($image_id, $image, $sort);

								while($stmt->fetch()){
									$images[] = array("path"=>"/".$dir."/".$image, "lang"=>$res["lang_id"], "id"=>$image_id);
								}
								$form->addImageGallery($images, true);
							}
						}

						$form->addSubmit($this->cT->get("global_submit"), "submit");
						echo $form->render();
						cms_back();
					}
				}
			}
		}
?>	