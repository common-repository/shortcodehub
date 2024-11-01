<?php
/**
 * Page
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Page' ) ) :

	/**
	 * Page
	 *
	 * @since 0.0.1
	 */
	class Sh_Page {

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
		 */
		function __construct() {
			add_action( 'admin_menu', array( $this, 'register' ) );
			add_filter( 'submenu_file', array( $this, 'submenu_file' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'wp_ajax_sh_ajax_create_shortcode', array( $this, 'process_form' ) );
		}

		/**
		 * Set the submenus.
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function register() {
			global $submenu, $_registered_pages;

			$parent       = 'edit.php?post_type=shortcode';
			$dashboard    = 'edit.php?post_type=shortcode&page=shortcodehub';
			$cat_url      = 'edit-tags.php?taxonomy=shortcode-category&post_type=shortcode';
			$add_new_hook = 'shortcode_page_shortcode-add-new';

			$submenu[ $parent ]     = array();
			$submenu[ $parent ][10] = array( __( 'All Shortcodes', 'shortcodehub' ), 'edit_posts', $parent );
			$submenu[ $parent ][20] = array( __( 'Add New', 'shortcodehub' ), 'edit_posts', 'shortcode-add-new', '' );
			$submenu[ $parent ][30] = array( __( 'Categories', 'shortcodehub' ), 'manage_categories', $cat_url );
			$submenu[ $parent ][70] = array( __( 'Dashboard', 'shortcodehub' ), 'manage_categories', $dashboard );

			add_action( $add_new_hook, array( $this, 'add_new_page' ) );
			$_registered_pages[ $add_new_hook ] = true;
		}

		/**
		 * Add new page
		 *
		 * @since 0.0.1
		 */
		function add_new_page() {
			$groups = sh_get_shortcode_types();

			require_once SHORTCODEHUB_DIR . 'inc/includes/add-new-form.php';
		}

		/**
		 * Sets the active menu item for the admin submenu.
		 *
		 * @since 0.0.1
		 *
		 * @param string $submenu_file  Submenu file.
		 * @return string               Submenu file.
		 */
		function submenu_file( $submenu_file ) {
			global $pagenow;

			$screen = get_current_screen();

			if ( isset( $_GET['page'] ) && 'shortcode-add-new' == $_GET['page'] ) {
				return 'shortcode-add-new';
			} elseif ( 'post.php' == $pagenow && 'shortcode' == $screen->post_type ) {
				return 'edit.php?post_type=shortcode';
			} elseif ( 'edit-tags.php' == $pagenow && 'shortcode-category' == $screen->taxonomy ) {
				return 'edit-tags.php?taxonomy=shortcode-category&post_type=shortcode';
			} elseif ( 'edit.php' == $pagenow && 'shortcode_page_shortcodehub' == $screen->base ) {
				return 'edit.php?post_type=shortcode&page=shortcodehub';
			}

			return $submenu_file;
		}

		/**
		 * Enqueues the needed CSS/JS for Backend.
		 *
		 * @param  string $hook Current hook.
		 *
		 * @since 0.0.1
		 */
		function admin_scripts( $hook = '' ) {
			if ( 'shortcode_page_shortcode-add-new' !== $hook ) {
				return;
			}

			wp_register_style( 'magnific-popup', SHORTCODEHUB_URI . 'inc/assets/vendor/css/' . sh_get_css_path( 'magnific-popup' ), null, sh_get_product_version(), 'all' );
			wp_register_script( 'magnific-popup', SHORTCODEHUB_URI . 'inc/assets/vendor/js/' . sh_get_js_path( 'magnific-popup' ), array( 'jquery' ), sh_get_product_version(), SHORTCODEHUB_VER );

			wp_enqueue_style( 'sh-add-new-form', SHORTCODEHUB_URI . 'inc/assets/css/' . sh_get_css_path( 'add-new-form' ), array( 'magnific-popup' ), sh_get_product_version(), 'all' );
			wp_enqueue_script( 'sh-add-new-form', SHORTCODEHUB_URI . 'inc/assets/js/' . sh_get_js_path( 'add-new-form' ), array( 'jquery', 'magnific-popup' ), sh_get_product_version(), SHORTCODEHUB_VER );

			$vars = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'_nonce'  => wp_create_nonce( 'sh_ajax_validation' ),
			);

			wp_localize_script( 'sh-add-new-form', 'SHAddNewVars', $vars );
		}

		/**
		 * Create the shortcode from add new shortcode form.
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function process_form() {

			check_ajax_referer( 'sh_ajax_validation', 'security' );

			$title         = sanitize_text_field( $_POST['title'] );
			$type          = sanitize_text_field( $_POST['type'] );
			$group         = sanitize_text_field( $_POST['group'] );
			$selected_hook = sanitize_text_field( $_POST['selected_hook'] );

			// Create New Shortcode.
			$this->create_shortcode( $title, $type, $group, $selected_hook );
		}

		/**
		 * Create Shortcode
		 *
		 * @since 0.0.1
		 *
		 * @param  string $title Shrotcode Title.
		 * @param  string $type  Shrotcode Type.
		 * @param  string $group  Shrotcode Group.
		 * @param  string $selected_hook  Selected Hook.
		 * @return void
		 */
		function create_shortcode( $title = '', $type = '', $group = '', $selected_hook = '' ) {

			$title         = sanitize_text_field( $title );
			$type          = sanitize_text_field( $type );
			$group         = sanitize_text_field( $group );
			$selected_hook = isset( $_GET['selected-hook'] ) ? sanitize_text_field( $_GET['selected-hook'] ) : $selected_hook;

			$post_id = wp_insert_post(
				array(
					'post_title'     => $title,
					'post_type'      => 'shortcode',
					'post_status'    => 'draft',
					'ping_status'    => 'closed',
					'comment_status' => 'closed',
					'meta_input'     => array(
						'shortcode-type'  => $type,
						'shortcode-group' => $group,
						'sh-current-hook' => $selected_hook,
					),
				)
			);

			$url = add_query_arg(
				array(
					'post'           => $post_id,
					'action'         => 'edit',
					'selected-hook'  => $selected_hook,
					'classic-editor' => '',
				),
				admin_url( 'post.php' )
			);

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				wp_send_json_success( array( 'url' => $url ) );
			}

			// Redirect to the new shortcode.
			wp_redirect( $url );

			wp_die();
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Page::get_instance();

endif;

if ( ! function_exists( 'sh_create_shortcode' ) ) :
	/**
	 * Create Shortcode
	 *
	 * @since 0.0.1
	 *
	 * @param  string $title Shrotcode Title.
	 * @param  string $type  Shrotcode Type.
	 * @param  string $group  Shrotcode Group.
	 * @return void
	 */
	function sh_create_shortcode( $title = '', $type = '', $group = '' ) {
		Sh_Page::get_instance()->create_shortcode( $title, $type, $group );
	}
endif;
