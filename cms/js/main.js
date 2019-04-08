$(document).ready(function(){
	navLogic();
	initLoginForm();
	initPasswordResetForm();
	initPasswordForgottenForm();
	init();

	google.charts.load('current', {packages: ['corechart', 'line']});
	google.charts.setOnLoadCallback(drawVisitors);
	google.charts.setOnLoadCallback(drawPlatforms);
});

function init(){
	styleFileUpload();
	optionsLogic();
	asyncLinks();
	richtexteditor();
	lightbox();
	initCmsForm();
	addCalendarNavigationControls();
	makeTableRowClickable();
	confirmationDialog();
}

function drawVisitors() {
	if($("#visitor_chart").length > 0){
		var data = new google.visualization.DataTable();
		data.addColumn('date', 'X');
		data.addColumn('number', 'Desktop Views');
		data.addColumn('number', 'Mobile views');

		$.get("/?async=1&getVisitorData=1", function(get_data){
			console.log(get_data);

			for (var i = 0; i < get_data.length; i++) {
				var tmp = get_data[i][0].split("-");
				get_data[i][0] = new Date(tmp[0], (tmp[1]-1), tmp[2]);
			}

			data.addRows(get_data);

			var options = {
				hAxis: {
					title: 'Date'
				},
				vAxis: {
					title: 'Amount'
				}
			};

			var chart = new google.visualization.LineChart(document.getElementById('visitor_chart'));

			chart.draw(data, options);
		});
	}
}

function drawPlatforms(){
	if($("#platforms_chart").length > 0){
		$.get("/?async=1&getPlatformData=1", function(get_data){

		var data = google.visualization.arrayToDataTable(get_data);

		var options = {
			title: 'Platforms',
			pieHole: 0.4,
		};

		var chart = new google.visualization.PieChart(document.getElementById('platforms_chart'));
		chart.draw(data, options);
		
		});
	}
}

/* FORM INITIALIZATION */
function initLoginForm(){
	$("#login-form").ajaxForm(function(data) {
		data = JSON.parse(data);
		$("#login-form-container h1").after("<p class=\"message\" style=\"display: none;\">"+data["status_message"]+"</p>");
		var timeout = data["status_code"] == 1 ? 1000 : 3000;
		$("p.message").slideDown();
		setTimeout(function(){
			$("p.message").slideUp(function(){
				$(this).remove();
				if(data["status_code"] == 1){
					window.location.reload();
				}
			});
		}, timeout);
	});
}

function initPasswordForgottenForm(){
	$("#forgot-password-form").ajaxForm(function(data) {
		console.log(data);
		$("#login-form-container h1").after("<p class=\"message\" style=\"display: none;\">"+data["status_message"]+"</p>");
		$("p.message").slideDown();
		
		if(data["status_code"] > 0){
			$("#forgot-password-form").slideUp();
		}else{
			setTimeout(function(){
				$("p.message").slideUp(function(){
					$(this).remove();
				});
			}, 3000);
		}
		
	});
}

function initPasswordResetForm(){
	$("#reset-password-form").ajaxForm(function(data) {
		
		$("#login-form-container h1").after("<p class=\"message\" style=\"display: none;\">"+data["status_message"]+"</p>");
		$("p.message").slideDown();

		var timeout = data["status_code"] == 1 ? 1000 : 3000;
		$("p.message").slideDown();
		setTimeout(function(){
			$("p.message").slideUp(function(){
				$(this).remove();
				if(data["status_code"] == 1){
					window.location.href = "/?admin=1";
				}
			});
		}, timeout);

		if(data["status_code"] > 0){
			$("#reset-password-form").slideUp();
		}
	});
}

function initCmsForm(){
	$(".cms-form").ajaxForm({
		beforeSubmit: function(arr, form){
			//VALIDATE FORM
			var formValid = validateCmsForm(form[0]);
			return formValid;
		},
		beforeSend: function(){
			for(var i = 0; i<=tinymce.editors.length-1; i++){
				tinymce.editors[i].save();
			}
			loader('show', 200);
		},
		success: function(data){
			loader('hide', 200);
			$("main").html(data);
			init();
		}
	});
}

