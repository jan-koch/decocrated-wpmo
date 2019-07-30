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

wp_nonce_field( 'wpmo-manage-excluded-coupons', 'wpmo_excluded_coupons_nonce' );
$excluded_coupons = get_option( 'wpmo_excluded_coupons' );
if ( strlen( $excluded_coupons ) > 0 ) {
	$excluded_coupons = json_decode( $excluded_coupons );
} else {
	$excluded_coupons = array();
}
?>
<p>Manage the coupon codes that should not be applicable for yearly subscriptions. Please add them one per line, separated by a comma.</p>
<textarea id="wpmo-excluded-coupons" style="min-height: 200px;">
<?php
if ( count( $excluded_coupons ) > 0 ) {
	foreach ( $excluded_coupons as $coupon ) {
		echo trim( $coupon ) . ",\n";
	}
}

?>
</textarea>
<button id='wpmo-save-excluded-coupons' class="button button-primary">Save</button>
<span id="wpmo-running">Please wait...</span>
<div id="wpmo-success-notice"><p>Success. Coupons saved.</p></div>
<div id="wpmo-error-notice"><p>Error. Saving coupons failed.</p></div>
