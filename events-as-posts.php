<?php
/*
Plugin Name:  Events as Posts
Plugin URI:   https://wordpress.org/plugins/events-as-posts/
Description:  A simple plugin that allows you to post events on your site
Version:      0.5.7
Author:       Ambrogio Piredda
Author URI:   https://profiles.wordpress.org/orbam7819
Text Domain:  events-as-posts
Domain Path:  /languages
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2018 Ambrogio Piredda
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// define plugin version
if ( ! defined( 'EAP_VERSION' ) ) {

    define('EAP_VERSION', '0.5.7');
}

// include all the required files
require ( plugin_dir_path( __FILE__ ) . 'eap-functions.php' );
require ( plugin_dir_path( __FILE__ ) . 'event-post-type.php' );
require ( plugin_dir_path( __FILE__ ) . 'eap-settings.php' );

// activation hook
function eap_activation() {

    update_option( 'eap_version', EAP_VERSION );

    /* eap_settings updating process */

    // eap_settings option default values
    $eap_settings_default = array(
        'date_format'      => 'F j, Y',
        'time_format'      => 'g:i a',
        'number_of_events' => 0,
        'categories'       => '',
        'period'           => 'future',
    );

    // eap settings option defined by the user
    $eap_settings_user = get_option( 'eap_settings' );

    if ( $eap_settings_user === false ) {

        $eap_settings_user = array();
    }

    update_option( 'eap_settings', array_merge( $eap_settings_default, $eap_settings_user ) );


    /* eap_settings_style updating process */

    $custom_css = '/* events as posts custom css */&#13;&#13;.eap__list {&#13;&#13;}&#13;.eap__event {&#13;&#13;}';

    // eap_settings_style option default values
    $eap_settings_style_default = array(
        'layout'            => '1',
        'event_bg_color'    => '#f4f4f4',
        'custom_css'        => $custom_css,
    );

    // eap settings option defined by the user
    $eap_settings_style_user = get_option( 'eap_settings_style' );

    if ( $eap_settings_style_user === false ) {

        $eap_settings_style_user = array();
    }

    update_option( 'eap_settings_style', array_merge( $eap_settings_style_default, $eap_settings_style_user ) );

    // registers custom post type
    eap_create_event_post_type();

    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'eap_activation' );


// deactivation hook
function eap_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'eap_event' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'eap_deactivation' );


// check actual version of the plugin
function eap_check_version() {

    // updates actual version if different
    if ( EAP_VERSION !== get_option( 'eap_version' ) ) {

        eap_activation();
    }
}
add_action( 'plugins_loaded', 'eap_check_version' );
