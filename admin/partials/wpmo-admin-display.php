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
?>
<p>Click the button below to trigger the export of the cancelled and pending-cancellation subscriptions.</p>
<button id='wpmo-trigger-cancelled-subscription-export' class="button button-primary">Start export</button>
<span id="wpmo-running">Please wait. Export is running.</span>
<div id="wpmo-success-notice">
	<p>Success. <a href="<?php echo esc_url( get_site_url() ); ?>/wp-content/uploads/cancelled-subscriptions.csv">Download export file here.</a></p>
</div>
<div id="wpmo-error-notice">
	<p></p>
</div>
