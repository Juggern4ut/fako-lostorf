<?php
/**
* plugin_visitors.php - contains the plugin_visitors class
* @author Lukas Meier
* @copyright Lukas Meier
*/

	/**
	* plugin_visitors - Manages the public and async functions for the visitors plugin
	* @author Lukas Meier
	* @copyright Lukas Meier
	*/
	class plugin_visitors extends plugin{
		public function async(){

			if(isset($_GET["getVisitorData"])){
				if($this->user->isLoggedIn()){
					header('Content-Type: application/json');
					$visits = array();
					$query = "SELECT COUNT(*) AS cnt, DATE(timestamp) AS day FROM cms_visit WHERE is_mobile = 0 GROUP BY day ORDER BY day ASC";
					$q = $this->db->query($query);
					while($res = $q->fetch_row()){
						$visits[$res[1]] = array($res[1], (int)$res[0], 0);
					}

					$query = "SELECT COUNT(*) AS cnt, DATE(timestamp) AS day FROM cms_visit WHERE is_mobile = 1 GROUP BY day ORDER BY day ASC";
					$q = $this->db->query($query);
					while($res = $q->fetch_row()){
						$visits[$res[1]][2] = (int)$res[0];
					}

					$visits = array_values($visits);

					echo json_encode($visits);
				}else{
					echo "Access denied";
				}
			}

			if(isset($_GET["getPlatformData"])){
				if($this->user->isLoggedIn()){
					header('Content-Type: application/json');

					$platforms = array(array("Browser", "Visits"));					
					$query = "SELECT browser_name, COUNT(*) as amount FROM cms_visit WHERE browser_name != '' GROUP BY browser_name ORDER BY amount DESC";
					$q = $this->db->query($query);
					while($res = $q->fetch_row()){
						$platforms[] = array($res[0], (int)$res[1]);
					}

					echo json_encode($platforms);
				}else{
					echo "Access denied";
				}
			}
		}

		private function convertDataToChartForm($data){
			$newData = array();
			$firstLine = true;

			foreach ($data as $dataRow){
				if ($firstLine){
				    $newData[] = array_keys($dataRow);
				    $firstLine = false;
				}

				$newData[] = array_values($dataRow);
			}

			return $newData;
		}
	}
?>