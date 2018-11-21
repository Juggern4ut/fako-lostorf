$(document).ready(function(){
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
			$("main > div#news article section").slideUp();
			$("main > div#news article h3 span.moreLess").html("» mehr");
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

		$.post("/?async=1", {"contact-form":"sent", "message":message, "name":name, "mail":mail, "subject":subject}, function(data){
			$("#contact-form").slideUp();
			$("#contact-form").after("<h3 style=\"display: none;\" class='form-status'>Ihre Kontaktanfrage wurde erfolgreich versandt.</h3>");
			$(".form-status").slideDown();
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
	if(window.innerWidth < 1024){
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