<?php
/**
 * Shortcode Type: Code Editor
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Text_Editor' ) ) :

	/**
	 * Shortcode Type: Code Editor
	 *
	 * @since 0.0.1
	 */
	class Sh_Shortcode_Type_Text_Editor {

		/**
		 * Instance
		 *
		 * @var instance Class Instance.
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
			add_action( 'sh_shortcode_markup_text-editor', array( $this, 'shortcode_markup' ) );
		}

		/**
		 * Shortcode Markup
		 *
		 * @since 0.0.1
		 *
		 * @param  int $post_id Shortcode ID.
		 * @return mixed
		 */
		function shortcode_markup( $post_id ) {

			// Avoided filter `the_content` for `shortcode` post type.
			// Because, It occurs infinite loop.
			if ( is_single() && 'shortcode' === get_post_type() ) {
				echo get_post_field( 'post_content', $post_id );
			} else {
				echo apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
			}
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Text_Editor::get_instance();

endif;
