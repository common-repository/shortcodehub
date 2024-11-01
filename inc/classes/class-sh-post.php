<?php
/**
 * Post
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Post' ) ) :

	/**
	 * Post
	 *
	 * @since 0.0.1
	 */
	class Sh_Post {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class object.
		 * @since 0.0.1
		 */
		private static $instance;

		/**
		 * Processed Ids.
		 *
		 * @access private
		 * @var array Post ids.
		 * @since 0.0.1
		 */
		private $ids = array();

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
		private function __construct() {
			add_action( 'init', array( $this, 'register_post_and_taxonomies' ) );
			add_action( 'add_meta_boxes', array( $this, 'meta_box_settings' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_head', array( $this, 'disable_editor' ) );
			add_filter( 'the_content', array( $this, 'content' ) );

			// Column.
			add_filter( 'manage_shortcode_posts_columns', array( $this, 'filter_view_custom_column_header' ) );
			add_action( 'manage_shortcode_posts_custom_column', array( $this, 'action_view_custom_column_content' ), 10, 2 );
			add_action( 'save_post_shortcode', array( $this, 'save_shortcode' ) );
		}

		/**
		 * Save Shortcode
		 *
		 * @since 0.0.1
		 *
		 * @param  int $post_id Post ID.
		 * @return void
		 */
		function save_shortcode( $post_id ) {

			$shortcode_group = get_post_meta( $post_id, 'shortcode-group', true );
			$shortcode_type  = get_post_meta( $post_id, 'shortcode-type', true );

			$selected_hook = isset( $_POST['sh-current-hook'] ) ? $_POST['sh-current-hook'] : get_post_meta( $post_id, 'sh-current-hook', true );
			update_post_meta( $post_id, 'sh-current-hook', $selected_hook );

			// Shortcode Group.
			do_action( 'sh_save_shortcode_' . $shortcode_group, $shortcode_type, $post_id );

			// Shortcode Type.
			do_action( 'sh_save_shortcode_' . $shortcode_type, $shortcode_group, $post_id );

			// Flush rewrite rules.
			if ( false === get_option( 'sh_flush_rewrite_rules', false ) ) {

				update_option( 'sh_flush_rewrite_rules', true );

				flush_rewrite_rules();
			}

		}

		/**
		 * Modify column in View list page (Admin)
		 *
		 * @since 0.0.1
		 *
		 * @param array $defaults Default column slugs.
		 * @return array
		 */
		public function filter_view_custom_column_header( $defaults ) {
			unset( $defaults['taxonomy-shortcode-category'] );
			unset( $defaults['author'] );
			unset( $defaults['date'] );

			$defaults['shortcode']                   = __( 'Shortcode', 'shortcodehub' );
			$defaults['action']                      = __( 'Selected Hook', 'shortcodehub' );
			$defaults['taxonomy-shortcode-category'] = __( 'Categories', 'shortcodehub' );
			$defaults['author']                      = __( 'Author', 'shortcodehub' );
			$defaults['date']                        = __( 'Date', 'shortcodehub' );

			return $defaults;
		}

		/**
		 * Admin custom column content
		 *
		 * @since 0.0.1
		 *
		 * @param type $column_name Column Name.
		 * @param type $post_id Post ID.
		 * @return void
		 */
		public function action_view_custom_column_content( $column_name, $post_id ) {
			if ( 'shortcode' == $column_name ) {
				printf( '<input type="text" style="width: 180px;" value="[shortcodehub id=&quot;%s&quot;]" onclick="this.select()" readonly="">', $post_id );
			}
			if ( 'action' == $column_name ) {
				echo get_post_meta( $post_id, 'sh-current-hook', true );
			}
		}

		/**
		 * Filter Content
		 *
		 * @since 0.0.1
		 *
		 * @param  mixed $content Post Content.
		 * @return mixed
		 */
		function content( $content ) {

			if ( 'shortcode' !== get_post_type() ) {
				return $content;
			}

			if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
				return $content;
			}

			if ( in_array( get_the_ID(), $this->ids ) ) {
				return $content;
			}

			$this->ids[] = get_the_ID();

			return '<div>' . do_shortcode( "[shortcodehub id='" . get_the_ID() . "']" ) . '</div>';
		}

		/**
		 * Disable editor
		 *
		 * If shortcode type other than 'page' then disable the editor.
		 *
		 * @since 0.0.1
		 */
		function disable_editor() {
			$shortcode_type = get_post_meta( get_the_ID(), 'shortcode-type', true );

			if ( 'text-editor' !== $shortcode_type ) {
				global $_wp_post_type_features;
				unset( $_wp_post_type_features['shortcode']['editor'] );
			}
		}

		/**
		 * Admin Scripts
		 *
		 * @since 0.0.1
		 *
		 * @param  string $hook Current page hook.
		 * @return void
		 */
		function admin_scripts( $hook = '' ) {

			if ( 'shortcode' !== get_current_screen()->id && 'edit-shortcode' !== get_current_screen()->id ) {
				return;
			}

			wp_enqueue_style( 'select2', SHORTCODEHUB_URI . 'inc/assets/vendor/css/' . sh_get_css_path( 'select2' ), null, sh_get_product_version(), 'all' );
			wp_enqueue_script( 'select2', SHORTCODEHUB_URI . 'inc/assets/vendor/js/' . sh_get_js_path( 'select2' ), array( 'jquery' ), sh_get_product_version(), true );
			wp_enqueue_script( 'sh-post', SHORTCODEHUB_URI . 'inc/assets/js/' . sh_get_js_path( 'post' ), array( 'wp-util', 'jquery' ), sh_get_product_version(), true );
			wp_enqueue_style( 'sh-post', SHORTCODEHUB_URI . 'inc/assets/css/' . sh_get_css_path( 'post' ), null, sh_get_product_version(), 'all' );

			$args = array(
				'hook_groups' => sh_get_hooks(),
			);
			wp_localize_script( 'sh-post', 'SHArgs', $args );
		}

		/**
		 * Register meta box(es).
		 *
		 * @since 0.0.1
		 */
		function meta_box_settings() {
			if ( 'shortcode' !== get_post_type() ) {
				return;
			}

			add_meta_box( 'shortcodehub', __( 'Shortcode Settings', 'shortcodehub' ), array( $this, 'meta_box_callback' ), null, 'normal', 'high' );
			add_meta_box( 'sh-sidebar', __( 'Show On', 'shortcodehub' ), array( $this, 'meta_box_side_callback' ), null, 'side', 'high' );
		}

		/**
		 * Meta Box
		 *
		 * @since 0.0.1
		 *
		 * @param  object $post Post object.
		 * @return mixed
		 */
		function meta_box_side_callback( $post ) {

			$hook_groups   = sh_get_hooks();
			$selected_hook = get_post_meta( $post->ID, 'sh-current-hook', true );
			if ( empty( $selected_hook ) ) {
				$selected_hook = isset( $_GET['selected-hook'] ) ? sanitize_text_field( $_GET['selected-hook'] ) : '';
			}
			$selected_hook_description = sh_get_hook_description( $selected_hook );
			?>
			<?php if ( $hook_groups ) { ?>
				<p>
					<select name="sh-current-hook" class="sh-current-hook" style="width: 100%;">
						<option value=""><?php esc_html_e( 'Select Hook', 'shortcodehub' ); ?></option>
						<?php foreach ( $hook_groups as $key => $hook_group ) { ?>
							<optgroup label="<?php echo esc_html( $hook_group['title'] ); ?>"> 
								<?php foreach ( $hook_group['hooks'] as $key => $hook ) { ?>
									<option value="<?php echo esc_attr( $hook['hook'] ); ?>" <?php selected( $selected_hook, $hook['hook'] ); ?>><?php echo esc_html( $hook['title'] ); ?></option>
								<?php } ?>
							</optgroup>
						<?php } ?>
					</select>
				</p>
				<p class="sh-current-hook-description description"></p>
				<p class="sh-default-hook-description description" style="display: none;">
					<?php esc_html_e( 'Show shortcode on above selected hook.', 'shortcodehub' ); ?>
					<?php sh_tip_icon( 'sh-tip-hooks', '' ); ?>
					<?php /* translators: %s is show hooks link. */ ?>
					<?php printf( __( '<br/>Don\'t know hook locations? <a href="%s" target="_blank">Show Hooks..</a>', 'shortcodehub' ), esc_url( sh_get_show_hooks_url() ) ); ?>
				</p>
				<?php sh_tip_content( 'sh-tip-hooks', __( '<p class="description">Your hook is not listed in above hooks list? Then, <a href="https://docs.surror.com/doc/shortcodehub/add-hooks" target="_blank">Add Hooks..</a></p>', 'shortcodehub' ) ); ?>
			<?php } ?>
			<p class="description sh-seperator"><?php esc_html_e( 'Use below shortcode anywhere:', 'shortcodehub' ); ?></p>
			<p><input type="text" onClick="this.select();" value="[shortcodehub id='<?php echo esc_attr( $post->ID ); ?>']" readonly="" style="width: 100%;"></p>
			<p class="description sh-seperator"><?php esc_html_e( 'Use below code in theme/plugin template file:', 'shortcodehub' ); ?></p>
			<p><input type="text" onClick="this.select();" value="&lt;?php echo do_shortcode( &quot;[shortcodehub id=&apos;<?php echo esc_attr( $post->ID ); ?>&apos;]&quot; ); ?&gt;" readonly="" style="width: 100%;"></p>
			<?php
		}

		/**
		 * Meta box display callback.
		 *
		 * @since 0.0.1
		 *
		 * @param WP_Post $post Current post object.
		 * @return void
		 */
		function meta_box_callback( $post ) {
			$shortcode_group = get_post_meta( $post->ID, 'shortcode-group', true );
			$shortcode_type  = get_post_meta( $post->ID, 'shortcode-type', true );

			do_action( 'sh_metabox_top', $shortcode_group, $post );
			?>
			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Shortcode Group', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<?php esc_html( sh_shortcode_type_title( $shortcode_group, $shortcode_type ) ); ?>
					</td>
				</tr>
			</table>

			<?php
			do_action( 'sh_metabox_' . $shortcode_group, $shortcode_type, $post );
			do_action( 'sh_metabox_' . $shortcode_type, $shortcode_group, $post );

			do_action( 'sh_metabox_bottom', $shortcode_group, $post );
		}

		/**
		 * Register Post & Taxonomies
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		public function register_post_and_taxonomies() {

			/**
			 * Register Post Type
			 *
			 * Register "ShortcodeHub" post type.
			 */
			$labels = array(
				'name'               => _x( 'Shortcodes', 'post type general name', 'shortcodehub' ),
				'singular_name'      => _x( 'Shortcode', 'post type singular name', 'shortcodehub' ),
				'menu_name'          => _x( 'Shortcodes', 'admin menu', 'shortcodehub' ),
				'name_admin_bar'     => _x( 'Shortcode', 'add new on admin bar', 'shortcodehub' ),
				'add_new'            => _x( 'Add New', 'new shortcode item', 'shortcodehub' ),
				'add_new_item'       => __( 'Add New Shortcode', 'shortcodehub' ),
				'new_item'           => __( 'New Shortcode', 'shortcodehub' ),
				'edit_item'          => __( 'Edit Shortcode', 'shortcodehub' ),
				'view_item'          => __( 'View Shortcode', 'shortcodehub' ),
				'all_items'          => __( 'All Shortcodes', 'shortcodehub' ),
				'search_items'       => __( 'Search Shortcodes', 'shortcodehub' ),
				'parent_item_colon'  => __( 'Parent Shortcodes:', 'shortcodehub' ),
				'not_found'          => __( 'No Shortcodes found.', 'shortcodehub' ),
				'not_found_in_trash' => __( 'No Shortcodes found in Trash.', 'shortcodehub' ),
			);

			$args = apply_filters(
				'sh_shortcode_post_type_args',
				array(
					'labels'             => $labels,
					'description'        => __( 'Description.', 'shortcodehub' ),
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => true,
					'has_archive'        => true,
					'hierarchical'       => true,
					'menu_position'      => null,
					'menu_icon'          => 'dashicons-editor-code',
					'supports'           => array( 'title', 'editor', 'excerpt' ),
					'rewrite'            => array( 'slug' => 'shortcode' ),
				)
			);

			register_post_type( 'shortcode', $args );

			/**
			 * Register Taxonomy
			 *
			 * Register taxonomy.
			 */
			$tax_labels = array(
				'name'              => _x( 'Categories', 'taxonomy general name', 'shortcodehub' ),
				'singular_name'     => _x( 'Categories', 'taxonomy singular name', 'shortcodehub' ),
				'search_items'      => __( 'Search Categories', 'shortcodehub' ),
				'all_items'         => __( 'All Categories', 'shortcodehub' ),
				'parent_item'       => __( 'Parent Categories', 'shortcodehub' ),
				'parent_item_colon' => __( 'Parent Categories:', 'shortcodehub' ),
				'edit_item'         => __( 'Edit Categories', 'shortcodehub' ),
				'update_item'       => __( 'Update Categories', 'shortcodehub' ),
				'add_new_item'      => __( 'Add New Categories', 'shortcodehub' ),
				'new_item_name'     => __( 'New Categories Name', 'shortcodehub' ),
				'menu_name'         => __( 'Categories', 'shortcodehub' ),
			);

			$tax_args = array(
				'hierarchical'          => true,
				'labels'                => $tax_labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'query_var'             => true,
				'show_in_rest'          => true,
				'can_export'            => true,
				'rest_controller_class' => 'WP_REST_Terms_Controller',
			);

			register_taxonomy( 'shortcode-category', array( 'shortcode' ), $tax_args );

		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Post::get_instance();

endif;
