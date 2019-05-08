<?php
/**
 * Admin View: Notice - Reset Wizard
 *
 * @package SUIT_Demo_Importer
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="message" class="updated suit-demo-importer-message">
	<p><?php _e( '<strong>Reset Wizard</strong> &#8211; If you need to reset the WordPress back to default again :)', 'suit-demo-importer' ); ?></p>
	<p class="submit"><a href="<?php echo esc_url( add_query_arg( 'do_reset_wordpress', 'true', admin_url( 'themes.php?page=suit-demo-importer' ) ) ); ?>" class="button button-primary suit-reset-wordpress"><?php _e( 'Run the Reset Wizard', 'suit-demo-importer' ); ?></a> <a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'suit-demo-importer-hide-notice', 'reset_notice' ), 'suit_demo_importer_hide_notice_nonce', '_suit_demo_importer_notice_nonce' ) ); ?>"><?php _e( 'Hide this notice', 'suit-demo-importer' ); ?></a></p>
</div>
