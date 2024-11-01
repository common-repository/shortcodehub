<?php
/**
 * Summery
 *
 * @since 1.2.0
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Query_Summery' ) ) :

	/**
	 * Summery
	 *
	 * @since 1.2.0
	 */
	class Sh_Shortcode_Type_Query_Summery {

		/**
		 * Instance
		 *
		 * @var object Class object.
		 * @access private
		 * @since 1.2.0
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.2.0
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
		 * @since 1.2.0
		 */
		public function __construct() {
			add_action( 'sh_shortcode_markup_summery', array( $this, 'shortcode_markup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		}

		/**
		 * Enqueue Assets.
		 *
		 * @version 1.0.0
		 *
		 * @return void
		 */
		function enqueue_assets() {
			wp_register_style( 'sh-query-summery', sh_get_plugin_uri( __FILE__ ) . 'css-static.css', null, sh_get_product_version(), 'all' );
		}

		/**
		 * Get Shortcode Markup
		 *
		 * @since 1.2.0
		 *
		 * @param  int $post_id Post ID.
		 * @return mixed
		 */
		function shortcode_markup( $post_id ) {

			$args = sh_get_query_args( $post_id );

			if ( empty( $args ) ) {
				return;
			}

			// Enqueue scripts.
			wp_enqueue_style( 'sh-query-summery' );

			$override_markup = get_post_meta( $post_id, 'sh-query-override-markup', true );
			if ( $override_markup ) {
				$raw_markup = get_post_meta( $post_id, 'sh-query-markup', true );
			} else {
				$raw_markup = sh_get_filesystem()->get_contents( sh_get_plugin_uri( __FILE__ ) . 'html.twig' );
			}

			$data = array(
				'posts' => Timber::get_posts( $args ),
			);

			do_action( 'sh_shortcode_markup_summery-before', $post_id, $args );

			if ( empty( $data['posts'] ) && is_user_logged_in() ) {
				esc_html_e( 'Not have any posts!', 'shortcodehub' );
			} else {
				echo Timber::compile_string( $raw_markup, $data );
			}

			do_action( 'sh_shortcode_markup_summery-after', $post_id, $args );
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Query_Summery::get_instance();

endif;
