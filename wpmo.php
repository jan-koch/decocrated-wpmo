<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpmastery.xyz
 * @since             1.0.0
 * @package           Wpmo
 *
 * @wordpress-plugin
 * Plugin Name:       Order Management
 * Plugin URI:        https://decocrated.com
 * Description:       This plugin renders overview pages for subscription data inside WP admin.
 * Version:           1.1.0
 * Author:            Jan Koch | WP Mastery
 * Author URI:        https://wpmastery.xyz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpmo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPMO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpmo-activator.php
 */
function activate_wpmo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpmo-activator.php';
	Wpmo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpmo-deactivator.php
 */
function deactivate_wpmo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpmo-deactivator.php';
	Wpmo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpmo' );
register_deactivation_hook( __FILE__, 'deactivate_wpmo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpmo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpmo() {
	$plugin = new Wpmo();
	$plugin->run();
}
run_wpmo();
