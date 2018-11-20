<?php
	class admin_termine extends plugin{
					
		public function configure(){
			$this->setPermission(0);
			$this->setName("Termine");
			$this->setNavigation(array("overview"=>"Übersicht", "calendar"=>"Kalender"));
		}

		public function controller(){
			if(!isset($_GET["part"])){
				$_GET["part"] = "overview";
			}

			if(!isset($_GET["details"]) && !isset($_GET["add"]) && !isset($_GET["edit"])){

				if(isset($_GET["rmv"]) && $this->user->getPermissions() >= 1){
					$query = "DELETE FROM tbl_appointment WHERE appointment_id = '".$_GET["rmv"]."'";
					$this->db->query($query);
					cms_status("Eintrag gelöscht");
				}

			}elseif(isset($_GET["edit"]) || isset($_GET["add"]) && $this->user->getPermissions() >= 1){

				if($_SERVER["REQUEST_METHOD"] === "POST"){
					$query = isset($_GET["edit"])	? "UPDATE tbl_appointment SET all_day = '".isset($_POST["all_day"])."', name = '".$_POST["name"]."', start_date = '".date("Y-m-d", strtotime($_POST["start_date"]))."', start_time = '".date("H:i:s", strtotime($_POST["start_time"]))."', end_date = '".date("Y-m-d", strtotime($_POST["end_date"]))."', end_time = '".date("H:i:s", strtotime($_POST["end_time"]))."', description = '".$_POST["description"]."', location='".$_POST["location"]."' WHERE appointment_id = '".$_GET["edit"]."'"
													: "INSERT INTO tbl_appointment (name, start_date, end_date, start_time, end_time, description, all_day, location) VALUES ('".$_POST["name"]."', '".date("Y-m-d", strtotime($_POST["start_date"]))."', '".date("Y-m-d", strtotime($_POST["end_date"]))."', '".date("H:i:s", strtotime($_POST["start_time"]))."', '".date("H:i:s", strtotime($_POST["end_time"]))."', '".$_POST["description"]."', '".isset($_POST["all_day"])."', '".$_POST["location"]."')";
					$this->db->query($query);
					$id = isset($_GET["edit"]) ? $_GET["edit"] : $this->db->insert_id;

					@mkdir("media/appointments/".$id);
					for($i = 0; $i < count($_FILES["documents"]["name"]); $i++){
						move_uploaded_file($_FILES["documents"]["tmp_name"][$i], "media/appointments/".$id."/".$_FILES["documents"]["name"][$i]);
					}

					cms_status("Eintrag erfolgreich gespeichert");
					if(isset($_GET["add"])){
						unset($_POST);
					}
				}

				if(isset($_GET["edit"])){
					$query = "SELECT name, start_date, start_time, end_date, end_time, description, all_day, location FROM tbl_appointment WHERE appointment_id = '".$_GET["edit"]."' LIMIT 1";
					$q = $this->db->query($query);
					$res = $q->fetch_assoc();
					$_POST["name"] = $res["name"];
					$_POST["start_date"] = date("d.m.Y", strtotime($res["start_date"]));
					$_POST["end_date"] = date("d.m.Y", strtotime($res["end_date"]));
					$_POST["start_time"] = date("H:i", strtotime($res["start_time"]));
					$_POST["end_time"] = date("H:i", strtotime($res["end_time"]));
					$_POST["description"] = $res["description"];
					$_POST["location"] = $res["location"];
					$_POST["all_day"] = $res["all_day"] == 0 ? null : 1;
				}

				if(isset($_GET["add"]) && $_GET["part"] == "calendar"){
					$_POST["start_date"] = date("d.m.Y", strtotime($_GET["add"]));
					$_POST["end_date"] = date("d.m.Y", strtotime($_GET["add"]));
					$_POST["all_day"] = 1;
					$_POST["start_time"] = "00:00";
					$_POST["end_time"] = "00:00";
				}
			}
		}

		public function view(){

			echo "<h1>Termine</h1>";
			echo "<p>Hier können Sie alle Termine einsehen.</p><br>";
			if($_GET["part"] == "overview"){
			
				$form = new coreForm();

				if(!isset($_GET["details"]) && !isset($_GET["add"]) && !isset($_GET["edit"])){
					$table = new coreTable();
					if($this->user->getPermissions() >= 1){
						$table->addTitle(array("Kommende Termine"), array(array("name"=>"Hinzufügen", "link"=>"add=1")));
					}else{
						$table->addTitle(array("Kommende Termine"));
					}
					$table->addSubtitle(array("Termin", "Datum", "Ort", "Beschreibung"));
					$query = "SELECT appointment_id, name, start_date, end_date, start_time, end_time, SUBSTRING(description, 1, 90) AS description, location FROM tbl_appointment WHERE start_date >= '".date("Y-m-d")."' ORDER BY start_date ASC, start_time ASC";
					$q = $this->db->query($query);
					while($res = $q->fetch_assoc()){
						if($this->user->getPermissions() >= 1){
							$table->addRow(array("<a href=\"/index.php/?admin=1&module=termine&part=overview&details=".$res["appointment_id"]."\">".$res["name"]."</a>", date("d.m.Y H:i", strtotime($res["start_date"]." ".$res["start_time"])), $res["location"], strip_tags($res["description"])."..."), array(
								array("name"=>"Bearbeiten", "link"=>"edit=".$res["appointment_id"]),
								array("name"=>"Löschen", "link"=>"rmv=".$res["appointment_id"], "async"=>true)
							));
						}else{
							$table->addRow(array("<a href=\"/index.php/?admin=1&module=termine&part=overview&details=".$res["appointment_id"]."\">".$res["name"]."</a>", date("d.m.Y H:i", strtotime($res["start_date"]." ".$res["start_time"])), $res["location"], strip_tags($res["description"])."..."));
						}
					}

					$query = "SELECT appointment_id, name, start_date, end_date, start_time, end_time, SUBSTRING(description, 1, 90) AS description, location FROM tbl_appointment WHERE start_date < '".date("Y-m-d")."' ORDER BY start_date ASC, start_time ASC";
					$q = $this->db->query($query);
					$table->addTitle(array("Vergangene Termine"));
					while($res = $q->fetch_assoc()){
						if($this->user->getPermissions() >= 1){
							$table->addRow(array("<a href=\"/index.php/?admin=1&module=termine&part=overview&details=".$res["appointment_id"]."\">".$res["name"]."</a>", date("d.m.Y H:i", strtotime($res["start_date"]." ".$res["start_time"])), $res["location"], strip_tags($res["description"])."..."), array(
								array("name"=>"Bearbeiten", "link"=>"edit=".$res["appointment_id"], "async"=>false),
								array("name"=>"Löschen", "link"=>"rmv=".$res["appointment_id"], "async"=>true)
							));
						}else{
							$table->addRow(array("<a href=\"/index.php/?admin=1&module=termine&part=overview&details=".$res["appointment_id"]."\">".$res["name"]."</a>", date("d.m.Y H:i", strtotime($res["start_date"]." ".$res["start_time"])), $res["location"], strip_tags($res["description"])."..."));
						}
					}
					echo $table->render();
				}elseif((isset($_GET["edit"]) || isset($_GET["add"])) && $this->user->getPermissions() >= 1){
					$this->getEventForm();
				}elseif(isset($_GET["details"])){
					$this->getEventDetailView();
				}
			}else{
				if(isset($_GET["details"])){
					$this->getEventDetailView();
				}elseif((isset($_GET["edit"]) || isset($_GET["add"])) && $this->user->getPermissions() >= 1){
					$this->getEventForm();
				}else{
					$calendar = new coreCalendar();
					$calendar->addNavigation();

					$calendar->addEventClick("details");
					if($this->user->getPermissions() >= 2){
						$calendar->addDayClick("add");
					}

					$query = "SELECT appointment_id, name, start_date, end_date, start_time, end_time, all_day, SUBSTRING(description, 1, 90) AS description FROM tbl_appointment WHERE start_date >= '".date($_SESSION["calendarYear"]."-".$_SESSION["calendarMonth"]."-01")."' AND start_date <= '".date($_SESSION["calendarYear"]."-".$_SESSION["calendarMonth"]."-31")."' ORDER BY start_date ASC, start_time ASC";
					
					$q = $this->db->query($query);
					while($res = $q->fetch_assoc()){
						$calendar->addEvent($res["start_date"], $res["end_date"], $res["start_time"], $res["end_time"], $res["name"], $res["appointment_id"], "lightblue", $res["all_day"]);
					}
					$calendar->show();
				}
			}
		}

		public function getEventDetailView(){
			$table = new coreTable(false);
			$query = "SELECT name, start_date, end_date, start_time, end_time, description, all_day, location FROM tbl_appointment WHERE appointment_id = '".$_GET["details"]."'";
			$q = $this->db->query($query);
			$res = $q->fetch_assoc();
			$table->addTitle(array($res["name"]));
			$table->addRow(array("Name", $res["name"]));
			if($res["all_day"]){
				if($res["start_date"] != $res["end_date"]){
					$table->addRow(array("Beginn", date("d.m.Y", strtotime($res["start_date"]))));
					$table->addRow(array("Ende", date("d.m.Y", strtotime($res["end_date"]))));
				}else{
					$table->addRow(array("Datum", date("d.m.Y", strtotime($res["start_date"]))));
				}
			}else{
				$table->addRow(array("Beginn", date("d.m.Y H:i", strtotime($res["start_date"]." ".$res["start_time"]))));
				$table->addRow(array("Ende", date("d.m.Y H:i", strtotime($res["end_date"]." ".$res["end_time"]))));
			}
			$table->addRow(array("Ort", $res["location"]));
			$table->addRow(array("Beschreibung", $res["description"]));

			if($this->user->getPermissions() >= 1){
				$table->addRow(array("<a href=\"/index.php/?admin=1&module=termine&part=".$_GET["part"]."&edit=".$_GET["details"]."\">Event bearbeiten</a>"));
			}

			$path = "media/appointments/".$_GET["details"]."/";
			if(file_exists($path)){
				$files = scandir($path);
				if(count($files) > 2){ 
					$table->addSubtitle(array("Dokumente"));
					foreach ($files as $file) {
						if($file != ".." && $file != "."){
							$table->addRow(array("<a class=\"media-document\" download href=\"/".$path.$file."\"><img draggable=\"false\" src=\"".getFiletypeIcon($path.$file)."\"> <span>".$file."</span></a>"));
						}
					}
				}
			}
			

			echo $table->render();
			cms_back();
		}

		public function getEventForm(){
			$form = new coreForm();
			$form->addTitle("Termin bearbeiten/erfassen");
			$form->addText("Name", "name", array("required"=>true));
			$form->addText("Start-Datum", "start_date", array("required"=>true));
			$form->addText("End-Datum", "end_date", array("required"=>true));
			$form->addCheckbox("Ganztägiger Event", "all_day");
			$form->addText("Zeit", "start_time", array("required"=>true));
			$form->addText("Ende", "end_time", array("required"=>true));
			$form->addText("Ort", "location", array("required"=>true));
			$form->addRichtext("Beschreibung", "description");
			$form->addFileUpload("Dokumente", "documents");


			$form->addSubmit("Speichern", "submit");
			echo $form->render();
			
			$path = "media/appointments/".$_GET["edit"];
			if(isset($_GET["edit"]) && file_exists($path)){
				$table = new coreTable();
				$table->addTitle(array("Dokumente"));
				$files = scandir($path);
				foreach ($files as $file) {
					if($file != ".." && $file != "."){
						$table->addRow(array("<a download href=\"/".$path."/".$file."\">".$file."</a>"), array(
							array("name"=>"Löschen", "link"=>"rmv_file=".$file, "async"=>true)
						));
					}
				}

				echo $table->render();
			}

			cms_back();
		}
	}
?>	