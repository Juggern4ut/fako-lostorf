<?php
	class admin_dashboard extends plugin{
				
		public function configure(){
			$this->setPermission(1);
			$this->setName("Home");
		}

		private function getWelcomeTile(){			
			echo "<div>";
				echo "<h2>".$this->cT->get('dashboard_welcome')." ".$this->user->getUsername()."</h2>";
				echo "<p>".$this->cT->get('dashboard_last_login')." ".date("d.m.Y H:i", strtotime($this->user->getLastLogin()))."</p>";
			echo "</div>";
		}

		private function getPageVisits(){
			echo "<div>";

				echo "<h2>".$this->cT->get('dashboard_visits_today')."</h2>";
				$uniqueVisitsToday = array();
				$q = $this->db->query("SELECT remote_ip FROM cms_visit WHERE timestamp LIKE '".date("Y-m-d")."%'");
				$visitsToday = $q->num_rows;
				while($res = $q->fetch_row()){
					$uniqueVisitsToday[$res[0]] += 1;
				}

				echo "<p>".$this->cT->get('dashboard_visits_today').": <b>".$visitsToday."</b></p>";
				echo "<p>".$this->cT->get('dashboard_unique_visits_today').": <b>".count($uniqueVisitsToday)."</b></p>";
				echo "<br />";

				echo "<h2>".$this->cT->get('dashboard_visits_all_time')."</h2>";
				$uniqueVisits = array();
				$q = $this->db->query("SELECT remote_ip FROM cms_visit");
				$visits = $q->num_rows;
				while($res = $q->fetch_row()){
					$uniqueVisits[$res[0]] += 1;
				}

				echo "<p>".$this->cT->get('dashboard_visits_all_time').": <b>".$visits."</b></p>";
				echo "<p>".$this->cT->get('dashboard_unique_visits_all_time').": <b>".count($uniqueVisits)."</b></p>";

			echo "</div>";
		}

		private function getEmptyPagesTile(){
			$emptyPages = array();
			
			$adminNavigation = $GLOBALS['cmh']->get("admin_navigation");
			$navigation = $GLOBALS['cmh']->get("plugin_navigation");

			$arr = array();
			$navigationPoints = $adminNavigation->navigationArray(0,0,$arr);

			foreach ($navigationPoints as $id=>$nav) {
				if(count($navigation->getContent($id)) == 0){
					$emptyPages[$id] = trim(str_replace("--","",$nav));
				}
			}

			if(count($emptyPages) > 0){
				echo "<div class=\"warning\">";
					echo "<h2>".$this->cT->get('dashboard_empty_pages_title')."</h2>";
					echo "<p>".$this->cT->get('dashboard_empty_pages_description')."</p>";
					echo "<ul>";
					foreach ($emptyPages as $id => $pageTitle) {
						echo "<li><a href=\"/index.php/?admin=".$_GET["admin"]."&module=navigation&articles=".$id."\">".$pageTitle."</a></li>";
					}
					echo "</ul>";
				echo "</div>";
			}
		}

		private function getDiskSpaceTile(){
			echo "<div>";
				echo "<h2>".$this->cT->get('dashboard_diskspace')."</h2>";
				echo "<svg width=\"200\" height=\"200\">";
					echo "<circle r=\"50\" cx=\"100\" cy=\"100\" />";
				echo "</svg>";

				$total = disk_total_space("/"); 
				$free = disk_free_space("/"); 

				$totalFormatted = convertBytesToHumanReadable($total);
				$usedFormatted = convertBytesToHumanReadable($total-$free);

				echo "<p>".$this->cT->get('dashboard_used_diskspace')." <span>".$usedFormatted."</span> ".$this->cT->get('dashboard_of')." <span>".$totalFormatted."</span></p>";

			echo "</div>";
		}

		private function getMobileViewTile(){
			echo "<div class=\"mobileView\">";
				echo "<iframe src=\"/\"></iframe>";
			echo "</div>";
		}

		public function controller(){
		}

		public function view(){
			echo "<div id='dashboard' style='text-align: center;'>";
				echo "<section>";
					$this->getWelcomeTile();
					$this->getEmptyPagesTile();
					$this->getDiskSpaceTile();
					$this->getPageVisits();
				echo "</section>";

				echo "<aside>";
					$this->getMobileViewTile();
				echo "</aside>";
			echo "</div>";
		}
	}
?>