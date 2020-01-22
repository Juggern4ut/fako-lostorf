<?php
		class admin_mail extends plugin{
						
			public function configure(){
				$this->setPermission(1);
				$this->setName("Mailverteiler");
			}

			public function controller(){
				if(!isset($_GET["members"])){
        }else if(!isset($_GET["edit"]) && !isset($_GET["add"])){
          if(isset($_GET["rmv"])){
            $stmt = $this->db->prepare("DELETE FROM tbl_mail_group_member WHERE mail_group_member_id = ?");
            $stmt->bind_param("i", $_GET["rmv"]);
            $stmt->execute();
            cms_status($this->cT->get("global_delete_success"));
          }
        }else{
          if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_GET["add"])){
              $stmt = $this->db->prepare("INSERT INTO tbl_mail_group_member (mail_group_fk, firstname, lastname, mail) VALUES (?,?,?,?);");
              $stmt->bind_param("isss", $_GET["members"], $_POST["firstname"], $_POST["lastname"], $_POST["mail"]);
              $stmt->execute();
              unset($_POST["firstname"], $_POST["lastname"], $_POST["mail"]);
              cms_status($this->cT->get("global_add_success"));
            }elseif(isset($_GET["edit"])){
              $stmt = $this->db->prepare("UPDATE tbl_mail_group_member SET firstname=?, lastname=?, mail=? WHERE mail_group_member_id=?");
              $stmt->bind_param("sssi", $_POST["firstname"], $_POST["lastname"], $_POST["mail"], $_GET["edit"]);
              $stmt->execute();
              cms_status($this->cT->get("global_edit_success"));
            }
          }else if(isset($_GET["edit"])){
            $stmt = $this->db->prepare("SELECT firstname, lastname, mail FROM tbl_mail_group_member WHERE mail_group_member_id = ?");
            $stmt->bind_param("i", $_GET["edit"]);
            $stmt->execute();
            $stmt->bind_result($firstname, $lastname, $mail);
            $stmt->fetch();
            $_POST["firstname"] = $firstname;
            $_POST["lastname"] = $lastname;
            $_POST["mail"] = $mail;
          }
        }
			}

			public function view(){
        $form = new coreForm();
        $table = new coreTable();
        if(!isset($_GET["members"])){
          echo "<h1>Mailergruppen</h1>";
          $table->addTitle(["Gruppen"]);

          $q = $this->db->query("SELECT mail_group_id, name FROM tbl_mail_group ORDER BY name ASC");
          while($res = $q->fetch_row()){
            $table->addRow([
              '<a href="?admin='.$_GET["admin"].'&module='.$_GET["module"].'&members='.$res[0].'">'.$res[1].'</a>'
            ]);
          }

          echo $table->render();
        }else if(!isset($_GET["edit"]) && !isset($_GET["add"])){
          echo "<h1>Mitglieder</h1>";
          $table->addTitle(["Personen"], [["link"=>"add=1", "name"=>"Add", "direct_link"=>true]]);

          $stmt = $this->db->prepare("SELECT mail_group_member_id, firstname, lastname, mail FROM tbl_mail_group_member WHERE mail_group_fk = ?");
          $stmt->bind_param("i", $_GET["members"]);
          $stmt->execute();
          $stmt->bind_result($id, $firstname, $lastname, $mail);
          while($stmt->fetch()){
            $table->addRow([
              '<a href="?admin='.$_GET["admin"].'&module='.$_GET["module"].'&members='.$_GET["members"].'&edit='.$id.'">'.$firstname.'</a>',
              $lastname, 
              $mail
            ],
            [[
              "link"=>"rmv=".$id,
              "name"=>"Delete",
              "confirmDialog"=>$this->cT->get("global_confirm_delete"),
              "direct_link"=>true,
              "async"=>"1"
            ]]);
          }
          echo $table->render();
          cms_back();
        }else{
          $form->addTitle("Mitglied");
          $form->addText("Vorname", "firstname");
          $form->addText("Nachname", "lastname");
          $form->addText("E-mail", "mail");
          $form->addSubmit("Speichern", "save");
          echo $form->render();
          cms_back();
        }
			}
		}
?>