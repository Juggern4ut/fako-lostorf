<?php
class plugin{
	public $name;
	protected $user;
	protected $logger;
	private $permission;
	private $navigation = [];
	private $ct;

	public function __construct(){
		$this->db = $GLOBALS['db'];
		$this->user = $GLOBALS['user'];
		$this->cT = $GLOBALS['coreTranslate'];
		$this->logger = $GLOBALS['coreLogger'];
	}
	
	public function setPermission($level = 0){
		$this->permission = $level;
	}
	
	public function getPermission(){
		return $this->permission;
	}
	
	public function setName($name = ""){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setNavigation($navigation = []){
		$this->navigation = $navigation;
	}
	
	public function getNavigation(){
		return $this->navigation;
	}
	
	public function configure(){
	}
	
	public function async(){

	}
}
?>