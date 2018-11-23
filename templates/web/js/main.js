$(document).ready(function(){
	mobileNavLinks();

	$("body").swipebox({selector:'.swipebox'});

	$("header > section").slick({
		dots: false,
		arrows: false,
		speed: 2000,
		fade: true,
		cssEase: 'linear',
		autoplay: true,
		autplayspeed: 6000,
		pauseOnFocus: false,
		pauseOnHover: false
	});

	$(".hasSubnav").click(function(){
		if($(this).parent().hasClass("open")){
			$(this).parent().parent().find("> li").removeClass("open");
		}else{
			$(this).parent().parent().find("> li").removeClass("open");
			$(this).parent().addClass("open");
		}
	});

	$("main > div#news article h3").click(function(){
		if($(this).parent().find("section").is(":hidden")){
			$(this).parent().find("section").slideDown(200);
			$(this).find("span.moreLess").html("« weniger");
		}else{
			$(this).parent().find("section").slideUp(200);
			$(this).find("span.moreLess").html("» mehr");
		}
	});

	$("#mobile-nav-burger").click(function(){
		$(this).parent().toggleClass("open");
	});

	$("#contact-form").submit(function(e){
		e.preventDefault();

		$(this).find("input[type=submit]").hide();
		$(this).append("<label>L&auml;dt...</label>");
		
		var message = $("#message").val();
		var name = $("#name").val();
		var mail = $("#mail").val();
		var subject = $("#subject").val();
		var message = $("#message").val();
		var captchaResponse = grecaptcha.getResponse();

		$.post("/?async=1", {"contact-form":"sent", "message":message, "name":name, "mail":mail, "subject":subject, "grecaptcha":captchaResponse}, function(data){
			console.log(data);
			if(data == 1){
				$("#contact-form").slideUp();
				$("#contact-form").after("<h3 style=\"display: none;\" class='form-status'>Ihre Kontaktanfrage wurde erfolgreich versandt.</h3>");
				$(".form-status").slideDown();
			}else{
				$(".g-recaptcha").after("<h3 style=\"display: none;\" class='form-error'>Bitte aktivieren sie das ReCaptcha.</h3>");
				$(".form-error").slideDown();
				
				setTimeout(function(){
					$(".form-error").slideUp(function(){
						$(".form-error").remove();
					});
				}, 2500);

				$("#contact-form > label").remove();
				$("#contact-form").append('<input type="submit" value="Abschicken">');
			}
		});
	});

	setMainMinHeight();
});

$(window).resize(function(){
	setMainMinHeight();
	if(window.innerWidth < 1024){
		$("header nav").css({"height":$("html").height()-73+"px"});
	}else{
		$("header nav").css({"height":"auto"});
	}
});

$(window).scroll(function(){
	setMobileNavTop();
});

function setMobileNavTop(){
	if(window.innerWidth <= 1024){
		var scrollTop = $(window).scrollTop();
		var navTop = 73;
		$("header nav").css({"top":navTop-scrollTop+"px"});
	}
}

function setMainMinHeight(){
	var windowHeight = window.innerHeight;
	var headerHeight = $("header").innerHeight();
	var footerHeight = $("footer").innerHeight();
	var mainPadding = parseInt($("main").css("padding-top"))*2;
	$("main").css({"min-height":windowHeight-(headerHeight+footerHeight+mainPadding)+"px"});
}

function mobileNavLinks(){
	$("nav a").click(function(e){
		if(window.innerWidth <= 1024){
			if($(this).hasClass("hasSubnav")){
				return true;
			}
			e.preventDefault();
			var link = $(this).attr("href");
			$("header").removeClass("open");
			setTimeout(function(){
				window.location.href = link;
			}, 400);
		}
	});
}