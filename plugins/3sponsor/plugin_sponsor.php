<?php
/**
* plugin_navigation.php - contains the plugin_navigation class
* @author Lukas Meier
* @copyright Lukas Meier
*/

	/**
	* plugin_navigation - Manages the public and async functions for the navigation plugin
	* @author Lukas Meier
	* @copyright Lukas Meier
	*/
	class plugin_sponsor extends plugin{

		/**
		 * 
		 */
		public function getSponsors(){
			$retArray = array();
			$q = $this->db->query('SELECT name, link, sponsor_id FROM tbl_sponsor ORDER BY sort ASC');
			while($res = $q->fetch_assoc()){
				$tmp = array();
				$tmp['id'] = $res["sponsor_id"];
				$tmp['name'] = $res["name"];
				$tmp['link'] = $res["link"];
				$tmp['hasLogo'] = file_exists('media/sponsor/'.$res["sponsor_id"].'.png') ? true : false;
				if($tmp['hasLogo']){
					$tmp['logo'] = 'media/sponsor/'.$res["sponsor_id"].'.png';
				}
				$retArray[] = $tmp;
			}
			return $retArray;
		}

		/**
		* Async-Function which is called by using the url /?async=1
		*/
		public function async(){

		}
	}
?>