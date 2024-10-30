<?php 
/**
* 
*/
class CIF_InquiryAjax 
{
	
	public function __construct()
	{
		add_action( 'wp_ajax_cb_submit_inquiry', array($this,'CIF_submit_inquiry_cb') );
		add_action( 'wp_ajax_nopriv_cb_submit_inquiry', array($this,'CIF_submit_inquiry_cb') );
	}
	public function CIF_submit_inquiry_cb()
	{

		$params = array();
    	parse_str($_POST['data'], $params);
    	$name = sanitize_text_field($params['name']);
    	$email = sanitize_email($params['email']);
    	$subject = sanitize_text_field($params['subject']);
    	$phone = sanitize_text_field($params['phone']);
    	$website = esc_url($params['website']);
    	$message = esc_html($params['message']);

    	/*====Variables for send Email to Admin======*/
    	$option_array = get_option( 'wp_custom_inquiry_option_name' );
		$user_success = esc_html($option_array['user_success']);
		$user_error = esc_html($option_array['user_error']);
		$user_message = esc_html($option_array['user_message']);
		$to_email = sanitize_email($option_array['email']);
		$to_email = (!empty($to_email) ? $to_email : get_bloginfo('admin_email ') );

		/*=====Set Message if not updated on Backend==========*/
		$success_msg = 'Inquiry submited successfully....';
		$error_msg = 'Something went wrong while submitting...';
		$default_msg = 'Thanks for your email and our team will get back to you shortly.';
		$user_message = (!empty($user_message) ? $user_message : $default_msg);
		$user_email_msg = '<p style="color: #565656; font-size: 14px;">Dear '.$name.'</p><p style="color: #565656; font-size: 14px;">'.$default_msg.'</p><p style="color: #565656; font-size: 14px;">Regards,</p><p style="color: #565656; font-size: 14px;">'.get_bloginfo('name').',</p><p style="color: #565656; font-size: 14px;"><a href="'.get_site_url().'" target="_top">'.get_site_url().'</a></p>';
		$user_success = (!empty($user_success) ? $user_success : $success_msg);
		$user_error = (!empty($user_error) ? $user_error : $error_msg);

    	global $wpdb;
		$table_name = $wpdb->prefix."custom_inquiry_az";
		$insert = $wpdb->insert($table_name, array(
		                'id' => '',
		                'name' => $name,
		                'email' => $email,
		                'subject' => $subject,
		                'phone' => $phone,
		                'website' => $website,
		                'message' => $message
		            )
		        );
		if($insert)
		{
			echo json_encode(array('status'=>'true','message'=>$user_success));

			/*=============Admin Email Sent Script=============*/

			$email_subject = 'WP Custom Inquiry | '.get_bloginfo( 'name' );
		    $admin_msg = '<table style="border-collapse:collapse;border-spacing:0;border-color:#999;table-layout: fixed; width: 100%"><colgroup><col style="width: 101px"><col style="width: 225px"></colgroup><tr><th style="font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;text-align:center;vertical-align:top" colspan="2">WP Custom Inquiry</th></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;font-weight:bold;vertical-align:top">Name</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;vertical-align:top">'.$name.'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;font-weight:bold;vertical-align:top">Email</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;vertical-align:top">'.$email.'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;font-weight:bold;vertical-align:top">Subject </td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;vertical-align:top">'.$subject.'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;font-weight:bold;vertical-align:top">Phone</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;vertical-align:top">'.$phone.'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;font-weight:bold;vertical-align:top">Website</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;vertical-align:top">'.$website.'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;font-weight:bold;vertical-align:top">Message</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;vertical-align:top">'.$message.'</td></tr></table>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $to_email, $email_subject, $admin_msg,$headers );

			/*==========User Email Script================*/
			$email_subject_user = 'Auto reply | '.get_bloginfo( 'name' );
			$d = wp_mail( $email, $email_subject_user, $user_email_msg,$headers );
		}
		else
		{
			echo json_encode(array('status'=>'false','message'=>$user_error));
		}
		exit();
	}
}

new CIF_InquiryAjax();