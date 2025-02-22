<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/dharmesh351991
 * @since      1.0.0
 *
 * @package    Custom_Inquiry_Form
 * @subpackage Custom_Inquiry_Form/admin/partials
 */

/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class WPCustomInquiry {
	private $wp_custom_inquiry_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wp_custom_inquiry_listing_menu' ) );
		add_action( 'admin_menu', array( $this, 'wp_custom_inquiry_settings_menu' ) );
		add_action( 'admin_init', array( $this, 'wp_custom_inquiry_page_init' ) );
	}

	public function wp_custom_inquiry_listing_menu() {
		add_menu_page(
			'WP Custom Inquiry',
			'Inquiry Listing',
			'manage_options',
			'wp-custom-inquiry-listing',
			 array( $this, 'wp_custom_inquiry_lising_cb' ),
			'dashicons-email',
			 61
		);
	}

	public function wp_custom_inquiry_settings_menu() {
		add_submenu_page(
			'wp-custom-inquiry-listing', 
			'WP Inquiry Settings', 
			'Inquiry Settings', 
			'manage_options',
			'wp_inquiry_settings', 
			 array( $this, 'wp_custom_inquiry_settings_cb' )
		);
	}

	public function wp_custom_inquiry_lising_cb() {
		global $wpdb;
	    $table = new WP_Custom_inquiry();
	    if(isset($_REQUEST['s'])){
	        $table->prepare_items($_REQUEST['s']);
	    } else {
	        $table->prepare_items();
	    }
	    $message = '';
	    if ('delete' === $table->current_action()) {
	        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'Songs_list_table'), count($_REQUEST['id'])) . '</p></div>';
	    }
	    ?>
	    <div class="wp-custom-heading" style="clear: both;">
				<h2>WP Custom Inquiry Listing</h2>
				<p>This page used for listing of all inquiries submitted by users will be displayed. </p>
			  </div>
		<div class="wrap">
		    <?php echo $message; ?>
		    <form id="songs-table" method="GET">
		        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
		        <?php 
		        	$table->search_box('Search', 'search');
			        $table->display();
		        ?>
		    </form>
		</div> 
	<?php }

	public function wp_custom_inquiry_settings_cb() {
		$this->wp_custom_inquiry_options = get_option( 'wp_custom_inquiry_option_name' );
		?>
		<div class="wp-custom-heading" style="clear: both;">
			<h2>WP Custom Inquiry Settings</h2>
		  </div>
		<div class="wrap">
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'wp_custom_inquiry_option_group' );
					do_settings_sections( 'wp-custom-inquiry-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function wp_custom_inquiry_page_init() {
		register_setting(
			'wp_custom_inquiry_option_group',
			'wp_custom_inquiry_option_name',
			array( $this, 'wp_custom_inquiry_sanitize' )
		);
		add_settings_section(
			'wp_custom_inquiry_setting_admin',
			'1. Admin Settings',
			array( $this, 'wp_custom_inquiry_admin_fields' ),
			'wp-custom-inquiry-admin'
		);
		add_settings_section(
			'wp_custom_inquiry_setting_front',
			'2. User Settings',
			array( $this, 'wp_custom_inquiry_user_fields' ),
			'wp-custom-inquiry-admin'
		);
		add_settings_field(
			'email',
			'To Email',
			array( $this, 'email_callback' ),
			'wp-custom-inquiry-admin',
			'wp_custom_inquiry_setting_admin'
		);
		add_settings_field(
			'user_message',
			'Email Success Message',
			array( $this, 'user_success_email_msg_cb' ),
			'wp-custom-inquiry-admin',
			'wp_custom_inquiry_setting_front'
		);
		add_settings_field(
			'user_success',
			'Success Message',
			array( $this, 'user_success_msg_cb' ),
			'wp-custom-inquiry-admin',
			'wp_custom_inquiry_setting_front'
		);
		add_settings_field(
			'user_error',
			'Error Message',
			array( $this, 'user_error_msg_cb' ),
			'wp-custom-inquiry-admin',
			'wp_custom_inquiry_setting_front'
		);
	}
	public function wp_custom_inquiry_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['email'] ) ) {
			$sanitary_values['email'] = sanitize_text_field( $input['email'] );
		}
		if ( isset( $input['user_message'] ) ) {
			$sanitary_values['user_message'] = sanitize_text_field( $input['user_message'] );
		}
		if ( isset( $input['user_success'] ) ) {
			$sanitary_values['user_success'] = sanitize_text_field( $input['user_success'] );
		}
		if ( isset( $input['user_error'] ) ) {
			$sanitary_values['user_error'] = sanitize_text_field( $input['user_error'] );
		}
		return $sanitary_values;
	}
	public function wp_custom_inquiry_admin_fields() {
	}
	public function wp_custom_inquiry_user_fields() {
	}
	public function email_callback() {
		printf(
			'<input class="regular-text" type="email" name="wp_custom_inquiry_option_name[email]" id="email" value="%s"><i>Leave it blank if you want to send it to wp admin Email.</i>',
			isset( $this->wp_custom_inquiry_options['email'] ) ? esc_attr( $this->wp_custom_inquiry_options['email']) : ''
		);
	}
	public function user_success_email_msg_cb() {
		printf(
			'<textarea class="regular-text" name="wp_custom_inquiry_option_name[user_message]" id="user_message">%s</textarea>',
			isset( $this->wp_custom_inquiry_options['user_message'] ) ? esc_attr( $this->wp_custom_inquiry_options['user_message']) : ''
		);
	}
	public function user_success_msg_cb() {
		printf(
			'<textarea class="regular-text" name="wp_custom_inquiry_option_name[user_success]" id="user_success">%s</textarea>',
			isset( $this->wp_custom_inquiry_options['user_success'] ) ? esc_attr( $this->wp_custom_inquiry_options['user_success']) : ''
		);
	}
	public function user_error_msg_cb() {
		printf(
			'<textarea class="regular-text" name="wp_custom_inquiry_option_name[user_error]" id="user_error">%s</textarea>',
			isset( $this->wp_custom_inquiry_options['user_error'] ) ? esc_attr( $this->wp_custom_inquiry_options['user_error']) : ''
		);
	}

}
if ( is_admin() )
	$wp_custom_inquiry = new WPCustomInquiry();

