<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/dharmesh351991
 * @since      1.0.0
 *
 * @package    Custom_Inquiry_Form
 * @subpackage Custom_Inquiry_Form/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Inquiry_Form
 * @subpackage Custom_Inquiry_Form/includes
 * @author     Dharmesh B Panchal <ddharmesh.panchal@gmail.com>
 */
class Custom_Inquiry_Form_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-inquiry-form',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
