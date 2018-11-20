<?php

echo "<div id=\"loader-container\">";
	echo "<div class=\"loader\">";
		echo "<div></div><div></div><div></div><div></div>";
	echo "</div>";
echo "</div>";

$cT = $GLOBALS["coreTranslate"];
$modules = $GLOBALS['cmh']->getModules();

echo "<aside id=\"cms-lightbox\">";
	echo "<div id=\"cms-lightbox-container\">";
		echo "<img src=\"/cms/img/lightbox_close.png\" />";
		echo "<div id=\"cms-lightbox-content\"></div>";
	echo "</div>";
echo "</aside>";

echo "<nav>";
	echo "<div id=\"menu\">";
		echo "<span></span>";
		echo "<span></span>";
		echo "<span></span>";
		echo "<span></span>";
	echo "</div>";
	echo "<ul>";
		$class = !isset($_GET["module"]) ? " class=\"active\"" : "";
		foreach ($modules as $key=>$module) {
			if(strpos($key, "admin_") !== false){
				$moduleName = $module->getName();
				$permissionLevel = $module->getPermission();
				$moduleName = is_array($moduleName) ? $moduleName[$_SESSION["lang"][0]] : $moduleName; 
				$_GET["module"] = isset($_GET["module"]) ? $_GET["module"] : str_replace("admin_", "", $key);
				$class = $key == "admin_".$_GET["module"] ? " class=\"active\"" : "";
				if($user->getPermissions() >= $permissionLevel){
					if(count($module->getNavigation()) > 0){
						echo "<li class=\"subnav\"><span>".$moduleName."</span>";
							if($_GET["module"] == str_replace("admin_", "", $key)){
								echo "<ul>";
							}else{
								echo "<ul style=\"display: none;\">";
							}
								foreach ($module->getNavigation() as $url=>$value) {
									echo "<li><a href=\"/index.php/?admin=1&module=".str_replace("admin_","",$key)."&part=".$url."\">".$value."</a></li>";
								}
							echo "</ul>";
						echo "</li>";
					}else{
						echo "<li><a".$class." href=\"/index.php/?admin=1&module=".str_replace("admin_","",$key)."\">".$moduleName."</a></li>";
					}	
				}
			}
		}
		echo "<li><a id=\"logout\" href=\"/?async=1\">".$cT->get('global_logout')."</a></li>";
	
	echo "</ul>";
	echo "<p id=\"navigation-version\">Version: ".$GLOBALS['version']."</p>";
echo "</nav>";

echo "<main>";
	//MODULE
	if(isset($_GET["module"])){
		if($tmp = $GLOBALS['cmh']->get("admin_".$_GET["module"])){
			if($tmp->getPermission() <= $user->getPermissions()){
				$tmp->controller();
				$tmp->view();
			}
		}else{
			echo "<h1>Module not found</h1>";
		}
	}
echo "</main>";
?>