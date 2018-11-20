<?php
	class coreLogger{
		private $db;
		public function __construct(){
			$this->db = $GLOBALS['db'];
		}

		public function log($message, $user=0){

			$message = mysqli_real_escape_string($this->db, $message);
			$user = (int)$user;

			$query = "INSERT INTO cms_log (user_fk, message) VALUES ('".$user."', '".$message."')";
			if($this->db->query($query)){
				return true;
			}else{
				return false;
			}
		}
	}
?>