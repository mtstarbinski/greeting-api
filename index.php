<?php
/*
Plugin Name: Greeting API
Description: Allows the admin to send and receive a greeting to another WordPress site.
Version: 1.0
Requires at least: 5.9
Requires PHP:      7.2
Author: Mark Starbinski
Author URI: http://starbinski.com/
Text Domain: greeting-api
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path:       /languages
*/

// Make sure we don't expose any info if called directly
if (!defined("ABSPATH")) exit;

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

// Setup
define('GAPI_PLUGIN_DIR', dirname( __FILE__ ));

// Includes
$rootFiles = glob(GAPI_PLUGIN_DIR . '/includes/*.php');
$subdirectoryFiles = glob(GAPI_PLUGIN_DIR . '/includes/**/*.php');
$allFiles = array_merge($rootFiles, $subdirectoryFiles);

foreach($allFiles as $filename){
	include_once($filename);
}

add_action( 'init', "gapi_register_blocks" );
add_action( 'rest_api_init', 'gapi_rest_api_init' );
// add all hooks
register_deactivation_hook(__FILE__, 'my_plugin_remove_database');
register_activation_hook(__FILE__, "table_creation");
register_activation_hook(__FILE__, 'initial_data');




