<?php
	class plugin_termine extends plugin{

		public function async(){
			if(isset($_GET["download_multiple_appointments"])){
				$ics = new coreIcs();

				$q = $this->db->query("SELECT start_date, end_date, start_time, end_time, description, location, name FROM tbl_appointment WHERE appointment_type_fk = '".$_GET["download_multiple_appointments"]."'");
				while($res = $q->fetch_row()){
					$start = $res[0]." ".$res[2];
					$end = $res[1]." ".$res[3];
					$ics->addEvent($start, $end, $res[6], strip_tags($res[4]), $res[5]);
				}

				$ics->show();
			}
		}
	}
?>