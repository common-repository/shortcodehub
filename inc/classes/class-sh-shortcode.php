<?php
/**
 * Shortcode
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Shortcode' ) ) :

	/**
	 * Shortcode
	 *
	 * @since 0.0.1
	 */
	class Sh_Shortcode {

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
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/class-sh-shortcode-type-text-editor.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/class-sh-shortcode-type-menu.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/class-sh-shortcode-type-widget.php';
			require_once SHORTCODEHUB_DIR . 'inc/classes/types/query/class-sh-shortcode-type-query.php';

			add_shortcode( 'shortcodehub', array( $this, 'markup' ) );
		}

		/**
		 * Shortcode Markup
		 *
		 * @since 0.0.1
		 *
		 * @param  array $data Params.
		 * @return mixed
		 */
		function markup( $data = array() ) {

			$data = shortcode_atts(
				array(
					'id' => '',
				),
				$data
			);

			$post_id = absint( $data['id'] );

			if ( empty( $post_id ) ) {

				if ( is_user_logged_in() ) {
					/* translators: %s is shortcode archive link */
					return sprintf( __( '<p><i>You have entered invalid shortcode ID. Please add correct shortcode ID from the <a href="%s">available shortcode list</a>.</i></p>', 'shortcodehub' ), admin_url( 'edit.php?post_type=shortcode' ) );
				}

				// Non login user? Return null.
				return;
			}

			$shortcode_type  = get_post_meta( $post_id, 'shortcode-type', true );
			$shortcode_group = get_post_meta( $post_id, 'shortcode-group', true );

			$has_wrapper_classes = apply_filters( 'sh_has_shortcode_wrapper', true, $shortcode_type, $shortcode_group );

			ob_start();
			if ( $has_wrapper_classes ) { ?>
				<div class="shortcodehub sh-<?php echo esc_attr( $post_id ); ?> shortcode-type-<?php echo esc_attr( $shortcode_type ); ?>">
			<?php } ?>

			<?php
			do_action( 'sh_shortcode_markup_top', $post_id );
			do_action( 'sh_shortcode_markup_' . $shortcode_type, $post_id );
			do_action( 'sh_shortcode_markup_bottom', $post_id );

			// Edit shortcode link for logged in user.
			if ( ! is_customize_preview() && is_user_logged_in() ) {
				?>
				<p class="edit-link">
					<a href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>"><?php esc_html_e( 'Edit Shortcode', 'shortcodehub' ); ?></a>
					<?php do_action( 'sh_shortcode_edit_link_' . $shortcode_type, $post_id ); ?>
				</p>
				<?php
			}

			if ( $has_wrapper_classes ) {
				?>
				</div><!-- .shortcodehub .sh-<?php echo esc_attr( $post_id ); ?> -->
			<?php } ?>

			<?php

			return ob_get_clean();
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode::get_instance();

endif;
