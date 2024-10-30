<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/dharmesh351991
 * @since             1.1.0
 * @package           Custom_Inquiry_Form
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Inquiry Form
 * Plugin URI:        http://www.archanaengineering.com/
 * Description:       Wordpress custom Inquiry for users inquiry with option page listed inquiries.
 * Version:           1.1.0
 * Author:            Dharmesh B Panchal
 * Author URI:        https://profiles.wordpress.org/dharmesh351991
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-inquiry-form
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CIF_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-inquiry-form-activator.php
 */
function activate_custom_inquiry_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-inquiry-form-activator.php';
	Custom_Inquiry_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-inquiry-form-deactivator.php
 */
function deactivate_custom_inquiry_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-inquiry-form-deactivator.php';
	Custom_Inquiry_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_inquiry_form' );
register_deactivation_hook( __FILE__, 'deactivate_custom_inquiry_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-inquiry-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_inquiry_form() {

	$plugin = new Custom_Inquiry_Form();
	$plugin->run();

}
run_custom_inquiry_form();
