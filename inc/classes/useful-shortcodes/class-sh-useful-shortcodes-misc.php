<?php
/**
 * Misc Shortcodes
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Useful_Shortcodes_Misc' ) ) :

	/**
	 * Misc Shortcodes
	 *
	 * @since 0.0.1
	 */
	class Sh_Useful_Shortcodes_Misc {

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
			$shortcodes = array(
				'date', // Shortcode - [sh_date].
			);

			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( 'sh_' . $shortcode, array( $this, $shortcode ) );
			}
		}

		/**
		 * Date & Time
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function date( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'format' => 'd F Y',
				),
				$atts
			);

			return date( $atts['format'] );
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Useful_Shortcodes_Misc::get_instance();

endif;
