<?php

namespace Mplus\Intercom\Settings;

class Settings {
	private $pages;

	public static $instance = null;

	public function __construct() {
		$pages = [
			'mplusis_welcome_page' => [
				'menu_title'	=> __( 'Welcome', 'mplus-intercom-subscription' ),
				'page_title'	=> __( 'Welcome to Intercom Live chat and Lead generation plugin', 'mplus-intercom-subscription' ),
				'menu_description' => __( 'Get help, account info', 'mplus-intercom-subscription' ),
				'fields' => [
					'intercom_connect_button' => [
						'type'		=> 'html',
						'content' 	=> [$this, 'intercom_plugin_welcome_page']
					],
				]
			],
			'mplusis_base_settings' => [
				'menu_title'       => __( 'Basic Setup', 'mplus-intercom-subscription' ),
				'page_title'       => __( 'Intercom Basic Setup', 'mplus-intercom-subscription' ),
				'menu_description' => __( 'Something about the addon', 'mplus-intercom-subscription' ),
				'page_icon'        => 'mplus-icon-home',
				'fields'           => [
					'intercom_authentication' => [
						'type'   => 'group-fields',
						'label'  => __( 'Subscription Type', 'mplus-intercom-subscription' ),
						'fields' => [
							'intercom_connect_button' => [
								'type'		=> 'html',
								'content' 	=> [$this, 'intercom_connect_section']
							],
							'mplusis_own_api_key' => [
								'type'       => 'checkbox',
								'label'      => __( 'Check to use your own Intercom APP', 'mplus-intercom-subscription' ),
								'desc'       => __( '', 'mplus-intercom-subscription' ),
								'value'      => '1',
								'groupfield' => true,
								'default'	 => '1'
							],
							'mplusis_api_key' => [
								'type'        => 'text',
								'label'       => __( 'Access Token', 'mplus-intercom-subscription' ),
								'placeholder' => __( 'your access token...', 'mplus-intercom-subscription' ),
								'desc'        => sprintf(
									__( 'To create your Access Token, go to %1$s and then click &quot;Get an Access Token&quot;. %2$s', 'mplus-intercom-subscription' ),
									sprintf( '<a href="https://app.intercom.com/a/developer-signup" target="_blank">%s</a>', __( 'developer signup', 'mplus-intercom-subscription' ) ),
									sprintf( '<a href="https://developers.intercom.com/docs/build-an-integration/learn-more/authentication/" target="_blank">%s</a>', __( 'more info', 'mplus-intercom-subscription' ) )
								),
								'groupfield'  => true,
							],
						],
						'desc' => '',
						'header' => __( 'Intercom Authentication', 'mplus-intercom-subscription' ),
					],
					'mplusis_subscription_type' => [
						'type'    => 'select',
						'label'   => __( 'Subscription Type', 'mplus-intercom-subscription' ),
						'options' => [
							'user' => 'User',
							'lead' => 'Lead',
						],
						'desc'   => 'Please select Intercom Subscription Type.',
						'header' => __( 'Subscription Type', 'mplus-intercom-subscription' ),
					],
					'mplusis_subscribe_to_intercom' => [
						'type'   => 'checkbox',
						'label'  => __( 'Enable Unsubscribe Checkbox', 'mplus-intercom-subscription' ),
						'desc'   => __( 'Check to show a email unsubscribe checkbox on the form.', 'mplus-intercom-subscription' ),
						'value'  => '1',
						'header' => __( 'Unsubscribe Email', 'mplus-intercom-subscription' ),
					],
					'mplusis_subscribe_company_field' => [
						'type'   => 'checkbox',
						'label'  => __( 'Enable Company Field', 'mplus-intercom-subscription' ),
						'desc'   => __( 'Check to show company select field on the form.', 'mplus-intercom-subscription' ),
						'value'  => '1',
						'header' => __( 'Company Field', 'mplus-intercom-subscription' ),
					],
					'mplusis_subscribe_company_register_page' => [
						'type'    => 'select',
						'label'   => __( 'Subscription Type', 'mplus-intercom-subscription' ),
						'options' => wp_list_pluck( get_pages(), 'post_title', 'guid' ),
						'desc'    => __( 'Please select Intercom Company Registration Page.', 'mplus-intercom-subscription' ),
						'header'  => __( 'Company Registration', 'mplus-intercom-subscription' ),
					],
					'mplusis_subscription_spam_protection' => [
						'type'   => 'checkbox',
						'label'  => __( 'Enable Spam Protection', 'mplus-intercom-subscription' ),
						'desc'   => __( 'Check to enable honeypot spam protection for forms.', 'mplus-intercom-subscription' ),
						'value'  => '1',
						'header' => __( 'Spam Protection', 'mplus-intercom-subscription' ),
					],
					'mplusis_enable_chat' => [
						'type'   => 'checkbox',
						'label'  => __( 'Enable Live Chat', 'mplus-intercom-subscription' ),
						'desc'   => __( 'Check to Show the chat bubble at the bottom.', 'mplus-intercom-subscription' ),
						'value'  => '1',
						'header' => __( 'Live Chat', 'mplus-intercom-subscription' ),
					],
				],
			],

			'intercom-addons' => [
				'menu_title'       => __( 'Add-ons List', 'mplus-intercom-subscription' ),
				'page_title'       => __( 'Intercom Addons List', 'mplus-intercom-subscription' ),
				'menu_description' => __( 'Add-on list page', 'mplus-intercom-subscription' ),
				'page_icon'        => 'mplus-icon-addons',
				'fields'           => [
					'intercom_addons_form' => [
						'type'   => 'group-fields',
						'label'  => __( 'Form Integration', 'mplus-intercom-subscription' ),
						'fields' => [
							'mplusis_intercom_nf' => [
								'type'        => 'addons',
								'label'       => __( 'Ninja Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work any form made with Ninja Forms, so that you can grow userbase when they use the form.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-nf.png',
								'product_id'  => '495574', // '495572',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-nf/',
								'groupfield'  => true,
							],
							'mplusis_intercom_wpf' => [
								'type'        => 'addons',
								'label'       => __( 'WPForms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with the forms offered with WPForms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-wpforms.png',
								'product_id'  => '495838',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-wpforms/',
								'groupfield'  => true,
							],
							'mplusis_intercom_elm' => [
								'type'        => 'addons',
								'label'       => __( 'Elementor', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with the forms offered with Elementor.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/elementor.png',
								'product_id'  => '502349',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-elementor/',
								'groupfield'  => true,
							],
							'mplusis_intercom_cf7' => [
								'type'        => 'addons',
								'label'       => __( 'Contact Form 7', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with Contact Form 7, so that you can use Intercom when an user interacts with your Contact Forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-cf7.png',
								'product_id'  => '495623',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-cf7/',
								'groupfield'  => true,
							],
							'mplusis_intercom_ff' => [
								'type'        => 'addons',
								'label'       => __( 'Formidable Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with the forms offered with Formidable Forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-ff.png',
								'product_id'  => '495852',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-ff/',
								'groupfield'  => true,
							],
							'mplusis_intercom_gf' => [
								'type'        => 'addons',
								'label'       => __( 'Gravity Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with the highly customizable forms made with Gravity Forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-gf.png',
								'product_id'  => '495597',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-gf/',
								'groupfield'  => true,
							],
							'mplusis_intercom_weform' => [
								'type'        => 'addons',
								'label'       => __( 'WeForms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with forms made with WeForms, so that you can connect customers when they use the forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-weform.png',
								'product_id'  => '495638',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-weforms/',
								'groupfield'  => true,
							],
							'mplusis_intercom_fluent_forms' => [
								'type'        => 'addons',
								'label'       => __( 'Fluent Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with forms made with Fluent Forms, so that you can connect customers when they use the forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-ff.png',
								'product_id'  => '502987',
								'product_url' => 'https://www.79mplus.com/product/intercom-subscription-fluent-forms/',
								'groupfield'  => true,
							],
							'mplusis_intercom_forminator' => [
								'type'        => 'addons',
								'label'       => __( 'Forminator Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with forms made with Forminator Forms, so that you can connect customers when they use the forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-ff.png',
								'product_id'  => '503396',
								'product_url' => 'https://www.79mplus.com/product/intercom-subscription-forminator/',
								'groupfield'  => true,
							],
							'mplusis_intercom_metform' => [
								'type'        => 'addons',
								'label'       => __( 'MetForm Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with forms made with MetForm Forms, so that you can connect customers when they use the forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-ff.png',
								'product_id'  => '503422',
								'product_url' => 'https://www.79mplus.com/product/intercom-subscription-forminator/',
								'groupfield'  => true,
							],
							'mplusis_intercom_everest_forms' => [
								'type'        => 'addons',
								'label'       => __( 'Everest Forms', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with forms made with Everest Forms, so that you can connect customers when they use the forms.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-ff.png',
								'product_id'  => '503436',
								'product_url' => 'https://www.79mplus.com/product/intercom-subscription-everest-forms/',
								'groupfield'  => true,
							],
						],
						'desc'         => __( 'Intercom form related addons list.', 'mplus-intercom-subscription' ),
						'header'       => __( 'Form Integration', 'mplus-intercom-subscription' ),
						'addons-group' => true,
					],
					'intercom_woocommerce_addons' => [
						'type'   => 'group-fields',
						'label'  => __( 'Intercom Wooommerce Add-ons', 'mplus-intercom-subscription' ),
						'fields' => [
							'mplusis_intercom_wc' => [
								'type'        => 'addons',
								'label'       => __( 'WooCommerce', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with WooCommerce, so that your customers can be engaged with Intercom when they purchase your products.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-wc.png',
								'product_id'  => '495633',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-wc/',
								'groupfield'  => true,
							],
							'mplusis_intercom_wc_sub' => [
								'type'        => 'addons',
								'label'       => __( 'WooCommerce Subscription', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with WooCommerce Subscription, so that your customers can be engaged with Intercom when they purchase your products.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-wc.png',
								'product_id'  => '502769',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-wcs-event/',
								'groupfield'  => true,
							],
							'mplusis_intercom_wc_book' => [
								'type'        => 'addons',
								'label'       => __( 'WooCommerce Booking', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with WooCommerce Booking, so that your customers can be engaged with Intercom when they purchase your products.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-wc.png',
								'product_id'  => '502768',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-wcb-event/',
								'groupfield'  => true,
							],
						],
						'desc'         => __( 'Intercom wooCommerce related addons list.', 'mplus-intercom-subscription' ),
						'header'       => __( 'E-commerce Integration', 'mplus-intercom-subscription' ),
						'addons-group' => true,
					],
					'intercom_wc_multivendor_addons' => [
						'type'   => 'group-fields',
						'label'  => __( 'Intercom Wooommerce Add-ons', 'mplus-intercom-subscription' ),
						'fields' => [
							'mplusis_intercom_wc_dokan' => [
								'type'        => 'addons',
								'label'       => __( 'Dokan', 'mplus-intercom-subscription' ),
								'desc'        => __( 'This Extension or Add On helps you easily gather and manage users on Intercom with your beloved Dokan store. It is seemlessly customizable and offers a great range of settings. Grow your userbase with the power and flexibility of Dokan.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-dokan.png',
								'product_id'  => '495628',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-dokan/',
								'groupfield'  => true,
							],
							'mplusis_intercom_wc_mvx' => [
								'type'        => 'addons',
								'label'       => __( 'MultivendorX', 'mplus-intercom-subscription' ),
								'desc'        => __( 'This Extension or add-on helps you easily gather and manage users on Intercom with your beloved MultivendorX-enabled website. It is seemlessly customizable and offers a great range of settings. Grow your user base with the power and flexibility of MultiVendorX and Intercom.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-dokan.png',
								'product_id'  => '502780',
								'product_url' => 'https://www.79mplus.com/product/intercom-subscription-multivendorx/',
								'groupfield'  => true,
							],
						],
						'desc'         => __( 'Intercom wooCommerce related addons list.', 'mplus-intercom-subscription' ),
						'header'       => __( 'MultiVendor E-commerce Integration', 'mplus-intercom-subscription' ),
						'addons-group' => true,
					],
					'intercom_edd_addons' => [
						'type'   => 'group-fields',
						'label'  => __( 'Intercom Download Management Add-ons', 'mplus-intercom-subscription' ),
						'fields' => [
							'mplusis_intercom_edd' => [
								'type'        => 'addons',
								'label'       => __( 'Easy Digital Downloads', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with the Downloads offered with Easy Digital Downloads.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-edd.png',
								'product_id'  => '495615',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-edd/',
								'groupfield'  => true,
							],
							// 'mplusis_intercom_wc' => [
							// 	'type'        => 'addons',
							// 	'label'       => __( 'WooCommerce', 'mplus-intercom-subscription' ),
							// 	'desc'        => __( 'Extends', 'mplus-intercom-subscription' ),
							// 	'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/79mplus.png',
							// 	'product_id'  => '',
							// 	'product_url' => '',
							// 	'groupfield'  => true,
							// ],
						],
						'desc'         => __( 'Intercom download management related addons list.', 'mplus-intercom-subscription' ),
						'header'       => __( 'Download Management Integration', 'mplus-intercom-subscription' ),
						'addons-group' => true,
					],
					'intercom_free_addons' => [
						'type'   => 'group-fields',
						'label'  => __( 'Intercom Free Add-ons', 'mplus-intercom-subscription' ),
						'fields' => [
							'mplusis_intercom_events' => [
								'type'        => 'addons',
								'label'       => __( 'Events', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin to work with Intercom Events to notify you of various things.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-events.png',
								'product_id'  => '496170',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-events/',
								'groupfield'  => true,
							],
							'mplusis_intercom_tags' => [
								'type'        => 'addons',
								'label'       => __( 'Tags', 'mplus-intercom-subscription' ),
								'desc'        => __( 'Extends the plugin so that Tags can be assigned to Intercom Contacts.', 'mplus-intercom-subscription' ),
								'image_url'   => MPLUSIS_PLUGINS_DIR_URI . 'assets/images/intercom-tags.png',
								'product_id'  => '495964',
								'product_url' => 'https://www.79mplus.com/product/mplus-intercom-tags/',
								'groupfield'  => true,
							],
						],
						'desc'         => __( 'Intercom free addons list.', 'mplus-intercom-subscription' ),
						'header'       => __( 'Free Addons', 'mplus-intercom-subscription' ),
						'addons-group' => true,
					],
				],
			],
			'mplusis-license-page' => [
				'menu_title'	=> __( 'License', 'mplus-intercom-subscription' ),
				'page_title'	=> __( 'License', 'mplus-intercom-subscription' ),
				'menu_description' => __( 'Acivate / Deactivate license key', 'mplus-intercom-subscription' ),
				'fields' => [
					'license_section' => [
						'type'		=> 'html',
						'content' 	=> [$this, 'intercom_plugin_license_page']
					],
				]
			],
		];

		$access_token = get_option( 'mplusis_api_key' );
		$own_api_key = get_option( 'mplusis_own_api_key' );

		if( $access_token && ! $own_api_key ){
			unset($pages['mplusis_base_settings']['fields']['intercom_authentication']['fields']['mplusis_own_api_key']);
		}
		$this->pages = apply_filters( 'mplusis_settings_pages', $pages );

		$this->addon_doc = apply_filters( 'mplusis_intercom_addons_docs', [] );

	}

	public function render() {
		?>
        <div class="mplus-wrap wrap">
            <h1 class="screen-reader-text"><?php echo __( 'Intercom Settings', 'mplus-intercom-subscription' ); ?></h1>
            <div class="mplus-body">
                <header class="mplus-Header">
                    <div class="mplus-Header-logo">
                        <img src="<?php echo MPLUSIS_PLUGINS_DIR_URI; ?>assets/images/logo-79mplus.png" width="56" height="" alt="Logo 79Mplus" class="mplus-Header-logo-desktop">
                        <img src="<?php echo MPLUSIS_PLUGINS_DIR_URI; ?>assets/images/logo-79mplus.png" width="28" height="" alt="Logo 79Mplus" class="mplus-Header-logo-mobile">
                    </div>
                    <?php $this->render_menu(); ?>
                </header>
                <section class="mplus-Content">
                    <?php $this->render_pages(); ?>
                </section>
                <aside class="mplus-Sidebar" style="display: none;">
					<div class="mplus-documentation" style="margin: 0 0 20px 0;">
						<p>
							<span class="dashicons dashicons-megaphone" style="font-size: 84px;margin-left: -56px;margin-top: -20px;color: #fcd839"></span>
						</p>
						<p style="margin-top: 49px;">
							<span style="font-weight: bold;font-size: 18px;text-align: center;display: inline-block;">Pass for Intercom Live chat and Lead generation plugin</span>
							<br>
							<span style="margin-top: 17px;display: inline-block;">
								SAVE MONEY ON EXTENSIONS AND BECOME LIMITLESS!
							</span>
							<a href="https://www.79mplus.com/product/all-access-pass-intercom/?utm_content=intercom_settings_page_rightbar" class="mplus-button" style="white-space:inherit;">Grab the All Access Pass</a>
						</p>

					</div>
					<div class="mplus-Sidebar-notice">
						<p>Check our tutorial and learn how to connect to Intercom.</p>
						<a href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/connect-to-intercom/?utm_content=intercom_settings_page_rightbar" target="_blank" rel="noopener" class="mplus-Sidebar-notice-link">Read our guide</a>
					</div>
					<div class="mplus-Sidebar-notice">
						<p>Check our tutorial and learn about the available add-ons.</p>
						<a href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/extensions/?utm_content=intercom_settings_page_rightbar" target="_blank" rel="noopener" class="mplus-Sidebar-notice-link">Read our guide</a>
					</div>
					<div class="mplus-Sidebar-notice">
						<p>Learn about the features of the Intercoms Subscription base plugin.</p>
						<a href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/features/?utm_content=intercom_settings_page_rightbar" target="_blank" rel="noopener" class="mplus-Sidebar-notice-link">Read our guide</a>
					</div>
					<div class="mplus-documentation" style="margin-bottom: 10px;">
                        <i class="mplus-icon-book"></i>
                        <h3 class="mplus-title2">Documentation</h3>
                        <p>It is a great starting point to configure Intercom Base plugin.</p>

                        <a href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/?utm_content=intercom_settings_page_rightbar" target="_blank"
                            class="mplus-button mplus-button--small mplus-button--blueDark">Read the documentation</a>
                    </div>
					<?php if( ! empty( $this->addon_doc ) ) {?>
						<div class="mplus-Sidebar-info">
							<i class="mplus-icon-information2"></i>
							<h4>Intercom Addons Documentations</h4>
						</div>
						<?php foreach ($this->addon_doc as $key => $doc) { ?>
							<div class="mplus-Sidebar-notice">
								<p><?php echo esc_attr( $doc['title'] ); ?></p>
								<a href="<?php echo esc_url( $doc['link'] ); ?>" target="_blank" rel="noopener" class="mplus-Sidebar-notice-link">Read our guide</a>
							</div>
						<?php } ?>
					<?php } ?>
                </aside>
            </div>
        </div>
        <?php
	}

	private function render_menu() {
		?>
        <div class="mplus-Header-nav">
            <?php $active = 'isActive'; ?>
            <?php foreach ( $this->pages as $page_id => $page ) { ?>
                <a href="#<?php echo $page_id; ?>" id="mplus-nav-<?php echo $page_id; ?>" class="mplus-menuItem <?php echo $active; ?>">
                    <div class="mplus-menuItem-title"><?php echo $page['menu_title']; ?></div>
                    <div class="mplus-menuItem-description">
                        <?php
							if ( isset( $page[ 'menu_description' ] ) ) {
								echo $page[ 'menu_description' ];
							}
            	?>
                    </div>
                </a>
                <?php $active = ''; ?>
            <?php } ?>
        </div>
        <?php
	}

	private function render_pages() {
		foreach ( $this->pages as $page_id => $page ) {
			?>
            <div id="<?php echo $page_id; ?>" class="mplus-Page mplusis-settings-page mplusis-settings-page-<?php echo $page_id; ?>" style="display:none">
                <div class="mplus-sectionHeader">
                    <h2 class="mplus-title1 <?php echo isset( $page['page_icon'] ) ? $page['page_icon'] : ''; ?>"><?php echo $page['page_title']; ?></h2>
                </div>
                <div class="settings-content-<?php echo $page_id; ?>">
                    <?php
						foreach ( $page['fields'] as $field_id => $field ) {
							$field = FieldFactory::get_field( $page_id, $field_id, $field );

							if ( $field ) {
								// echo '<fieldset class="mplus-fieldsContainer-fieldset">';
								$field->render();
								// echo '</fieldset>';
							}
						}
			?>
                </div>
                <button id="mplus-options-submit" class="settings-page-submit mplus-button <?php echo $page_id; ?>" data-settings-page="<?php echo $page_id; ?>">Save</button>
                <!-- <input type="submit" class="settings-page-submit mplus-button" id="mplus-options-submit" value="Save Changes" style="display: none;" data-settings-page="<?php echo $page_id; ?> /> -->
            </div>
            <?php
		}
		wp_enqueue_script( 'mplusis_settings_script' );
		wp_localize_script( 'mplusis_settings_script', 'mplusis_settings', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'pages'   => $this->pages,
			'nonce'   => wp_create_nonce( 'mplus-settings' ),
		] );
		wp_enqueue_style( 'mplusis_settings_style' );
	}

	/**
	 * Intercom connect section.
	 *
	 * @return void
	 */
	public function intercom_connect_section() {

		$access_token = get_option( 'mplusis_api_key' );
		$own_api_key = get_option( 'mplusis_own_api_key' );

		if( $access_token && ! $own_api_key ){
			$disconnect_url = site_url('wp-admin/admin.php?page=mplusis-settings&disconnect=1');
			echo __( 'You are connected with Intercom.', 'mplus-intercom-subscription') .
				' ' .
				sprintf( "<a href='%s'>" . __('Disconnect', 'mplus-intercom-subscription') . "</a>", $disconnect_url );
		}else{
			$connect_url = \Mplus_Intercom_Subscription_OAuth::connect_url();
			printf("<a href='%s' class='intercom-connect'><img src='%s'></a>", $connect_url, MPLUSIS_PLUGINS_DIR_URI. 'assets/images/intercom-connect.png');
		}
		echo "<style>a.intercom-connect:active, a.intercom-connect:focus {
				outline: 0;
				border: none;
				box-shadow: none;
				-moz-outline-style: none;
			}</style>";

	}

	/**
	 * the welcome page
	 * @return void
	 */
	public function intercom_plugin_welcome_page(){
		echo mplus_intercom_subscription_get_template("settings-dashboard.php");
	}

	/**
	 * @return void
	 */
	public function intercom_plugin_license_page(){
		echo mplus_intercom_subscription_get_template("license.php");
	}

	public static function get() {
		if ( null == static::$instance ) {
			static::$instance = new self();
		}

		return static::$instance;
	}
}
