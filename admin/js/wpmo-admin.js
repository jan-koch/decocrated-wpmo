(function ($) {
	'use strict';
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
