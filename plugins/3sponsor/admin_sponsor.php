<?php
	class admin_sponsor extends plugin{

		private $_userLang;
					
		public function configure(){
			$this->setPermission(1);
			$this->setName("Sponsoren");
			$this->_userLang = $this->user->getUserLanguage();
		}

		public function controller(){
			if(!isset($_GET["edit"]) && !isset($_GET["add"])){
				if(isset($_GET["sort"])){
					foreach ($_POST["sort"] as $sort => $id) {
						$stmt = $this->db->prepare('UPDATE tbl_sponsor SET sort = ? WHERE sponsor_id = ?');
						$stmt->bind_param('ii', $sort, $id);
						$stmt->execute();
					}
				}
			}else{
				if($_SERVER["REQUEST_METHOD"] === "POST" && trim($_POST["name"]) != ""){
					$stmt = isset($_GET["add"])	?	$this->db->prepare("INSERT INTO tbl_sponsor (name, link) VALUES (?, ?)")
												:	$this->db->prepare("UPDATE tbl_sponsor SET name = ?, link = ? WHERE sponsor_id = ?");

					isset($_GET["add"]) ?	$stmt->bind_param('ss', $_POST["name"], $_POST["link"])
										:	$stmt->bind_param('ssi', $_POST["name"], $_POST["link"], $_GET["edit"]);
					
					$stmt->execute();
					$id = isset($_GET["add"]) ? $this->db->insert_id : $_GET["edit"];

					if(count($_FILES["logo"]["name"]) > 0){
						@mkdir('media/sponsor');
						$ir = new coreImageResizer();
						$ir->resizeImage($_FILES["logo"]["tmp_name"][0], 'media/sponsor/'.$id.'.png', 200, 200, false, "png");
					}
					
				}elseif($_SERVER["REQUEST_METHOD"] === "POST"){
					echo "ERROR";
				}else{
					if(isset($_GET["cmsRemoveSimpleImage"])){
						if(file_exists($_GET["cmsRemoveSimpleImage"])){
							unlink($_GET["cmsRemoveSimpleImage"]);
						}
					}

					if(isset($_GET["edit"])){
						$stmt = $this->db->prepare("SELECT name, link FROM tbl_sponsor WHERE sponsor_id = ? LIMIT 1");
						$stmt->bind_param('i',$_GET["edit"]);
						$stmt->execute();
						$stmt->bind_result($name, $link);
						$stmt->fetch();
						$_POST["name"] = $name;
						$_POST["link"] = $link;
					}
				}
			}
		}

		public function view(){
			$form = new coreForm();
			$table = new coreTable();
			$table->makeSortable('sponsors');
			if(!isset($_GET["edit"]) && !isset($_GET["add"])){
				$table->addTitle(array("Sponsoren"), array(
					array("name"=>"Hinzufügen", "link"=>"add=1", "direct_link"=>true)
				));

				$table->addSubtitle(array('Name', 'Link'));

				$stmt = $this->db->prepare("SELECT sponsor_id, name, link FROM tbl_sponsor ORDER BY sort ASC");
				$stmt->execute();
				$stmt->bind_result($sponsor_id, $name, $link);
				while($stmt->fetch()){
					$table->addRow(array('<a href="/?admin=1&module='.$_GET["module"].'&edit='.$sponsor_id.'">'.$name.'</a>', $link), null, $sponsor_id);
				}

				echo $table->render();
			}else{
				$form->addTitle('Sponsor');
				$form->addText('Name', 'name');
				$form->addText('Link', 'link');
				$form->addFileUpload('Logo', 'logo');
				if(isset($_GET["edit"]) && file_exists('media/sponsor/'.$_GET["edit"].'.png')){
					$form->addSimpleImageGallery(array('media/sponsor/'.$_GET["edit"].'.png'));
				}
				$form->addSubmit('Speichern', 'submit');
				echo $form->render();
				cms_back();
			}
		}
	}
?>