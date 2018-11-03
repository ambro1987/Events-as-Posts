<?php
/*
Plugin Name:  Events as Posts
Plugin URI:   https://wordpress.org/plugins/events-as-posts/
Description:  A simple plugin that allows you to post events on your site
Version:      0.4
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

require ( plugin_dir_path( __FILE__ ) . 'eap-functions.php' );
require ( plugin_dir_path( __FILE__ ) . 'event-post-type.php' );
require ( plugin_dir_path( __FILE__ ) . 'eap-options.php' );

 /**
  * When activated
  */

 function eap_install() {
     // trigger our function that registers the custom post type
     eap_create_event_post_type();
     // clear the permalinks after the post type has been registered
     flush_rewrite_rules();

     update_option( 'eap_settings', array(
         'date_format'      => 'F j, Y',
         'time_format'      => 'g:i a',
         'number_of_events' => 0,
         'categories'       => '',
         'period'           => 'future',
     ));
 }
 register_activation_hook( __FILE__, 'eap_install' );

 /**
  * When deactivated
  */

 function eap_deactivation() {
   // unregister the post type, so the rules are no longer in memory
   unregister_post_type( 'eap_event' );
   // clear the permalinks to remove our post type's rules from the database
   flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'eap_deactivation' );

 /**
  * Load plugin stylesheet
  */

 function eap_load_plugin_stylesheet() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'eap_stylesheet', $plugin_url . '/inc/eap.css' );
  }
  add_action( 'wp_enqueue_scripts', 'eap_load_plugin_stylesheet' );

 /**
  * Load admin stylesheet
  */

  function eap_wp_admin_style() {
    wp_register_style( 'eap_wp_admin_css', plugin_dir_url( __FILE__ ) . '/inc/eap-admin.css', false );
    wp_enqueue_style( 'eap_wp_admin_css' );
  }
  add_action( 'admin_enqueue_scripts', 'eap_wp_admin_style' );

 /**
  * Load color picker style and script
  */

 function eap_add_color_picker( $hook ) {
    if( is_admin() ) {
        // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( '/inc/eap.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
 }
 add_action( 'admin_enqueue_scripts', 'eap_add_color_picker' );

 /**
  * Load textdomain for translations
  */

 function eap_load_textdomain() {
   $plugin_dir = basename(dirname(__FILE__)) . '/languages';
   load_plugin_textdomain( 'events-as-posts', false, $plugin_dir );
 }
 add_action('plugins_loaded', 'eap_load_textdomain');
