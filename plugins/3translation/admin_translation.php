<?php
	class admin_translation extends plugin{

		private $_userLang;

		public function configure(){
			$this->setPermission(2);
			$this->setName($this->cT->get("module_translation"));
			$this->_userLang = $this->user->getUserLanguage();
		}

		public function controller(){

			if(!isset($_GET["add"]) && !isset($_GET["edit"])){
				if(isset($_GET["rmv"])){

					$stmt = $this->db->prepare("DELETE FROM cms_translation WHERE translation_id = ?");
					$stmt->bind_param("i", $_GET["rmv"]);

					$stmt2 = $this->db->prepare("DELETE FROM cms_translation_text WHERE translation_fk = ?");
					$stmt2->bind_param("i", $_GET["rmv"]);

					if($stmt->execute() && $stmt2->execute()){
						cms_status($this->cT->get("global_delete_success"), "#080");
					}
				}
			}else{
				if($_SERVER["REQUEST_METHOD"] === "POST"){
					if(isset($_GET["add"])){

						$stmt = $this->db->prepare("INSERT INTO cms_translation (`key`) VALUES (?)");
						$stmt->bind_param("s", $_POST["key"]);
						$stmt->execute();

						$translation_id = $this->db->insert_id;

						$query = "SELECT lang_id FROM cms_lang ORDER BY timestamp ASC";
						$q = $this->db->query($query);
						while($res = $q->fetch_assoc()){
							$stmt = $this->db->prepare("INSERT INTO cms_translation_text (translation_fk, lang_fk, text) VALUES (?, ?, ?)");
							$stmt->bind_param("iis", $translation_id, $res["lang_id"], $_POST["translation_".$res["lang_id"]]);
							$stmt->execute();
						}

						cms_status($this->cT->get("global_add_success"), "#080");
						unset($_POST);

					}elseif(isset($_GET["edit"])){

						$stmt = $this->db->prepare("UPDATE cms_translation SET `key` = ? WHERE translation_id = ?");
						$stmt->bind_param("si", $_POST["key"], $_GET["edit"]);
						$stmt->execute();
						$stmt->close();

						$query = "SELECT lang_id FROM cms_lang ORDER BY timestamp ASC";
						$q = $this->db->query($query);
						while($res = $q->fetch_assoc()){
							$stmt = $this->db->prepare("UPDATE cms_translation_text SET text = ? WHERE lang_fk = ? AND translation_fk = ?");
							$stmt->bind_param("sii", $_POST["translation_".$res["lang_id"]], $res["lang_id"], $_GET["edit"]);
							$stmt->execute();
						}

						cms_status($this->cT->get("global_edit_success"), "#080");
					}

					$this->cT->refreshTranslationFiles();

				}else{

					$stmt = $this->db->prepare("SELECT `key` FROM cms_translation WHERE translation_id = ? LIMIT 1");
					$stmt->bind_param("i", $_GET["edit"]);
					$stmt->execute();
					$stmt->bind_result($key);
					$stmt->fetch();
					$_POST["key"] = $key;
					unset($stmt);

					$stmt = $this->db->prepare("SELECT text, lang_fk FROM cms_translation_text WHERE translation_fk = ?");
					$stmt->bind_param("i", $_GET["edit"]);
					$stmt->execute();
					$stmt->bind_result($text, $lang);
					while($stmt->fetch()){
						$_POST["translation_".$lang] = $text;
					}
				}
			}
		}

		public function view(){

			$table = new coreTable();
			$form = new coreForm();

			echo "<h1>".$this->cT->get("translation_module_title")."</h1>";
			echo "<p>".$this->cT->get("translation_module_description")."</p>";
			echo "<br>";

			if(!isset($_GET["add"]) && !isset($_GET["edit"])){

				$table->addTitle(
					array("Titel"), 
					array(
						array("link"=>"add=1", "async"=>false, "direct_link"=>true, "name"=>"add")
					)
				);

				$table->addSubtitle(["Key", $this->cT->get("translation_value")]);

				$_GET["page"] = isset($_GET["page"]) ? $_GET["page"] : 1;
				$articlesPerPage = 50;
				$lowerBound = ($_GET["page"]-1)*$articlesPerPage;

				$stmt = $this->db->prepare("SELECT t.translation_id, t.key, tt.text FROM cms_translation AS t LEFT JOIN cms_translation_text AS tt ON t.translation_id = tt.translation_fk WHERE tt.lang_fk = ? ORDER BY t.key ASC LIMIT ?,?");
				$stmt->bind_param("iii", $this->_userLang, $lowerBound, $articlesPerPage);
				$stmt->execute();
				$stmt->bind_result($translation_id, $key, $text);

				while($stmt->fetch()){
					$table->addRow(
						array("<a href=\"/?admin=1&module=".$_GET["module"]."&edit=".$translation_id."\">".$key."</a>", $text), 
						array(
							array("link"=>"rmv=".$translation_id, "async"=>true, "confirmDialog"=>$this->cT->get("global_confirm_delete"), "direct_link"=>true)
						)
					);
				}
				echo $table->render();

				echo "<div class=\"cms-pagination\">";
					$stmt = $this->db->prepare("SELECT t.translation_id, t.key, tt.text FROM cms_translation AS t LEFT JOIN cms_translation_text AS tt ON t.translation_id = tt.translation_fk WHERE tt.lang_fk = ? ORDER BY t.key ASC");
					$stmt->bind_param("i", $this->_userLang);
					$stmt->execute();
					$stmt->store_result();
					$pages = ceil($stmt->num_rows/$articlesPerPage);
					for($i = 1; $i <= $pages; $i++){
						if($i == $_GET["page"]){
							echo "<span>".$i."</span>";
						}else{
							echo "<a href=\"/index.php/?admin=1&module=".$_GET["module"]."&page=".$i."\">".$i."</a>";
						}
						if($i != $pages){
							echo " | "; 
						}
					}
				echo "</div>";

			}else{
				$form->addTitle($this->cT->get("translation_translation"));

				$query = "SELECT lang_id, short, name FROM cms_lang ORDER BY timestamp ASC";
				$q = $this->db->query($query);
				$form->addText("Key", "key");
				while($res = $q->fetch_assoc()){
					$form->addText($res["name"], "translation_".$res["lang_id"]);
				}

				$form->addSubmit($this->cT->get("global_submit"), "submit");
				
				echo $form->render();
				cms_back();
			}		
		}
	}
?>	