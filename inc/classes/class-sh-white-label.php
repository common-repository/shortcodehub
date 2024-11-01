<?php
/**
 * White Label
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_White_Label' ) ) :

	/**
	 * White Label
	 *
	 * @since 0.0.1
	 */
	class Sh_White_Label {

		/**
		 * Instance
		 *
		 * @since 0.0.1
		 *
		 * @var object Class object.
		 * @access private
		 */
		private static $instance;

		/**
		 * Product URI.
		 *
		 * @since 0.0.1
		 *
		 * @var string Product URI.
		 * @access public
		 */
		public $product_uri = '';

		/**
		 * Product Logo URL.
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Logo URL.
		 * @access public
		 */
		public $product_logo_url = '';

		/**
		 * Product Slug
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Slug
		 * @access public
		 */
		public $product_slug = '';

		/**
		 * Action Prefix
		 *
		 * @since 0.0.1
		 *
		 * @var string Action Prefix
		 * @access public
		 */
		public $action_prefix = '';

		/**
		 * Option Prefix
		 *
		 * @since 0.0.1
		 *
		 * @var string Option Prefix
		 * @access public
		 */
		public $option_prefix = '';

		/**
		 * Product Name
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Name
		 * @access public
		 */
		public $product_name = '';

		/**
		 * Product Version
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Version
		 * @access public
		 */
		public $product_version = '';

		/**
		 * Brand URL
		 *
		 * @since 0.0.1
		 *
		 * @var string Brand URL
		 * @access public
		 */
		public $brand_url = '';

		/**
		 * Brand Name
		 *
		 * @since 0.0.1
		 *
		 * @var string Brand Name
		 * @access public
		 */
		public $brand_name = '';

		/**
		 * Product Docs URL
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Docs URL
		 * @access public
		 */
		public $product_docs_url = '';

		/**
		 * Product Pro URL
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Pro URL
		 * @access public
		 */
		public $product_pro_url = '';

		/**
		 * Product Support URL
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Support URL
		 * @access public
		 */
		public $product_support_url = '';

		/**
		 * Product Support Form URL
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Support Form URL
		 * @access public
		 */
		public $product_support_form_url = '';

		/**
		 * Product Rating URL
		 *
		 * @since 0.0.1
		 *
		 * @var string Product Rating URL
		 * @access public
		 */
		public $product_rating_url = '';

		/**
		 * Initiator
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
		public function __construct() {
			$this->product_uri              = $this->get( 'product-uri' );
			$this->product_logo_url         = $this->get( 'product-logo-url' );
			$this->product_slug             = $this->get( 'product-slug' );
			$this->product_name             = $this->get( 'product-name' );
			$this->product_version          = $this->get( 'product-version' );
			$this->brand_url                = $this->get( 'brand-url' );
			$this->brand_name               = $this->get( 'brand-name' );
			$this->product_docs_url         = $this->get( 'product-docs-url' );
			$this->product_pro_url          = $this->get( 'product-pro-url' );
			$this->product_support_url      = $this->get( 'product-support-url' );
			$this->product_support_form_url = $this->get( 'product-support-form-url' );
			$this->product_rating_url       = $this->get( 'product-rating-url' );
			$this->action_prefix            = $this->get( 'action-prefix' );
			$this->option_prefix            = $this->get( 'option-prefix' );
		}

		/**
		 * Get White Label Options
		 *
		 * @since 0.0.1
		 *
		 * @return mixed
		 */
		function get_options() {
			return apply_filters(
				'sh_white_label_get_options',
				array(
					// Product.
					'product-name'             => 'ShortcodeHub',
					'product-text-domain'      => 'ShortcodeHub',
					'product-uri'              => SHORTCODEHUB_URI,
					'product-version'          => SHORTCODEHUB_VER,
					'product-slug'             => 'shortcodehub',
					'product-localize-object'  => 'ShortcodeHub',

					'product-support-url'      => 'https://surror.com/help/',
					'product-support-form-url' => 'https://surror.com/contact/',
					'product-docs-url'         => 'https://docs.surror.com/doc/shortcodehub/',
					'product-rating-url'       => 'https://wordpress.org/support/plugin/shortcodehub/reviews/#new-post',
					'product-pro-url'          => 'https://surror.com/',
					'product-logo-url'         => SHORTCODEHUB_URI . 'inc/assets/images/logo.png',

					// Brand.
					'brand-name'               => 'ShortcodeHub',
					'brand-url'                => 'https://surror.com/',

					// Hooks.
					'action-prefix'            => 'shortcodehub',
					'option-prefix'            => 'shortcodehub',
				)
			);
		}

		/**
		 * Get White Label Option
		 *
		 * @since 0.0.1
		 *
		 * @param  string $key      White Label Key.
		 * @param  mixed  $defaults  Defaults.
		 * @return mixed
		 */
		function get( $key = '', $defaults = '' ) {
			$options = $this->get_options();

			if ( array_key_exists( $key, $options ) ) {
				return $options[ $key ];
			}

			return $defaults;
		}

		/**
		 * Get current URL from the theme or plugin
		 *
		 * @since 0.0.1
		 *
		 * @param  string $file File Absolute Path.
		 * @return mixed
		 */
		function get_uri( $file = __FILE__ ) {

			$realpath   = realpath( dirname( $file ) );
			$path       = wp_normalize_path( $realpath );
			$theme_dir  = wp_normalize_path( get_template_directory() );
			$plugin_dir = wp_normalize_path( WP_PLUGIN_DIR );

			if ( strpos( $path, $theme_dir ) !== false ) {
				$current_dir = str_replace( $theme_dir, '', $path );
				return rtrim( get_template_directory_uri() ) . $current_dir . '/';
			} elseif ( strpos( $path, $plugin_dir ) !== false ) {
				return rtrim( plugin_dir_url( $file ) );
			}

			return;
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_White_Label::get_instance();

endif;

if ( ! function_exists( 'sh_get_white_label_options' ) ) :
	/**
	 * Get White Label Options
	 *
	 * @since 0.0.1
	 *
	 * @return array
	 */
	function sh_get_white_label_options() {
		return Sh_White_Label::get_instance()->get_options();
	}
endif;

if ( ! function_exists( 'sh_get_product_uri' ) ) :
	/**
	 * Get Product URI
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_uri() {
		return Sh_White_Label::get_instance()->product_uri;
	}
endif;

if ( ! function_exists( 'sh_get_product_logo_url' ) ) :
	/**
	 * Get Product URI
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_logo_url() {
		return Sh_White_Label::get_instance()->product_logo_url;
	}
endif;

if ( ! function_exists( 'sh_get_product_slug' ) ) :
	/**
	 * Get Product Slug
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_slug() {
		return Sh_White_Label::get_instance()->product_slug;
	}
endif;

if ( ! function_exists( 'sh_get_action_prefix' ) ) :
	/**
	 * Get Action Prefix
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_action_prefix() {
		return Sh_White_Label::get_instance()->action_prefix;
	}
endif;

if ( ! function_exists( 'sh_get_option_prefix' ) ) :
	/**
	 * Get Option Prefix
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_option_prefix() {
		return Sh_White_Label::get_instance()->option_prefix;
	}
endif;

if ( ! function_exists( 'sh_get_product_name' ) ) :
	/**
	 * Get Product Name
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_name() {
		return Sh_White_Label::get_instance()->product_name;
	}
endif;

if ( ! function_exists( 'sh_get_product_version' ) ) :
	/**
	 * Get Product Version
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_version() {
		return Sh_White_Label::get_instance()->product_version;
	}
endif;

if ( ! function_exists( 'sh_get_brand_url' ) ) :
	/**
	 * Get Brand URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_brand_url() {
		return Sh_White_Label::get_instance()->brand_url;
	}
endif;

if ( ! function_exists( 'sh_get_brand_name' ) ) :
	/**
	 * Get Brand Name
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_brand_name() {
		return Sh_White_Label::get_instance()->brand_name;
	}
endif;

if ( ! function_exists( 'sh_get_product_docs_url' ) ) :
	/**
	 * Get Product Docs URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_docs_url() {
		return Sh_White_Label::get_instance()->product_docs_url;
	}
endif;

if ( ! function_exists( 'sh_get_product_pro_url' ) ) :
	/**
	 * Get Product Pro URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_pro_url() {
		return Sh_White_Label::get_instance()->product_pro_url;
	}
endif;

if ( ! function_exists( 'sh_get_product_support_url' ) ) :
	/**
	 * Get Product Support URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_support_url() {
		return Sh_White_Label::get_instance()->product_support_url;
	}
endif;

if ( ! function_exists( 'sh_get_product_demo_url' ) ) :
	/**
	 * Get Product Support URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_demo_url() {
		return Sh_White_Label::get_instance()->product_demo_url;
	}
endif;

if ( ! function_exists( 'sh_get_product_support_form_url' ) ) :
	/**
	 * Get Product Support URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_support_form_url() {
		return Sh_White_Label::get_instance()->product_support_form_url;
	}
endif;

if ( ! function_exists( 'sh_get_product_rating_url' ) ) :
	/**
	 * Get Product Rating URL
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	function sh_get_product_rating_url() {
		return Sh_White_Label::get_instance()->product_rating_url;
	}
endif;

if ( ! function_exists( 'sh_get_plugin_uri' ) ) :
	/**
	 * Get current URL from the theme or plugin
	 *
	 * @since 0.0.1
	 *
	 * @param  string $file File Absolute Path.
	 * @return mixed
	 */
	function sh_get_plugin_uri( $file = __FILE__ ) {
		return Sh_White_Label::get_instance()->get_uri( $file );
	}
endif;
