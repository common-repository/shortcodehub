<?php
/**
 * Shortcode Type: Menu
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Menu' ) ) :

	/**
	 * Shortcode Type: Menu
	 *
	 * @since 0.0.1
	 */
	class Sh_Shortcode_Type_Menu {

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
			add_action( 'sh_shortcode_markup_menu', array( $this, 'shortcode_markup' ) );
			add_action( 'sh_metabox_menu', array( $this, 'metabox_markup' ), 10, 2 );
			add_action( 'sh_save_shortcode_menu', array( $this, 'save_shortcode' ), 10, 3 );
		}

		/**
		 * Meta box display callback.
		 *
		 * @since 0.0.1
		 *
		 * @param string  $shortcode_group Shortcode Group.
		 * @param WP_Post $post Current post object.
		 * @return void
		 */
		function metabox_markup( $shortcode_group, $post ) {
			$selected_nav_menu_slug = get_post_meta( $post->ID, 'sh-menu-id', true );

			$nav_menus = wp_get_nav_menus();
			?>
			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Select Menu', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<select name="sh-menu-id">
							<option value=""><?php esc_html_e( 'Select Menu...', 'shortcodehub' ); ?></option>
							<?php foreach ( $nav_menus as $key => $nav_menu ) : ?>
								<option value="<?php echo esc_attr( $nav_menu->slug ); ?>" <?php selected( $selected_nav_menu_slug, $nav_menu->slug ); ?>>
									<?php echo esc_html( $nav_menu->name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Save Shortcode
		 *
		 * @param  string $shortcode_group Shortcode Group.
		 * @param  int    $post_id            Post ID.
		 * @return void
		 */
		function save_shortcode( $shortcode_group = '', $post_id = 0 ) {
			if ( isset( $_POST['sh-menu-id'] ) ) {
				update_post_meta( $post_id, 'sh-menu-id', sanitize_key( $_POST['sh-menu-id'] ) );
			}
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

			// Get menu ID.
			$selected_menu_id = get_post_meta( $post_id, 'sh-menu-id', true );

			// If empty then return.
			if ( empty( $selected_menu_id ) ) {
				return;
			}

			wp_nav_menu( array( 'menu' => $selected_menu_id ) );
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Menu::get_instance();

endif;
