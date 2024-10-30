<?php

/**
 * Manages Shortcodes functionality of this plugin.
 *
 * @package Mplus_Intercom_Subscription
 * @subpackage Mplus_Intercom_Subscription/includes
 * @author 79mplus
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

if ( ! class_exists( 'Mplus_Intercom_Subscription_Shortcode' ) ) {
	class Mplus_Intercom_Subscription_Shortcode {

		/**
		 * Constructs the class.
		 *
		 * @return void
		 */
		function __construct() {

		}

		/**
		 * Handles the [mplus_intercom_subscription] shortcode.
		 *
		 * @param array $atts Holds the shortcode parameters.
		 * @return string Returns html for the ouput.
		 */
		public function mplus_intercom_subscription( $atts ) {

			if ( ! is_admin() && get_option( 'mplusis_api_key' ) ) {
				// Generates shortcode output.
				$html = mplus_intercom_subscription_get_template( 'mplus-intercom-subscription-shortcode.php' );
				mplusis_log("rendered [mplus_intercom_subscription] shortcode. attributes: " . serialize($atts), 'base', true);
				$mplusis_shortcode_rendered = get_option('mplusis_shortcode_rendered', []);
				$url = mplusis_get_current_url();
				if( ! in_array( $url, $mplusis_shortcode_rendered ) ){
					$mplusis_shortcode_rendered[] = $url;
					update_option('mplusis_shortcode_rendered', $mplusis_shortcode_rendered);
				}
				return $html;
			} else {
				return '';
			}

		}

		/**
		 * Handles the [mplus_intercom_subscription_company] shortcode.
		 *
		 * @param array $atts Holds the shortcode parameters.
		 * @return string Returns html for the ouput.
		 */
		public function mplus_intercom_subscription_company( $atts ) {

			if ( ! is_admin() && get_option( 'mplusis_api_key' ) ) {
				// Generates shortcode output.
				$html = mplus_intercom_subscription_get_template( 'mplus-intercom-subscription-company-shortcode.php' );
				mplusis_log("rendered [mplus_intercom_subscription_company] shortcode. attributes: " . serialize($atts), 'base', true);
				$mplusis_shortcode_rendered = get_option('mplusis_shortcode_rendered', []);
				$url = mplusis_get_current_url();
				if( ! in_array( $url, $mplusis_shortcode_rendered ) ){
					$mplusis_shortcode_rendered[] = $url;
					update_option('mplusis_shortcode_rendered', $mplusis_shortcode_rendered);
				}
				return $html;
			} else {
				return '';
			}

		}
	}
}
