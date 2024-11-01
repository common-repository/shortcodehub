<?php
/**
 * Inbox
 *
 * @since 1.3.0
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Query_Inbox' ) ) :

	/**
	 * Inbox
	 *
	 * @since 1.3.0
	 */
	class Sh_Shortcode_Type_Query_Inbox {

		/**
		 * Instance
		 *
		 * @var object Class object.
		 * @access private
		 * @since 1.3.0
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.3.0
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
		 * @since 1.3.0
		 */
		public function __construct() {
			add_action( 'sh_shortcode_markup_inbox', array( $this, 'shortcode_markup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'wp_ajax_sh-query-inbox-show-single-post', array( $this, 'show_post' ) );
		}

		/**
		 * Show Posts
		 *
		 * @return void
		 */
		function show_post() {
			$post_id = isset( $_POST['sh_post_id'] ) ? absint( $_POST['sh_post_id'] ) : 0;

			if ( ! $post_id ) {
				wp_send_json_error();
			}

			$contents        = sh_get_filesystem()->get_contents( sh_get_plugin_uri( __FILE__ ) . 'single.twig' );
			$context         = Timber::context();
			$context['post'] = new Timber\Post( $post_id );
			$markup          = Timber::compile_string( $contents, $context );

			wp_send_json_success( $markup );
		}

		/**
		 * Enqueue Assets.
		 *
		 * @version 1.0.0
		 *
		 * @return void
		 */
		function enqueue_assets() {
			wp_register_style( 'bootstrap-grid', SHORTCODEHUB_URI . 'inc/assets/css/' . sh_get_css_path( 'bootstrap-grid' ), null, sh_get_product_version(), 'all' );
			wp_register_style( 'sh-inbox-grid', sh_get_plugin_uri( __FILE__ ) . 'css-static.css', null, sh_get_product_version(), 'all' );
			wp_register_script( 'sh-inbox-grid', sh_get_plugin_uri( __FILE__ ) . 'js-static.js', array( 'jquery' ), sh_get_product_version(), true );
			wp_localize_script(
				'sh-inbox-grid',
				'ShQueryInbox',
				array(
					'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				)
			);
		}

		/**
		 * Get Shortcode Markup
		 *
		 * @since 1.3.0
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
			wp_enqueue_style( 'bootstrap-grid' );
			wp_enqueue_style( 'sh-inbox-grid' );
			wp_enqueue_script( 'sh-inbox-grid' );

			$override_markup = get_post_meta( $post_id, 'sh-query-override-markup', true );
			if ( $override_markup ) {
				$raw_markup = get_post_meta( $post_id, 'sh-query-markup', true );
			} else {
				$raw_markup = apply_filters( 'sh_query_inbox_shortcode_markup', sh_get_filesystem()->get_contents( sh_get_plugin_uri( __FILE__ ) . 'html.twig' ) );
			}

			$data = array(
				'posts' => Timber::get_posts( $args ),
			);

			do_action( 'sh_shortcode_markup_inbox-before', $post_id, $args );

			if ( empty( $data['posts'] ) && is_user_logged_in() ) {
				esc_html_e( 'Not have any posts!', 'shortcodehub' );
			} else {
				echo Timber::compile_string( $raw_markup, $data );
			}

			do_action( 'sh_shortcode_markup_inbox-after', $post_id, $args );
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Query_Inbox::get_instance();

endif;