/* CALENDAR */ 
function addCalendarNavigationControls(){
	$(".prevMonth").click(function(){
		$.get("/?async=1&calendarMonth=-1", function(){
			window.location.reload();
		});
	});

	$(".nextMonth").click(function(){
		$.get("/?async=1&calendarMonth=1", function(){
			window.location.reload();
		});
	});
}

/* TABLE */
function makeTableRowClickable(){
	$(".cms-table .row").each(function(){
		var row = $(this);
		if(row.find("td > a").length == 1){
			var link = row.find("td > a").attr("href");
			row.find("td").css({"cursor":"pointer"});
			row.click(function(e){
				if(e.target.nodeName != "DIV" && e.target.parentElement.nodeName != "LI" && e.target.parentNode.classList[0] != "directLink"){
					if(e.target.nodeName != "A"){
						e.preventDefault();
						var a = document.createElement('a');
						a.href = link;
						if(row.find("td > a").attr("download") != undefined){
							a.setAttribute("download", "");
						}
						a.click();
					}		
				}
			});
		}
	});
}

function makeTableSortable(tableName){
	var fixHelper = function(e, ui) {  
		ui.children().each(function() {  
			$(this).width($(this).width());  
		});  
		return ui;  
	};

	var table = $(".cms-table."+tableName);
	$(".cms-table."+tableName).sortable({
		items: ".row",
		helper: fixHelper,
		update: function(event, ui) {
			var sortArray = {};
			$(this).find(".row").each(function(index){
				sortArray[index+1] = $(this).attr("row_id");
			});

			$.post(window.location.href+"&async=1&sort=1&table="+tableName, {"sort":sortArray}, function(data){
				console.log(sortArray);
				console.log(data);
			});
		}
	}).disableSelection();
}

function optionsLogic(){
	$(".cms-table-options > div").unbind();
	$('html').click(function(e) {
		if ($(e.target).closest('.cms-table-options div').length === 0) {
			$(".cms-table-options").removeClass("open");
		}
	});

	$(".cms-table-options > div").click(function(){
		if(!$(this).parent().hasClass("open")){
			$(".cms-table-options").removeClass("open");
			$(this).parent().toggleClass("open");
		}else{
			$(".cms-table-options").removeClass("open");
		}
	});
}

function asyncLinks(){
	$("a.async").click(function(event){
		event.preventDefault();
		loader('show', 200);
		var url = $(this).attr("href");
		$.get(url, function(data){
			$("main").html(data);
			loader('hide', 200);
		});
	});
}

/* FORM */
function styleFileUpload(){
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input ){
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;
		input.addEventListener( 'change', function(e){
			var fileName = '';
			if( this.files && this.files.length > 1 ){
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			}else{
				fileName = e.target.value.split( '\\' ).pop();
			}
			if(fileName){
				label.querySelector('span').innerHTML = fileName;
			}else{
				label.innerHTML = labelVal;
			}
		});
	});
}

function validateCmsForm(form){
			var formError = false;
			$(form).find("input, select, textarea").each(function(){

				var value = $(this).val();
				var minLength = $(this).attr("minLength") != undefined ? $(this).attr("minLength") : 0;
				var error = false;

				/*console.log($(this)[0].tagName);
				console.log(value);*/

				if($(this).attr("type") == "radio" && $(this).attr("required") == "required"){
					var name = $(this).attr("name");
					var val = $("input:radio[name ='" + name + "']:checked").val();
					if(val == undefined){
						error = true;
					}
				}

				if($(this).attr("type") == "checkbox" && $(this).attr("required") == "required" && !$(this).is(":checked")){
					error = true;
				}

				if($(this)[0].tagName == "SELECT" && value == "0" && $(this).attr("required") == "required"){
					error = true;
				}

				if($(this).attr("required") == "required" && value.length <= 0){
					error = true;
				}

				if($(this).hasClass("cms-richtext")){
					var rtVal = tinymce.editors[$(this).index()-1].getContent();
					console.log(rtVal);
					if($(this).attr("required") == "required" && rtVal.length <= 0){
						error = true;
					}
				}

				if(value.length < minLength){
					error = true;
				}

				if(error){
					$(this).closest("td").addClass("cms-error");
					formError = true;
				}else{
					$(this).closest("td").removeClass("cms-error");
				}
			});

			if(formError){
				return false;
			}else{
				return true;
			}
}

