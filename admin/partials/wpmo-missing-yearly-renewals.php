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

wp_nonce_field( 'wpmo-trigger-missing-yearly-subscriptions', 'wpmo_missing_yearly_nonce' );
?>
<p>Please use the form below to search for missing yearly subscriptions.
	Enter the date after which subscriptions should have renewed.
	Upon hitting "Search", the website will retrieve a list of active yearly subscriptions,
	that do not have a renewal order after the given date.
</p>
<input type="date" id="wpmo-date">
<button id='wpmo-trigger-missing-yearly-renewal-search' class="button button-primary">Search</button>
<span id="wpmo-running">Please wait. Search is running.</span>
<div id="wpmo-success-notice">
	<p>Success. <a href="<?php echo esc_url( get_site_url() ); ?>/wp-content/uploads/cancelled-subscriptions.csv">Download export file here.</a></p>
</div>
<div id="wpmo-error-notice">
	<p></p>
</div>
<div id="wpmo-missing-yearly-results"></div>
