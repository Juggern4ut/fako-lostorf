<div id="login_container">
	<?php
		$cT = $GLOBALS["coreTranslate"];
		if(!isset($_GET["forgot_password"]) && !isset($_GET["reset_password"])){
	?>
		<a class="to_frontend" href="/">Frontend</a>
		<a class="forgot_password" href="/?admin=1&forgot_password=1"><?php echo $cT->get('login_forgot_password'); ?></a>
		<div id="login-form-container" >
			<h1>Weble - Login</h1>
			<form id="login-form" method="POST" action="/?async=1&login=1" autocomplete="off">
				<input placeholder="<?php echo $cT->get('login_username'); ?>" type="text" name="username"/><br/>
				<input placeholder="<?php echo $cT->get('login_password'); ?>" type="password" name="password"/><br/>
				<input type="submit" name="submit" value="Login"/>
			</form>
		</div>
	<?php
		}elseif(isset($_GET["reset_password"]) && isset($_GET["hash"])){
	?>
			<a class="to_frontend" href="/?admin=1">Zum Login</a>
			<div id="login-form-container" >
				<h1>Passwort ändern</h1>
				<form id="reset-password-form" method="POST" action="/?async=1&reset_password=1&hash=<?php echo $_GET["hash"]; ?>" autocomplete="off">
					<input placeholder="<?php echo $cT->get('login_new_password'); ?>" type="password" name="new_password"/><br/>
					<input placeholder="<?php echo $cT->get('login_repeat_new_password'); ?>" type="password" name="repeat_new_password"/><br/>
					<input type="submit" name="submit" value="Login"/>
				</form>
			</div>
	<?php
		}else{
	?>
		<a class="to_frontend" href="/?admin=1">Zum Login</a>
		<div id="login-form-container" >
			<h1>Passwort vergessen</h1>
			<form id="forgot-password-form" method="POST" action="/?async=1&forgot_password=1" autocomplete="off">
				<input placeholder="<?php echo $cT->get('login_username'); ?>" type="text" name="username"/><br/>
				<input type="submit" name="submit" value="<?php echo $cT->get('login_password_reset'); ?>"/>
			</form>
		</div>
	<?php
		}
	?>
	<p id="version">Version: <em><?php echo $GLOBALS['version']; ?></em></p>
</div>