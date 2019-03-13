<?php
/**
 * Demo Importer Updates.
 *
 * Backward compatibility for demo importer configs and options.
 *
 * @package RT_Demo_Importer/Functions
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Update demo importer options.
 *
 * @since 1.3.4
 */
function rt_update_demo_importer_options() {
	$migrate_options = array(
		'rt_demo_imported_id'             => 'rt_demo_importer_activated_id',
		'rt_demo_imported_notice_dismiss' => 'rt_demo_importer_reset_notice',
	);

	foreach ( $migrate_options as $old_option => $new_option ) {
		$value = get_option( $old_option );

		if ( $value ) {
			update_option( $new_option, $value );
			delete_option( $old_option );
		}
	}
}
add_action( 'admin_init', 'rt_update_demo_importer_options' );
