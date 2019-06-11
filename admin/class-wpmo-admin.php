<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpmastery.xyz
 * @since      1.0.0
 *
 * @package    Wpmo
 * @subpackage Wpmo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpmo
 * @subpackage Wpmo/admin
 * @author     Jan Koch | WP Mastery <jan@wpmastery.xyz>
 */
class Wpmo_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpmo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpmo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpmo-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpmo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpmo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpmo-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function render_admin_menu() {
		add_menu_page(
			'Order Management',
			'Order Management',
			'manage_options',
			'wpmo',
			array( $this, 'render_admin_page' )
		);
		add_submenu_page(
			'wpmo',
			'Quarterly Subscriptions',
			'Quarterly Subscriptions',
			'manage_options',
			'wpmo_quarterly',
			array( $this, 'render_quarterly_subscription_overview_page' )
		);
	}

	public function render_admin_page() {
		ob_start();
		// $this->load_quarterly_renewal_subscriptions();
		echo ob_get_clean();
	}


	public function get_active_subscriptions() {
		$post_args     = array(
			'post_type'   => 'shop_subscription',
			'post_status' => 'wc-active',
			'numberposts' => -1,
			'orderby'     => 'date',
			'order'       => 'DESC',
		);
		$subscriptions = get_posts( $post_args );
		return $subscriptions;
	}

	public function is_annual_and_not_prepaid( $subscription_id ) {
		$subscription = wcs_get_subscription( $subscription_id );
		$price        = $subscription->get_total();
		if ( 200 < $price ) {
			$prepaid = get_post_meta( $subscription_id, '_flycart_wcs_handling_upfront_recurring', true );
			if ( empty( $prepaid ) || false == $prepaid ) {
				return true;
			}
		}
		return false;
	}
	public function subscription_did_create_renewal( $post_obj ) {
		$subscription = wcs_get_subscription( $post_obj->ID );
		if ( ! is_a( $subscription, 'WC_Subscription' ) ) {
			return;
		}

		$season = get_post_meta( $subscription->get_id(), 'deco_current_season', true );
		if ( empty( $season ) ) {
			$season = wpm_get_season_from_order( $subscription->get_id() );
		}
		$renewals        = wpm_get_renewal_orders_in_subscription( $subscription->get_id() );
		$renewal_created = false;
		$wpm_season_flag = get_post_meta( $subscription->get_id(), '_wpm_current_season', true );
		if (
			( strtolower( $season ) == 'fall' && count( $renewals ) == 2 ) ||
			( strtolower( $season ) == 'winter' && count( $renewals ) == 1 ) ||
			( strtolower( $season ) == 'spring' && count( $renewals ) == 0 )
		) {
			$renewal_created = false;
		} elseif (
			( strtolower( $season ) == 'fall' && count( $renewals ) >= 3 ) ||
			( strtolower( $season ) == 'winter' && count( $renewals ) >= 2 ) ||
			( strtolower( $season ) == 'spring' && count( $renewals ) >= 1 ) ||
			( strtolower( $wpm_season_flag ) == 'summer' )
		) {
			$renewal_created          = true;
			$correct_renewal_order_id = max( array_keys( $renewals ) );
		}
		if ( ! $renewal_created ) {
			foreach ( $renewals as $renewal ) {
				$renewal_order       = wc_get_order( $renewal );
				$renewal_order_id    = $renewal_order->get_id();
				$renewal_timestamp   = strtotime( $renewal_order->get_date_created( 'view' ) );
				$summer_season_start = strtotime( '13.05.2019' );
				if ( $renewal_timestamp >= $summer_season_start ) {
					$correct_renewal_order_id = $renewal_order_id;
					$renewal_created          = true;
					break;
				}
				// If the renewal contains the Summer box, the subscription renewed successfully.
				$order_items = $renewal_order->get_items();
				foreach ( $order_items as $key => $item ) {
					if ( ! $renewal_created ) {
						$product_id   = $item->get_product_id();
						$variation_id = $item->get_variation_id();
						if ( empty( $season ) ) {
							$season = wc_get_order_item_meta( $key, 'Season', true );
						}
						if ( 15940 == $variation_id || strcasecmp( 'summer', $season ) == 0 ) {
							$renewal_created          = true;
							$correct_renewal_order_id = $renewal_order_id;
							break;
						}
					}
				}
			}
		}
		$subscription_edit_page = get_site_url() . '/wp-admin/post.php?post=' . $subscription->get_id() . '&action=edit';

		echo 'Subscription <a href="' . $subscription_edit_page . '" target="_blank">'
				. $subscription->get_id() . '</a> was created in ' . ucfirst( $season ) . '. ';
		if ( $renewal_created ) {
			$renewal_edit_page = get_site_url() . '/wp-admin/post.php?post=' . $correct_renewal_order_id . '&action=edit';
			echo ' Summer renewal order exists: '
				. '<a href="' . $renewal_edit_page . '" target="_blank">' . $correct_renewal_order_id . '</a><br />';
			return true;
		} elseif ( ! $renewal_created ) {
			// If the renewal has been created after summer time, please a mark.
			echo '<span style="color:red;"> Summer renewal order missing.</span><br />';
		}

		return false;
	}

	public function box_skipped( $subscription_id ) {
		global $wpdb;
		$wpdb->show_errors();

		$comments_table = $wpdb->prefix . 'comments';
		$sql            = 'select comment_content from ' . $comments_table . " WHERE
							comment_post_id = %d and comment_author = 'WooCommerce'
							ORDER BY comment_id DESC LIMIT 1";
		$results        = $wpdb->get_results(
			$wpdb->prepare(
				$sql,
				$subscription_id
			)
		);
		if ( count( $results ) == 1 ) {
			if ( stripos( $results[0]->comment_content, 'customer chose to skip the next shipping' ) !== false ) {
				return true;
			}
		}
	}

	public function get_active_annual_subscriptions() {
		$post_args     = array(
			'post_type'   => 'shop_subscription',
			'post_status' => 'wc-active',
			'numberposts' => -1,
			'date_query'  => array(
				'before' => array(
					'year'  => 2019,
					'month' => 5,
					'day'   => 13,
				),
			),
			'meta_key'    => '_flycart_wcs_handling_upfront_recurring',
			'meta_value'  => 1,
			'orderby'     => 'date',
			'order'       => 'DESC',
		);
		$subscriptions = get_posts( $post_args );
		return $subscriptions;
	}


	public function get_active_annual_flycart_upfront_billing_cycle_subscriptions() {
		$post_args     = array(
			'post_type'   => 'shop_subscription',
			'post_status' => 'wc-active',
			'numberposts' => -1,
			'date_query'  => array(
				'before' => array(
					'year'  => 2019,
					'month' => 5,
					'day'   => 13,
				),
			),
			'meta_key'    => '_flycart_wcs_upfront_billing_cycle',
			'meta_value'  => 1,
			'orderby'     => 'date',
			'order'       => 'DESC',
		);
		$subscriptions = get_posts( $post_args );
		return $subscriptions;
	}



	public function get_active_old_annual_subscriptions() {
		$post_args         = array(
			'post_type'   => 'shop_subscription',
			'post_status' => 'wc-active',
			'numberposts' => -1,
			'date_query'  => array(
				'before' => array(
					'year'  => 2019,
					'month' => 5,
					'day'   => 13,
				),
			),
			'orderby'     => 'date',
			'order'       => 'DESC',
		);
		$subscriptions     = get_posts( $post_args );
		$old_subscriptions = array();
		foreach ( $subscriptions as $subscription_obj ) {
			$flycart_key = get_post_meta( $subscription_obj->ID, '_flycart_wcs_handling_upfront_recurring', true );
			if ( empty( $flycart_key ) || false == $flycart_key ) {
				$subscription = wcs_get_subscription( $subscription_obj->ID );
				foreach ( $subscription->get_items() as $key => $item_obj ) {
					$pay_upfront_flag = wc_get_order_item_meta( $key, '_flycart_wcs_pay_upfront', true );
					if ( isset( $pay_upfront_flag ) && 1 == $pay_upfront_flag ) {
						$old_subscriptions[] = $subscription_obj;
					} elseif ( $subscription->get_total() > 200 ) {
						$old_subscriptions[] = $subscription_obj;
					}
				}
			}
		}
		return $old_subscriptions;
	}

	public function load_quarterly_renewal_subscriptions() {
		$post_args = array(
			'post_type'   => 'shop_subscription',
			'post_status' => 'wc-active',
			'numberposts' => -1,
			'meta_key'    => '_schedule_next_payment',
			'orderby'     => 'meta_value_date',
			'order'       => 'ASC',
		);

		$subscriptions           = get_posts( $post_args );
		$quarterly_subscriptions = array();
		foreach ( $subscriptions as $subscription_obj ) {
			$flycart_key = get_post_meta( $subscription_obj->ID, '_flycart_wcs_handling_upfront_recurring', true );
			if ( empty( $flycart_key ) || false == $flycart_key ) {
				$subscription = wcs_get_subscription( $subscription_obj->ID );
				foreach ( $subscription->get_items() as $key => $item_obj ) {
					$pay_upfront_flag = wc_get_order_item_meta( $key, '_flycart_wcs_pay_upfront', true );
					if ( ! ( isset( $pay_upfront_flag ) && 1 == $pay_upfront_flag ) || $subscription->get_total() < 200 ) {
						if ( ! array_key_exists( $subscription_obj->ID, $quarterly_subscriptions ) ) {
							$scheduled_payment_date                           = get_post_meta( $subscription_obj->ID, '_schedule_next_payment', true );
							$quarterly_subscriptions[ $subscription_obj->ID ] = strtotime( $scheduled_payment_date );
						}
					}
				}
			}
		}
		asort( $quarterly_subscriptions );
		?>
		<table class="widefat striped">
			<thead>
				<th>Subscription ID</th>
				<th>Next payment date</th>
			</thead>
			<tfoot>
				<th>Subscription ID</th>
				<th>Next payment date</th>
			</tfoot>
			<tbody>
		<?php
		foreach ( $quarterly_subscriptions as $quarterly_id => $quarterly_renewal_date ) {
			$scheduled_payment_date = get_post_meta( $quarterly_id, '_schedule_next_payment', true );
			$link                   = get_site_url() . '/wp-admin/post.php?post=' . $quarterly_id . '&action=edit';
				echo "<tr><td><a target='_blank' href='$link'>$quarterly_id</a></td><td>$scheduled_payment_date</td></tr>";
		}
		?>
			</tbody>
		</table>
		<?php
	}

	public function render_quarterly_subscription_overview_page() {
		ob_start();
		echo '<h2>Overview on Quarterly Subscriptions</h2>';
		echo $this->load_quarterly_renewal_subscriptions();
		echo ob_get_clean();
	}
}
