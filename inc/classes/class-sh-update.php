<?php
/**
 * Update
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Update' ) ) :

	/**
	 * Update
	 *
	 * @since 0.0.1
	 */
	class Sh_Update {

		/**
		 * Instance
		 *
		 * @var object Class object.
		 * @access private
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
			add_action( 'admin_init', array( $this, 'init' ) );
		}

		/**
		 * Init
		 *
		 * @since 0.0.1
		 * @return void
		 */
		function init() {

			do_action( 'sh_update_before' );

			// Get auto saved version number.
			$saved_version = get_option( 'sh-auto-version', false );

			// Update auto saved version number.
			if ( ! $saved_version ) {
				update_option( 'sh-auto-version', SHORTCODEHUB_VER );
			}

			// If equals then return.
			if ( version_compare( $saved_version, SHORTCODEHUB_VER, '=' ) ) {
				return;
			}

			// Update auto saved version number.
			update_option( 'sh-auto-version', SHORTCODEHUB_VER );

			do_action( 'sh_update_after' );
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Update::get_instance();

endif;
