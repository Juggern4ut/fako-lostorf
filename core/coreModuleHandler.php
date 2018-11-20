<?php
	class coreModuleHandler{
		private $_modules = array();
		private $_db;
		private $_user;

		public function __construct(){
			$this->_db = $GLOBALS['db'];
			$this->_user = $GLOBALS['user'];
		}

		public function loadAllModules(){
			$this->modules = array();
			$modules = scandir("plugins");
			foreach ($modules as $module){
				if($module != "." && $module != ".."){
					$tmp2 = scandir("plugins/".$module);
					foreach($tmp2 as $doc){
						if($doc != ".." && $doc != "."){
							$mdl = explode("_",$doc);
							$mdl = $mdl[1];
							$mdl = explode(".",$mdl);
							$mdl = $mdl[0];
						}
					}

					require_once 'plugins/'.$module.'/plugin_'.$mdl.'.php';
					$tmpClass = "plugin_".$mdl;
					$tmp = new $tmpClass($this->db);
					$tmp->configure();
					$this->modules["plugin_".$mdl] = $tmp;
					unset($tmp);
					
					if($this->_user->isLoggedIn()){
						require_once 'plugins/'.$module.'/admin_'.$mdl.'.php';
						$tmpClass = "admin_".$mdl;
						$tmp = new $tmpClass($this->db);
						$tmp->configure();
						if($tmp->getPermission() <= $this->_user->getPermissions()){
							$this->modules["admin_".$mdl] = $tmp;
						}
						unset($tmp);
					}
				}
			}
		}

		public function getModules(){
			return $this->modules;
		}

		public function get($module){
			if(isset($this->modules[$module])){
				return $this->modules[$module];
			}else{
				return false;
			}
		}

		public function getFirstModule($frontend=false){
			foreach ($this->modules as $moduleName => $module) {
				if((substr($moduleName, 0, 6) == "admin_" && $frontend == false) || (substr($moduleName, 0, 7) == "plugin_" && $frontend == true)){
					return $module;
				}
			}
			return false;
		}
	}
?>