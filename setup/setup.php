<?php
	session_start();
	ini_set('display_errors', '0');
	
	if(file_exists('../db.php')){
		header("Location: /admin");
	}
	
	if(isset($_GET["setupAsync"])){

		if(isset($_GET["checkDB"])){
			header('Content-Type: application/json');
			if ($db = mysqli_connect($_POST["server"], $_POST["username"], $_POST["password"])) {
				$dbName = "sample_database_".date("Y_m_d");
				$query = "CREATE DATABASE ".$dbName;
				if($db->query($query) === TRUE){
					$db->query("DROP DATABASE ".$dbName);
					$returnArray = array("status_code"=>1, "status_message"=>"Connection and Priviliges checked successfully.");
					$_SESSION["dbServer"] = $_POST["server"];
					$_SESSION["dbUsername"] = $_POST["username"];
					$_SESSION["dbPassword"] = $_POST["password"];
				}else{
					$returnArray = array("status_code"=>-1, "status_message"=>"The user '".$_POST["username"]."' has no priviliges to create new databases.");
				}
			}else{
				$returnArray = array("status_code"=>-2, "status_message"=>"The connection to the database could not have been established, please check the address and user credentials.");
			}
			echo json_encode($returnArray);
		}

		if(isset($_GET["setMailserver"])){
			$_SESSION["mailserver_host"] = $_POST["mailserver_host"];
			$_SESSION["mailserver_port"] = $_POST["mailserver_port"];
			$_SESSION["mailserver_username"] = $_POST["mailserver_username"];
			$_SESSION["mailserver_password"] = $_POST["mailserver_password"];
		}

		if(isset($_GET["submit"])){
			header('Content-Type: application/json');
			if(filter_var($_POST["admin_email"], FILTER_VALIDATE_EMAIL)){

				$databaseName = "weble_cms";
				$db = mysqli_connect($_SESSION["dbServer"], $_SESSION["dbUsername"], $_SESSION["dbPassword"]);

				if(!$db){
					$returnArray = array("status_code"=>-3, "status_message"=>"Could not connect");
				}

				if ($db->query("CREATE DATABASE ".$databaseName) === TRUE) {
					mysqli_select_db($db,$databaseName);
					
					include 'dbQueries.php';
					
					$password = password_hash($_POST["admin_password"], PASSWORD_DEFAULT);
					$admin_email = $_POST["admin_email"];
					$admin_username = $_POST["admin_username"];
					$language = $_POST["admin_language"];

					$db->query("INSERT INTO `cms_user` (`user_id`, `lang_fk`, `username`, `password`, `email`, `permission_level`, `last_login`, `is_active`, `is_disabled`, `timestamp`) VALUES (1, '".$language."', '".$admin_username."', '".$password."', '".$admin_email."', 2, '".date("Y-m-d H:i:s")."', 1, 0, '".date("Y-m-d H:i:s")."')");

					$data = '<?php
								$username = "'.$_SESSION["dbUsername"].'";
								$password = "'.$_SESSION["dbPassword"].'";
								$server = "'.$_SESSION["dbServer"].'";
								$database = "'.$databaseName.'";
							?>';

					file_put_contents("../db.php", $data);

					$msData = '<?php
									$MailServerData = array(
										"host"=>"'.$_SESSION["mailserver_host"].'", 
										"port"=>"'.$_SESSION["mailserver_port"].'", 
										"username"=>"'.$_SESSION["mailserver_username"].'", 
										"password"=>"'.$_SESSION["mailserver_password"].'", 
										"sender"=>"'.$_SESSION["mailserver_username"].'", 
										"smtpsecure"=>"tls", 
										"charset"=>"UTF-8"
									);
								?>';

					file_put_contents("../core/PHPMailer/mailserver.connection.php", $msData);

					$returnArray = array("status_code"=>1, "status_message"=>"Setup completed");
				}else{
					$returnArray = array("status_code"=>-2, "status_message"=>$db->error);
				}
			}else{
				$returnArray = array("status_code"=>-1, "status_message"=>"This is not a valid E-Mail");
			}
			echo json_encode($returnArray);
		}
	}else{
?>

	<!DOCTYPE html>
	<html>
		<head>
			<title>Weble CMS - Setup</title>

			<link href="https://fonts.googleapis.com/css?family=Raleway:200,400,700" rel="stylesheet">
			<link rel="stylesheet" type="text/css" href="/setup/css/setup.css">

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
			<script type="text/javascript" src="/setup/js/setup.js">

			</script>
		</head>
		<body>
			<form action="/setup/setup.php" method="POST">
				<h1>First time setup</h1>
				<div id="step1">
					<h2>Database</h2>
					<p>Enter the data, needed to connect to your database</p>
					<input type="text" name="server" placeholder="Database Address/IP">
					<input type="text" name="username" placeholder="Database Username">
					<input type="password" name="password" placeholder="Database Password">
					<button type="button" onclick="page2(true);" id="next1">Next</button>
				</div>
				<div id="step2">
					<h2>Mailserver</h2>
					<p>The Mailserver that is used to send mails (for example the 'forgot password' email)</p>
					<input type="text" name="mailserver_host" placeholder="Host">
					<input type="text" name="mailserver_port" placeholder="Port">
					<input type="text" name="mailserver_username" placeholder="Username">
					<input type="password" name="mailserver_password" placeholder="Password">
					<input id="no_mailserver" type="checkbox" name="no_mailserver"><label for="no_mailserver" title="This will cause an error-message if a user tries to reset their password, since the link will be sent via email">Don't set up a mailserver for now</label>
					<button type="button" onclick="page1();" id="back1">Back</button>
					<button type="button" onclick="page3();" id="next2">Next</button>
				</div>
				<div id="step3">
					<h2>Admin Account</h2>
					<p>Enter the data for the administrator account</p>
					<input type="text" name="admin_username" placeholder="Admin Username">
					<input type="text" name="admin_email" placeholder="Admin Mail">
					<input type="password" name="admin_password" placeholder="Admin Password">
					<select name="admin_language">
						<option value="2">English</option>
						<option value="1">Deutsch</option>
					</select>

					<button type="button" onclick="page2(false);" id="back2">Back</button>
					<button type="button" onclick="submitSetup();" id="submit">Setup</button>
				</div>
			</form>
		</body>
	</html>

<?php
	}
?>