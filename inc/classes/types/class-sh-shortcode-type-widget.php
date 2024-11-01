<?php
/**
 * Shortcode Type: Widget
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Shortcode_Type_Widget' ) ) :

	/**
	 * Shortcode Type: Widget
	 *
	 * @since 0.0.1
	 */
	class Sh_Shortcode_Type_Widget {

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
			add_action( 'sh_shortcode_markup_widget', array( $this, 'shortcode_markup' ) );
			add_action( 'sh_metabox_widget', array( $this, 'metabox_markup' ), 10, 2 );
			add_action( 'sh_save_shortcode_widget', array( $this, 'save_shortcode' ), 10, 3 );
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

			global $wp_registered_widgets, $wp_registered_sidebars;

			$selected_widget_id = get_post_meta( $post->ID, 'sh-widget-id', true );
			?>
			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Select Widget', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<select name="sh-widget-id">
							<option value=""><?php esc_html_e( 'Select Widget', 'shortcodehub' ); ?></option>
							<?php
							foreach ( wp_get_sidebars_widgets() as $sidebar_id => $widget_ids ) {
								if ( ! empty( $widget_ids ) ) {
									if ( 'wp_inactive_widgets' !== $sidebar_id ) {
										?>
										<optgroup label="<?php echo esc_html( $wp_registered_sidebars[ $sidebar_id ]['name'] ); ?>"> 
											<?php foreach ( $widget_ids as $key => $widget_id ) : ?>
												<option value="<?php echo esc_attr( $widget_id ); ?>" <?php selected( $selected_widget_id, $widget_id ); ?>>
													<?php echo esc_html( $wp_registered_widgets[ $widget_id ]['name'] ); ?>
												</option>
											<?php endforeach; ?>
										</optgroup>
										<?php
									}
								}
							}
							?>
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
			if ( isset( $_POST['sh-widget-id'] ) ) {
				update_post_meta( $post_id, 'sh-widget-id', sanitize_key( $_POST['sh-widget-id'] ) );
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
			$selected_widget_id = get_post_meta( $post_id, 'sh-widget-id', true );

			// If empty then return.
			if ( empty( $selected_widget_id ) ) {
				return;
			}

			global $wp_registered_widgets;

			// If empty then return.
			if ( empty( $wp_registered_widgets ) ) {
				return;
			}

			// If empty then return.
			if ( empty( $wp_registered_widgets ) ) {
				return;
			}

			// If not exist in widget list.
			if ( ! array_key_exists( $selected_widget_id, $wp_registered_widgets ) ) {
				return;
			}

			// Get widget class.
			$widget_class = get_class( $wp_registered_widgets[ $selected_widget_id ]['callback'][0] );

			// Class not exist the return.
			if ( ! class_exists( $widget_class ) ) {
				return;
			}

			// Get widget instance.
			$instance = get_option( $wp_registered_widgets[ $selected_widget_id ]['callback'][0]->option_name, '' );

			// If empty then return.
			if ( empty( $instance ) ) {
				return;
			}

			// Get widget instance number.
			$instance_number = $wp_registered_widgets[ $selected_widget_id ]['params'][0]['number'];

			// Get current widget instance.
			$widget_instance = array_key_exists( $instance_number, $instance ) ? $instance[ $instance_number ] : '';

			if ( empty( $widget_instance ) ) {
				return;
			}

			// Execute widget.
			the_widget( $widget_class, $widget_instance );
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Type_Widget::get_instance();

endif;
