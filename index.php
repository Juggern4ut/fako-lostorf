<?php
/**
	* All the important variables are set here and the correct content will be loaded, based on the page the user is currently on
	* @author Lukas Meier
*/
	
	ini_set('display_errors', '1');
	session_start();
	
	require_once 'globalFunctions.php';

	if(file_exists('db.php')){
		include 'db.php';
	}elseif(file_exists("setup/setup.php")){
		header("Location: /setup/setup.php");
	}else{
		die("Weble error: The setup-file <b>'/setup/setup.php'</b> was not found.");
	}

	if(isset($db)){mysqli_close($db);}
	unset($db,$GLOBALS['db']);

	if(!$db = mysqli_connect($server, $username, $password, $database)){
		die("The connection to the database on '".$server."' could not have been established.");
	}

	$GLOBALS['db'] = $db;

	if($_SERVER["REQUEST_METHOD"] === "POST"){
		foreach ($_POST as $key=>$val) {
			$search = array("'");
			$replace = array("\'");
			$_POST[$key] = str_replace($search, $replace, $val);
		}
	}

	//SET LANUGAGE IN SESSION
	$defaultLanguage = array(0=>1,1=>"de");
	if(isset($_GET["lang"]))
		$lang = $_GET["lang"];
	elseif(!isset($_SESSION["lang"][0]))
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	$query = "SELECT lang_id, short FROM cms_lang WHERE short = '".$lang."' LIMIT 1";
	$q = $db->query($query);
	if($q->num_rows > 0){
		$res = $q->fetch_row();
		$_SESSION["lang"] = array(0=>$res[0], 1=>$res[1]);
	}else
		$_SESSION["lang"] = $defaultLanguage;

	//LOAD ALL CORE-FILES
	spl_autoload_register(function ($class_name) {
    	include 'core/'.$class_name.'.php';
	});
	
	//MANUALLY LOAD THE FILES FOR THE PHP-MAILER
	include 'core/PHPMailer/PHPMailer.php';
	include 'core/PHPMailer/class.pop3.php';
	include 'core/PHPMailer/class.smtp.php';
	
	//CREATE MODULE-HANDLER AND LOAD IT WITH FRONTEND-MODULES
	$GLOBALS['coreTranslate'] = new coreTranslate();
	$GLOBALS['coreLogger'] = new coreLogger();
	$GLOBALS['user'] = new coreUser();
	$GLOBALS['cmh'] = new coreModuleHandler();
	$GLOBALS['cmh']->loadAllModules();

	$GLOBALS["coreTranslate"]->init();

	//BUILD PAGE
	if(isset($_GET["admin"])){
		include 'cms/index.php';
	}elseif(isset($_GET["async"])){
		include 'cms/async.php';
	}else{

		//BEFORE INCLUDING THE FRONTEND, ADD THE USER INTO THE VISITOR-LIST, IF NEEDED
		if(!isset($_SESSION["visitor_ip"])){
			$userData = getUserData();
			$stmt = $db->prepare("INSERT INTO cms_visit (remote_ip, is_mobile, useragent) VALUES (?, ?, ?)");
			$stmt->bind_param("sis", $userData["ip"], $userData["isMobile"], $userData["userAgent"]);
			$stmt->execute();
			echo $db->error;
			$_SESSION["visitor_ip"] = $userData["ip"];
		}

		include 'templates/web/index.php';
	}

	mysqli_close($db);
	unset($db,$GLOBALS['db']);
?>