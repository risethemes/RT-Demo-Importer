<?php
/**
 * Plugin Name: SUIT Demo Importer
 * Plugin URI: #
 * Description: Suitable Theme official demo importer that can import content, widgets and theme settings with just one click.
 * Version: 1.0
 * Author: 
 * Author URI: #
 * License: GPLv3 or later
 * Text Domain: suit-demo-importer
 * Domain Path: /languages/
 *
 * @package SUIT_Demo_Importer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define SUIT_DM_PLUGIN_FILE.
if ( ! defined( 'SUIT_DM_PLUGIN_FILE' ) ) {
	define( 'SUIT_DM_PLUGIN_FILE', __FILE__ );
}

if( ! defined( 'SUIT_DM_PLUGIN_DEMO_IMPORTER_URL' ) ) {		
	define( 'SUIT_DM_PLUGIN_DEMO_IMPORTER_URL', 'https://raw.githubusercontent.com/suitable12/demoimporter/master/' );
}

// Include the main RT Demo Importer class.
if ( ! class_exists( 'SUIT_Demo_Importer' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-suit-demo-importer.php';
}

/**
 * Main instance of Suitable Demo importer.
 *
 * Returns the main instance of TGDM to prevent the need to use globals.
 *
 * @since  1.0
 * @return SUIT_Demo_Importer
 */
function suitdm() {
	return Suitable_Demo_Importer::instance();
}

// Global for backwards compatibility.
$GLOBALS['suit-demo-importer'] = suitdm();
