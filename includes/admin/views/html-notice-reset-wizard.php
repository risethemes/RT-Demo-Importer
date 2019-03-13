<?php
/**
 * Admin View: Notice - Reset Wizard
 *
 * @package Evision_Demo_Importer
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="message" class="updated rt-demo-importer-message">
	<p><?php _e( '<strong>Reset Wizard</strong> &#8211; If you need to reset the WordPress back to default again :)', 'rt-demo-importer' ); ?></p>
	<p class="submit"><a href="<?php echo esc_url( add_query_arg( 'do_reset_wordpress', 'true', admin_url( 'themes.php?page=demo-importer' ) ) ); ?>" class="button button-primary evision-reset-wordpress"><?php _e( 'Run the Reset Wizard', 'rt-demo-importer' ); ?></a> <a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'rt-demo-importer-hide-notice', 'reset_notice' ), 'evision_demo_importer_hide_notice_nonce', '_rt_demo_importer_notice_nonce' ) ); ?>"><?php _e( 'Hide this notice', 'rt-demo-importer' ); ?></a></p>
</div>
