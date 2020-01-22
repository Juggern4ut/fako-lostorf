<?php
/**
* plugin_settings.php - contains the plugin_settings class
* @author Lukas Meier
* @copyright Lukas Meier
*/

	/**
	* plugin_settings - Manages the public and async functions for the settings plugin
	* @author Lukas Meier
	* @copyright Lukas Meier
	*/
	class plugin_countdown extends plugin{
		public function async(){
			if(isset($_GET["getCountdownData"])){
				$q = $this->db->query("SELECT title, date FROM tbl_countdown WHERE countdown_id = 1");
				$res = $q->fetch_row();
				header('Content-Type: application/json');
				echo JSON_encode(["title"=>$res[0],"date"=>$res[1]]);
			}
		}
	}
?>