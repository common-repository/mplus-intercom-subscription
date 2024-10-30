<?php

/**
 * Manages Admin settings
 *
 * @package Mplus_Intercom_Subscription
 * @subpackage Mplus_Intercom_Subscription/includes
 * @author 79mplus
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

if ( ! class_exists( 'Mplus_Intercom_Subscription_Settings' ) ) {
	class Mplus_Intercom_Subscription_Settings {

		/**
		 * To hold manu page ID.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @var string $menupage Hold Menu page Id.
		 */
		protected $menupage;

		/**
		 * Constructs the class.
		 *
		 * @return void
		 */
		function __construct() {

		}

		/**
		 * Creates the admin menu for API settings.
		 *
		 * @return void
		 */
		function mplusis_admin_menu() {

			$this->menupage = add_menu_page( 'Intercom Subscription', 'Intercom Subscription', 'manage_options', 'mplusis-settings', array( $this, 'mplusis_personal_token_settings' ), plugins_url( MPLUSIS_NAME . '/assets/images/admin-icon.png' ), 27 );
			//$this->license_menu = add_submenu_page( 'mplusis-settings', 'License Activation', 'License Activation', 'manage_options', 'mplusis-license-activation', array( $this, 'mplusis_licence_activation_submenu' ) );
			add_action( "load-{$this->menupage}", array( $this, 'mplusis_settings_help' ) );

		}

		/**
		 * Shows Intercom Personal Access Token Fields.
		 *
		 * @return void
		 */
		public function mplusis_personal_token_settings() {

			if(isset($_GET['disconnect'])){
				delete_option('mplusis_api_key');
			}
			$settings = Mplus\Intercom\Settings\Settings::get();
			$settings->render();
		}

		public function maybe_delate_api_key( $option, $old_value, $value ) {
			if( 'mplusis_own_api_key' == $option && $old_value ){
				delete_option('mplusis_api_key');
			}
		}

		/**
		 * Displays Help page.
		 *
		 * @since 1.0
		 * @return null|void
		 */
		function mplusis_settings_help() {

			$screen = get_current_screen();

			if ( $screen->id != $this->menupage )
				return;

			$screen->add_help_tab( array(
				'id'      => 'mplusis_settings_overview',
				'title'   => __( 'Overview', 'mplus-intercom-subscription' ),
				'content' => sprintf(
					/* translators: %s: link location */
					__( "<h3>Intercom Subscription Plugin</h3><p>The easiest and most extendable WordPress plugin for Intercom. This lets you offer a subscription form for Intercom and offers a wide range of extensions to grow your user base with the power of Intercom.<br/>Please <a target='_blank' href='%s'>click here</a> to get more information.</p>", 'mplus-intercom-subscription' ),
					esc_url( 'https://www.79mplus.com/' ) ),
			));

			$screen->add_help_tab( array(
				'id'      => 'mplusis_settings_info',
				'title'   => __( 'Settings', 'mplus-intercom-subscription' ),
				'content' => self::mplusis_settings_connect(),
			) );

			/* Set Help Sidebar */
			$screen->set_help_sidebar(
				'<p><strong>' . __( 'For more information:', 'mplus-intercom-subscription' ) . '</strong></p>' .
				'<p><a href="https://wordpress.org/plugins/mplus-intercom-subscription/#faq" target="_blank">' . __( 'FAQ', 'mplus-intercom-subscription' ) . '</a></p>' .
				'<p><a href="https://wordpress.org/support/plugin/mplus-intercom-subscription" target="_blank">' . __( 'Support Forum', 'mplus-intercom-subscription' ) . '</a></p>'
			);

		}

		/**
		 * Returns Help page content.
		 *
		 * @since 1.0
		 *
		 * @return string
		 */
		public static function mplusis_settings_connect() {

			return sprintf(
				/* translators: 1: link location 2: link location */
				__( '
			<p><strong>Where is Intercom Access Token?</strong></p>
			<ol>
				<li>Please visit <a target="_blank" href="%1$s">Intercom Application</a> to get more about Intercom Access Token.</li>
			</ol>

			<p><strong>I am new. How do I get access token?</strong> Please follow the instruction below to create a Intercom Access Token:</p>
			<ol>
				<li>To create your Access Token, go to the dashboard in the Intercom Developer Hub by <a target="_blank" href="%2$s">clicking here</a> or by clicking on Dashboard at the top of the page and click <strong>"Get an Access Token"</strong></li>
				<li>When you setup your Token, you will be asked to choose between two levels of scopes. Select Your Scopes.</li>
				<li>Once you have created your Access Token you will see it in the same section in your Dashboard. You can edit or delete the token from <a target="_blank" href="%3$s">here</a>.</li>
			</ol>
			', 'mplus-intercom-subscription' ), 'https://developers.intercom.com/docs/personal-access-tokens', 'https://app.intercom.com/a/developer-signup', 'https://app.intercom.com/a/developer-signup' );

		}

		/**
		 * Displays admin notice.
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		function mplusis_admin_notices() {

			/* Get the options */
			$access_token = get_option( 'mplusis_api_key' );

			$page = ( isset( $_GET['page'] ) ? $_GET['page'] : null );

			if ( empty( $access_token ) && $page != 'mplusis-settings' && current_user_can( 'manage_options' ) ) :
				echo '<div class="error fade">';
					echo '<p>' . sprintf(
						/* translators: 1: anchor tag start 2: anchor tag end */
						__( 'Intercom Subscription Plugin is almost ready. Please %1$sconnect to Intercom%2$s to use the plugin.', 'mplus-intercom-subscription' ),
						'<a href="admin.php?page=mplusis-settings">', '</a>'
						) . '</p>';
				echo '</div>';
			endif;

			$phpversion = phpversion();

			if ( $phpversion < 7.1 ) :
				echo '<div class="error fade">';
					echo '<p>' . sprintf(
						/* translators: 1: anchor tag start 2: anchor tag end */
						__( 'Intercom Subscription plugin uses %1$sofficial PHP bindings to the Intercom API%2$s. This library supports PHP 7.1 and later. Your web server has PHP version %3$s, which doesn\'t meet the requirement for this to work as expected.', 'mplus-intercom-subscription' ), '<a href="https://github.com/intercom/intercom-php" target="_blank">', '</a>', $phpversion ) . '</p>';
				echo '</div>';
			endif;

		}

		/**
		 * Renders License Activation page contents
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		public function mplusis_licence_activation_submenu() {

			$page = $_GET['page'];
			$addons = apply_filters( 'mplus_intercom_subscription_addon_license_tabs', array() );
			if ( ! empty( $addons ) ) {
				$active_addon = isset( $_GET['addon'] ) ? $_GET['addon'] : key( $addons );
				echo '<h2 class="nav-tab-wrapper">';

				foreach( $addons as $addon => $label ) {
					$nav_class = ( $active_addon == $addon ) ? 'nav-tab-active' : '';
					echo '<a href="?page=' . $page . '&addon=' . $addon . '" class="nav-tab ' . $nav_class . '">' . $label . '</a>';
				}
				echo '</h2>';

				do_action( 'mplus_intercom_subscription_addon_licence_activation_form', $active_addon );
			} else {
				echo '<h2>' . __( 'No Premium Addon Found', 'mplus-intercom-subscription' ) . '</h2>';
			}
		}

		/**
		 * Gets all page select options
		 *
		 * @since 1.0
		 *
		 * @return string
		 */
		static public function mplusis_get_all_page_select_options() {

			$pages = get_pages();
			$pages_options = '<option value="">' . __( 'Select Page', 'mplus-intercom-subscription' ) . '</option>';

			foreach ( $pages as $page ) :
				if ( get_page_link( $page->ID ) == get_option( 'mplusis_subscribe_company_register_page' ) ) :
					$selected = 'selected="selected"';
				else :
					$selected = '';
				endif;
				$pages_options .= '<option value="' . get_page_link( $page->ID ) . '" ' . $selected . '>' . __( ucwords( $page->post_title ), 'mplus-intercom-subscription' ) . '</option>';
			endforeach;

			return $pages_options;
		}
	}
}
