<?php
/**
 * Hooks
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Hooks' ) ) :

	/**
	 * Hooks
	 *
	 * @since 0.0.1
	 */
	class Sh_Hooks {

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
			add_action( 'wp', array( $this, 'trigger_hook' ) );
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 90 );
			add_action( 'init', array( $this, 'show_hooks' ), 9999 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Enqueue Scripts
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function enqueue_scripts() {

			if ( false === $this->is_show_hooks() ) {
				return;
			}

			wp_enqueue_style( 'sh-show-hooks', SHORTCODEHUB_URI . 'inc/assets/css/' . sh_get_css_path( 'show-hooks' ), null, sh_get_product_version(), 'all' );
		}

		/**
		 * Get Show hooks URL
		 *
		 * @since 0.0.1
		 *
		 * @return string Show Hooks URL.
		 */
		function get_show_hooks_url() {
			if ( is_admin() ) {
				return add_query_arg(
					array(
						'show-hooks' => 'show',
					),
					site_url()
				);
			}

			$href       = add_query_arg( 'show-hooks', 'show' );
			$show_hooks = isset( $_GET['show-hooks'] ) ? sanitize_text_field( $_GET['show-hooks'] ) : '';
			if ( 'show' === $show_hooks ) {
				$href = remove_query_arg( 'show-hooks' );
			}
			return $href;
		}

		/**
		 * Trigger Hook
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function trigger_hook() {

			// Is Admin? Then return.
			if ( is_admin() ) {
				return;
			}

			$query_args = array(
				'post_type'      => 'shortcode',

				// Query performance optimization.
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			);

			$meta_query = new WP_Query( $query_args );

			// Is empty? Then return.
			if ( empty( $meta_query->posts ) ) {
				return;
			}

			foreach ( $meta_query->posts as $key => $post_id ) {

				// Execute hook.
				$action = get_post_meta( $post_id, 'sh-current-hook', true );
				if ( $action ) {
					add_action(
						$action,
						function() use ( $post_id ) {
							echo do_shortcode( '[shortcodehub id="' . absint( $post_id ) . '"]' );
						}
					);
				}
			}
		}

		/**
		 * Admin Bar Menu
		 *
		 * @since 0.0.1
		 *
		 * @param  array $wp_admin_bar Admin bar menus.
		 * @return void
		 */
		function admin_bar_menu( $wp_admin_bar = array() ) {

			$title = __( 'Show Hooks', 'shortcodehub' );

			$show_hooks = isset( $_GET['show-hooks'] ) ? sanitize_text_field( $_GET['show-hooks'] ) : '';
			if ( 'show' === $show_hooks ) {
				$title = esc_html__( 'Hide Hooks', 'shortcodehub' );
			}

			$wp_admin_bar->add_menu(
				array(
					'title'  => $title,
					'id'     => 'sh-show-hooks',
					'parent' => false,
					'href'   => $this->get_show_hooks_url(),
				)
			);
		}

		/**
		 * Get Hooks
		 *
		 * @since 0.0.1
		 *
		 * @return array Hooks List.
		 */
		function get_hooks() {
			return apply_filters(
				'sh_hooks',
				array(
					'core' => array(
						'title'       => __( 'Core Hooks', 'shortcodehub' ),
						'description' => __( 'Core hooks which are used in any WordPress theme/plugin.', 'shortcodehub' ),
						'hooks'       => array(
							array(
								'hook'        => 'wp_head',
								'title'       => __( 'WP Head', 'shortcodehub' ),
								'description' => __( 'Use hook <b>wp_head</b> to add the content within the &lt;head&gt;&lt;/head&gt; tag.', 'shortcodehub' ),
							),
							array(
								'hook'        => 'loop_start',
								'title'       => __( 'Loop Start', 'shortcodehub' ),
								'description' => __( 'Use hook <b>loop_start</b> to add the content at the start of the loop.', 'shortcodehub' ),
							),
							array(
								'hook'        => 'dynamic_sidebar_before',
								'title'       => __( 'Before Dynamic Sidebar', 'shortcodehub' ),
								'description' => __( 'Use hook <b>dynamic_sidebar_before</b> to add the content at before the sidebar.', 'shortcodehub' ),
							),
							array(
								'hook'        => 'dynamic_sidebar_after',
								'title'       => __( 'After Dynamic Sidebar', 'shortcodehub' ),
								'description' => __( 'Use hook <b>dynamic_sidebar_after</b> to add the content at after the sidebar.', 'shortcodehub' ),
							),
							array(
								'hook'        => 'loop_end',
								'title'       => __( 'Loop End', 'shortcodehub' ),
								'description' => __( 'Use hook <b>loop_end</b> to add the content at the start of the loop.', 'shortcodehub' ),
							),
							array(
								'hook'        => 'wp_footer',
								'title'       => __( 'WP Footer', 'shortcodehub' ),
								'description' => __( 'Use hook <b>wp_footer</b> to add the content exact before the &lt;/body&gt; tag.', 'shortcodehub' ),
							),
						),
					),
				)
			);
		}

		/**
		 * Show hooks
		 *
		 * @since 0.0.1
		 *
		 * @return mixed
		 */
		function show_hooks() {

			if ( false === $this->is_show_hooks() ) {
				return;
			}

			$hook_groups = $this->get_hooks();
			if ( $hook_groups ) {
				foreach ( $hook_groups as $key => $hook_group ) {
					foreach ( $hook_group['hooks'] as $key => $hook ) {
						add_action(
							$hook['hook'],
							function() {
								$current_hook = current_action();
								$hook_name    = str_replace( '_', ' ', $current_hook );
								$hook_name    = ucwords( $hook_name );
								?>
							<div class="sh-show-hooks sh-hook-<?php echo esc_attr( $current_hook ); ?>">
								<div>
									<span class="hook-name"><?php echo esc_html( $hook_name ); ?></span>
									<span class="add-new-hook"><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shortcode&page=shortcode-add-new&selected-hook=' . $current_hook ) ); ?>" title="<?php esc_html_e( 'Add new Shortcode', 'shortcodehub' ); ?>"><?php esc_html_e( 'Add Shortcode', 'shortcodehub' ); ?></a></span>
								</div>
								<div><small style="font-size: 10px;">
								<?php
								/* translators: %s is current hook name. */
								printf( __( 'Hook Name: %s', 'shortcodehub' ), $current_hook );
								?>
								</small></div>
								<?php
							},
							0
						);
						add_action(
							$hook['hook'],
							function() {
								?>
							</div><!-- .sh-show-hooks .sh-hook-<?php echo esc_attr( current_action() ); ?> -->
								<?php
							},
							99999
						);
					}
				}
			}
		}

		/**
		 * Show hooks
		 *
		 * Add `show-hooks` parameter in the URL to show the hooks.
		 *
		 * E.g. https://mysite.org/?show-hooks
		 *
		 * @since 0.0.1
		 * @return null If not Admin (wp-admin) or if not have the URL parameter `show-hooks`.
		 */
		function is_show_hooks() {

			if ( is_admin() ) {
				return false;
			}

			if ( ! isset( $_GET['show-hooks'] ) ) {
				return false;
			}

			$show_hooks = sanitize_text_field( $_GET['show-hooks'] );

			if ( 'show' !== $show_hooks ) {
				return false;
			}

			return true;
		}

		/**
		 * Get Hooks
		 *
		 * @since 0.0.1
		 *
		 * @param  string $hook_name Hook Name.
		 * @param  string $default Default Value.
		 * @return mixed
		 */
		function get_hook_description( $hook_name = '', $default = '' ) {

			if ( empty( $hook_name ) ) {
				return $default;
			}

			$hook_groups = $this->get_hooks();
			if ( $hook_groups ) {
				foreach ( $hook_groups as $key => $hook_group ) {
					foreach ( $hook_group['hooks'] as $key => $hook ) {
						if ( $hook_name === $hook['hook'] ) {
							if ( isset( $hook['description'] ) && ! empty( $hook['description'] ) ) {
								return $hook['description']; // WPCS: ok.
							}
						}
					}
				}
			}

			return $default;
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Hooks::get_instance();

endif;

if ( ! function_exists( 'sh_get_show_hooks_url' ) ) :
	/**
	 * Get show hooks URL
	 *
	 * @since 0.0.1
	 * @return string
	 */
	function sh_get_show_hooks_url() {
		return Sh_Hooks::get_instance()->get_show_hooks_url();
	}
endif;

if ( ! function_exists( 'sh_get_hooks' ) ) :
	/**
	 * Get hooks
	 *
	 * @since 0.0.1
	 * @return array Hooks list.
	 */
	function sh_get_hooks() {
		return Sh_Hooks::get_instance()->get_hooks();
	}
endif;

if ( ! function_exists( 'sh_get_hook_description' ) ) :
	/**
	 * Get hook description.
	 *
	 * @since 0.0.1
	 * @param  string $selected_hook Selected hook.
	 * @return string
	 */
	function sh_get_hook_description( $selected_hook = '' ) {
		return Sh_Hooks::get_instance()->get_hook_description( $selected_hook );
	}
endif;
