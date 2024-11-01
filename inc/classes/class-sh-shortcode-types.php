<?php
/**
 * Shortcode Types
 *
 * @package ShortcodeHub
 * @since 0.0.1
 */

if ( ! class_exists( 'Sh_Shortcode_Types' ) ) :

	/**
	 * Shortcode Types
	 *
	 * @since 0.0.1
	 */
	class Sh_Shortcode_Types {

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
		function __construct() {}

		/**
		 * Get Shortcode Types
		 *
		 * @since 0.0.1
		 *
		 * @return array
		 */
		function get_shortcode_types() {

			return apply_filters(
				'sh_shortcode_types',
				array(
					'basic'      => array(
						'label' => __( 'Basic Shortcodes', 'shortcodehub' ),
						'types' => array(
							'text-editor' => array(
								'title'       => __( 'Text Editor', 'shortcodehub' ),
								'description' => __( 'Use TinyMCE editor to add your content.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'code-editor' => array(
								'title'       => __( 'Code Editor', 'shortcodehub' ),
								'description' => __( 'Use code editor to add your custom code.', 'shortcodehub' ),
								'video-link'  => '',
								'is_pro'      => true,
								'is_soon'     => true,
							),
						),
					),
					'core'       => array(
						'label' => __( 'Core Shortcodes', 'shortcodehub' ),
						'types' => array(
							'widget' => array(
								'title'       => __( 'Widget', 'shortcodehub' ),
								'description' => __( 'Select any active widget with shortcode.', 'shortcodehub' ),
							),
							'menu'   => array(
								'title'       => __( 'Menu', 'shortcodehub' ),
								'description' => __( 'Select any menu and show it anywhere with shortcode.', 'shortcodehub' ),
							),
						),
					),
					'post-query' => array(
						'label' => __( 'Post, Page & Custom Post Shortcodes', 'shortcodehub' ),
						'types' => array(
							'simple-grid'     => array(
								'title'       => __( 'Simple Grid', 'shortcodehub' ),
								'description' => __( 'Make a Simple Grid of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'inbox'           => array(
								'title'       => __( 'Inbox View', 'shortcodehub' ),
								'description' => __( 'Make a Inbox View of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'masonry-grid'    => array(
								'title'       => __( 'Masonry Grid', 'shortcodehub' ),
								'description' => __( 'Make a Masonry Grid of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'glossary'        => array(
								'title'       => __( 'Glossary', 'shortcodehub' ),
								'description' => __( 'Make a Glossary of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'summery'         => array(
								'title'       => __( 'Summery', 'shortcodehub' ),
								'description' => __( 'Make a Summery of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'timeline'        => array(
								'title'       => __( 'Timeline', 'shortcodehub' ),
								'description' => __( 'Make a Timeline of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
							),
							'accordion'       => array(
								'title'       => __( 'Accordion', 'shortcodehub' ),
								'description' => __( 'Make a Accordion of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
								'is_soon'     => false,
							),
							'tabs'            => array(
								'title'       => __( 'Tabs', 'shortcodehub' ),
								'description' => __( 'Make a Tabs layout of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
								'is_soon'     => true,
							),
							'simple-list'     => array(
								'title'       => __( 'List', 'shortcodehub' ),
								'description' => __( 'Make a Simple List of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
								'is_soon'     => true,
							),
							'carousel'        => array(
								'title'       => __( 'Carousel', 'shortcodehub' ),
								'description' => __( 'Make a Carousel of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
								'is_soon'     => true,
							),
							'slider'          => array(
								'title'       => __( 'Slider', 'shortcodehub' ),
								'description' => __( 'Make a Slider of post, page and custom post types.', 'shortcodehub' ),
								'video-link'  => '',
								'is_soon'     => true,
							),
							'filterable-grid' => array(
								'title'       => __( 'Filterable Grid', 'shortcodehub' ),
								'description' => __( 'Show all items and filter them with categories, tags and taxonomies.', 'shortcodehub' ),
								'is_pro'      => 'pro',
								'is_soon'     => true,
							),
						),
					),
				)
			);
		}

		/**
		 * Get Shortcode Type Title
		 *
		 * @since 0.0.1
		 *
		 * @param  string $shortcode_type Shrotcode Type.
		 * @return mixed
		 */
		function get_shortcode_type_title( $shortcode_type = '' ) {
			$shortcode_types = $this->get_shortcode_types();

			if ( array_key_exists( $shortcode_type, $shortcode_types ) ) {
				if ( isset( $shortcode_types[ $shortcode_type ]['label'] ) ) {
					return $shortcode_types[ $shortcode_type ]['label'];
				}
			}

			return;
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Shortcode_Types::get_instance();

endif;

if ( ! function_exists( 'sh_get_shortcode_types' ) ) :
	/**
	 * Get Shortcode Types
	 *
	 * @since 0.0.1
	 *
	 * @return array Shortcode types.
	 */
	function sh_get_shortcode_types() {
		return Sh_Shortcode_Types::get_instance()->get_shortcode_types();
	}
endif;

if ( ! function_exists( 'sh_get_shortcode_type_title' ) ) :
	/**
	 * Get Shortcode Type_title
	 *
	 * @since 0.0.1
	 *
	 * @param  string $shortcode_type Shortcode Type.
	 * @return string
	 */
	function sh_get_shortcode_type_title( $shortcode_type = '' ) {
		return Sh_Shortcode_Types::get_instance()->get_shortcode_type_title( $shortcode_type );
	}
endif;

if ( ! function_exists( 'sh_shortcode_type_title' ) ) :
	/**
	 * Print Shortcode Type Title
	 *
	 * @since 0.0.1
	 *
	 * @param  string $shortcode_type Shortcode Type.
	 * @return void
	 */
	function sh_shortcode_type_title( $shortcode_type = '' ) {
		echo Sh_Shortcode_Types::get_instance()->get_shortcode_type_title( $shortcode_type );
	}
endif;
