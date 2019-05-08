<?php
/**
 * Plugin Name: RT Demo Importer
 * Plugin URI: #
 * Description:  Rise Theme official demo importer that can import content, widgets and theme settings with just one click.
 * Version: 1.0
 * Author: 
 * Author URI: #
 * License: GPLv3 or later
 * Text Domain: rt-demo-importer
 * Domain Path: /languages/
 *
 * @package RT_Demo_Importer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define RTDM_PLUGIN_FILE.
if ( ! defined( 'RTDM_PLUGIN_FILE' ) ) {
	define( 'RTDM_PLUGIN_FILE', __FILE__ );
}

if( ! defined( 'RTDM_PLUGIN_DEMO_IMPORTER_URL' ) ) {
	/*define( 'RTDM_PLUGIN_DEMO_IMPORTER_URL', 'http://202.166.198.46/demo_importer' );*/
	//https://raw.githubusercontent.com/risethemes/risetheme_demo_packages/master/	
	define( 'RTDM_PLUGIN_DEMO_IMPORTER_URL', 'https://raw.githubusercontent.com/suitable12/demoimporter/master/' );
}

// Include the main RT Demo Importer class.
if ( ! class_exists( 'RTM_Demo_Importer' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-rt-demo-importer.php';
}

/**
 * Main instance of RT Demo importer.
 *
 * Returns the main instance of TGDM to prevent the need to use globals.
 *
 * @since  1.3.4
 * @return RT_Demo_Importer
 */
function rtdm() {
	return RTM_Demo_Importer::instance();
}

// Global for backwards compatibility.
$GLOBALS['rt-demo-importer'] = rtdm();
