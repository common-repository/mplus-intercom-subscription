<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package Mplus_Intercom_Subscription
 * @subpackage Mplus_Intercom_Subscription/includes
 * @author 79mplus
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

if ( ! class_exists( 'Mplus_Intercom_Subscription_Admin' ) ) {
	class Mplus_Intercom_Subscription_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var string $version The current version of this plugin.
		 */
		private $version;

		/**
		 * Initializes the class and sets its properties.
		 *
		 * @since 1.0.0
		 *
		 * @param string $plugin_name The name of this plugin.
		 * @param string $version The version of this plugin.
		 * @return void
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version = $version;

		}

		/**
		 * Registers the stylesheets for the admin area.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function mplus_enqueue_styles() {

		}

		/**
		 * Registers the JavaScript for the admin area.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function mplus_enqueue_scripts() {
			wp_enqueue_script( $this->plugin_name, MPLUSIS_PLUGINS_DIR_URI . 'assets/js/mplus-intercom-subscription-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'waitme', MPLUSIS_PLUGINS_DIR_URI . 'assets/js/waitMe.min.js', array( 'jquery' ), $this->version, false );
			wp_register_script( 'mplusis_settings_script', MPLUSIS_PLUGINS_DIR_URI . 'assets/js/mplus-intercom-subscription-settings.js', array( 'jquery' ), $this->version, false );
			wp_register_style( 'mplusis_settings_style', MPLUSIS_PLUGINS_DIR_URI . 'assets/css/mplus-intercom-subscription-settings.css' );
			wp_enqueue_style( 'waitme', MPLUSIS_PLUGINS_DIR_URI . 'assets/css/waitMe.min.css' );
		}

		/**
		 * Prepares plugin row meta.
		 *
		 * @since 1.0
		 *
		 * @param array $links Links sent to function.
		 * @param string $file Filename sent to function.
		 * @return array
		 */
		public function mplus_plugin_row_meta( $links, $file ) {

			if ( strpos( $file, $this->plugin_name . '.php' ) !== false  ) :
				$links[] = sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'https://docs.79mplus.com/intercom-subscription-base-plugin/' ), __( 'Docs', 'mplus-intercom-subscription' )  );
				$links[] = sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'https://www.79mplus.com/intercom-subscription/' ), __( 'Premium Addons', 'mplus-intercom-subscription' )  );
			endif;

			return $links;

		}

		/**
		 * Prepares plugin action links.
		 *
		 * @since 1.0
		 *
		 * @param array $actions Actions sent to function.
		 * @param string $plugin_file Plugin filename sent to function.
		 * @return array
		 */
		public function mplus_add_action_links( $actions, $plugin_file ) {

			if ( strpos( $plugin_file, $this->plugin_name . '.php' ) !== false  ) :

				$actions['settings'] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( "admin.php?page=mplusis-settings" ) ), __( 'Settings', 'mplus-intercom-subscription' )  );
			endif;

			return $actions;

		}

		/**
		 * save settings
		 */
		public function save_settings(){
			if(check_ajax_referer('mplus-settings')){
				foreach($_POST['values'] as $option => $val){
					update_option($option, $val);
				}
				mplusis_log("Settings saved.");
			}
		}

		/**
		 * create a page with the shortcode to render the lead creation form.
		 */
		public function create_lead_generation_page(){
			// Set up the page data
			if(check_ajax_referer('mplus-settings')){
				$page_data = array(
					'post_title'    => 'Intercom Lead Generation',
					'post_content'  => '[mplus_intercom_subscription]',
					'post_status'   => 'publish',
					'post_type'     => 'page', // Use 'post' for a blog post
				);
	
				// Insert the page into the database
				$page_id = wp_insert_post($page_data);
	
				// Check if the page was created successfully
				if ($page_id) {
					$page_url = get_permalink($page_id);
					$mplusis_shortcode_rendered = get_option('mplusis_shortcode_rendered', []);
					$mplusis_shortcode_rendered[] = $page_url;
					update_option('mplusis_shortcode_rendered', $mplusis_shortcode_rendered);
					wp_send_json_success([$page_url]);
				} else {
					wp_send_json_error();
				}
			}
		}

		/**
		 * submit the support form
		 */
		public function submit_mplusis_support_form(){

			// Unserialize the form data
			 $unserialized_data = wp_parse_args($_POST['formData']);
		 
			 // Now, you can access individual form fields as an associative array
			 $name = sanitize_text_field(urldecode($unserialized_data['name']));
			 $email = sanitize_email(urldecode($unserialized_data['email']));
			 $message = nl2br(urldecode($unserialized_data['message']));
		
			// Additional validation and processing if needed
		
			// Set email content type to HTML
			add_filter('wp_mail_content_type', 'mplusis_set_html_content_type');
		
			// Compose the email message with a table
			$body = '<table cellpadding="15">';
			$body .= '<tr><td><strong>Name:</strong></td><td>' . esc_html($name) . '</td></tr>';
			$body .= '<tr><td><strong>Email:</strong></td><td>' . esc_html($email) . '</td></tr>';
			$body .= '<tr><td><strong>Message:</strong></td><td>' . $message . '</td></tr>';
			$body .= '</table>';
		
			// Send email
			wp_mail('support@79mplus.com', 'New Support Form Submission', $body);
		
			// Remove the filter to avoid affecting other emails
			remove_filter('wp_mail_content_type', 'mplusis_set_html_content_type');

			/* if the form is submitted after a promo notice close, don't show the promo again */
			if( isset( $unserialized_data[ 'promo_key' ] ) ){
				$removed_promo = get_option( 'mplusis_removed_promo', [] );
				$removed_promo[] = $unserialized_data[ 'promo_key' ];
				update_option('mplusis_removed_promo', $removed_promo);
			}

		
			// Optionally, you can send a response back to the client
			wp_send_json_success(array('status' => 'success'));
		
			// Always exit to avoid extra output
			wp_die();
		}

		/**
		 * init the promo notice class
		 */
		public function promo_notice(){
			new Mplus_Intercom_Subscription_Promo_Notice();
		}

		/**
		 * license activation pages are moved to the new settings page.
		 * redirect from the old page to new page.
		 * 
		 * @since 3.0.0
		 */
		public function redirect_old_license_activation_link_to_new_settings($die_handler){
			if (isset($_GET['page']) && $_GET['page'] === 'mplusis-license-activation') {
				// Preserve other query parameters
				$query_params = array_diff_key($_GET, array('page' => ''));
		
				// Redirect to 'admin.php?page=mplusis-settings' with preserved query parameters
				wp_safe_redirect(admin_url('admin.php?page=mplusis-settings' . '&' . http_build_query($query_params)) . "#mplusis-license-page");
				exit();
			}
			return $die_handler;
		}

	}
}
