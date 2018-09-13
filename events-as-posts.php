<?php
/*
Plugin Name:  Events as Posts
Description:  A simple plugin that allows you to post events on your site
Version:      1.0.0
Author:       Ambrogio Piredda
Text Domain:  events-as-posts
Domain Path:  /languages
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
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
 }
 register_activation_hook( __FILE__, 'eap_install' );

 /**
  * When deactivated
  */

 function eap_deactivation() {
   // unregister the post type, so the rules are no longer in memory
   unregister_post_type( 'event' );
   // clear the permalinks to remove our post type's rules from the database
   flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'eap_deactivation' );

 /**
  * Load plugin stylesheet
  */

 function eap_load_plugin_stylesheet() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'eap_stylesheet', $plugin_url . 'inc/eap-stylesheet.css' );
  }
  add_action( 'wp_enqueue_scripts', 'eap_load_plugin_stylesheet' );

 /**
  * Load color picker style and script
  */

 function eap_add_color_picker( $hook ) {
    if( is_admin() ) {
        // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'inc/eap-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
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