function cmsRemoveSimpleImage(image) {
	var r = confirm("Möchten Sie dieses Element wirklich löschen?");
	if (r == true) {
		var url = window.location.href;
		url = url.replace("&async=1", "");
		url = url + "&async=1&cmsRemoveSimpleImage=" + image;
		
		$.get(url, function (data) {
			$("main").html(data);
			init();
			$("#cms-lightbox").fadeOut();
		});
	}
}

function cmsRemoveImage(image, id){
	var r = confirm("Möchten Sie dieses Element wirklich löschen?");
	if (r == true) {
		var url = window.location.href;
		url = url.replace("&async=1", "");
		url = url+"&async=1&cmsRemoveImage="+image+"&image_id="+id;
		$.get(url, function(data){
			$("main").html(data);
			init();
			$("#cms-lightbox").fadeOut();
		});
	}
}

function cmsImageSettings(image, id){
	var url = "/?async=1&imageSettings=" + image + "&image_id=" + id;
	$.get(url, function (data) {
		$("#cms-lightbox-content").html(data);
		$.get("/?async=1&getImageSettings="+id, function(data){
			$("aside#cms-lightbox div#cms-lightbox-container .image-align span").css({ "top": data.percentage+"%"});
			if(data.show_in_slideshow){
				$("#showInSlideshow").click();
			}
			$("#cms-lightbox").fadeIn();
			initImageAlign(id);
		})
	});
}

function initImageAlign(id){
	$(window).resize();
	var dragging = false;
	var initY = 0;
	var initTop = 0;
	var element = $("aside#cms-lightbox div#cms-lightbox-container .image-align span");
	element.mousedown(function(e){
		dragging = true;
		initY = e.originalEvent.pageY;
		initTop = parseInt($(this).css("top"));
	});

	element.mousemove(function(e){
		if(dragging){
			var maxTop = parseInt($(this).parent().css("height")) - parseInt($(this).css("height"));
			var top = e.originalEvent.pageY - initY + initTop > 0 ? (e.originalEvent.pageY - initY + initTop)+"px" : "0px";
			top = parseInt(top) < maxTop ? top : maxTop;
			$(this).css({ "top" : top });
		}
	});

	$("body").mouseup(function(){
		dragging = false;	
	});

	$(".save-image-align").click(function(){
		let percentage = 0;
		var top = parseFloat(element.css("top"));
		var bottom = parseFloat(element.parent().css("height")) - (top + parseFloat(element.css("height")));
		var delta = top < bottom ? top / bottom * 100 : bottom / top * 100;
		if (top < bottom) {
			percentage = delta / 2;
		} else {
			percentage = 100 - delta / 2;
		}

		let cmsViewPercentage = top / parseFloat(element.parent().css("height")) * 100;

		percentage = percentage > 100 ? 100 : percentage;

		var showInSlideshow = $(".showInSlideshow").is(":checked") ? "1" : "0";

		$.get("/?async=1&alignImage=" + id + "&percentage=" + percentage + "&showInSlideshow=" + showInSlideshow +"&cmsViewPercentage="+cmsViewPercentage, function (data) {
			$("#cms-lightbox").fadeOut();
		});
	})
}

/* WYSIWYG */
function myFileBrowser(callback, value, meta){
	var url = meta.filetype == "image" ? "/?async=1&richtext_images=1" : "/?async=1&richtext_files=1";
	$.get(url, function(data){
		$("#cms-lightbox-content").html(data);
		$("#cms-lightbox").fadeIn();

		$("#cms-lightbox-content form input[type=file]").change(function(){
			$(this).parent().submit();
		});

		$("#cms-lightbox-content form").ajaxForm({
			success:function(){
				myFileBrowser(callback, value, meta);
			}
		});

		fileBrowserClick(callback);
	});
}

function fileBrowserClick(callback){
	$(".tiny-mce-image").unbind();
	$(".tiny-mce-image").click(function(){
		var path = $(this).attr("docpath");
		$.get("/?async=1&isDir="+path, function(data){
			data = data.trim();
			if(data == "0"){
				console.log(path);
				callback(path);
				$("#cms-lightbox").fadeOut();
			}else{
				$.get("/?async=1&richtext_files=1&path="+path+"/", function(data){
					$("#cms-lightbox-content").html(data);
					fileBrowserClick(callback);
				});
			}
		});
	});
}

