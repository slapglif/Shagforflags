$(function(){
	$("#form_location").geocomplete({
		types: ['(cities)']
	}).bind("geocode:result", function (event, result) {
		$('#form_location').val(result.address_components[0].short_name);
	});
});

$(document).ready(function(){
	var typingTimer;
	var doneTypingInterval = 500;
	var $input = $("#form_alias");

	$input.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});

	function doneTyping () {
		var alias = $input.val().trim();

		if(alias != ''){
			$.ajax({
				url: '/profile/alias-check',
				type: 'post',
				data: {alias: alias},
				success: function(response){
					if ($(".alias-check").hasClass("d-none")) {
						$(".alias-check").removeClass("d-none");
					}

					if (response == "true") {
						if ($(".alias-check").hasClass("custom-icon-green")) {
							$(".alias-check").removeClass("custom-icon-green");
						}
						if ($(".alias-check").hasClass("icon-check")) {
							$(".alias-check").removeClass("icon-check");
						}

						$(".alias-check").addClass("custom-icon-red icon-close").attr("data-original-title", "Not Available");

					}else if (response == "false") {
						if ($(".alias-check").hasClass("custom-icon-red")) {
							$(".alias-check").removeClass("custom-icon-red");
						}
						if ($(".alias-check").hasClass("icon-close")) {
							$(".alias-check").removeClass("icon-close");
						}

						$(".alias-check").addClass("custom-icon-green icon-check").attr("data-original-title", "Available");
					}
					return true;
				}
			});
		}
	}
});