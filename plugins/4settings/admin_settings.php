<?php
		class admin_settings extends plugin{
						
			public function configure(){
				$this->setPermission(0);
				$this->setName($this->cT->get("module_settings"));
			}

			public function controller(){

				if($this->user->getPermissions() <= 0){
					$_GET["edit"] = $this->user->getId();
				}

				if(isset($_GET["edit"]) || isset($_GET["add"])){
					if($_SERVER["REQUEST_METHOD"] === "POST"){
						$error = false;
						
						$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
						$username = $_POST["username"];
						$email = $_POST["email"];
						$permission_level = $_POST["permission_level"];
						$lang_fk = $_POST["language"];

						if(isset($_GET["add"])){
							if(isset($_POST["password"]) && strlen($_POST["password"]) > 0 && $_POST["password"] === $_POST["password_repeat"]){
								$stmt = $this->db->prepare("INSERT INTO cms_user (username, password, email, permission_level, lang_fk) VALUES (?, ?, ?, ?, ?)");
								$stmt->bind_param("sssii", $username, $password, $email, $permission_level, $lang_fk);
								$stmt->execute();
 	
								$id = $this->db->insert_id;
								$this->logger->log($this->user->getUsername()." created a new account named '".$username."'.", $this->user->getId());
							}else{
								$error = true;
							}
						}else{
							$id = $_GET["edit"];
							$perm = $this->user->getPermissions() >= 2 ? $permission_level : "permission_level";

							if(isset($_POST["password"]) && strlen($_POST["password"]) > 0 && $_POST["password"] === $_POST["password_repeat"]){
								$stmt = $this->db->prepare("UPDATE cms_user SET permission_level = ?, username = ?, email = ?, password = ?, lang_fk = ? WHERE user_id = ?");
								$stmt->bind_param("isssii", $perm, $username, $email, $password, $lang_fk, $id);
								$this->logger->log($this->user->getUsername()." changed the account settings and password of '".$username."'.", $this->user->getId());
							}else{
								$stmt = $this->db->prepare("UPDATE cms_user SET permission_level = ?, username = ?, email = ?, lang_fk = ? WHERE user_id = ?");
								$stmt->bind_param("issii", $perm, $username, $email, $lang_fk, $id);
								$this->logger->log($this->user->getUsername()." changed the account settings of '".$username."'.", $this->user->getId());
							}
							$stmt->execute();
						}

						if($error){
							cms_status($this->cT->get("error"), "#C00", false);
						}else{
							isset($_GET["add"]) ? cms_status($this->cT->get("global_add_success")) : cms_status($this->cT->get("global_edit_success"));
						}

						if(isset($_GET["add"])){
							unset($_POST);
						}
					}else{

						$stmt = $this->db->prepare("SELECT username, email, permission_level, lang_fk FROM cms_user WHERE user_id = ?");
						$stmt->bind_param("i", $_GET["edit"]);
						$stmt->execute();
						$stmt->bind_result($username, $email, $permission_level, $lang_fk);

						while($stmt->fetch()){
							$_POST["username"] = $username;
							$_POST["email"] = $email;
							$_POST["permission_level"] = $permission_level;
							$_POST["language"] = $lang_fk;
						}
					}
				}else{
					if(isset($_GET["rmv"])){
						if($this->user->getId() == $_GET["rmv"]){
							cms_status($this->cT->get("settings_delete_self_error"), "#C00", false);
						}else{

							$stmt = $this->db->prepare("SELECT username FROM cms_user WHERE user_id = ? LIMIT 1");
							$stmt->bind_param("i", $_GET["rmv"]);
							$stmt->execute();
							$stmt->bind_result($username);
							$stmt->fetch();
							$stmt->close();

							$stmt = $this->db->prepare("UPDATE cms_user SET is_disabled = 1 WHERE user_id = ?");
							$stmt->bind_param("i", $_GET["rmv"]);
							$stmt->execute();

							$this->logger->log($this->user->getUsername()." deleted the account of '".$username."'.", $this->user->getId());

							cms_status($this->cT->get("global_delete_success"));
						}
					}
				}		
			}

			public function view(){
				
				$form = new coreForm();
				$table = new coreTable();

				echo "<h1>".$this->cT->get("settings_module_title")."</h1>";
				echo "<p>".$this->cT->get("settings_module_description")."</p><br>";

				if(!isset($_GET["edit"]) && !isset($_GET["add"])){

					$table->addTitle(array($this->cT->get("settings_user")), array(array("link"=>"add=1", "direct_link"=>true)));
					
					$query = "SELECT username, user_id FROM cms_user WHERE is_disabled = 0 ORDER BY username ASC";
					$q = $this->db->query($query);
					while($res = $q->fetch_assoc()){
						$table->addRow(array("<a href=\"/?admin=1&module=settings&edit=".$res["user_id"]."\">".$res["username"]."</a>"), 
							array(
								array("link"=>"rmv=".$res["user_id"], "name"=>$this->cT->get("remove"), "confirmDialog"=>$this->cT->get("global_confirm_delete"), "direct_link"=>true, "async"=>"1")
							)
						);
					}

					echo $table->render();

				}else{

					$form->addTitle($this->cT->get("settings_user"));
						
					$form->addText($this->cT->get("settings_username"), "username");
					$form->addText($this->cT->get("settings_email"), "email");

					$languages = [];
					$stmt = $this->db->prepare("SELECT lang_id, name FROM cms_lang ORDER BY name ASC");
					$stmt->execute();
					$stmt->bind_result($lang_id, $name);
					while($stmt->fetch()){
						$languages[$lang_id] = $name;
					}

					$form->addSelect($this->cT->get("settings_language"), "language", $languages);

					if($this->user->getPermissions() >= 2){
						$form->addSelect($this->cT->get("settings_permissions"), "permission_level", array("User", "Administrator", "Root"));
					}

					$form->addPassword($this->cT->get("settings_password"), "password");
					$form->addPassword($this->cT->get("settings_password_repeat"), "password_repeat");

					$form->addSubmit($this->cT->get("global_submit"), "submit");
					echo $form->render();

					cms_back();

				}				
			}
		}
?>	