<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpmastery.xyz
 * @since      1.0.0
 *
 * @package    Wpmo
 * @subpackage Wpmo/admin/partials
 */
wp_nonce_field( 'wpmo-trigger-cancelled-subscription-export', 'wpmo_export_nonce' );
$missing_annuals = array(
	9612,
	9601,
	9595,
	9591,
	9583,
	9575,
	9565,
	9561,
	9552,
	9546,
	9508,
	9472,
	9456,
	9448,
	9440,
	9435,
	9427,
	9404,
	9396,
	9369,
	9342,
	9314,
	9264,
	9259,
	9234,
	9222,
	9218,
	9210,
	9198,
	9190,
	9182,
	9174,
	9171,
	9167,
	9150,
	9122,
	9114,
	9091,
	9066,
	9062,
	9007,
	8997,
	8985,
	8977,
	8969,
	8965,
	8932,
	8928,
	8924,
	8916,
	8913,
	8905,
	8890,
	8886,
	8874,
	8844,
	8840,
	8803,
	8799,
	8795,
	8779,
	8771,
	8763,
	8759,
	8739,
	8735,
	/*
	8731,
	8728,
	8712,
	8704,
	8688,
	8634,
	8621,
	8613,
	8595,
	8589,
	8585,
	8564,
	8545,
	8525,
	8483,
	8474,
	8470,
	8458,
	8453,
	8449,
	8446,
	8434,
	8432,
	8415,
	8407,
	8403,
	8371,
	8363,
	8358,
	8350,
	8342,
	8335,
	8331,
	8319,
	8307,
	8304,
	8270,
	8242,
	8230,
	8212,
	8207,
	8194,
	8190,
	8179,
	8172,
	8168,
	8128,
	8107,
	8103,
	8094,
	8083,
	8070,
	8062,
	8058,
	8046,
	8029,
	8025,
	8017,
	7920,
	7910,
	7882,
	7873,
	7851,
	7831,
	7827,
	7823,
	7815,
	7811,
	7783,
	7779,
	7775,
	7770,
	7761,
	7752,
	7738,
	7718,
	7706,
	7690,
	7674,
	7665,
	7654,
	7637,
	7629,
	7617,
	7578,
	7574,
	7558,
	7536,
	7528,
	7523,
	7506,
	7482,
	7474,
	7456,
	7450,
	7442,
	7438,
	7422,
	7418,
	7414,
	7410,
	7402,
	7381,
	7373,
	7357,
	7353,
	7341,
	7307,
	7303,
	7299,
	7279,
	7262,
	7224,
	7199,
	7195,
	7184,
	7166,
	7138,
	7134,
	7126,
	7101,
	7098,
	7094,
	7090,
	7086,
	7079,
	7042,
	7025,
	7021,
	7001,
	6996,
	6988,
	6981,
	6957,
	6942,
	6934,
	6931,
	6914,
	6905,
	6897,
	6875,
	6871,
	6863,
	6846,
	6838,
	6834,
	6822,
	6809,
	6805,
	6770,
	6762,
	6734,
	6730,
	6722,
	6702,
	6698,
	6679,
	6667,
	6659,
	6655,
	6651,
	6632,
	6629,
	6624,
	6612,
	6609,
	6605,
	6601,
	6572,
	6560,
	6545,
	6535,
	6523,
	6513,
	6509,
	6497,
	6470,
	6462,
	6452,
	6424,
	6420,
	6410,
	6406,
	6398,
	6394,
	6389,
	6385,
	6378,
	6374,
	6361,
	6357,
	6353,
	6349,
	6341,
	6333,
	6328,
	6295,
	6291,
	6282,
	6274,
	6266,
	6262,
	6258,
	6254,
	6248,
	6226,
	6188,
	6176,
	6142,
	6126,
	6101,
	6093,
	6086,
	6079,
	6049,
	6041,
	6037,
	6033,
	6012,
	5996,
	5992,
	5984,
	5975,
	5971,
	5955,
	5945,
	5941,
	5907,
	5903,
	5899,
	5895,
	5891,
	5876,
	5866,
	5845,
	5841,
	5837,
	5816,
	5801,
	5796,
	5787,
	5783,
	5779,
	5769,
	5765,
	5732,
	5728,
	5720,
	5704,
	5680,
	5676,
	5662,
	5635,
	5627,
	5623,
	5605,
	5589,
	5584,
	5581,
	5577,
	5573,
	5569,
	5557,
	5551,
	5547,
	5540,
	5510,
	5493,
	5482,
	5468,
	5461,
	5427,
	5412,
	5391,
	5382,
	5352,
	5348,
	5331,
	5327,
	5322,
	5310,
	5306,
	5294,
	5278,
	5265,
	5261,
	5257,
	5250,
	5228,
	5199,
	5192,
	5181,
	5167,
	5163,
	5159,
	5150,
	5122,
	5118,
	5096,
	5048,
	5030,
	5025,
	5019,
	5015,
	5007,
	5003,
	4964,
	4940,
	4936,
	4930,
	4922,
	4918,
	4914,
	4909,
	4904,
	4899,
	4895,
	4891,
	4887,
	4883,
	4879,
	4875,
	4871,
	4854,
	4837,
	4824,
	4817,
	4810,
	4805,
	4801,
	4797,
	4793,
	4779,
	4773,
	4768,
	4764,
	4760,
	4755,
	4751,
	4747,
	4742,
	4737,
	4733,
	4725,
	4721,
	4716,
	4710,
	4705,
	4701,
	4697,
	4692,
	4687,
	4683,
	4678,
	4675,
	4672,
	4664,
	4656,
	4652,
	4644,
	4636,
	4631,
	4627,
	4621,
	4614,
	4609,
	4603,
	4591,
	4587,
	4582,
	4532,
	4527,
	4515,
	4509,
	4443,
	4414,
	4406,
	4183,
	4159,
	4134,
	4130,
	4100,
	4095,
	4060,
	4052,
	3876,
	3700,
	3677,
	3667,
	3648,
	3625,
	3602,
	3588,
	3576,
	3541,
	3533,
	3516,
	3504,
	3500,
	3494,
	3491,
	3487,
	3470,
	3225,
	3154,
	3135,
	3123,
	3115,
	3094,
	3078,
	3073,
	3045,
	3033,
	3020,
	3011,
	2952,
	2940,
	2924,
	2920,
	2905,
	2883,
	2861,
	2798,
	2793,
	2785,
	2777,
	2744,
	2740,
	2736,
	2732,
	2675,
	2643,
	2619,
	2614,
	2591,
	2584,
	2580,
	2571,
	2567,
	2551,
	2526,
	2518,
	2510,
	2507,
	2479,
	2474,
	2454,
	2448,
	2440,
	2436,
	2419,
	2395,
	2382,
	2374,
	2353,
	2349,
	2343,
	2340,
	2336,
	2320,
	2312,
	2297,
	2288,
	2280,
	2272,
	2238,
	2171,
	2155,
	2146,
	2110,
	2106,
	2090,
	2082,
	2059,
	2055,
	2043,
	2026,
	2018,
	1998,
	1991,
	1987,
	1983,
	1967,
	1936,
	1932,
	1928,
	1865,
	1855,
	1851,*/
);
$forbidden_order_status        = array(
	'wc-refunded',
	'wc-cancelled',
	'wc-failed',
	'wc-on-hold',
);
$forbidden_subscription_status = array(
	'wc-on-hold',
	'wc-cancelled',
	'trash',
	'wc-pending-cancel',
	'wc-pending',
);
foreach ( $missing_annuals as $order_id ) {
	$subscription_id = wpm_get_subscription_from_order_id( $order_id );
	if (
		$subscription_id &&
		! in_array( get_post_status( $order_id ), $forbidden_order_status, true ) &&
		! in_array( get_post_status( $subscription_id ), $forbidden_subscription_status, true )
	) {
		wpm_fix_renewal_date( $subscription_id );
		update_post_meta( $subscription_id, '_billing_interval', 1 );
		update_post_meta( $subscription_id, '_billing_period', 'year' );
		update_post_meta( $subscription_id, '_wpm_current_season', 'summer' );
		wpmastery_write_log( "Fixed subscription: $subscription_id from order $order_id" );
	}
}
?>
<p>Click the button below to trigger the export of the cancelled and pending-cancellation subscriptions.</p>
<button id='wpmo-trigger-cancelled-subscription-export' class="button button-primary">Start export</button>
<span id='wpmo-running'>Please wait. Export is running.</span>
<div id='wpmo-success-notice'>
	<p>Success. <a href='<?php echo esc_url( get_site_url() ); ?>/wp-content/uploads/cancelled-subscriptions.csv'>Download export file here.</a></p>
</div>
<div id="wpmo-error-notice">
	<p></p>
</div>
