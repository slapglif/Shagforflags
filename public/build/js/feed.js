$(document).ready(function(){
	var pagenumber = 1;
	var filter = 'worldwide';
	var loadmore = false;
	var vote_status = '';

	$("#feed-filters").on( 'click', '.btn-feed-filter ', function () {
		if (!$(this).hasClass('feed-filter-active')) {
			var active_btn = $('#feed-filters .feed-filter-active');
			active_btn.removeClass('feed-filter-active');

			$(this).addClass('feed-filter-active');
			var data_filter = $(this).attr('data-filter');

			pagenumber = 0;
			filter = data_filter;

			// Clear feeds
			$('#all-feeds').html('');

			// Load data
			loadData();

			// Check load-button
			if (!$('.load-more-btn').hasClass('d-none')) {
				$('.load-more-btn').addClass('d-none');
			}
			loadmore = false;
		}
	});

	$(window).on('scroll',infiniteScroll);
	$(window).on('touchmove',infiniteScroll);
	function infiniteScroll() {
		var position = $(window).scrollTop();
		var bottom = $(document).height() - $(window).height();

		if (position > (bottom - 100)) {
			if (loadmore == false) {
				loadmore = true;
				$('.load-more-btn').removeClass('d-none');

				var loading_response = loadData();
				if (loading_response) {
					loadmore = false;
				}
				$('.load-more-btn').addClass('d-none');
			}
		}
	}

	function loadData() {
		var respond = false;
		$.ajax({
			url: '/story/load-more',
			type: 'post',
			async: false,
			data: {
				page: pagenumber,
				filter: filter
			},
			success: function(response){
				if (response != 'false') {
					var data = $.parseJSON(response);
					pagenumber = data.page;

					$.each(data.items, function (key, feed) {
						var new_feeds = $("#feed-clone").clone();
						new_feeds.appendTo("#all-feeds");

						var id = "feed-" + feed.id;
						new_feeds.attr("id", id);

						$("#" + id + " .clone-story-flag").attr("src", feed.countryFlag);
						$("#" + id + " .feed-title-location").html(feed.location);
						$("#" + id + " .feed-title-time").html('(' + feed.storyTime + ')');
						$("#" + id + " .clone-reporter-flag").attr("src", feed.reporter.flag);
						$("#" + id + " .feed-reporter-name").html(feed.reporter.name);
						$("#" + id + " .clone-reporter-country").html(feed.reporter.country);
						$("#" + id + " .clone-reporter-gender").html(feed.reporter.gender);
						$("#" + id + " .clone-reporter-age").html(feed.reporter.age + ' Years');
						$("#" + id + " .clone-reporter-orient").html(feed.reporter.orient);
						$("#" + id + " .feed-story").html(feed.story);

						$.each(feed.partnerFlags.flags, function (key, flag) {
							var partnerflag = "/build/images/flags-big/" + flag + ".png";
							var partnerflagHtml = '<span class="feed-icon-flags"><img class="feed-title-flag rounded-circle" src="' + partnerflag + '"></span>';
							$("#" + id + " .clone-story-partners").append(partnerflagHtml);
						});
						if (feed.partnerFlags.additional > 0) {
							var partnerflagAdditional = '<span class="feed-icon-flags feed-icon-flags-additional"><span class="feed-title-flag rounded-circle">+' + feed.partnerFlags.additional + '</span></span>';
							$("#" + id + " .clone-story-partners").append(partnerflagAdditional);
						}

						$("#" + id + " .upvote").html(feed.votes.up);
						$("#" + id + " .downvote").html(feed.votes.down);
						if (feed.votes.vote != "") {
							if (feed.votes.vote == "up") {
								$("#" + id + " .upvote-f").addClass('feed-socials-green-checked');
							}else {
								$("#" + id + " .downvote-f").addClass('feed-socials-red-checked');
							}
						}

						$("#" + id + " .comments").html(feed.comments);

						new_feeds.removeClass("d-none");
					});
					respond = true;
				}
			}
		});

		return respond;
	}

	$("#all-feeds").on( 'click', '.feed-socials i', function () {
		var feed_nr = getFeedId(this);
		var parent = $(this).parent();

		if ($(this).hasClass('upvote-f')) {
			$(this).removeClass('upvote-f');

			voteFeed(feed_nr, '1');
			var upvote_counter = parent.find('.upvote');
			var current_nr = parseInt(upvote_counter.html());

			if (vote_status == 'added') {
				upvote_counter.html(current_nr + 1);
				$(this).addClass('feed-socials-green-checked');

			}else if (vote_status == 'removed') {
				upvote_counter.html(current_nr - 1);
				$(this).removeClass('feed-socials-green-checked');

			}else if (vote_status == 'changed') {
				upvote_counter.html(current_nr + 1);
				$(this).addClass('feed-socials-green-checked');

				parent.parent().find('.downvote-f').removeClass('feed-socials-red-checked');
				var downvote_counter = parent.parent().find('.downvote');
				var downvote_counter_int = parseInt(downvote_counter.html());
				downvote_counter.html(downvote_counter_int - 1);
			}
			$(this).addClass('upvote-f');

		}else if ($(this).hasClass('downvote-f')) {
			$(this).removeClass('downvote-f');

			voteFeed(feed_nr, '0');
			var downvote_counter = parent.find('.downvote');
			var current_nr = parseInt(downvote_counter.html());

			if (vote_status == 'added') {
				downvote_counter.html(current_nr + 1);
				$(this).addClass('feed-socials-red-checked');

			}else if (vote_status == 'removed') {
				downvote_counter.html(current_nr - 1);
				$(this).removeClass('feed-socials-red-checked');

			}else if (vote_status == 'changed') {
				downvote_counter.html(current_nr + 1);
				$(this).addClass('feed-socials-red-checked');

				parent.parent().find('.upvote-f').removeClass('feed-socials-green-checked');
				var upvote_counter = parent.parent().find('.upvote');
				var upvote_counter_int = parseInt(upvote_counter.html());
				upvote_counter.html(upvote_counter_int - 1);
			}
			$(this).addClass('downvote-f');

		}else if ($(this).hasClass('comment-f')) {
			alertify.prompt(
				'Your comment:',
				'',
				function (event, value) {
					if (value != "") {
						$.ajax({
							url: '/story/add-comment',
							type: 'post',
							async: false,
							data: {
								nr: feed_nr,
								comment: value
							},
							success: function(response){
								if (response != 'false') {
									var comment_counter = parent.find('.comments');
									var comment_number = parseInt(comment_counter.html());
									comment_counter.html(comment_number + 1);
									alertify.success('Comment added!');
								}
							}
						});
					}
				}, function () {
					this.destroy();
				}
			).set({
				'labels': {ok:'Add', cancel:'Close'},
				'title': 'Add Comment'
			});
			$('.alertify').appendTo(".site-wrap");
		}
	});

	function voteFeed(nr, vote) {
		$.ajax({
			url: '/story/vote',
			type: 'post',
			async: false,
			data: {
				nr: nr,
				vote: vote
			},
			success: function(response){
				if (response == 'added' || response == 'changed' || response == 'removed') {
					vote_status = response;
				}else {
					vote_status = '';
				}
			}
		});
	}

	function getFeedId(obj) {
		return $(obj).closest('.feed').attr('id').split('-')[1];
	}


	$("#all-feeds").on( 'click', '.feed .feed-title-bg', function () {
		openFeed(this);
	});
	$("#all-feeds").on( 'click', '.feed .feed-body', function () {
		openFeed(this);
	});
	function openFeed(obj) {
		var feednr = getFeedId(obj);
		location.href = '/story/detail/' + feednr;
		return true;
	}
});