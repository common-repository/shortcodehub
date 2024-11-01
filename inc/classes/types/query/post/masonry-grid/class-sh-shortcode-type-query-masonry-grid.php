<?php
/**
 * Masonry Grid
 *
 * @since 1.2.0
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Query_Masonry_Grid' ) ) :

	/**
	 * Masonry Grid
	 *
	 * @since 1.2.0
	 */
	class Sh_Shortcode_Type_Query_Masonry_Grid {

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
			add_action( 'sh_shortcode_markup_masonry-grid', array( $this, 'shortcode_markup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'sh_metabox_post-query', array( $this, 'metabox_markup' ), 12, 2 );
			add_action( 'sh_save_shortcode_post-query', array( $this, 'save_shortcode' ), 10, 3 );
		}

		/**
		 * Save Shortcode
		 *
		 * @param  string $shortcode_group Shortcode Group.
		 * @param  int    $post_id            Post ID.
		 * @return void
		 */
		function save_shortcode( $shortcode_group = '', $post_id = 0 ) {
			$shortcode_type = get_post_meta( $post_id, 'shortcode-type', true );
			if ( 'masonry-grid' !== $shortcode_type ) {
				return;
			}

			if ( isset( $_POST['sh-query-masonry-cols'] ) ) {
				update_post_meta( $post_id, 'sh-query-masonry-cols', $_POST['sh-query-masonry-cols'] );
			}
		}

		/**
		 * Meta box display callback.
		 *
		 * @since 1.2.0
		 *
		 * @param string  $shortcode_group Shortcode Group.
		 * @param WP_Post $post Current post object.
		 * @return void
		 */
		function metabox_markup( $shortcode_group, $post ) {
			$shortcode_type = get_post_meta( $post->ID, 'shortcode-type', true );

			if ( 'masonry-grid' !== $shortcode_type ) {
				return;
			}

			$cols = get_post_meta( $post->ID, 'sh-query-masonry-cols', true );
			?>

			<h3 class="sh-title"><?php esc_html_e( 'Styling', 'shortcodehub' ); ?></h3>
			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Columns', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<input type="number" name="sh-query-masonry-cols" value="<?php echo esc_attr( $cols ); ?>" placeholder="3" max="4" min="1" />
						<p class="description"><?php esc_html_e( 'Show number of items per column.', 'shortcodehub' ); ?></p>
					</td>
				</tr>
			</table>
			<?php
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
			wp_register_style( 'sh-masonry-grid', sh_get_plugin_uri( __FILE__ ) . 'css-static.css', null, sh_get_product_version(), 'all' );
			wp_register_script( 'sh-masonry-grid', sh_get_plugin_uri( __FILE__ ) . 'js-static.js', array( 'jquery', 'jquery-masonry' ), sh_get_product_version(), true );
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
			wp_enqueue_style( 'bootstrap-grid' );
			wp_enqueue_style( 'sh-masonry-grid' );
			wp_enqueue_script( 'sh-masonry-grid' );

			$override_markup = get_post_meta( $post_id, 'sh-query-override-markup', true );
			if ( $override_markup ) {
				$raw_markup = get_post_meta( $post_id, 'sh-query-markup', true );
			} else {
				$raw_markup = sh_get_filesystem()->get_contents( sh_get_plugin_uri( __FILE__ ) . 'html.twig' );
			}

			$col_class = 'col-md-4';
			$cols      = get_post_meta( $post_id, 'sh-query-masonry-cols', true );

			if ( ! empty( $cols ) ) {
				switch ( $cols ) {
					case '4':
						$col_class = 'col-md-3';
						break;
					case '3':
						$col_class = 'col-md-4';
						break;
					case '2':
						$col_class = 'col-md-6';
						break;
					case '1':
						$col_class = 'col-md-12';
						break;
				}
			}

			$data = array(
				'posts' => Timber::get_posts( $args ),
				'class' => $col_class,
			);

			do_action( 'sh_shortcode_markup_masonry-grid-before', $post_id, $args );

			if ( empty( $data['posts'] ) && is_user_logged_in() ) {
				esc_html_e( 'Not have any posts!', 'shortcodehub' );
			} else {
				echo Timber::compile_string( $raw_markup, $data );
			}

			do_action( 'sh_shortcode_markup_masonry-grid-after', $post_id, $args );
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Query_Masonry_Grid::get_instance();

endif;
