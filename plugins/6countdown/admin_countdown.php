<?php
		class admin_countdown extends plugin{
						
			public function configure(){
				$this->setPermission(1);
				$this->setName("Countdown");
			}

			public function controller(){
				if($_SERVER["REQUEST_METHOD"] === "POST"){
					$datetime = date("Y-m-d H:i:s", strtotime($_POST["date"]." ".$_POST["time"]));
					$stmt = $this->db->prepare("UPDATE tbl_countdown SET title=?, date=? WHERE countdown_id = 1");
					$stmt->bind_param("ss", $_POST["title"], $datetime);
					$stmt->execute();
				}else{
					$q = $this->db->query("SELECT title, date FROM tbl_countdown WHERE countdown_id = 1");
					$res = $q->fetch_row();
					$_POST["title"] = $res[0];
					$_POST["date"] = date("d.m.Y", strtotime($res[1]));
					$_POST["time"] = date("H:i", strtotime($res[1]));
				}
			}

			public function view(){
				echo "<h1>Countdown</h1>";
				$form = new coreForm();
				$form->addTitle("Countdown");
				$form->addText("&Uuml;berschrift", "title");
				$form->addText("Datum<div style='font-size: 12px;'>Format: 19.03.1994</div>", "date");
				$form->addText("Uhrzeit<div style='font-size: 12px;'>Format: 13:22</div>", "time");
				$form->addSubmit("Speichern", "save");
				echo $form->render();
			}
		}
?>