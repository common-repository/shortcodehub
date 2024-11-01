<?php
/**
 * Init
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Loader' ) ) :

	/**
	 * Init
	 *
	 * @since 0.0.1
	 */
	class Sh_Loader {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class Instance.
		 * @since 0.0.1
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 0.0.1
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			// Activation.
			register_activation_hook( SHORTCODEHUB_FILE, array( $this, 'activate' ) );

			// Plugin loaded.
			add_action( 'plugins_loaded', array( $this, 'load_plugin' ), 99 );
		}

		/**
		 * Loads plugin files.
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function load_plugin() {

			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-white-label.php';

			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-update.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-helper.php';

			if ( ! class_exists( 'Timber' ) ) {
				require_once SHORTCODEHUB_DIR . 'inc/classes/timber-library/timber.php';
			}

			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-hooks.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/dashboard/class-sh-dashboard.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-shortcode-types.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-shortcode.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-page.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-post.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/useful-shortcodes/class-sh-useful-shortcodes.php';
		}

		/**
		 * Activate
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function activate() {

			set_transient( 'sh_redirect_after_activation', true, MONTH_IN_SECONDS );

			update_option( 'sh_first_activation', false );

			// Activation hook.
			do_action( 'sh_activated' );
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Loader::get_instance();

endif;
