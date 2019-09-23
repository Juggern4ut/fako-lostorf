<?php
		class admin_visitors extends plugin{
						
			public function configure(){
				$this->setPermission(1);
				$this->setName($this->cT->get("module_visitors"));
			}

			public function getDailyVisitorsDiagram(){
				echo "<h1>".$this->cT->get("visitors_count")."</h1>";
				echo "<div id='visitor_chart'></div>";
				echo "<h1>".$this->cT->get("visitors_platform")."</h1>";
				echo "<div style=\"height: 400px; width: 100%;\" id='platforms_chart'></div>";
			}

			public function controller(){	
				
			}

			public function view(){
				$this->getDailyVisitorsDiagram();
			}
		}
?>