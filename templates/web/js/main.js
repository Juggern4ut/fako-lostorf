$(document).ready(function(){

	setCountdown();

	$('.slickSlider').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autplayspeed: 5000,
		draggable: false,
		speed: 1000,
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
});

function setCountdown(){
	var end = new Date('11/11/2018 10:11 AM');
	var _second = 1000;
	var _minute = _second * 60;
	var _hour = _minute * 60;
	var _day = _hour * 24;
	var timer;

	var a = setInterval(function(){
		var now = new Date();
		var distance = end - now;
		if (distance < 0) {
			clearInterval(timer);
			document.getElementById('countdown').innerHTML = 'EXPIRED!';
			return;
		}
		var days = Math.floor(distance / _day);
		var hours = ("0" + Math.floor((distance % _day) / _hour)).slice(-2);
		var minutes = ("0" + Math.floor((distance % _hour) / _minute)).slice(-2);
		var seconds = ("0" + Math.floor((distance % _minute) / _second)).slice(-2);;

		//var formattedNumber = ("0" + myNumber).slice(-2);

		//$("#countdown").html("<div>" + weeks + "<span>" + 'Wochen</span></div>');
		$("#countdown").html("<div>" + days + "<span>" + ':</span></div>');
		$("#countdown").html($("#countdown").html() + "<div>" + hours + "<span>" + ':</span></div>');
		$("#countdown").html($("#countdown").html() + "<div>" + minutes + "<span>" + ':</span></div>');
		$("#countdown").html($("#countdown").html() + "<div>" + seconds + "<span>" + '</span></div>');
	}, 1000);
}