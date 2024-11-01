<?php
/**
 * Dashboard
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Dashboard' ) ) :

	/**
	 * Dashboard
	 */
	class Sh_Dashboard {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class object.
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
		 *  Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// AJAX.
			add_action( 'wp_ajax_sh-submit-product-rating', array( $this, 'submit_product_rating' ) );

			// Tabs.
			add_action( 'sh_dashboard_welcome', array( $this, 'markup_welcome' ) );

			add_action( 'admin_init', array( $this, 'redirect_to_dashboard' ) );
			add_action( 'admin_head', array( $this, 'create_shortcode' ) );

			add_action( 'plugin_action_links_' . SHORTCODEHUB_BASE, array( $this, 'action_links' ) );
			add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ), 50 );
		}

		/**
		 * Add dashboard widget
		 *
		 * @since 1.5.0
		 */
		function add_dashboard_widget() {

			wp_add_dashboard_widget( 'sh-dashboard-overview', sprintf( __( '%s Overview', 'shortcodehub' ), sh_get_product_name() ), array( $this, 'widget_markup' ) );

			// Move our widget to top.
			global $wp_meta_boxes;

			$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
			$ours      = [
				'sh-dashboard-overview' => $dashboard['sh-dashboard-overview'],
			];

			$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $ours, $dashboard ); // WPCS: override ok.
		}

		/**
		 * Widget markup
		 *
		 * @since 1.5.0
		 */
		function widget_markup() {

			wp_enqueue_style( 'sh-dashboard-widget' );

			if ( false === ( $updates = get_transient( 'sh_dashboard_widget_updates' ) ) ) {
				$parameters = array(
					'timeout' => 200,
				);

				$raw_extensions = wp_remote_get(
					'https://surror.com/wp-json/wp/v2/posts/?_fields=title,link&per_page=5',
					$parameters
				);
				if ( ! is_wp_error( $raw_extensions ) ) {
					$updates = json_decode( wp_remote_retrieve_body( $raw_extensions ), true );
					set_transient( 'sh_dashboard_widget_updates', $updates, WEEK_IN_SECONDS );
				}
			}

			$query_args = [
				'post_type'      => 'shortcode',
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => '3',
				'orderby'        => 'modified',
			];

			$query = new WP_Query( $query_args );
			?>
			<div class="sh-dashboard-widget">
				<div class="sh-header">
					<div class="logo">
						<img src="<?php echo esc_url( SHORTCODEHUB_URI . 'inc/assets/images/logo-128x128.jpg' ); ?>" style="width: 40px;" />
						<div class="sh-version"><?php echo sh_get_product_name(); ?> v<?php echo SHORTCODEHUB_VER; ?></div>
					</div>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shortcode&page=shortcode-add-new' ) ); ?>" class="button"><span aria-hidden="true" class="dashicons dashicons-plus"></span> <?php esc_html_e( 'Create New Shortcode', 'shortcodehub' ); ?></a>
				</div>

				<div class="sh-recent-edits">
					<h3><?php esc_html_e( 'Recent Edits', 'shortcodehub' ); ?></h3>
					<ul>
						<?php if ( $query->posts ) { ?>
							<?php foreach ( $query->posts as $key => $single_post ) { ?>
								<li>
									<a href="<?php echo esc_url( get_edit_post_link( $single_post->ID ) ); ?>" target="_blank"><?php echo esc_html( $single_post->post_title ); ?></a>
									<?php
									$date = date_i18n( _x( 'M jS h:i a', 'Dashboard Overview Widget Recently Date', 'shortcodehub' ), get_the_modified_time( 'U', $single_post->ID ) );
									echo $date;
									?>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>

				<div class="sh-news-and-updates">
					<h3><?php esc_html_e( 'News & Updates', 'shortcodehub' ); ?></h3>
					<ul>
						<?php if ( $updates ) { ?>
							<?php foreach ( $updates as $key => $site ) { ?>
								<li>
									<a href="<?php echo esc_url( $site['link'] ); ?>" target="_blank"><?php echo esc_html( $site['title']['rendered'] ); ?></a>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>

				<div class="sh-footer">
					<ul>
						<li><a href="<?php echo esc_url( sh_get_product_uri() ); ?>" target="_blank"><?php esc_html_e( 'Blog', 'shortcodehub' ); ?> <i class="dashicons dashicons-external"></i></a></li>
						<li><a href="<?php echo esc_url( sh_get_product_support_url() ); ?>" target="_blank"><?php esc_html_e( 'Help', 'shortcodehub' ); ?> <i class="dashicons dashicons-external"></i></a></li>

						<?php if ( ! apply_filters( 'sh_remove_pro_button', false ) ) { ?>
							<li><a href="<?php echo esc_url( sh_get_product_pro_url() ); ?>" target="_blank"><?php esc_html_e( 'Get Pro', 'shortcodehub' ); ?> <i class="dashicons dashicons-external"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<?php
		}

		/**
		 * Show action links on the plugin screen.
		 *
		 * @param   mixed $links Plugin Action links.
		 * @return  array
		 */
		function action_links( $links ) {
			$action_links = array(
				'dashboard' => '<a href="' . admin_url( 'edit.php?post_type=shortcode&page=shortcodehub' ) . '" aria-label="' . esc_attr__( 'Dashboard', 'shortcodehub' ) . '">' . esc_html__( 'Dashboard', 'shortcodehub' ) . '</a>',
			);

			return array_merge( $action_links, $links );
		}

		/**
		 * Redirect to Dashboard Page.
		 *
		 * @since 0.0.1
		 *
		 * @return mixed
		 */
		function redirect_to_dashboard() {

			if ( ! get_transient( 'sh_redirect_after_activation' ) ) {
				return;
			}

			// Delete the transient.
			delete_transient( 'sh_redirect_after_activation' );

			// Redirect to the Dashboard page.
			if ( ! is_multisite() ) {

				// Redirect to 'Getting Started' page for first activation.
				if ( false === get_option( 'sh_first_activation' ) ) {

					// Safe redirect.
					wp_safe_redirect( admin_url( 'edit.php?post_type=shortcode&page=shortcodehub&getting-started' ) );

					// Set first activation.
					update_option( 'sh_first_activation', true );
				} else {
					wp_safe_redirect( admin_url( 'edit.php?post_type=shortcode&page=shortcodehub&getting-started' ) );
				}
				exit();
			}

		}

		/**
		 * Enqueue Scripts
		 *
		 * @since 0.0.1
		 *
		 * @param  string $hook Current Hook.
		 * @return mixed
		 */
		function enqueue_scripts( $hook = '' ) {
			wp_register_style( 'sh-dashboard-widget', sh_get_plugin_uri( __FILE__ ) . 'dashboard-widget.css', null, sh_get_product_version(), 'all' );

			if ( 'shortcode_page_shortcodehub' !== $hook ) {
				return;
			}

			wp_enqueue_style( 'sh-dashboard', sh_get_plugin_uri( __FILE__ ) . 'dashboard.css', null, sh_get_product_version(), 'all' );
			wp_enqueue_script( 'sh-dashboard', sh_get_plugin_uri( __FILE__ ) . 'dashboard.js', array( 'jquery' ), sh_get_product_version(), true );
		}

		/**
		 * Add Menu
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function add_menu() {
			add_submenu_page( 'edit.php?post_type=shortcode', __( 'Dashboard', 'shortcodehub' ), __( 'Dashboard', 'shortcodehub' ), 'manage_options', sh_get_product_slug(), array( $this, 'page_content' ) );
		}

		/**
		 * Welcome Content
		 *
		 * @since 0.0.1
		 *
		 * @param string $tab Current Tab Slug.
		 * @return void
		 */
		function markup_welcome( $tab = '' ) {
			?>
			<div id="welcome-panel" class="welcome-panel" style="margin-top:0;">
				<div class="welcome-panel-content">
					<h2><?php esc_html_e( 'Welcome to ShortcodeHub!', 'shortcodehub' ); ?></h2>
					<p class="about-description"><?php esc_html_e( 'We\'ve assembled some links to get you started:', 'shortcodehub' ); ?></p>
					<div class="welcome-panel-column-container">
						<div class="welcome-panel-column">
							<h3><?php esc_html_e( 'Get Started', 'shortcodehub' ); ?></h3>
							<a class="button button-primary button-hero" href="<?php echo esc_url( admin_url( 'edit.php?post_type=shortcode&page=shortcode-add-new' ) ); ?>"><?php esc_html_e( 'Create Your Shortcode', 'shortcodehub' ); ?></a>
							<?php /* translators: %s quick start guide. */ ?>
							<p><?php printf( __( 'or, <a href="%s">check quick start guide</a>', 'shortcodehub' ), admin_url( 'edit.php?post_type=shortcode&page=shortcodehub&getting-started' ) ); ?></p>
						</div>
						<div class="welcome-panel-column">
							<h3><?php esc_html_e( 'Quick Links', 'shortcodehub' ); ?></h3>
							<ul>
								<li><a href="https://docs.surror.com/" target="_blank"><i class="welcome-icon dashicons dashicons-editor-code"></i> <?php esc_html_e( 'Most useful shortcodes', 'shortcodehub' ); ?></a></li>
								<li><a href="https://docs.surror.com/" target="_blank"><i class="welcome-icon dashicons dashicons-welcome-learn-more"></i> <?php esc_html_e( 'Learn more about getting started', 'shortcodehub' ); ?></a></li>
							</ul>
						</div>
						<div class="welcome-panel-column welcome-panel-last">
							<h3><?php esc_html_e( 'More Actions', 'shortcodehub' ); ?></h3>
							<ul>
								<li><a href="https://www.facebook.com/groups/440225573212597/" target="_blank"><i class="welcome-icon dashicons dashicons-facebook-alt"></i> <?php esc_html_e( 'Join Facebook Group', 'shortcodehub' ); ?></a></li>
								<li><a href="https://forum.surror.com/forums/forum/shortcodehub/" target="_blank"><i class="welcome-icon dashicons dashicons-groups"></i> <?php esc_html_e( 'Ask on Forum', 'shortcodehub' ); ?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Create Shortcode
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function create_shortcode() {

			$create_shortcode = isset( $_GET['create-shortcode'] ) ? sanitize_text_field( $_GET['create-shortcode'] ) : '';
			$shortcode_title  = isset( $_GET['title'] ) ? sanitize_text_field( $_GET['title'] ) : '';
			$shortcode_type   = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : '';

			if ( 'yes' !== $create_shortcode ) {
				return;
			}

			if ( empty( $shortcode_type ) ) {
				return;
			}

			sh_create_shortcode( $shortcode_title, $shortcode_type );
		}

		/**
		 * Triggered when clicking the rating footer.
		 *
		 * @since 0.0.1
		 */
		function submit_product_rating() {
			update_user_meta( get_current_user_id(), 'sh-rating', 1 );
			wp_send_json_success( get_current_user_id() );
		}

		/**
		 * Theme Page Content
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function page_content() {

			$current_tab = 'welcome';
			if ( isset( $_GET['tab'] ) ) {
				$current_tab = sanitize_key( $_GET['tab'] );
			}

			$tabs = $this->get_tabs();

			$title = isset( $tabs[ $current_tab ] ) ? $tabs[ $current_tab ] : __( 'Dashboard', 'shortcodehub' );

			if ( isset( $_GET['getting-started'] ) ) {
				require_once SHORTCODEHUB_DIR . 'inc/includes/getting-started.php';
			}

			?>
			<div class="dashboard wrap tab-<?php echo esc_attr( $current_tab ); ?>">
				<h1>
					<span class="title"><?php echo esc_html( $title ); ?></span>
					<?php if ( sh_get_product_logo_url() ) { ?>
						<img src="<?php echo esc_url( sh_get_product_logo_url() ); ?>" class="product-logo" />
					<?php } ?>
					<?php /* translators: %s is plugin version. */ ?>
					<span class="version"><?php printf( __( 'Version %s', 'shortcodehub' ), sh_get_product_version() ); ?></span>
				</h1>
				<nav class="wp-filter">
					<ul class="filter-links">
						<?php foreach ( $tabs as $tab_key => $tab_title ) { ?>
							<li class="<?php echo ( $tab_key === $current_tab ) ? 'current' : ''; ?>">
								<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shortcode&page=' . sh_get_product_slug() . '&tab=' . esc_attr( $tab_key ) ) ); ?>"><?php echo esc_html( $tab_title ); ?></a>
							</li>
						<?php } ?>
					</ul>

					<?php $this->pro_action_button(); ?>

					<ul class="filter-links alignright">
						<li>
							<a href="<?php echo esc_url( sh_get_product_support_url() ); ?>" target="_blank"><?php esc_html_e( 'Support', 'shortcodehub' ); ?><span class="dashicons dashicons-external"></span></a>
						</li>
						<li>
							<a href="<?php echo esc_url( sh_get_product_docs_url() ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'shortcodehub' ); ?><span class="dashicons dashicons-external"></span></a>
						</li>
					</ul>
				</nav>

				<div class="content">
				<?php
				do_action( 'sh_dashboard_' . $current_tab, $current_tab );
				?>
				</div>

				<div class="footer wp-filter">
					<p>
						<?php
						/* translators: %1$s is a product name, %2$s is a product pro link, %2$s is a brand name, %2$s is a product doc link. */
						printf( __( '<b>%1$s</b> is a product of <a href="%2$s" target="_blank">%3$s</a>. For questions and feedback please <a href="%4$s" target="_blank">Visit our Help site.</a>', 'shortcodehub' ), sh_get_product_name(), sh_get_brand_url(), sh_get_brand_name(), sh_get_product_docs_url() );
						?>

						<?php $this->rating_message(); ?>

					</p>
				</div>
			</div>
			<?php
		}

		/**
		 * Rating Message
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function rating_message() {
			$rated = get_user_meta( get_current_user_id(), 'sh-rating', true );

			if ( ! $rated ) {
				printf(
					/* translators: 1: Brand Name 2:: five stars */
					__( '<br/><span class="rating-wrap">If you like %1$s please leave us a %2$s rating. A huge thanks in advance!</span>', 'shortcodehub' ),
					sprintf( '<strong>%s</strong>', sh_get_product_name() ),
					'<a href="' . sh_get_product_rating_url() . '" target="_blank" class="sh-product-rating-link" data-rated="' . esc_attr__( 'Thanks :)', 'shortcodehub' ) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
				);
			}
		}

		/**
		 * Pro plugin action button
		 *
		 * @since 0.0.1
		 *
		 * @return void
		 */
		function pro_action_button() {
			if ( ! apply_filters( 'sh_remove_pro_button', false ) ) {
				?>
				<span class="get-pro">
					<?php
					if ( sh_pro_exist() ) {
						if ( sh_pro_inactive() ) {
							?>
						<a class="button button-primary" href="<?php echo esc_url( sh_get_pro_plugin_activate_link() ); ?>" target="_blank"><?php esc_html_e( 'Activate Pro', 'shortcodehub' ); ?></a>
							<?php
						} else {
							?>
						<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php?post_type=shortcode&page=shortcodehub&tab=license' ) ); ?>"><?php esc_html_e( 'Activate License', 'shortcodehub' ); ?></a>
							<?php
						}
					} else {
						?>
					<a class="button button-primary" href="<?php echo esc_url( sh_get_product_pro_url() ); ?>" target="_blank"><?php esc_html_e( 'Get Pro', 'shortcodehub' ); ?></a>
						<?php
					}
					?>
				</span>
				<?php
			}
		}

		/**
		 * Get Tabs
		 *
		 * @since 0.0.1
		 *
		 * @return array Tabs.
		 */
		function get_tabs() {
			return apply_filters(
				'sh_dashboard_tabs',
				array(
					'welcome' => __( 'Dashboard', 'shortcodehub' ),
				)
			);
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Dashboard::get_instance();

endif;
