$(document).ready(function(){
	var vote_status = '';

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
			$('.add-comment').focus();
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

	$("#all-feeds").on('click', '.add-comment-btn', function () {
		addComment();
	});
	$('.add-comment').keypress(function(event) {
		if (event.keyCode == 13) {
			addComment();
		}
	});

	function addComment() {
		var comment_value = $('.add-comment').val();
		var feed_nr = $('.feed').attr('id').split('-')[1];

		if (comment_value != "") {
			$.ajax({
				url: '/story/add-comment',
				type: 'post',
				async: false,
				data: {
					nr: feed_nr,
					comment: comment_value
				},
				success: function (response) {
					if (response != 'false') {
						var data = $.parseJSON(response);

						var comment_number = parseInt($('.comments').html());
						$('.comments').html(comment_number + 1);

						var new_comment_html = $(".commentList li:last").clone();
						new_comment_html.find('.commenterImage img').attr('src', data.photo);
						new_comment_html.find('.commentText p').html(data.comment);
						new_comment_html.find('.commentText .date').html(data.created);
						new_comment_html.appendTo(".commentList");

						$('.add-comment').val("");
						scrollCommentBox();

						alertify.success('Comment added!');
					}
				}
			});
		}
	}

	function scrollCommentBox() {
		var cm_list = $('.commentList');
		var height = cm_list[0].scrollHeight;
		cm_list.scrollTop(height);
	}
});