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

	$("main.tile article").click(function(){
		$(this).toggleClass("open")
	})

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

	$("main article table").each(function () {
		var table = $(this);
		table.find("tr").each(function () {
			var row = $(this);
			if (row.find("td").length == 2) {
				if (row.find("td").eq(0).find("img").length > 0) {
					row.find("td").eq(0).css({ "width": "33%" });
				} else {
					row.find("td").eq(0).css({ "width": "67%" });
				}

				if (row.find("td").eq(1).find("img").length > 0) {
					row.find("td").eq(1).css({ "width": "33%" });
				} else {
					row.find("td").eq(1).css({ "width": "67%" });
				}
			}
		});
	});
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

function initCountdown(selector) {

	var endTime = new Date("11 November 2019 00:00:00");
	endTime = (Date.parse(endTime) / 1000);

	var container = $(selector);
	container.append("<div class='days'></div>")
	container.append("<div class='hours'></div>")
	container.append("<div class='minutes'></div>")
	container.append("<div class='seconds'></div>")
	setInterval(function () {
		var now = new Date();
		now = (Date.parse(now) / 1000);

		var timeLeft = endTime - now;

		var days = Math.floor(timeLeft / 86400);
		var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
		var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
		var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

		if (hours < "10") { hours = "0" + hours; }
		if (minutes < "10") { minutes = "0" + minutes; }
		if (seconds < "10") { seconds = "0" + seconds; }

		container.find(".days").html(days + "<span>Tage</span>");
		container.find(".hours").html(hours + "<span>Stunden</span>");
		container.find(".minutes").html(minutes + "<span>Minuten</span>");
		container.find(".seconds").html(seconds + "<span>Sekunden</span>");
	}, 1000);
}