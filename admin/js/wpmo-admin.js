(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function () {
		$('#yearly-subscriptions').dataTable({
			"order": [[0, "desc"]],
			"columnDefs": [{
				"targets": 2,
				"data": "download_link",
				"render": function (data, type, row, meta) {
					return '<a target="_blank" href="' + data + '">Open Subscription</a>';
				}
			}]
		})

		$('#wpmo-trigger-cancelled-subscription-export').on('click', function () {
			var data = {
				action: 'wpmo-trigger-cancelled-subscription-export',
				s: $('#wpmo_export_nonce').val()
			};
			$('#wpmo-running').show();
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: data,
				dataType: "HTML",
				success: function (response) {
					$('#wpmo-success-notice').show();
					$('#wpmo-running').hide();
				},
				error: function (xmlHttpRequest, textStatus, errorThrown) {
					if (xmlHttpRequest.readyState == 0 || xmlHttpRequest.status == 0) {
						return;  // it's not really an error
					} else {
						$('#wpmo-error-notice').show();
						//console.log(xmlHttpRequest.readyState == 0 + ' - ' + xmlHttpRequest.status == 0 +  ' - ' + errorThrown);
					}
				}
			}); // end ajax call
			$('#wpmo-running').hide();
		});
	});

})(jQuery);
