<?php
/**
	* coreUser - Weble-CMS user class
*/

	/**
		* Handles all the user related functions. 
		*
		* Handles functions such as login/logout, setting the session of the user,
		* changing user settings, such as permissions, language and so on.
		* @author Lukas Meier
		* @copyright Lukas Meier
	*/
	class coreUser{

		/**
		* The database connection
		* @var mysqli The database connection
		*/
		protected $db;

		/**
		* $_userData All user data saved in a string array
		* @var string[]
		*/
		private $_userData;

		/**
		* Sets the databaseconnection on creation
		*/
		public function __construct(){
			$this->db = $GLOBALS["db"];
		}

		/**
		* Returns the userdata if logged in, or false if no user is logged in
		* @return array[]|boolean
		*/
		public function getUser(){
			if(isset($_SESSION["cms_user"])){
				$this->_userData = unserialize(base64_decode($_SESSION["cms_user"]));
			}

			if(isset($this->_userData)){
				return $this->_userData;
			}else{
				return false;
			}
		}

		/**
		* Returns if the user is logged in
		* @return boolean true if user is logged in, false otherwise.
		*/
		public function isLoggedIn(){
			if($GLOBALS["user"]){
				$user = $this->getUser();
				if($user["state"]["code"] == 1){
					return true;
				}else{
					return false;
				}
			}
		}

		/**
		* Attemts a login with the given username and password
		*
		* @param string $username The username
		* @param string $password The password
		* @return boolean returns true if the login was successful, false otherwise.
		*/
		public function login($username, $password){

			if(trim($username) == "" || trim($password) == ""){
				throw new Exception("Password or username empty");
			}

			$stmt = $this->db->prepare("SELECT user_id, username, email, last_login, timestamp, is_disabled, permission_level, lang_fk, password FROM cms_user WHERE username=? LIMIT 1");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id, $dbUsername, $email, $last_login, $timestamp, $is_disabled, $permission_level, $lang_fk, $dbPassword);
			$stmt->fetch();

			if(password_verify($password, $dbPassword)){
				$tmp["id"] = $id;
				$tmp["username"] = $dbUsername;
				$tmp["email"] = $email;
				$tmp["lastLogin"] = $last_login;
				$tmp["is_disabled"] = $is_disabled;
				$tmp["permissions"] = $permission_level;
				$tmp["settings"]["cms_lang"] = $lang_fk;
				$tmp["state"]["message"] =  "Logged in";
				$tmp["state"]["code"] =  "1";

				$this->_userData = $tmp;
				unset($tmp);

				$_SESSION["cms_user"] = base64_encode(serialize($this->_userData));

				$now = date("Y-m-d H:i:s", strtotime("now"));
				$uid = $this->_userData["id"];

				$stmt2 = $this->db->prepare("UPDATE cms_user SET last_login = ? WHERE user_id = ?");
				$stmt2->bind_param("si", $now, $uid);
				$stmt2->execute();

				if(!$stmt2->execute()){
					throw new Exception("Time the user last logged in could not be updated");	
				}
				return true;
			}else{
				return false;
			}
		}

		/**
		* Logs the user out
		* @return void
		*/
		public function logout(){
			unset($this->_userData, $_SESSION["cms_user"]);
			if(isset($this->_userData) || isset($_SESSION["cms_user"])){
				return false;
			}else{
				return true;
			}
		}

		/**
		* Gets the state of the user
		* @return string State
		*/
		public function getState(){
			return $this->_userData["state"];
		}

		/**
		* Gets the permission level of the user
		* @return int Permissions
		*/
		public function getPermissions(){
			return $this->_userData["permissions"];
		}

		/**
		* Gets the username of the user
		* @return string Username
		*/
		public function getUsername(){
			return $this->_userData["username"];
		}

		/**
		* Gets the id of the user
		* @return int UserID
		*/
		public function getId(){
			return $this->_userData["id"];
		}

		/**
		* Gets the language of the user
		* @return int Language
		*/
		public function getUserLanguage(){
			return $this->_userData["settings"]["cms_lang"];
		}

		/**
		* Returns the date and time the user last logged in
		* @return datetime Time the user last logged in
		*/
		public function getLastLogin(){
			return $this->_userData["lastLogin"];
		}
	}
?>