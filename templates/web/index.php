<?php
	$navigation = $GLOBALS['cmh']->get("plugin_navigation");
	$team = $GLOBALS['cmh']->get("plugin_team");
	$navigationPoints = $navigation->getNavigation();

	$primaryId = $navigationPoints[0]["id"];
	$error = false;

	//ID-Naming order:
	//primaryId, secondaryId, tertiaryId, quaternaryId, quinaryId...

	if(isset($_GET["n0"])){
		$setId = false;
		foreach ($navigationPoints as $nav) {
			if($nav["link"] === strtolower(urlencode($_GET["n0"]))){
				$primaryId = $nav["id"];
				$setId = true;
			}
		}

		if(!$setId){
			$error = true;
		}
	}

	if(isset($_GET["n1"])){
		$setId = false;
		foreach ($navigation->getNavigation($primaryId) as $nav) {
			if($nav["link"] === strtolower(urlencode($_GET["n1"]))){
				$secondaryId = $nav["id"];
				$setId = true;
			}
		}

		if(!$setId){
			$error = true;
		}
	}

	if(isset($_GET["n2"])){
		$setId = false;
		foreach ($navigation->getNavigation($secondaryId) as $nav) {
			if($nav["link"] === $_GET["n2"]){
				$tertiaryId = $nav["id"];
				$setId = true;
			}
		}

		if(!$setId){
			$error = true;
		}
	}

	if($error){
		header("HTTP/1.0 404 Not Found");
		$query = "SELECT navigation_id FROM cms_navigation WHERE is_errorpage = 1 LIMIT 1";
		$q = $db->query($query);
		$res = $q->fetch_row()[0];
		$primaryId = $res !== "" ? $res : 0;
	}

	//print_r($_GET);
	
	if(isset($tertiaryId)){
		$activeId = $tertiaryId;
	}elseif(isset($secondaryId)){
		$activeId = $secondaryId;
	}else{
		$activeId = $primaryId;
	}

	//$activeId = isset($secondaryId) ? $secondaryId : $primaryId;
	$pageTitle = $navigation->getMeta($activeId, "title");
	$metaDescription = $navigation->getMeta($activeId, "description");
	$metaKeywords = str_replace(" ", "", $navigation->getMeta($activeId, "keywords"));
	$metaImage = $navigation->getMeta($activeId, "image");
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if(!isset($_COOKIE["news_read"])){
		$news = $navigation->getContent(30);
		setcookie("news_read", 0, time() + (86400 * 30), "/");
	}

	$contents = $navigation->getContent($activeId);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $pageTitle; ?> - Fasnachtsverein Lostorf</title>

		<!-- GENERAL META -->
		<meta http-equiv="content-language" content="ch-de" />
		<meta name="robots" content="index,follow">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Lukas Meier" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="keywords" content="<?php echo $metaKeywords; ?>" />
		<meta name="description" content="<?php echo $metaDescription; ?>" />

		<!-- FACEBOOK META -->
		<meta property="og:url" content="<?php echo $actual_link; ?>">
		<meta property="og:image" content="<?php echo $metaImage; ?>">
		<meta property="og:description" content="<?php echo $metaDescription; ?>">
		<meta property="og:title" content="<?php echo $pageTitle; ?>">
		<meta property="og:site_name" content="<?php echo $pageTitle; ?>">

		<!-- GOOGLE+ META -->
		<meta itemprop="name" content="<?php echo $pageTitle; ?>">
		<meta itemprop="description" content="<?php echo $metaDescription; ?>">
		<meta itemprop="image" content="<?php echo $metaImage; ?>">

		<!-- TWITTER META -->
		<meta name="twitter:card" content="summary">
		<meta name="twitter:url" content="<?php echo $actual_link; ?>">
		<meta name="twitter:title" content="<?php echo $pageTitle; ?>">
		<meta name="twitter:description" content="<?php echo $metaDescription; ?>">
		<meta name="twitter:image" content="<?php echo $metaImage; ?>">
		
		<link rel="Stylesheet" type="text/css" media="screen" href="/templates/web/dist/main.css?v=3">

		<link rel="icon" href="/favicon.png" type="image/png">
		<link rel="shortcut icon" href="/favicon.png" type="image/png">
		<link rel="shortcut icon" href="/favicon.png" type="image/png">
		<link rel="apple-touch-icon" href="/favicon.png"/>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/templates/web/dist/main.js" type="text/javascript" charset="utf-8"></script>
		<script src="/templates/web/js/slick.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/templates/web/js/jquery.swipebox.min.js" type="text/javascript" charset="utf-8"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body>
		<?php
			if($primaryId == 30){
				$news = $navigation->getContent($primaryId);
				setcookie("news_read", count($news), time() + (86400 * 30), "/");
			}
		?>
		<header>
			<div class="navigation__mobile-burger" id="mobile-nav-burger">
				<span class="navigation__mobile-burger-span"></span>
				<span class="navigation__mobile-burger-span"></span>
				<span class="navigation__mobile-burger-span"></span>
			</div>
			<a class="navigation__mobile-logo" href="/">
				<img class="navigation__mobile-logo-image" src="/templates/web/img/logo.png" />
			</a>
			<nav class="navigation">
				<a class="navigation__title" href="/">Fasnachtsverein Lostorf</a>
				<ul class="navigation__list">
					<?php
						foreach ($navigationPoints as $nav) {
							if($nav["is_invisible"] != 1 && $nav["is_active"]){
								$class = "";
								if($nav["id"] == $primaryId){
									$class = " navigation__list-item--active";
									$_GET["n0"] = $nav["link"];
									$headerImage = $nav["header_image"];
									$layout = $nav["is_tiledesign"] ? " main--tile" : "";
								}

								$liId = $nav["link"] == "news" ? " id='news'" : "";

								echo "<li class='navigation__list-item".$class."'".$liId.">";
									$subnavPoints = $navigation->getNavigation($nav["id"]);
									if(count($subnavPoints) > 0){
										echo "<a class=\"navigation__list-link navigation__list-link--subnav\">".$nav["title"]."</a>";
										echo "<ul class='navigation__sub-list'>";
											foreach ($subnavPoints as $snav) {
												$class = "";
												if($snav["id"] == $secondaryId){
													$class = " active";
												}
												echo "<li class='navigation__list-item".$class."'>";
													$subSubnavPoints = $navigation->getNavigation($snav["id"]);
													if(count($subnavPoints) > 0){
														echo "<a class=\"navigation__list-link navigation__list-link--subnav\">".$snav["title"]."</a>";
														echo "<ul class='navigation__sub-list'>";
															foreach ($subSubnavPoints as $ssnav) {
																echo "<li class='navigation__list-item'><a class=\"navigation__list-link\" href=\"/".$_SESSION["lang"][1]."/".$nav["link"]."/".$snav["link"]."/".$ssnav["link"]."\">".$ssnav["title"]."</a></li>";
															}
														echo "</ul>";
													}else{
														echo "<a class=\"navigation__list-link\" href=\"/".$_SESSION["lang"][1]."/".$nav["link"]."/".$snav["link"]."\">".$snav["title"]."</a>";
													}
												echo "</li>";
											}
										echo "</ul>";
									}else{
										if($nav["id"] == 30){

											$np = count($navigation->getContent(30));
											if($np > $_COOKIE["news_read"]){
												$diff = $np - $_COOKIE["news_read"];
												echo "<span class='navigation__unread_news' id='unread_news'>".$diff."</span>";
											}
										}
										echo "<a class=\"navigation__list-link\" href=\"/".$_SESSION["lang"][1]."/".$nav["link"]."\">".$nav["title"]."</a>";
									}
								echo "</li>";
							}
						}
					?>
				</ul>
			</nav>
			<?php $image = $contents[0]["images"][0]; ?>
			<section>
				<?php
					echo "<article style=\"background-image: url('/".$headerImage."');\">&nbsp;</article>";
				?>
			</section>
		</header>
		<main class="main<?php echo $layout; ?>">
			<?php
				//DEFAULT CONTENT
				if($primaryId != 24){
					echo "<section>";
						foreach ($contents as $content) {

							if(!$content["is_active"]){
								continue;
							}

							echo "<article class='article'>";
								if(file_exists($content["images"][0]["image"])){
									echo "<div class='article_head' style='background-image: url(\"/".$content["images"][0]["image"]."\");'></div>";
								}
								$form = $navigation->getContactForm();
								echo str_replace("<p>{kontakt_formular}</p>", $form, $content["content"]);
							echo "</article>";
						}
					echo "</section>";

					if($primaryId === 1){
						echo "<div class='countdown'>";
							echo "<h1>Fasnachtsauftakt</h1>";
						echo "</div>";
						echo "<script>initCountdown('.countdown')</script>";
					}
				//GALLERY
				}elseif($primaryId == 24 && isset($secondaryId)){
					foreach ($contents as $content) {
						echo "<br />";
						echo "<h1>".$content["title"]."</h1>";
						echo "<br />";
						echo "<section class=\"gallery\">";
							foreach ($content["images"] as $image) {
								echo "<a href='/".$image["image"]."' class='swipebox'>";
									if(file_exists(str_replace("navigation", "navigation_thumbs", $image["thumbnail"]))){
										echo "<article class='article' style=\"background-image: url('/".str_replace("navigation", "navigation_thumbs", $image["thumbnail"])."')\"></article>";
									}else{
										echo "<article class='article' style=\"background-image: url('/".$image["image"]."')\"></article>";
									}
								echo "</a>";
							}
						echo "</section>";
					}
				}
			?>
		</main>
		<footer class="footer">
			<span>Copyright - FaKo Lostorf 2018 &copy;</span>
			<span><a class="footer__link" href="/de/impressum">Impressum</a></span>
		</footer>
	</body>
</html>