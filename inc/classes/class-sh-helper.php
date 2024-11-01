<?php
/**
 * Helper
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Helper' ) ) :

	/**
	 * Helper
	 *
	 * @since 0.0.1
	 */
	class Sh_Helper {

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
		public function __construct() {}

		/**
		 * Get tip content.
		 *
		 * @since 0.0.1
		 *
		 * @param  string $tip_id Unique Tip ID.
		 * @param  mixed  $tip_content Tip content.
		 * @return mixed
		 */
		function get_tip_content( $tip_id = '', $tip_content = '' ) {
			if ( empty( $tip_id ) || empty( $tip_content ) ) {
				return '';
			}
			?>
			<div class="sh-tip-info sh-tip-message" id="<?php echo esc_attr( $tip_id ); ?>" style="display: none;">
				<?php echo $tip_content; // WPCS: ok. ?>
			</div>
			<?php
		}

		/**
		 * Get tip icon.
		 *
		 * @since 0.0.1
		 *
		 * @param  string $tip_id Unique Tip icon.
		 * @param  string $tip_title Tip title.
		 * @return mixed
		 */
		function get_tip_icon( $tip_id = '', $tip_title = 'Tip' ) {
			if ( empty( $tip_id ) ) {
				return '';
			}
			?>
			<span class="sh-tip">
				<span class="icon" data-id="<?php echo esc_attr( $tip_id ); ?>">
					<i class="dashicons dashicons-editor-help"></i> <?php echo esc_html( $tip_title ); ?>
				</span>
			</span>
			<?php
		}

		/**
		 * Get assets js path
		 *
		 * @since 0.0.1
		 *
		 * @param  string $js_file_name JS file name.
		 * @return string               JS minified file path.
		 */
		function get_assets_js_path( $js_file_name = '' ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				return $js_file_name . '.js';
			}
			return 'min/' . $js_file_name . '.min.js';
		}

		/**
		 * Get assets css path
		 *
		 * @since 0.0.1
		 *
		 * @param  string $css_file_name CSS file name.
		 * @return string                CSS minified file path.
		 */
		function get_assets_css_path( $css_file_name = '' ) {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				return $css_file_name . '.css';
			}
			return 'min/' . $css_file_name . '.min.css';
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Helper::get_instance();

endif;

if ( ! function_exists( 'sh_tip_content' ) ) :
	/**
	 * Echo tip content.
	 *
	 * @since 0.0.1
	 *
	 * @param  string $tip_id Unique Tip ID.
	 * @param  mixed  $tip_content Tip content.
	 * @return mixed
	 */
	function sh_tip_content( $tip_id = '', $tip_content = '' ) {
		echo Sh_Helper::get_instance()->get_tip_content( $tip_id, $tip_content );
	}
endif;

if ( ! function_exists( 'sh_get_tip_content' ) ) :
	/**
	 * Get tip content.
	 *
	 * @since 0.0.1
	 *
	 * @param  string $tip_id Unique Tip ID.
	 * @param  mixed  $tip_content Tip content.
	 * @return mixed
	 */
	function sh_get_tip_content( $tip_id = '', $tip_content = '' ) {
		return Sh_Helper::get_instance()->get_tip_content( $tip_id, $tip_content );
	}
endif;


if ( ! function_exists( 'sh_tip_icon' ) ) :
	/**
	 * Echo tip icon.
	 *
	 * @since 0.0.1
	 *
	 * @param  string $tip_id Unique Tip icon.
	 * @param  string $tip_title Tip title.
	 */
	function sh_tip_icon( $tip_id = '', $tip_title = 'Tip' ) {
		echo Sh_Helper::get_instance()->get_tip_icon( $tip_id, $tip_title );
	}
endif;

if ( ! function_exists( 'sh_get_tip_icon' ) ) :
	/**
	 * Get tip icon.
	 *
	 * @since 0.0.1
	 *
	 * @param  string $tip_id Unique Tip icon.
	 * @param  string $tip_title Tip title.
	 * @return mixed
	 */
	function sh_get_tip_icon( $tip_id = '', $tip_title = 'Tip' ) {
		return Sh_Helper::get_instance()->get_tip_icon( $tip_id, $tip_title );
	}
endif;

if ( ! function_exists( 'sh_get_js_path' ) ) :
	/**
	 * Get assets JS path
	 *
	 * @since 0.0.1
	 *
	 * @param  string $js_file_name JS file name.
	 * @return string               JS minified file path.
	 */
	function sh_get_js_path( $js_file_name = '' ) {
		return Sh_Helper::get_instance()->get_assets_js_path( $js_file_name );
	}
endif;

if ( ! function_exists( 'sh_get_css_path' ) ) :
	/**
	 * Get assets CSS path
	 *
	 * @since 0.0.1
	 *
	 * @param  string $css_file_name CSS file name.
	 * @return string                CSS minified file path.
	 */
	function sh_get_css_path( $css_file_name = '' ) {
		return Sh_Helper::get_instance()->get_assets_css_path( $css_file_name );
	}
endif;

if ( ! function_exists( 'sh_pro_inactive' ) ) :
	/**
	 * Detect Pro is installed but not activated
	 *
	 * @since 0.0.1
	 *
	 * @return boolean
	 */
	function sh_pro_inactive() {

		// Pro plugin inactive?
		if ( ! is_plugin_active( 'sh-pro/sh-pro.php' ) ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'sh_get_pro_plugin_activate_link' ) ) :
	/**
	 * Get Pro plugin activation link
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_pro_plugin_activate_link() {
		$path = 'sh-pro/sh-pro.php';
		return wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . $path ), 'activate-plugin_' . $path );
	}
endif;

if ( ! function_exists( 'sh_pro_exist' ) ) :
	/**
	 * Detect Pro is installed but not activated
	 *
	 * @since 0.0.1
	 *
	 * @return boolean
	 */
	function sh_pro_exist() {

		// Pro plugin directory exist?
		if ( file_exists( WP_PLUGIN_DIR . '/sh-pro/sh-pro.php' ) ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'sh_get_support_link' ) ) :
	/**
	 * Generate Support Link
	 *
	 * @since 0.0.1
	 *
	 * @param  string $subject User support subject.
	 * @param  string $message User support message.
	 * @param  string $name    User name.
	 * @param  string $email   User email.
	 * @return string
	 */
	function sh_get_support_link( $subject = '', $message = '', $name = '', $email = '' ) {

		$user_id = get_current_user_id();

		$name    = ! empty( $name ) ? $name : get_the_author_meta( 'display_name', $user_id );
		$email   = ! empty( $email ) ? $email : get_the_author_meta( 'email', $user_id );
		$subject = ! empty( $subject ) ? $subject : '';
		$message = ! empty( $message ) ? $message : '';

		$url = add_query_arg(
			array(
				'user-name'    => $name,
				'user-email'   => $email,
				'user-subject' => $subject,
				'user-message' => $message,
			),
			sh_get_product_support_form_url()
		);

		return $url;
	}
endif;

if ( ! function_exists( 'sh_get_filesystem' ) ) :

	/**
	 * Get an instance of WP_Filesystem_Direct.
	 *
	 * @since 1.3.0
	 * @return object A WP_Filesystem_Direct instance.
	 */
	function sh_get_filesystem() {
		global $wp_filesystem;

		require_once ABSPATH . '/wp-admin/includes/file.php';

		WP_Filesystem();

		return $wp_filesystem;
	}
endif;
