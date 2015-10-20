/* global ajaxbase */

(function($) {  // Avoid conflicts with other libraries

'use strict';

$(function() {
	// post_preview start
	if (ajaxbase.script == 'posting') {
		$('input[name="preview"]').click(function() {
			// disable preview button
			$(this).attr('disabled', 'disabled');
			// hide errors
			$('.error').html('');
			// hide preview
			$('#preview_wrapper').html('');

			// start collecting data
			var data = {};
			// hidden
			data.preview = true;
			data.creation_time = $('[name="creation_time"]').val();
			data.form_token = $('[name="form_token"]').val();
			// basic stuff
			data.subject = $('#subject').val();
			data.message = $('#message').val();
			// options
			$('#disable_bbcode').is(':checked') ? data.disable_bbcode = true : '';
			$('#disable_smilies').is(':checked') ? data.disable_smilies = true : '';
			$('#disable_magic_url').is(':checked') ? data.disable_magic_url = true : '';
			$('#attach_sig').is(':checked') ? data.attach_sig = true : '';
			// attachments
			$('#postform input[name*="attachment_data"]').each(function() {
				data[$(this).attr('name')] = $(this).val();
			});
			// poll
			$('#poll_delete').is(':checked') ? data.poll_delete = true : '';
			data.poll_title = $('#poll_title').val();
			data.poll_option_text = $('#poll_option_text').val();
			data.poll_max_options = $('#poll_max_options').val();
			data.poll_length = $('#poll_length').val();
			$('#poll_vote_change').is(':checked') ? data.poll_vote_change = true : '';

			// ajaxify!
			$.ajax({
				url: ajaxbase.preview_url,
				type: 'POST',
				data: data,
				statusCode: {
					// errors
					412: function(data) {
						// hide preview
						$('#preview_wrapper').html('');

						// display errors
						if ($('.error').length > 0) {
							$('.error').html(data.responseText);
						}
						else {
							$('.fields1:first').prepend('<p class="error">' + data.responseText + '</p>');
						}
					},

					// preview it!
					200: function(data) {
						// hide errors
						$('.error').html('');

						// display preview
						$('#preview_wrapper').html(data);
					}
				}
			});

			// jump to preview
			location.hash = '#preview_wrapper';

			// enable preview button
			$(this).removeAttr('disabled');

			return false;
		});
	}

	// who is online and statistics
	if (ajaxbase.script == 'index') {
		setInterval(function() {
			$('#who_is_online_wrapper').load(ajaxbase.url, {mode: 'who_is_online'});
			$('#statistics_wrapper').load(ajaxbase.url, {mode: 'statistics'});
		}, 15000);
	}
});

})(jQuery); // Avoid conflicts with other libraries
