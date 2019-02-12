<?php
	$usr = $GLOBALS['user']->getUser();
	
	$usr = $GLOBALS['user']->getUser();
	if($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_GET["admin"])){
		if(!$GLOBALS['user']->login($_POST["username"], $_POST["password"])){
			if(!$usr){	
				$_GET["message"] = "login_error";
			}
		}
	}
	
	$GLOBALS['cmh']->loadAllModules();
	$modules = $GLOBALS['cmh']->getModules();
	if($usr){
		$webpageTitle = isset($_GET["module"]) ? $GLOBALS['cmh']->get("admin_".$_GET["module"])->getName() : $GLOBALS['cmh']->getFirstModule()->getName();
	}else{
		$webpageTitle = "Backend";
	}

	if(isset($_GET["async"]) && $usr){
		if(isset($_GET["module"]) && $user !== false){
			$tmp = $GLOBALS['cmh']->get("admin_".$_GET["module"]);
			$tmp->controller();
			$tmp->view();
			echo "<script>init();</script>";
		}else{
			$tmp = $GLOBALS['cmh']->get("plugin_".$_GET["module"]);
			$tmp->async();
		}
	}else{
?>
	<!DOCTYPE HTML>
	<html>
		<head>
			<title>Weble - <?php echo $webpageTitle; ?></title>

			<!--[if lt IE 10]>
				<script>
					window.location.href="/templates/fallback/fallback.html";
				</script>
			<![endif]-->

			<meta name="keywords" content="weble,cms,backend,admin" />
			<meta name="description" content="This is the backend of a page running the Weble-CMS" />
			<meta http-equiv="content-language" content="ch-de" />
			<meta name="robots" content="index,follow">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
			<meta name="author" content="Lukas Meier" />
		
			<link href="https://fonts.googleapis.com/css?family=Raleway:200,400,700" rel="stylesheet"> 
			<link rel="Stylesheet" type="text/css" media="screen" href="/cms/css/styles.css">
			<!--<link rel="Stylesheet" type="text/css" media="screen" href="/cms/css/styles.min.css">-->
	
			<!--FAVICONS-->
			<link rel="apple-touch-icon" sizes="180x180" href="/cms/img/favicon/apple-touch-icon.png">
			<link rel="icon" type="image/png" sizes="32x32" href="/cms/img/favicon/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="/cms/img/favicon/favicon-16x16.png">
			<link rel="manifest" href="/cms/img/favicon/site.webmanifest">
			<link rel="mask-icon" href="/cms/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
			<link rel="shortcut icon" href="/cms/img/favicon/favicon.ico">
			<meta name="msapplication-TileColor" content="#2b5797">
			<meta name="msapplication-config" content="/cms/img/favicon/browserconfig.xml">
			<meta name="theme-color" content="#ffffff">
			<!--END FAVICONS-->

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
			<script src="https://www.gstatic.com/charts/loader.js" type="text/javascript"></script>
			
			<script src="/cms/js/jquery.form.js"></script> 
			<script src="/cms/js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
			<script src="/cms/js/main.js" type="text/javascript" charset="utf-8"></script>

			<?php
				$total = disk_total_space(".");
				$used = $total - disk_free_space("."); 

				$delta = $used/$total;
				$dash = 314*$delta;

				echo "<style>";
					echo "@keyframes fillup {
						to { stroke-dasharray: ".$dash." 416; }
					}";
				echo "</style>";

				echo "<script>";
					echo "$(document).ready(function(){";
						echo "diskUsageForIE(".$dash.");";
					echo "});";
				echo "</script>";
			?>

		</head>
		<body>
			<?php
				if($usr){
					include 'cms.php';
				}else{
					include 'login.php';
				}

			?>
		</body>
	</html>
<?php
	}
?>