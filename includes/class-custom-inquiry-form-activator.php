<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/dharmesh351991
 * @since      1.0.0
 *
 * @package    Custom_Inquiry_Form
 * @subpackage Custom_Inquiry_Form/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Custom_Inquiry_Form
 * @subpackage Custom_Inquiry_Form/includes
 * @author     Dharmesh B Panchal <ddharmesh.panchal@gmail.com>
 */
class Custom_Inquiry_Form_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'custom_inquiry_az';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	            id int(11) NOT NULL AUTO_INCREMENT,
		        name varchar(255) DEFAULT NULL,
		        email varchar(50) DEFAULT NULL,
		        subject varchar(50) DEFAULT NULL,
		        phone varchar(50) DEFAULT NULL,
		        website varchar(50) DEFAULT NULL,
		        message text,
		        time datetime DEFAULT CURRENT_TIMESTAMP,
		        UNIQUE KEY id (id)
	    ) $charset_collate;";
	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	    dbDelta( $sql );

	}

}
