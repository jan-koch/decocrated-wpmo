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
	}

	public function render_admin_page() {
		ob_start();
		$subscriptions = $this->get_active_subscriptions();
		echo 'Found ' . count( $subscriptions ) . ' active subscriptions<br />';
		$missing_renewals = array();
		foreach ( $subscriptions as $subscription ) {
			if ( ! in_array( $subscription->ID, $missing_renewals ) ) {
				$has_renewal = $this->subscription_did_create_renewal( $subscription );
				if ( ! $has_renewal ) {
					$missing_renewals[] = $subscription->ID;
				}
			}
		}

		echo '<br ><br >' . count( $missing_renewals ) . ' renewals are missing.';
		echo ob_get_clean();
	}


	public function get_active_subscriptions() {
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
			'orderby'     => 'date',
			'order'       => 'DESC',
		);
		$subscriptions = get_posts( $post_args );
		return $subscriptions;
	}

	public function subscription_did_create_renewal( $post_obj ) {
		$subscription = wcs_get_subscription( $post_obj->ID );
		if ( ! is_a( $subscription, 'WC_Subscription' ) ) {
			return;
		}

		$renewals = wpm_get_renewal_orders_in_subscription( $subscription->get_id() );
		foreach ( $renewals as $renewal ) {
			$renewal_order          = wc_get_order( $renewal );
			$renewal_order_id       = $renewal_order->get_id();
			$renewal_timestamp      = strtotime( $renewal_order->get_date_created( 'view' ) );
			$summer_start_timestamp = strtotime( '13.05.2019' );
			$renewal_created        = false;
			$subscription_edit_page = get_site_url() . '/wp-admin/post.php?post=' . $subscription->get_id() . '&action=edit';
			$renewal_edit_page      = get_site_url() . '/wp-admin/post.php?post=' . $renewal_order_id . '&action=edit';
			// If the renewal contains the Summer box, the subscription renewed successfully.
			$order_items = $renewal_order->get_items();
			foreach ( $order_items as $key => $item ) {
				$product_id   = $item->get_product_id();
				$variation_id = $item->get_variation_id();

				if ( 15940 == $variation_id && $renewal_timestamp > $summer_start_timestamp ) {
					echo '<br />Subscription <a href="' . $subscription_edit_page . '" target="_blank">'
						. $subscription->get_id() . '</a> created Summer renewal order: '
						. '<a href="' . $renewal_edit_page . '" target="_blank">' . $renewal_order_id . '</a>';
					return true;
				}
			}

			// If the renewal has been created after summer time, please a mark.
			if ( ! $renewal_created ) {
				echo '<br /><span style="color:red;">Subscription '
				. '<a href="' . $subscription_edit_page . '" target="_blank">' . $subscription->get_id() . '</a> has no renewal</span>';
			}
		}
		return false;
	}
}