function richtexteditor(){

	for(var i = 0; i<=tinymce.editors.length-1; i++){
		tinymce.editors[i].destroy();
	}

	tinymce.init({
		selector: '.cms-richtext',
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste imagetools wordcount"
		],
		toolbar: "styleselect | bold italic | table | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
		a_plugin_option: true,
		statusbar : false,
		menubar : false,
		a_configuration_option: 400,
		relative_urls : false,
		remove_script_host : true,
		branding: false,
		file_picker_callback: function(callback, value, meta) {
			myFileBrowser (callback, value, meta);
		}
	});
}

function lightbox(){
	$("#cms-lightbox-container > img").click(function(){
		$("#cms-lightbox").fadeOut();
	});
}

/* DASHBOARD */	
function diskUsageForIE(percentage){
	var myNav = navigator.userAgent.toLowerCase();
	var isIE = (myNav.indexOf('msie') != -1 || myNav.indexOf('trident') != -1) ? true : false;
	if(isIE){
		$("div#dashboard div circle").css({"stroke-dasharray":percentage+" 416"});
	}
}

/* MISC */
function navLogic(){
	$("nav div#menu").click(function(){
		$("nav").toggleClass("open");
	});

	$("nav ul li a").click(function(e){
		e.preventDefault();
		var elem = $(this);
		var link = $(this).attr("href");
		$("nav").removeClass("open");
		setTimeout(function(){
			if(elem.is("#logout")){
				$.get("/?async=1&cms_logout=1", function(data){
					window.location.href = "/?admin=1";
				});
			}else{
				window.location.href = link;
			}
		}, 500);
	});

	$("nav ul li.subnav").click(function(){
		if($(this).find("ul").is(":hidden")){
			$(this).find("ul").slideDown();
		}else{
			$(this).find("ul").slideUp();
		}
	});
}

function displayStatusMessage(message, color, autohide, displayduration){
	color = color == undefined ? "#080" : color;
	$("body").append("<div style=\"background-color: "+color+";\" id=\"status\"><p>"+message+"</p></div>");

	$("#status").click(function(){
		$("#status").removeClass("moving");
			setTimeout(function(){
				$("#status").remove();
		}, 500);
	});

	setTimeout(function(){
		$("#status").addClass("moving");
		var to = setTimeout(function(){
			$("#status").removeClass("moving");
			setTimeout(function(){
				$("#status").remove();
			}, 500)
		}, displayduration);
		if(autohide == false){
			clearTimeout(to);
		}
	}, 100);
}

function confirmationDialog(){
	$("a.confirmDialog").unbind();
	$("a.confirmDialog").click(function(e){
		e.preventDefault();
		var link = $(this).attr("href");
		var message = $(this).attr("confirmdialog");
		var isAsync = $(this).hasClass("async");

		$.get("/?async=1&getConfirmDialogButtons=1", function(data){
			$("#cms-lightbox-content").html(message+data);
			$("#cms-lightbox").fadeIn();

			$("button.no").click(function(){
				$("#cms-lightbox").fadeOut();
			});

			$("button.yes").click(function(){
				$("#cms-lightbox").fadeOut(function(){
					if(isAsync){
						loader('show', 200);
						$.get(link, function(data){
							$("main").html(data);
							loader('hide', 200);
						});
					}else{
						window.location.href = link;
					}
				});
			});
		});
	});
}

$(window).resize(function () {
	let imageAlignSpan = $("aside#cms-lightbox div#cms-lightbox-container .image-align span")
	if (imageAlignSpan.length > 0) {
		var imageAlignSpanNewHeight = parseInt(imageAlignSpan.css("width")) / 3;
		imageAlignSpan.css({ "height": imageAlignSpanNewHeight + "px" });
	}
});

function loader(state, speed){
	speed = speed == undefined ? 200 : speed;
	if(state == "hide"){
		$("#loader-container").fadeOut(speed);
	}else if(state == "show"){
		$("#loader-container").fadeIn(speed);
	}else{
		alert("ERROR, FIRST PARAMETER OF LOADER SHOULD BE 'hide' or 'show'. Was: "+state);
	}
}