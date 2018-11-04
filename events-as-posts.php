<?php
/*
Plugin Name:  Events as Posts
Plugin URI:   https://wordpress.org/plugins/events-as-posts/
Description:  A simple plugin that allows you to post events on your site
Version:      0.5
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

    define('EAP_VERSION', '0.5');
}

// include all the required files
require ( plugin_dir_path( __FILE__ ) . 'eap-functions.php' );
require ( plugin_dir_path( __FILE__ ) . 'event-post-type.php' );
require ( plugin_dir_path( __FILE__ ) . 'eap-settings.php' );
