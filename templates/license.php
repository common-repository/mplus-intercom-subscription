<?php
$page = $_GET['page'];
$addons = apply_filters( 'mplus_intercom_subscription_addon_license_tabs', array() );
if ( ! empty( $addons ) ) {
    $active_addon = isset( $_GET['addon'] ) ? $_GET['addon'] : key( $addons );
    echo '<h2 class="nav-tab-wrapper nav-tab-wrapper-top" style="margin-top: 24px">';

    foreach( $addons as $addon => $label ) {
        $nav_class = ( $active_addon == $addon ) ? 'nav-tab-active' : '';
        echo '<a href="?page=' . $page . '&addon=' . $addon . '" class="nav-tab ' . $nav_class . '">' . $label . '</a>';
    }
    echo '</h2>';

    do_action( 'mplus_intercom_subscription_addon_licence_activation_form', $active_addon );
} else {
    echo '<h2>' . __( 'No Premium Addon Found', 'mplus-intercom-subscription' ) . '</h2>';
}