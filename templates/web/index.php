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
		$primaryId = 8;
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
		
		<link rel="Stylesheet" type="text/css" media="screen" href="/templates/web/css/styles.css">
		<link rel="Stylesheet" type="text/css" media="screen" href="/templates/web/css/slick.css">

		<link rel="icon" href="/favicon.png" type="image/png">
		<link rel="shortcut icon" href="/favicon.png" type="image/png">
		<link rel="shortcut icon" href="/favicon.png" type="image/png">
		<link rel="apple-touch-icon" href="/favicon.png"/>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/templates/web/js/main.js" type="text/javascript" charset="utf-8"></script>
		<script src="/templates/web/js/slick.min.js" type="text/javascript" charset="utf-8"></script>

	</head>
	<body>
		<?php
			if($primaryId == 30){
				$news = $navigation->getContent($primaryId);
				setcookie("news_read", count($news), time() + (86400 * 30), "/");
			}
		?>
		<header>
			<div id="mobile-nav-burger">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<a id="mobile-logo" href="/"><img src="/templates/web/img/logo.png" /></a>
			<nav>
				<a class="nav-title" href="/">Fasnachtsverein Lostorf</a>
				<ul>
					<?php
						foreach ($navigationPoints as $nav) {
							if($nav["is_invisible"] != 1){
								$class = "";
								if($nav["id"] == $primaryId){
									$class = " class=\"active\"";
									$_GET["n0"] = $nav["link"];
								}

								if($nav["link"] == "news"){
									$liId = " id='news'";
								}
								echo "<li".$class.$liId.">";
									$subnavPoints = $navigation->getNavigation($nav["id"]);
									if(count($subnavPoints) > 0){
										echo "<a class=\"hasSubnav\">".$nav["title"]."</a>";
										echo "<ul>";
											foreach ($subnavPoints as $snav) {
												$class = "";
												if($snav["id"] == $secondaryId){
													$class = " class=\"active\"";
												}
												echo "<li".$class.">";
													$subSubnavPoints = $navigation->getNavigation($snav["id"]);
													if(count($subnavPoints) > 0){
														echo "<a class=\"hasSubnav\">".$snav["title"]."</a>";
														echo "<ul>";
															foreach ($subSubnavPoints as $ssnav) {
																echo "<li><a href=\"/".$_SESSION["lang"][1]."/".$nav["link"]."/".$snav["link"]."/".$ssnav["link"]."\">".$ssnav["title"]."</a></li>";
															}
														echo "</ul>";
													}else{
														echo "<a href=\"/".$_SESSION["lang"][1]."/".$nav["link"]."/".$snav["link"]."\">".$snav["title"]."</a>";
													}
												echo "</li>";
											}
										echo "</ul>";
									}else{
										if($nav["id"] == 30){

											$np = count($navigation->getContent(30));
											if($np > $_COOKIE["news_read"]){
												$diff = $np - $_COOKIE["news_read"];
												echo "<span id='unread_news'>".$diff."</span>";
											}
										}
										echo "<a href=\"/".$_SESSION["lang"][1]."/".$nav["link"]."\">".$nav["title"]."</a>";
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
					foreach ($contents[0]["images"] as $image) {
						echo "<article style=\"background-image: url('/".$image."');\">&nbsp;</article>";
					}
				?>
			</section>
		</header>
		<main>
			<?php
				//DEFAULT CONTENT
				if($primaryId != 30 && $primaryId != 24 && $primaryId != 29){
					echo "<section>";
						foreach ($contents as $content) {
							echo "<article>";
									$form = $navigation->getContactForm();
									echo str_replace("<p>{kontakt_formular}</p>", $form, $content["content"]);
							echo "</article>";
						}
					echo "</section>";
				//NEWS
				}elseif($primaryId == 30){
					echo "<div id='news'>";
						foreach ($contents as $content) {
							echo "<article class='news'>";
								echo "<h3><span>".date("d.m.Y", strtotime($content["timestamp"]))."</span><br />".$content["title"]."<span class='moreLess'>» mehr</h3>";
								echo "<section>";
									echo $content["content"];
								echo "</section>";
							echo "</article>";
							$count++;
						}
					echo "</div>";
				//GALLERY
				}elseif($primaryId == 24 && isset($secondaryId)){
					foreach ($contents as $content) {
						echo "<br />";
						echo "<h1>".$content["title"]."</h1>";
						echo "<br />";
						echo "<section class=\"gallery\">";
							foreach ($content["images"] as $image) {
								echo "<article style=\"background-image: url('/".$image."')\"></article>";
							}
						echo "</section>";
					}
				//PROGRAMM
				}elseif($primaryId == 29){
					echo "<div id='program'>";
						echo "<h1>Fasnachts Programm - 2019</h1>";
						echo "<p>Das genaue Programm befindet sich derzeit noch in der Planung. Das finale Programm wird gewöhnlich kurz vor Ende Jahr veröffentlicht, bitte besuchen Sie uns wieder.</p>";
						foreach ($contents as $content) {
							echo "<section class='program'>";
								echo "<h2>".$content["title"]."</h2>";
								echo $content["content"];
							echo "</section>";
						}
					echo "</div>";
				}

			?>
		</main>
		<footer>
			<span>Copyright - FaKo Lostorf 2018 &copy;</span>
			<span><a href="/de/impressum">Impressum</a></span>
		</footer>
	</body>
</html>
