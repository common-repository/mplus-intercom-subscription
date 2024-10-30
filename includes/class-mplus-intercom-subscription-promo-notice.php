<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Promotion class
 */
class Mplus_Intercom_Subscription_Promo_Notice {

    /**
     * Load autometically when class initiate
     *
     * @since 2.9.0
     */
    public function __construct() {
        add_action( 'admin_notices', [ $this, 'show_promotions' ] );
        add_action( 'wp_ajax_mplusis-dismiss-promotional-notice', [ $this, 'dismiss_promo' ] );
    }

    public function show_promotions() {

        $notices = $this->get_latest_promo();

        if ( empty( $notices ) ) {
            return;
        }
        echo mplus_intercom_subscription_get_template("promo-notice.php", array('notices' => $notices));
    }

    /**
     * Dissmiss prmo notice
     */
    public function dismiss_promo() {

        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'mplusis_admin' ) ) {
            wp_send_json_error( __( 'Invalid nonce', 'mplus-intercom-subscription' ) );
        }

        $promo_key          = sanitize_text_field( wp_unslash( $_POST['key'] ) );
        $promo_dismiss_time = get_option( 'mplusis_promo_dismiss_time', [] );

        $promo_dismiss_time[$promo_key] = current_time('timestamp', 1);

        update_option( 'mplusis_promo_dismiss_time', $promo_dismiss_time );

        wp_send_json_success();
    }

    /**
     * Get latest prmo
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_latest_promo() {

        $promos = get_transient( 'mplusis_promo_notices' );

        if ( empty( $promos ) ) {
            $promo_notice_url = 'https://www.79mplus.com/wp-json/promo/offers';
            $response         = wp_remote_get( $promo_notice_url, array( 'timeout' => 15 ) );
            $promos           = wp_remote_retrieve_body( $response );

            if ( is_wp_error( $response ) || $response['response']['code'] !== 200 ) {
                $promos = [];
            }

            set_transient( 'mplusis_promo_notices', $promos,  DAY_IN_SECONDS );
        }

        if( empty( $promos ) ){
            return [];
        }

        $promos  = json_decode( $promos, true );
        $notices = apply_filters( 'mplusis_promo_notices', [] );
        // check if api data is valid
        if ( empty( $promos ) || ! is_array( $promos ) ) {
            return $notices;
        }

        $current_gmt_date = current_time('Y-m-d', 1);
        $current_gmt_timestamp = current_time('timestamp', 1);
        $removed_promo = get_option( 'mplusis_removed_promo', [] );
        $promo_dismiss_time = get_option( 'mplusis_promo_dismiss_time', [] );

        foreach ( $promos as $promo ) {
            if ( in_array( $promo['key'], $removed_promo ) ) {
                continue;
            }
            if( isset( $promo_dismiss_time[ $promo['key'] ] ) && ($current_gmt_timestamp - $promo_dismiss_time[ $promo['key'] ]) < DAY_IN_SECONDS ){
                continue;
            }

            if ( $current_gmt_date >= $promo['start_date'] && $current_gmt_date <= $promo['end_date'] ) {
                $notices[] = [
                    'type'              => 'promotion',
                    'key'               => $promo['key'],
                    'title'             => $promo['title'],
                    'content'           => $promo['content'],
                    'priority'          => $promo['priority'],
                    'show_close_button' => $promo['show_close_button'],
                    'thumbnail'         => $promo['thumbnail'],
                    'ajax_data'         => [
                        'action' => 'mplusis_promotional_notice',
                        'nonce'  => wp_create_nonce( 'mplusis_admin' ),
                        'key'    => $promo['key'],
                    ],
                    'action'            => [
                        'type'   => 'primary',
                        'text'   => $promo['action_title'],
                        'link' => $promo['action_url'],
                        'target' => '_blank',
                    ],
                ];
            }
        }

        if ( empty( $notices ) ) {
            return $notices;
        }

        uasort( $notices, [ $this, 'sort_by_priority' ] );

        return array_values( $notices );
    }

    /**
     * Sort all promotions depends on priority key
     *
     * @param array $a
     * @param array $b
     *
     * @return integer
     */
    private function sort_by_priority( $a, $b ) {
        if ( isset( $a['priority'] ) && isset( $b['priority'] ) ) {
            return $b['priority'] - $a['priority'];
        } else {
            return 199;
        }
    }
}