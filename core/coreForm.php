<?php
	class coreForm{

		private $_fields = array();

		/**
		 * @param string $title Form title
		 */
		public function addTitle($title){
			$this->_fields[] = array("class"=>"title", "type"=>"title", "title"=>$title);
		}

		/**
		 * @param string $title Form subtitle
		 */
		public function addSubtitle($title){
			$this->_fields[] = array("class"=>"subtitle", "type"=>"subtitle", "title"=>$title);
		}

		/**
		 * @param string $text Text that describes the field
		 * @param string $name The name of the field
		 * @param array $options All the additional options the field can have
		 */
		public function addText($text, $name, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"text", "name"=>$name, "options"=>$options);
		}

		public function addTextarea($text, $name, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"textarea", "name"=>$name, "options"=>$options);
		}

		public function addRichtext($text, $name, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"richtext", "name"=>$name, "options"=>$options);
		}

		public function addPassword($text, $name, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"password", "name"=>$name, "options"=>$options);
		}

		public function addSelect($text, $name, $values, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"select", "name"=>$name, "values"=>$values, "options"=>$options);
		}

		public function addCheckbox($text, $name, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"checkbox", "name"=>$name, "options"=>$options);
		}

		public function addRadio($text, $name, $values, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"radio", "name"=>$name, "values"=>$values, "options"=>$options);
		}

		public function addFileUpload($text, $name, $options = array()){
			$this->_fields[] = array("class"=>"row", "title"=>$text, "type"=>"fileupload", "name"=>$name, "options"=>$options);
		}

		public function addSubmit($value, $name){
			$this->_fields[] = array("class"=>"row", "title"=>$value, "type"=>"submit", "name"=>$name);
		}

		public function addImageGallery($images, $sortable = false, $sortName = 'sortImages'){
			$this->_fields[] = array("class"=>"row", "type"=>"imageGallery", "value"=>$images, "sortable"=>$sortable, "sortName"=>$sortName);
		}

		private function _renderText($field){
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
				$minLength = isset($field["options"]["minLength"]) ? " minLength=\"".$field["options"]["minLength"]."\"" : "";
				$maxLength = isset($field["options"]["maxLength"]) ? " maxLength=\"".$field["options"]["maxLength"]."\"" : "";
				echo "<input value=\"".$_POST[$field["name"]]."\" type=\"text\"".$required.$minLength.$maxLength." name=\"".$field["name"]."\" />";
			echo "</td>";
		}

		private function _renderTextarea($field){
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
				echo "<textarea".$required." name=\"".$field["name"]."\">";
					echo $_POST[$field["name"]];
				echo "</textarea>";
			echo "</td>";
		}

		private function _renderRichtext($field){
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				echo "<div>";
					$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
					echo "<textarea".$required." class=\"cms-richtext\" name=\"".$field["name"]."\">";
						echo $_POST[$field["name"]];
					echo "</textarea>";
				echo "</div>";
			echo "</td>";	
		}

		private function _renderSelect($field){
			$options = $field["values"];
			$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				echo "<select".$required." name=\"".$field["name"]."\">";
					foreach ($options as $value=>$option) {
						$selected = isset($_POST[$field["name"]]) && $_POST[$field["name"]] == $value ? " selected=\"selected\"" : "";
						echo "<option".$selected." value=\"".$value."\">".$option."</option>";
					}
				echo "</select>";
			echo "</td>";
		}

		private function _renderCheckbox($field){
			echo "<td colspan=\"2\">";
				$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
				$checked = strlen($_POST[$field["name"]]) > 0 ? " checked=\"checked\"" : "";

  				echo "<span class='radio_checkbox'>";
					echo "<input".$checked." type=\"checkbox\"".$required." id=\"".$field["name"]."\" name=\"".$field["name"]."\" />";
					echo "<label for=\"".$field["name"]."\"><div></div>".$field["title"]."</label>";
				echo "</span>";
			echo "</td>";
		}

		private function _renderRadio($field){
			$options = $field["values"];
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				$count = 1;
				foreach ($options as $value=>$option) {
					echo "<span class='radio_checkbox'>";
						$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
						echo "<input".$required." type=\"radio\" id=\"".$field["name"]."_".$count."\" name=\"".$field["name"]."\" value=\"".$value."\">";
						echo "<label for=\"".$field["name"]."_".$count."\"><div></div>".$option."</label>";
					echo "</span>";
					$count++;
				}
			echo "</td>";
		}

		private function _renderPassword($field){
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
				echo "<input type=\"password\"".$required." name=\"".$field["name"]."\" />";
			echo "</td>";
		}

		private function _renderSubmit($field){
			echo "<td></td>";
			echo "<td>";
				echo "<input type=\"submit\" name=\"".$field["name"]."\" value=\"".$field["title"]."\" />";
			echo "</td>";
		}

		private function _renderFileUpload($field){
			$required = $field["options"]["required"] == true ? " required=\"required\"" : "";
			echo "<td>".$field["title"]."</td>";
			echo "<td>";
				echo "<input".$required." type=\"file\" id=\"".$field["name"]."\" class=\"inputfile\" name=\"".$field["name"]."[]\" data-multiple-caption=\"{count} files selected\" multiple/>";
				echo "<label class=\"fileUpload\" for=\"".$field["name"]."\"><span>File Upload</span></label>";
			echo "</td>";
		}

		private function _renderImageGallery($field){
			echo "<td colspan=\"2\">";
				foreach ($field["value"] as $image) {
					$class = strlen(trim($image["class"])) > 0 ? " ".trim($image["class"]) : "";
					echo "<div class=\"image-gallery-element".$class."\" sortListName=\"".$field["sortName"]."\" language=\"".$image["lang"]."\" image_id=\"".$image["id"]."\" onclick=\"cmsImageSettings('".$image["path"]."', '".$image["id"]."', this);\" style=\"background-image: url('".$image["path"]."');\"><span></span></div>";
				}
			echo "</td>";
		}

		public function render(){
			ob_start();

			if(isset($_POST)){
				foreach ($_POST as $key=>$val) {
					$_POST[$key] = str_replace("\'", "'", $val);
				}
			}

			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			echo "<form novalidate class=\"cms-form\" method=\"POST\" action=\"".$actual_link."&async=1\" enctype=\"multipart/form-data\">";
				echo "<table class=\"cms-table\">";
					foreach ($this->_fields as $row) {
						echo "<tr class=\"".$row["type"]."\">";
								if($row["type"] == "title"){
									echo "<td>".$row["title"]."</td>";
									echo "<td></td>";
								}elseif($row["type"] == "subtitle"){
									echo "<td>".$row["title"]."</td>";
									echo "<td></td>";
								}elseif($row["type"] == "text"){
									$this->_renderText($row);
								}elseif($row["type"] == "select"){
									$this->_renderSelect($row);
								}elseif($row["type"] == "checkbox"){
									$this->_renderCheckbox($row);
								}elseif($row["type"] == "password"){
									$this->_renderPassword($row);									
								}elseif($row["type"] == "radio"){
									$this->_renderRadio($row);									
								}elseif($row["type"] == "fileupload"){
									$this->_renderFileUpload($row);									
								}elseif($row["type"] == "imageGallery"){
									$this->_renderImageGallery($row);

									if($row["sortable"]){
										?>
											<script type="text/javascript">
												var sortName = '<?php echo $row["sortName"] ?>';
												$("form.cms-form").append("<input type='hidden' class='"+sortName+"' name='"+sortName+"'>");
												$("tr.imageGallery td").sortable({
													update: function( event, ui ) {
														var sortArray = {};
														var lang;
														ui.item.parent().find("div").each(function(index){
															sortArray[index+1] = $(this).attr("image_id");
															lang = $(this).attr("language");
														});

														var listName = ui.item.attr("sortlistname");

														$("."+listName).val(JSON.stringify(sortArray));
													}
												});
											</script>
										<?php
									}

								}elseif($row["type"] == "submit"){
									$this->_renderSubmit($row);
								}elseif($row["type"] == "textarea"){
									$this->_renderTextarea($row);
								}elseif($row["type"] == "richtext"){
									$this->_renderRichtext($row);
								}
						echo "</tr>";
					}
				echo "</table>";
			echo "</form>";
			$return = ob_get_clean();
			return $return;
		}
	}
?>