<?php
// if uninstall.php is not called by WordPress, die
if ( !defined('WP_UNINSTALL_PLUGIN' ) ) {

    die;
}

// delete options
delete_option( 'eap_settings' );
delete_option( 'eap_settings_style' );
delete_option( 'eap_version' );
