<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Locates template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/mplus-intercom-subscription/templates/$template_name
 * 2. /plugins/mplus-intercom-subscription/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param string $template_name Template to load.
 * @param string $template_path (optional) Path to templates.
 * @param string $default_path (optional) Default path to template files.
 * @return string Path to the template file.
 */
function mplus_intercom_subscription_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	// Set variable to search in templates folder of theme.
	if ( ! $template_path ) {
		$template_path = get_template_directory() . '/' . MPLUSIS_NAME . '/templates/';
	}

	// Set default plugin templates path.
	if ( ! $default_path ) {
		$default_path = MPLUSIS_PLUGINS_DIR . 'templates/';
	}
	// Search template file in theme folder.
	$template = locate_template( [
		$template_path . $template_name,
		$template_name,
	] );

	// Get plugins template file.
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	return apply_filters( 'mplus_intercom_subscription_locate_template', $template, $template_name, $template_path, $default_path );
}

/**
 * Gets template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see mplus_intercom_subscription_locate_template()
 *
 * @param string $template_name Template to load.
 * @param array $args Args passed for the template file.
 * @param string $template_path (optional) Path to templates.
 * @param string $default_path (optional) Default path to template files.
 * @return null|void
 */
function mplus_intercom_subscription_get_template( $template_name, $args = [], $tempate_path = '', $default_path = '' ) {
	if ( is_array( $args ) && isset( $args ) ) {
		extract( $args );
	}
	$template_file = mplus_intercom_subscription_locate_template( $template_name, $tempate_path, $default_path );

	if ( ! file_exists( $template_file ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );

		return;
	}
	// Gets the content from the template.
	ob_start();
	require_once $template_file;
	$html = ob_get_clean();

	return $html;
}

/**
 * Gets all intercom company select options.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_all_company_list() {
	$intercom            = mplusis_get_client();
	$companies_data      = [];
	$companies_options   = [];
	$companies_options[] = 'Select Company';

	if ( ! $intercom ) {
		return [];
	}

	try {
		$companies = $intercom->companies->getCompanies( [
			'per_page' => 50,
		] );

		if ( property_exists( $companies, 'data' ) ) {
			$companies_data = array_merge( $companies_data, $companies->data );
			$pages          = $companies->pages;
			$total_pages    = $pages->total_pages;

			$page = 2;

			do {
				$companies = $intercom->companies->getCompanies( [
					'per_page' => 50,
					'page'     => $page,
				] );

				if ( property_exists( $companies, 'data' ) ) {
					$companies_data = array_merge( $companies_data, $companies->data );
				}
				++$page;
			} while ( $page <= $total_pages );
		}

		foreach ( $companies_data as $company ) {
			if ( isset( $company->name ) ) {
				$companies_options[ $company->id ] = $company->name;
			}
		}
	} catch ( \Exception $e ) {
		# code...
	}

	return $companies_options;
}

/**
 * Gets company information.
 *
 * @param int $company_ID Company ID to be used for function.
 * @return mixed
 */
function get_company_information( $company_ID ) {
	$intercom = mplusis_get_client();

	/** Get a company by ID */
	return $company = $intercom->companies->getCompany( $company_ID );
}

function mplusis_get_client() {
	if ( class_exists( 'Intercom\IntercomClient' ) ) {
		try {
			// Access token
			$access_token = get_option( 'mplusis_api_key' );
			$_client      = new Intercom\IntercomClient( $access_token, null );
		} catch ( Exception $e ) {
			$_client = false;
		}

		return $_client;
	}
}

// Function to set email content type to HTML
function mplusis_set_html_content_type() {
    return 'text/html';
}

function mplusis_log($message, $add_on = 'base', $log_url = false) {

	$add_on = str_replace('mplus-intercom-subscription-', '', $add_on);

	$log_file_name = md5(site_url('mplusis'))."-{$add_on}.log"; //a name that cannot be guessed.

    $log_file_path = MPLUSIS_PLUGINS_DIR . 'assets/logs/' . $log_file_name;

	if( $log_url ){
		$current_url = mplusis_get_current_url();
		$message .= " URL: " . $current_url;
	}

    // Format the log entry
    $log_entry = '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n";

	if ( ! file_exists( MPLUSIS_PLUGINS_DIR . 'assets/logs/' ) ) {
		mkdir( MPLUSIS_PLUGINS_DIR . 'assets/logs/', 0777, true );
	}

	if ( ! file_exists( $log_file_path ) ) {
		$fh = fopen( $log_file_path, 'w' );
		fclose($fh);
	}

    // Append the log entry to the log file
    file_put_contents($log_file_path, $log_entry, FILE_APPEND | LOCK_EX);
}

function mplusis_get_current_url(){
	// Get the current URL
	$currentURL = "http";
	$currentURL .= ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$currentURL .= "://";
	$currentURL .= $_SERVER["SERVER_NAME"];

	// Add the port if it's not the default port
	if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
		$currentURL .= ":" . $_SERVER["SERVER_PORT"];
	}

	// Add the request URI (path and query string)
	$currentURL .= $_SERVER["REQUEST_URI"];

	// Output the current URL
	return $currentURL;
}
