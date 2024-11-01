<?php
/**
 * Useful Shortcodes
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Useful_Shortcodes' ) ) :

	/**
	 * Useful Shortcodes
	 *
	 * @since 0.0.1
	 */
	class Sh_Useful_Shortcodes {

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
			require_once SHORTCODEHUB_DIR . 'inc/classes/useful-shortcodes/class-sh-useful-shortcodes-post.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/useful-shortcodes/class-sh-useful-shortcodes-theme.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/useful-shortcodes/class-sh-useful-shortcodes-plugin.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/useful-shortcodes/class-sh-useful-shortcodes-author.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/useful-shortcodes/class-sh-useful-shortcodes-misc.php';
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Useful_Shortcodes::get_instance();

endif;
