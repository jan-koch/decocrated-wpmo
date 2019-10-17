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

wp_nonce_field( 'wpmo-wrongly-active-subscriptions', 'wpmo_wrong_subscriptions_nonce' );
global $wpdb;
$wpdb->show_errors();
$sql = 'SELECT ID, post_parent FROM ' . $wpdb->prefix . 'posts where post_type LIKE "shop_subscription" and post_status = "wc-active"';

// Load all subscriptions.
$subscriptions = $wpdb->get_results( $sql );

// Prepare empty array to store wrong subscriptions in.
$wrong_subscriptions = array();

// Loop through subscriptions and validate if post_parent has status other than wc-completed.
foreach ( $subscriptions as $subscription ) {
	$sql         = 'SELECT post_status FROM ' . $wpdb->prefix . 'posts WHERE ID = %d';
	$post_status = $wpdb->get_var( $wpdb->prepare( $sql, $subscription->post_parent ), 0, 0 );
	if ( 'wc-failed' === $post_status || 'wc-cancelled' === $post_status ) {
		$wrong_subscriptions[] = array(
			'subscription' => $subscription->ID,
			'parent_order' => $subscription->post_parent,
		);
	}
}
?>
<p> This page will show you subscriptions that are active but shouldn't be, because the parent order never got paid.
</p>
<table class="widefat">
	<thead>
		<tr>
			<th>Subscription</th>
			<th>Parent Order</th>
		</tr>
</thead>
<tbody>
	<?php
	foreach ( $wrong_subscriptions as $subscription ) {
		echo '<tr>';
		echo "<td><a target='_blank_ href='" . get_site_url() . '/wp-admin/post.php?post=' . $subscription['subscription'] . " &action=edit'>" . $subscription['subscription'] . '</a></td> ';
		echo "<td><a target='_blank_ href='" . get_site_url() . '/wp-admin/post.php?post=' . $subscription['parent_order'] . " &action=edit'>" . $subscription['parent_order'] . '</a></td> ';
		echo '</tr>';
	}
	?>
</tbody>
</table>
