<?php
	class coreTable{
		private $_rows = array();
		private $_columnCount = 0;
		private $_sortable = false;
		private $_hoverRows = true;
		private $_class = "";

		public function __construct($hoverRows = true){
			$this->_hoverRows = $hoverRows;
		}

		public function addTitle($column = array(), $options = null){
			$this->_rows[] = array("columns"=>$column, "type"=>"title", "options"=>$options);
			$this->checkRowCount($column, $options);
		}

		public function addSubtitle($column = array(), $options = null){
			$this->_rows[] = array("columns"=>$column, "type"=>"subtitle", "options"=>$options);
			$this->checkRowCount($column, $options);
		}

		public function addRow($column = array(), $options = null, $id=false){
			$this->_rows[] = array("columns"=>$column, "type"=>"row", "options"=>$options, "id"=>$id);
			$this->checkRowCount($column, $options);
		}

		private function checkRowCount($column, $options){
			$optionsSet = $options !== null ? 1 : 0;
			if(count($column)+$optionsSet > $this->_columnCount){
				$this->_columnCount = count($column)+$optionsSet;
			}
		}

		public function makeSortable($tableName = "no-name"){
			$this->_sortable = array("isSortable"=>true,"tableName"=>$tableName);
		}

		public function render(){
			ob_start();
			echo "<table class=\"cms-table ".$this->_sortable["tableName"]."\">";
				foreach ($this->_rows as $row) {

					$rowId = $row["id"] !== false ? " row_id = \"".$row["id"]."\"" : "";
					$noHover = $this->_hoverRows ? "" : " no_hover";

					echo "<tr".$rowId." class=\"".$row["type"]."".$noHover."\">";
						$rowCount = 0;
						foreach ($row["columns"] as $column) {
							echo "<td>".$column."</td>";
							$rowCount++;
						}

						while($rowCount < $this->_columnCount){
							echo "<td></td>";
							$rowCount++;
						}

						if($row["options"] !== null){
							$url = $_SERVER["REQUEST_URI"];

							$countDirectLinks = 0;
							foreach ($row["options"] as $link=>$option){
								if($option["direct_link"]){
									echo "<td class=\"cms-table-options\">";
										$tmp = explode("=", $option["link"]);
										$link = $this->getLink($option["link"], $option["async"]);
										echo "<div class=\"directLink ".$tmp[0]."\">";
											$classAsync = $option["async"] ? "async " : "";
											$classConfirmDialog = isset($option["confirmDialog"]) ? "confirmDialog" : "";
											$attrConfirmDialog = isset($option["confirmDialog"]) ? " confirmdialog=\"".$option["confirmDialog"]."\"" : "";
											echo "<a class=\"".$classAsync.$classConfirmDialog."\"".$attrConfirmDialog." href=\"".$link."\"></a>";
										echo "</div>";
									echo "</td>";
									$countDirectLinks++;
								}
							}

							if(count($row["options"]) > $countDirectLinks){
								echo "<td class=\"cms-table-options\">";
									echo "<div>";
									echo "</div>";
										echo "<ul>";
											foreach ($row["options"] as $link=>$option) {
												if(!$option["direct_link"]){
													$url = $this->getLink($option["link"], $option["async"]);
													
													$classAsync = $option["async"] ? "async " : "";
													$classConfirmDialog = isset($option["confirmDialog"]) ? " confirmDialog" : "";
													$attrConfirmDialog = isset($option["confirmDialog"]) ? " confirmdialog=\"".$option["confirmDialog"]."\"" : "";
													
													echo "<li><a class=\"".$classAsync.$classConfirmDialog."\"".$attrConfirmDialog." href=\"".$url."\">".$option["name"]."</a></li>";
												}
											}
									echo "</ul>";
								echo "</td>";
							}
							
						}else{
							echo "<td></td>";
						}
					echo "</tr>";
				}
			echo "</table>";

			if($this->_sortable["isSortable"]){
				echo "<script>";
					echo "makeTableSortable('".$this->_sortable["tableName"]."');";
				echo "</script>";
			}

			$return = ob_get_clean();
			return $return;
		}

		private function getLink($link, $async){
			
			$url = $_SERVER["REQUEST_URI"];
			$tmp = explode("=", $link);

			if($async){
				if(strpos($url, $tmp[0]."=") !== false){
					$url = explode("&async=1", $url);
					$url = str_replace($url[1], "", $_SERVER["REQUEST_URI"]);
				}else{
					$url = $_SERVER["REQUEST_URI"];
				}
				
				$url = str_replace(array("&sort=1","&async=1"), "", $url);
				return $url."&async=1&".$link;

			}else{
				$url = $_SERVER["REQUEST_URI"];
				$url = str_replace(array("&sort=1","&async=1"), "", $url);
				return $url."&".$link;
			}
		}

	}
?>