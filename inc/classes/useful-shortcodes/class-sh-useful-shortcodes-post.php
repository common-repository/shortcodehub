<?php
/**
 * Post Shortcodes
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Useful_Shortcodes_Post' ) ) :

	/**
	 * Post Shortcodes
	 *
	 * @since 0.0.1
	 */
	class Sh_Useful_Shortcodes_Post {

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
			$shortcodes = array(
				'post_id',               // Shortcode - [sh_post_id].
				'post_title',            // Shortcode - [sh_post_title].
				'post_slug',             // Shortcode - [sh_post_slug].
				'post_content',          // Shortcode - [sh_post_content].
				'post_excerpt',          // Shortcode - [sh_post_excerpt].
				'post_author',           // Shortcode - [sh_post_author].

				'post_date',             // Shortcode - [sh_post_date].
				'post_date_gmt',         // Shortcode - [sh_post_date_gmt].
				'post_modified',         // Shortcode - [sh_post_modified].
				'post_modified_gmt',     // Shortcode - [sh_post_modified_gmt].

				'post_publish_date',     // Shortcode - [sh_post_publish_date].
				'post_publish_date_gmt', // Shortcode - [sh_post_publish_date_gmt].
				'post_update_date',      // Shortcode - [sh_post_update_date].
				'post_update_date_gmt',  // Shortcode - [sh_post_update_date_gmt].

				'post_status',           // Shortcode - [sh_post_status].
				'post_comment_status',   // Shortcode - [sh_post_comment_status].
				'post_ping_status',      // Shortcode - [sh_post_ping_status].
				'post_password',         // Shortcode - [sh_post_password].
				'post_to_ping',          // Shortcode - [sh_post_to_ping].
				'post_pinged',           // Shortcode - [sh_post_pinged].
				'post_content_filtered', // Shortcode - [sh_post_content_filtered].
				'post_parent',           // Shortcode - [sh_post_parent].
				'post_guid',             // Shortcode - [sh_post_guid].
				'post_menu_order',       // Shortcode - [sh_post_menu_order].
				'post_type',             // Shortcode - [sh_post_type].
				'post_mime_type',        // Shortcode - [sh_post_mime_type].
				'post_comment_count',    // Shortcode - [sh_post_comment_count].
				'post_filter',           // Shortcode - [sh_post_filter].

				'post_meta',             // Shortcode - [sh_post_meta].
			);

			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( 'sh_' . $shortcode, array( $this, $shortcode ) );
			}
		}

		/**
		 * Post ID
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function post_id( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			return ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();
		}

		/**
		 * Post Title
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_title( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_the_title( $post_id );
		}

		/**
		 * Post Slug
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_slug( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_name', $post_id );
		}

		/**
		 * Post Content
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_content( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_content', $post_id );
		}

		/**
		 * Post Excerpt
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_excerpt( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_excerpt', $post_id );
		}

		/**
		 * Post Author
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_author( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'    => '',
					'field' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$author_id = get_post_field( 'post_author', $post_id );

			if ( ! empty( $atts['field'] ) ) {
				return sh_get_author_field( $author_id, $atts['field'] );
			}

			return $author_id;
		}

		/**
		 * Post Publish Date
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_publish_date( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$publish_date = get_post_field( 'post_date', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $publish_date;
			}

			return date( $atts['format'], strtotime( $publish_date ) );
		}

		/**
		 * Post Post Date
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_date( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$post_date = get_post_field( 'post_date', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $post_date;
			}

			return date( $atts['format'], strtotime( $post_date ) );
		}

		/**
		 * Post Publish Date GMT
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_publish_date_gmt( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$publish_date_gmt = get_post_field( 'post_date_gmt', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $publish_date_gmt;
			}

			return date( $atts['format'], strtotime( $publish_date_gmt ) );
		}

		/**
		 * Post Post Date GMT
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_date_gmt( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$post_date_gmt = get_post_field( 'post_date_gmt', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $post_date_gmt;
			}

			return date( $atts['format'], strtotime( $post_date_gmt ) );
		}

		/**
		 * Post Update Date
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_update_date( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$post_update_date = get_post_field( 'post_modified', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $post_update_date;
			}

			return date( $atts['format'], strtotime( $post_update_date ) );
		}

		/**
		 * Post Update Date GMT
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_update_date_gmt( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$post_update_date_gmt = get_post_field( 'post_modified_gmt', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $post_update_date_gmt;
			}

			return date( $atts['format'], strtotime( $post_update_date_gmt ) );
		}

		/**
		 * Post Status
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_status( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_status', $post_id );
		}

		/**
		 * Post Comment Status
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_comment_status( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'comment_status', $post_id );
		}

		/**
		 * Post Ping Status
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_ping_status( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'ping_status', $post_id );
		}

		/**
		 * Post Password
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_password( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'password', $post_id );
		}

		/**
		 * Post To Ping
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_to_ping( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'to_ping', $post_id );
		}

		/**
		 * Post Pinged
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_pinged( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'pinged', $post_id );
		}

		/**
		 * Post Modified
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_modified( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$post_modified_date = get_post_field( 'post_modified', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $post_modified_date;
			}

			return date( $atts['format'], strtotime( $post_modified_date ) );
		}

		/**
		 * Post Modified GMT
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_modified_gmt( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id'     => '',
					'format' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			$post_modified_gmt = get_post_field( 'post_modified_gmt', $post_id );

			if ( empty( $atts['format'] ) ) {
				return $post_modified_gmt;
			}

			return date( $atts['format'], strtotime( $post_modified_gmt ) );
		}

		/**
		 * Post Content Filtered
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_content_filtered( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_content_filtered', $post_id );
		}

		/**
		 * Post Parent
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_parent( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_parent', $post_id );
		}

		/**
		 * Post Guid
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_guid( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'guid', $post_id );
		}

		/**
		 * Post Menu Order
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_menu_order( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'menu_order', $post_id );
		}

		/**
		 * Post Type
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_type( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_type', $post_id );
		}

		/**
		 * Post Mime Type
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_mime_type( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'post_mime_type', $post_id );
		}

		/**
		 * Post Comment Count
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_comment_count( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'comment_count', $post_id );
		}

		/**
		 * Post Filter
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_filter( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();

			return get_post_field( 'filter', $post_id );
		}

		/**
		 * Post Meta
		 *
		 * @since 1.7.0
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function post_meta( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'id'  => '',
					'key' => '',
				),
				$atts
			);

			$post_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_ID();
			$key     = ! empty( $atts['key'] ) ? $atts['key'] : '';

			if ( $key && $post_id ) {
				return get_post_meta( $post_id, $key, true );
			}

			return '';
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Useful_Shortcodes_Post::get_instance();

endif;
