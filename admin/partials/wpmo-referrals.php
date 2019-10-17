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

wp_nonce_field( 'wpmo-referrals', 'wpmo_referrals_nonce' );
?>
<div>
	<p>Please use the table below to access and export referral information.</p>
	<table id="wpmo_referrals">
		<thead>
			<tr>
				<th>User ID</th>
				<th>Email</th>
				<th>Remaining credit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Collect all advocate IDs and sum up their remaining balance.
			global $wpdb;
			$sql       = 'SELECT DISTINCT advocate_id FROM ' . $wpdb->prefix . 'automatewoo_referrals' .
				' GROUP BY advocate_id';
			$advocates = $wpdb->get_results(
				$sql
			);
			foreach ( $advocates as $advocate ) {
				$sql      = 'SELECT SUM(reward_amount_remaining) AS sum FROM ' . $wpdb->prefix . 'automatewoo_referrals' .
					' WHERE advocate_id = %d GROUP BY advocate_id';
				$sum      = $wpdb->get_var(
					$wpdb->prepare(
						$sql,
						$advocate->advocate_id
					)
				);
				$userdata = get_userdata( $advocate->advocate_id );
				echo '<tr><td>' . $advocate->advocate_id . '</td>';
				echo '<td>' . $userdata->user_email . '</td>';
				echo '<td>' . $sum . '</td></tr>';
			}
			?>
		</tbody>
	</table>
</div>
<?php
