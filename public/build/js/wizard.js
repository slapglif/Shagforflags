$(document).ready(function(){

	var current_fs, next_fs, previous_fs;
	var opacity;
	var step_1, step_2_partners, step_3;

	function NextProgress(button) {
		current_fs = $(button).closest("fieldset");
		next_fs = current_fs.next();

		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		//show the next fieldset
		next_fs.show();

		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now) {
				opacity = 1 - now;
				current_fs.css({
					'display': 'none',
					'position': 'relative'
				});
				next_fs.css({'opacity': opacity});
			},
			duration: 600
		});
		customAnimate("#msform");
	}

	$(".next-1").click(function(){
		step_1 = {};
		var story_location = $("#step-1-location").val();
		var story_country = $("#step-1-country").val();
		var story_date = $("#step-1-date").val();

		step_1 = {
			"location": story_location,
			"country": story_country,
			"date": story_date
		};

		var step_1_error = 0;
		$.each(step_1, function (key, value) {
			$("#step-1-" + key).css("border", "1px solid #ced4da");

			if (!value) {
				$("#step-1-" + key).css("border", "2px solid #FF6A6A");
				step_1_error = step_1_error + 1;
			}
		});
		if (step_1_error > 0) {
			$(".wizard-error-1").css("display", "block");
			customAnimate("#progress-form-1");
			return false;
		}else {
			$(".wizard-error-1").css("display", "none");
			NextProgress(this);
		}
	});

	$(".next-2").click(function(){
		step_2_partners = {};
		$("#progress-form-2 #wizard-accordion .card").each(function() {
			var partner_id = this.id;

			var step_2_action_chips = {};
			$("#" + partner_id + " .active .step-2-achips").each(function(index) {
				step_2_action_chips[index] = $(this).val();
			});

			// add country from selection
			var partner_country = $("#" + partner_id + " .step-2-country .dropdown-toggle").attr("title");
			if (!partner_country || partner_country == "Country") {
				partner_country = "";
			}

			var partner_item = {
				"name": $("#" + partner_id + " .step-2-partner-name").val(),
				"country": partner_country,
				"gender": $("#" + partner_id + " .active .step-2-gender").val(),
				"ages": $("#" + partner_id + " .active .step-2-intages").val(),
				"shape": $("#" + partner_id + " .active .step-2-bodyshape").val(),
				"birthcontrol": $("#" + partner_id + " .active .step-2-birthcontrol").val(),
				"met": $("#" + partner_id + " .active .step-2-met").val(),
				"sexorient": $("#" + partner_id + " .active .step-2-sexorient").val(),
				"actionchips": step_2_action_chips
			};
			step_2_partners[partner_id] = partner_item;
		});

		var step_2_error = 0;
		$.each(step_2_partners, function (key, value) {
			$.each(step_2_partners[key], function (pkey, pvalue) {
				if (pkey != "actionchips") {
					if (!pvalue) {
						if (pkey == "name" || pkey == "country") {
							if (pkey == "name") {
								$("#" + key + " .step-2-partner-name").css("border", "2px solid #FF6A6A");
							}else {
								$("#" + key + " .step-2-country").css("border", "2px solid #FF6A6A");
							}
						}

						step_2_error = step_2_error + 1;
					}else {
						if (pkey == "name" || pkey == "country") {
							if (pkey == "name") {
								$("#" + key + " .step-2-partner-name").css("border", "1px solid #ced4da");
							}else {
								$("#" + key + " .step-2-country").css("border", "1px solid #ced4da");
							}
						}
					}
				}else {
					if (Object.keys(pvalue).length === 0 && pvalue.constructor === Object) {
						step_2_error = step_2_error + 1;
					}
				}
			});
		});

		if (step_2_error > 0) {
			$(".wizard-error-2").css("display", "block");
			customAnimate("#progress-form-2");
			return false;
		}else {
			$(".wizard-error-2").css("display", "none");
			NextProgress(this);
		}
	});

	$(".save").click(function(){
		step_3 = {};
		var story_content = $("#step-3-story").val();

		step_3 = {
			"story": story_content,
		};

		var step_3_error = 0;
		$.each(step_3, function (key, value) {
			$("#step-3-story").css("border", "1px solid #ced4da");
			if (!value) {
				step_3_error = step_3_error + 1;
				$("#step-3-story").css("border", "2px solid #FF6A6A");
			}
		});
		if (step_3_error > 0) {
			$(".wizard-error-3").css("display", "block");
			customAnimate("#progress-form-3");
			return false;
		}else {
			$(".wizard-error-3").css("display", "none");

			$("#progress-form-3 .previous").css("display", "none");
			$("#progress-form-3 .save").css("display", "none");
			$(".cs-loading-btn").css("display", "block");
			createStory();
		}
	});
	function createStory() {
		$.ajax({
			url: '/story/add-story',
			type: 'post',
			data: {
				step_1: JSON.stringify(step_1),
				step_2: JSON.stringify(step_2_partners),
				step_3: JSON.stringify(step_3),
				step_4: JSON.stringify(fileList)
			},
			success: function(response){
				if (response == "true") {
					$("#progress-form-1").remove();
					$("#progress-form-2").remove();
					$("#progress-form-3").remove();

					$("#progress-success").css("display", "block");
				}
			}
		});
	}

	$(".previous").click(function(){
		current_fs = $(this).closest("fieldset");
		previous_fs = current_fs.prev();

		//Remove class active
		$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

		//show the previous fieldset
		previous_fs.show();

		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now) {
				opacity = 1 - now;
				current_fs.css({
					'display': 'none',
					'position': 'relative'
				});
				previous_fs.css({'opacity': opacity});
			},
			duration: 600
		});

		customAnimate("#msform");
	});

	$("#wizard-accordion").on( 'click', '.card-link', function () {
		var caret = $(this).find(".icomoon");
		if (caret.hasClass('icon-caret-up')) {
			caret.removeClass('icon-caret-up');
			caret.addClass('icon-caret-down');
		}else {
			caret.removeClass('icon-caret-down');
			caret.addClass('icon-caret-up');
		}

		var clicked_accordion_id = $(this).parent().attr("id");
		var all_cards = $("#wizard-accordion .card");
		$.each(all_cards, function (i) {
			if (clicked_accordion_id != $(this).attr("id")) {
				$(this).find(".card-link .icomoon").removeClass("icon-caret-up");
				$(this).find(".card-link .icomoon").addClass("icon-caret-down");
			}
		});
	});

	var partner_number = 2;
	$(".add-sex-partner").click(function () {
		// Remove remove-sex-partner-button
		$('.remove-sex-partner').remove();

		var all_cards = $("#wizard-accordion .card");
		$.each(all_cards, function (i) {
			if ($(this).find(".collapse").hasClass('show')) {
				// Close all active partners
				$(this).find(".collapse").removeClass('show');
			}

			// Change carets
			$(this).find(".card-link .icomoon").removeClass("icon-caret-up");
			$(this).find(".card-link .icomoon").addClass("icon-caret-down");
		});

		var new_partner = $("#partner-0").clone();
		new_partner.appendTo("#wizard-accordion");
		new_partner.removeClass("d-none");

		// Set partner-id
		var new_partner_id = "partner-" + partner_number;
		new_partner.attr("id", new_partner_id);

		// Set href and id
		$("#" + new_partner_id + " .card-link").attr("href", "#c-" + partner_number);
		$("#" + new_partner_id + " .collapse").attr("id", "c-" + partner_number);

		var title_content = '<i class="icomoon icon-caret-up"></i> Partner ' + partner_number + ' <i class="icomoon icon-remove_circle remove-sex-partner"></i>';
		$("#" + new_partner_id + " .fs-subtitle").html(title_content);

		var new_countrypicker_select = $("#" + new_partner_id + " .step-2-country");
		new_countrypicker_select.addClass("country-selector");
		new_countrypicker_select.selectpicker("render");
		$("#" + new_partner_id + " .step-2-country .dropdown-toggle").css({
			'background-size': '20px',
			'background-position': '10px 12px',
			'background-repeat': 'no-repeat',
			'background-image': 'url("http://shagforflags.loc/build/images/flags/undefined.png")',
			'border-radius': '4px',
			'border': '1px solid rgb(206, 212, 218)',
			'background-color': 'transparent',
			'padding': '11px 30px 11px 40px',
		});

		partner_number = partner_number + 1;
	});

	$("#wizard-accordion").on( 'click', '.remove-sex-partner', function () {
		$(this).parent().parent().remove();
		partner_number = partner_number - 1;
		removePartnerButton();
	});

	function removePartnerButton() {
		$('.remove-sex-partner').remove();

		// Add to the latest partner remove-button
		var partnerbox = $('.card').eq(-2);
		if (partnerbox.attr('id') != "partner-1") {
			var removebtn = '<i class="icomoon icon-remove_circle remove-sex-partner"></i>';
			partnerbox.find('.fs-subtitle').append(removebtn);
		}
	}

	function customAnimate(destination) {
		$([document.documentElement, document.body]).animate({
			scrollTop: $(destination).offset().top
		}, 1000);
	}

	$(function () {
		$('#step-3-story').emoji({place: 'after'});
	});

	//$("#progress-form-1 .next-1:first").trigger("click");
	//$("#progress-form-2 .next:first").trigger("click");
});

$(function(){
	$("#step-1-location").geocomplete({
		types: ['(cities)']
	}).bind("geocode:result", function (event, result) {
		$('#step-1-location').val(result.address_components[0].short_name);
		for(var i = 0; i < result.address_components.length; i++) {
			var addressObj = result.address_components[i];
			for(var j = 0; j < addressObj.types.length; j++) {
				if (addressObj.types[j] === 'country') {
					$('#step-1-country').val(addressObj.long_name);
				}
			}
		}
	});
});