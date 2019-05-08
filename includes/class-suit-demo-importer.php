<?php
/**
 * RT Demo Importer setup
 *
 * @package SUIT_Demo_Importer
 * @since   1.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Suitable Demo Importer Class.
 *
 * @class Suitable_Demo_Importer
 */
final class Suitable_Demo_Importer {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * Theme single instance of this class.
	 *
	 * @var object
	 */
	protected static $_instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.4
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'suit-demo-importer' ), '1.4' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.4
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'suit-demo-importer' ), '1.4' );
	}

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		$this->define_constants();
		$this->init_hooks();

		do_action( 'SUIT_demo_importer_loaded' );
	}

	/**
	 * Define TGDM Constants.
	 */
	private function define_constants() {
		$upload_dir = wp_upload_dir( null, false );

		$this->define( 'SUIT_DM_ABSPATH', dirname( SUIT_DM_PLUGIN_FILE ) . '/' );
		$this->define( 'SUIT_DM_PLUGIN_BASENAME', plugin_basename( SUIT_DM_PLUGIN_FILE ) );
		$this->define( 'SUIT_DM_VERSION', $this->version );
		$this->define( 'SUIT_DM_DEMO_DIR', $upload_dir['basedir'] . '/suit-demo-pack/' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Hook into actions and filters.
	 */
	private function init_hooks() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Register activation hook.
		register_activation_hook( SUIT_DM_PLUGIN_FILE, array( $this, 'install' ) );

		// Check with Official RT theme is installed.
		if ( in_array( get_option( 'template' ), $this->get_core_supported_themes(), true ) ) {
			$this->includes();

			add_filter( 'plugin_action_links_' . SUIT_DM_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		} else {
			add_action( 'admin_notices', array( $this, 'theme_support_missing_notice' ) );
		}
	}

	/**
	 * Get core supported themes.
	 *
	 * @return array
	 */
	private function get_core_supported_themes() {
		$core_themes = array( 'business-click','suitable' );

		// Check for official core themes pro version.
		$pro_themes = array_diff( $core_themes, array() );
		if ( ! empty( $pro_themes ) ) {
			$pro_themes = preg_replace( '/$/', '-pro', $pro_themes );
		}

		return array_merge( $core_themes, $pro_themes );
	}

	/**
	 * Include required core files.
	 */
	private function includes() {
		include_once SUIT_DM_ABSPATH . 'includes/class-demo-importer.php';
		include_once SUIT_DM_ABSPATH . 'includes/functions-demo-importer.php';		
	}

	/**
	 * Install RT Demo Importer.
	 */
	public function install() {
		$files = array(
			array(
				'base'    => SUIT_DM_DEMO_DIR,
				'file'    => 'index.html',
				'content' => '',
			),
		);

		// Bypassing if filesystem is read-only and/or non-standard upload system is used.
		if ( ! is_blog_installed() || apply_filters( 'RT_demo_importer_install_skip_create_files', false ) ) {
			return;
		}
		// Install files and folders.
		foreach ( $files as $file ) {
			if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
				$file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
				if ( $file_handle ) {
					fwrite( $file_handle, $file['content'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
					fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
				}
			}
		}

		// Redirect to demo importer page.
		set_transient( '_ev_demo_importer_activation_redirect', 1, 30 );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/suit-demo-importer/suit-demo-importer-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/suit-demo-importer-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'suit-demo-importer' );

		unload_textdomain( 'suit-demo-importer' );
		load_textdomain( 'suit-demo-importer', WP_LANG_DIR . '/suit-demo-importer/suit-demo-importer-' . $locale . '.mo' );
		load_plugin_textdomain( 'suit-demo-importer', false, plugin_basename( dirname( SUIT_DM_PLUGIN_FILE ) ) . '/languages' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', SUIT_DM_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( SUIT_DM_PLUGIN_FILE ) );
	}

	/**
	 * Display action links in the Plugins list table.
	 *
	 * @param  array $actions Plugin Action links.
	 * @return array
	 */
	public function plugin_action_links( $actions ) {
		$new_actions = array(
			'importer' => '<a href="' . admin_url( 'themes.php?page=suit-demo-importer' ) . '" aria-label="' . esc_attr( __( 'View Demo Importer', 'suit-demo-importer' ) ) . '">' . __( 'Demo Importer', 'suit-demo-importer' ) . '</a>',
		);

		return array_merge( $new_actions, $actions );
	}

	/**
	 * Display row meta in the Plugins list table.
	 *
	 * @param  array  $plugin_meta Plugin Row Meta.
	 * @param  string $plugin_file Plugin Row Meta.
	 * @return array
	 */
	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		/*if ( SUIT_DM_PLUGIN_BASENAME === $plugin_file ) {
			$new_plugin_meta = array(
				'docs'    => '<a href="' . esc_url( apply_filters( 'suit_demo_importer_docs_url', 'https://risethemes.com/docs/suit-demo-importer/' ) ) . '" title="' . esc_attr( __( 'View Demo Importer Documentation', 'suit-demo-importer' ) ) . '">' . __( 'Docs', 'suit-demo-importer' ) . '</a>',
				'support' => '<a href="' . esc_url( apply_filters( 'suit_demo_importer_support_url', 'https://risethemes.com/support-forum/' ) ) . '" title="' . esc_attr( __( 'Visit Free Customer Support Forum', 'suit-demo-importer' ) ) . '">' . __( 'Free Support', 'suit-demo-importer' ) . '</a>',
			);

			return array_merge( $plugin_meta, $new_plugin_meta );
			
		}*/

		return (array) $plugin_meta;
	}

	/**
	 * Theme support fallback notice.
	 */
	public function theme_support_missing_notice() {
		$themes_url = array_intersect( array_keys( wp_get_themes() ), $this->get_core_supported_themes() ) ? admin_url( 'themes.php?search=risetheme' ) : admin_url( 'theme-install.php?search=risetheme' );

		/* translators: %s: official RT themes URL */
		echo '<div class="error notice is-dismissible"><p><strong>' . esc_html__( 'RT Demo Importer', 'suit-demo-importer' ) . '</strong> &#8211; ' . sprintf( esc_html__( 'This plugin requires %s to be activated to work.', 'suit-demo-importer' ), '<a href="' . esc_url( $themes_url ) . '">' . esc_html__( 'Official RT Theme', 'suit-demo-importer' ) . '</a>' ) . '</p></div>';
	}
}
