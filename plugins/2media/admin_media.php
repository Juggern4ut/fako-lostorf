<?php
		class admin_media extends plugin{
						
			public function configure(){
				$this->setPermission(0);
				$this->setName($this->cT->get("module_media"));
			}

			private function deleteFolder($dir){
				if (is_dir($dir)) { 
					$objects = scandir($dir); 
				    foreach ($objects as $object) { 
				    	if ($object != "." && $object != "..") { 
				        	if (is_dir($dir."/".$object))
				        		rrmdir($dir."/".$object);
				        	else
								unlink($dir."/".$object); 
				    	} 
				    }
				    rmdir($dir); 
				}
			}

			private function removeLogic(){
				if(isset($_GET["rmv"]) && $this->user->getPermissions()){

					$path = (isset($_GET["path"]) && trim($_GET["path"]) != "") ? "media/userdocuments/".$_GET["path"].$_GET["rmv"] : "media/userdocuments/".$_GET["rmv"];
					if(file_exists($path) && strpos($_GET["rmv"], "..") === false){
						if(is_dir($path))
							$this->deleteFolder($path);
						else
							unlink($path);

						cms_status($this->cT->get("global_delete_success"));
						$this->logger->log($this->user->getUsername()." deleted the file '".$_GET["rmv"]."'.", $this->user->getId());
					}
				}
			}

			private function uploadLogic(){
				if($_SERVER["REQUEST_METHOD"] === "POST"){
					if(isset($_FILES["files"])){
						for($i = 0; $i < count($_FILES["files"]["name"]); $i++){
							move_uploaded_file($_FILES["files"]["tmp_name"][$i], "media/userdocuments/".$_GET["path"].$_FILES["files"]["name"][$i]);
							$this->logger->log($this->user->getUsername()." uploaded the file '".$_FILES["files"]["name"][$i]."' into the folder '".$_GET["path"]."'", $this->user->getId());
						}
					}

					if(trim($_POST["folder"]) != ""){
						@mkdir("media/userdocuments/".$_GET["path"].$_POST["folder"]);
						$this->logger->log($this->user->getUsername()." created the media-folder '/".$_GET["path"].$_POST["folder"]."'.", $this->user->getId());
						unset($_POST);
					}
				}
			}

			public function controller(){
				$_GET["path"] = !isset($_GET["path"]) ? "" : $_GET["path"];
				$_GET["path"] = strpos($_GET["path"], "..") !== false ? "" : $_GET["path"];
				$this->removeLogic();
				$this->uploadLogic();
			}

			public function view(){
				$form = new coreForm();
				$table = new coreTable();

				echo "<h1>".$this->cT->get("media_module_title")."</h1>";
				echo "<p>".$this->cT->get("media_module_description")."</p><br>";

				if($this->user->getPermissions()){
					$form->addTitle("Upload");
					$form->addFileUpload($this->cT->get("media_file")."<div class='form-label'>Maximale Dateigrösse: ".ini_get("upload_max_filesize")."</div>", "files");
					$form->addText($this->cT->get("media_foldername"), "folder");
					$form->addSubmit($this->cT->get("global_submit"), "submit");
					echo $form->render();
				}

				$table->addTitle(array($this->cT->get("media_files")));
				$table->addSubtitle(array($this->cT->get("media_filename")));
				$files_tmp = scandir("media/userdocuments/".$_GET["path"]);
				$tmp_folders = array();
				$tmp_files = array();
				foreach($files_tmp as $fl){
					if(is_dir("media/userdocuments/".$_GET["path"]."/".$fl)){
						$tmp_folders[] = $fl;
					}else{
						$tmp_files[] = $fl;
					}
				}

				$files = array_merge($tmp_folders, $tmp_files);

				$prevPath = explode("/", $_GET["path"]);
				unset($prevPath[count($prevPath)-1], $prevPath[count($prevPath)-1]);
				$prevPath = implode("/", $prevPath);
				if(strlen($prevPath) > 0){
					$prevPath .= "/";
				}

				if(isset($_GET["path"]) && $_GET["path"] != "/" && $_GET["path"] != ""){
					$table->addRow(	array("<a class=\"media-document\" href=\"/index.php/?admin=1&module=media&path=".$prevPath."\"><img draggable=\"false\" src=\"/cms/img/filetypes/folder_up.png\"><span>..</span></a>"));
				}

				count($files) <= 2 ? $table->addRow(array($this->cT->get("global_no_entry_found"))) : null;
				
				foreach ($files as $file) {

					if($file != ".." && $file != "."){

						$rmvIcon = $this->user->getPermissions() ? array(array("link"=>"rmv=".$file, "name"=>$this->cT->get("remove"), "async"=>"1", "confirmDialog"=>$this->cT->get("global_confirm_delete"), "direct_link"=>true))
																 : null;

						if(is_dir("media/userdocuments/".$_GET["path"].$file)){
							$table->addRow(	array("<a class=\"media-document\" href=\"/index.php/?admin=1&module=media&path=".$_GET["path"].$file."/\"><img draggable=\"false\" src=\"".getFiletypeIcon("media/userdocuments/".$_GET["path"].$file)."\"> <span>".$file."</span></a>"), $rmvIcon);
						}else{
							$table->addRow(	array("<a class=\"media-document\" download href=\"/media/userdocuments/".$_GET["path"].$file."\"><img draggable=\"false\" src=\"".getFiletypeIcon("media/userdocuments/".$_GET["path"].$file)."\"> <span>".$file."</span></a>"), $rmvIcon);
						}
					}
				}

				echo $table->render();
				echo "<span style=\"font-size: 9px; font-style: italic;\">Icons made by <a target=\"_blank\" href=\"https://www.flaticon.com/authors/smashicons\">smashicons</a> from <a target=\"_blank\" href=\"https://www.flaticon.com\">www.flaticon.com</a></span>";
			}
		}
?>	