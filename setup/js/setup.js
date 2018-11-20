$(document).ready(function() {
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	$("input[name=no_mailserver]").click(function(){
		if($("input[name=no_mailserver]").is(":checked")){
			$("input[name=mailserver_host]").val("mail.test.com");
			$("input[name=mailserver_port]").val("587");
			$("input[name=mailserver_username]").val("sender@test.com");
			$("input[name=mailserver_password]").val("password");
		}else{
			$("input[name=mailserver_host]").val("");
			$("input[name=mailserver_port]").val("");
			$("input[name=mailserver_username]").val("");
			$("input[name=mailserver_password]").val("");
		}
	});

});

function page2(val){
	if(val){
		var server = $("input[name=server]").val();
		var username = $("input[name=username]").val();
		var password = $("input[name=password]").val();

		if(server != "" && username != ""){
			$("input[name=server]").css({"border-color":"rgba(255,255,255,0.6)"});
			$("input[name=username]").css({"border-color":"rgba(255,255,255,0.6)"});

			$.post("/setup/setup.php?setupAsync=1&checkDB=1", {"server":server, "username":username, "password":password}, function(data){
				console.log(data);
				if(data.status_code == "1"){
					$("#step1").css({"right":"200px", "opacity":"0", "pointer-events":"none"});
					setTimeout(function(){
						$("#step2").css({"right":"0px", "opacity":"1", "pointer-events":"auto"});
					}, 200);
				}else{
					$("input[name=server]").before("<p class='error'>"+data.status_message+"</p>")
					$(".error").slideDown(function(){
						setTimeout(function(){
							$(".error").slideUp(function(){
								$(this).remove();
							});
						}, 2000);
					});
				}
			});
		}else{
			server == "" ? $("input[name=server]").css({"border-color":"#C00"}) : $("input[name=server]").css({"border-color":"rgba(255,255,255,0.6)"});
			username == "" ? $("input[name=username]").css({"border-color":"#C00"}) : $("input[name=username]").css({"border-color":"rgba(255,255,255,0.6)"});
		}
	}else{
		$("#step3").css({"right":"-200px", "opacity":"0", "pointer-events":"none"});
		setTimeout(function(){
			$("#step2").css({"right":"0px", "opacity":"1", "pointer-events":"auto"});
		}, 200);
	}
}

function page3(){
	mailserver_host = $("input[name=mailserver_host]").val();
	mailserver_port = $("input[name=mailserver_port]").val();
	mailserver_username = $("input[name=mailserver_username]").val();
	mailserver_password = $("input[name=mailserver_password]").val();

	if(mailserver_host != "" && mailserver_port != "" && mailserver_username != "" && mailserver_password != ""){
		$.post("/setup/setup.php?setupAsync=1&setMailserver=1", {"mailserver_host":mailserver_host, "mailserver_port":mailserver_port, "mailserver_username":mailserver_username, "mailserver_password":mailserver_password}, function(data){
			$("#step2").css({"right":"200px", "opacity":"0", "pointer-events":"none"});
			setTimeout(function(){
				$("#step3").css({"right":"0px", "opacity":"1", "pointer-events":"auto"});
			}, 200);
		});
	}else{
		mailserver_host == "" ? $("input[name=mailserver_host]").css({"border-color":"#C00"}) : $("input[name=mailserver_host]").css({"border-color":"rgba(255,255,255,0.6)"});
		mailserver_port == "" ? $("input[name=mailserver_port]").css({"border-color":"#C00"}) : $("input[name=mailserver_port]").css({"border-color":"rgba(255,255,255,0.6)"});
		mailserver_username == "" ? $("input[name=mailserver_username]").css({"border-color":"#C00"}) : $("input[name=mailserver_username]").css({"border-color":"rgba(255,255,255,0.6)"});
		mailserver_password == "" ? $("input[name=mailserver_password]").css({"border-color":"#C00"}) : $("input[name=mailserver_password]").css({"border-color":"rgba(255,255,255,0.6)"});
	}
}

function submitSetup(){
	var admin_password = $("input[name=admin_password]").val();
	var admin_email = $("input[name=admin_email]").val();
	var admin_username = $("input[name=admin_username]").val();
	var admin_language = $("select[name=admin_language]").val();

	if(admin_password != "" && admin_email != "" && admin_username != ""){

		$("input[name=admin_password]").css({"border-color":"rgba(255,255,255,0.6)"});
		$("input[name=admin_email]").css({"border-color":"rgba(255,255,255,0.6)"});
		
		$("#submit").html("Loading...");
		$("#submit").addClass("loading");
		$("#submit").removeAttr("onclick");
		
		$.post("/setup/setup.php?setupAsync=1&submit=1", {"admin_password":admin_password, "admin_email":admin_email, "admin_username":admin_username, "admin_language":admin_language}, function(data){
			if(data.status_code < "0"){
				if(data.status_code == "-1"){
					$("input[name=admin_email]").css({"border-color":"#C00"});
				}

				$("input[name=admin_username]").before("<p class='error'>"+data.status_message+"</p>")
				$(".error").slideDown(function(){
					setTimeout(function(){
						$(".error").slideUp(function(){
							$(this).remove();
						});
					}, 2000);
				});
				
				$("#submit").html("Setup");
				$("#submit").removeClass("loading");
				$("#submit").attr("onclick", "submitSetup();");
				
			}else{
				$("input[name=admin_email]").css({"border-color":"rgba(255,255,255,0.6)"});
				window.location.href = "/admin";
			}

		});

	}else{
		admin_password == "" ? $("input[name=admin_password]").css({"border-color":"#C00"}) : $("input[name=admin_password]").css({"border-color":"rgba(255,255,255,0.6)"});
		admin_email == "" ? $("input[name=admin_email]").css({"border-color":"#C00"}) : $("input[name=admin_email]").css({"border-color":"rgba(255,255,255,0.6)"});
		admin_username == "" ? $("input[name=admin_username]").css({"border-color":"#C00"}) : $("input[name=admin_username]").css({"border-color":"rgba(255,255,255,0.6)"});
	}
}

function page1(){
	$("#step2").css({"right":"-200px", "opacity":"0", "pointer-events":"none"});
	setTimeout(function(){
		$("#step1").css({"right":"0px", "opacity":"1", "pointer-events":"auto"});
	}, 200);
}