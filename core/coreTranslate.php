<?php
/**
* coreTranslate.php - contains the coreTranslate class
* @author Lukas Meier
* @copyright Lukas Meier
*/
	/**
	* Manages the translation of the CMS and frontend
	* @author Lukas Meier
	* @copyright Lukas Meier
	*/
	class coreTranslate{

		/**
		* Contains the database connection
		* @var mysqli
		*/
		private $_db;
		
		/**
		* Contains all currently saved translations
		* @var array
		*/
		private $_translations;

		/**
		* Constructor sets the database connection and the userdata
		*/
		public function __construct(){
			$this->db = $GLOBALS['db'];
			$this->user = $_SESSION['cms_user'];
		}

		/**
		* Checks if the translation files exist and loads them. If they don't exist, the function will create them.
		*/
		public function init(){

			if($this->user != "" && $_GET["admin"] == 1){
				$this->user = unserialize(base64_decode($_SESSION['cms_user']));
				$lang_id = $this->user["settings"]["cms_lang"];
				$short = "";
				$stmt = $this->db->prepare("SELECT short FROM cms_lang WHERE lang_id = ?");
				$stmt->bind_param("i", $lang_id);
				$stmt->execute();
				$stmt->bind_result($lng_short);
				$stmt->fetch();
				$short = $lng_short;
				$stmt->close();
			}else{
				$lang_id = $_SESSION["lang"][0];
				$short = $_SESSION["lang"][1];
			}

			if(!file_exists("media/locale/translations.".$short)){
				$langArray = array();

				$stmt = $this->db->prepare("SELECT tt.text, t.key FROM cms_translation_text as tt LEFT JOIN cms_translation AS t ON tt.translation_fk = t.translation_id WHERE tt.lang_fk = ?");
				$stmt->bind_param("i", $lang_id);
				$stmt->execute();
				$stmt->bind_result($text, $key);

				while($stmt->fetch()){
					$langArray[$key] = $text;
				}

				$storage_lang = gzcompress(serialize($langArray));
				file_put_contents("media/locale/translations.".$short, $storage_lang);
			}

			$file_contents = file_get_contents('media/locale/translations.'.$short);
			$lang = unserialize(gzuncompress($file_contents));
			$this->_translations = $lang;
		}

		/**
		* Returns a translation based on the language in the session or user-settings
		* @param string $key The key of the translation
		* @return string the translated string
		*/
		public function get($key){
			if(isset($this->_translations[$key])){
				return $this->_translations[$key];
			}else{
				return "[".$key."]";
			}
		}

		/**
		* Delete all translation files and initialize them again.
		*/
		public function refreshTranslationFiles(){
			$files = scandir("media/locale");
			foreach ($files as $file) {
				if($file != ".." && $file != "."){
					unlink("media/locale/".$file);
				}
			}
			$this->init();
		}
	}
?>