<?php
/**
 * Author Shortcodes
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Useful_Shortcodes_Author' ) ) :

	/**
	 * Author Shortcodes
	 *
	 * @since 0.0.1
	 */
	class Sh_Useful_Shortcodes_Author {

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
				'author_id',                  // Shortcode - [sh_author_id].
				'author_admin_color',         // Shortcode - [sh_author_admin_color].
				'author_aim',                 // Shortcode - [sh_author_aim].
				'author_comment_shortcuts',   // Shortcode - [sh_author_comment_shortcuts].
				'author_description',         // Shortcode - [sh_author_description].
				'author_display_name',        // Shortcode - [sh_author_display_name].
				'author_first_name',          // Shortcode - [sh_author_first_name].
				'author_jabber',              // Shortcode - [sh_author_jabber].
				'author_last_name',           // Shortcode - [sh_author_last_name].
				'author_nickname',            // Shortcode - [sh_author_nickname].
				'author_plugins_last_view',   // Shortcode - [sh_author_plugins_last_view].
				'author_plugins_per_page',    // Shortcode - [sh_author_plugins_per_page].
				'author_rich_editing',        // Shortcode - [sh_author_rich_editing].
				'author_syntax_highlighting', // Shortcode - [sh_author_syntax_highlighting].
				'author_user_activation_key', // Shortcode - [sh_author_user_activation_key].
				'author_user_description',    // Shortcode - [sh_author_user_description].
				'author_user_email',          // Shortcode - [sh_author_user_email].
				'author_user_firstname',      // Shortcode - [sh_author_user_firstname].
				'author_user_lastname',       // Shortcode - [sh_author_user_lastname].
				'author_user_level',          // Shortcode - [sh_author_user_level].
				'author_user_login',          // Shortcode - [sh_author_user_login].
				'author_user_nicename',       // Shortcode - [sh_author_user_nicename].
				'author_user_pass',           // Shortcode - [sh_author_user_pass].
				'author_user_registered',     // Shortcode - [sh_author_user_registered].
				'author_user_status',         // Shortcode - [sh_author_user_status].
				'author_user_url',            // Shortcode - [sh_author_user_url].
				'author_yim',                 // Shortcode - [sh_author_yim].
			);

			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( 'sh_' . $shortcode, array( $this, $shortcode ) );
			}
		}

		/**
		 * Author ID
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function author_id( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			return ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );
		}

		/**
		 * Author Admin Color
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_admin_color( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'admin_color' );
		}

		/**
		 * Author Aim
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_aim( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'aim' );
		}

		/**
		 * Author Comment Shortcuts
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_comment_shortcuts( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'comment_shortcuts' );
		}

		/**
		 * Author Description
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_description( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'description' );
		}

		/**
		 * Author Display Name
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_display_name( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'display_name' );
		}

		/**
		 * Author First Name
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_first_name( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'first_name' );
		}

		/**
		 * Author Jabber
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_jabber( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'jabber' );
		}

		/**
		 * Author Last Name
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_last_name( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'last_name' );
		}

		/**
		 * Author Nickname
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_nickname( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'nickname' );
		}

		/**
		 * Author Plugins Last View
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_plugins_last_view( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'plugins_last_view' );
		}

		/**
		 * Author Plugins Per Page
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_plugins_per_page( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'plugins_per_page' );
		}

		/**
		 * Author Rich Editing
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_rich_editing( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'rich_editing' );
		}

		/**
		 * Author Syntax Highlighting
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_syntax_highlighting( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'syntax_highlighting' );
		}

		/**
		 * Author User Activation Key
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_activation_key( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_activation_key' );
		}

		/**
		 * Author User Description
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_description( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_description' );
		}

		/**
		 * Author User Email
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_email( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_email' );
		}

		/**
		 * Author User Firstname
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_firstname( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_firstname' );
		}

		/**
		 * Author User Lastname
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_lastname( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_lastname' );
		}

		/**
		 * Author User Level
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_level( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_level' );
		}

		/**
		 * Author User Login
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_login( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_login' );
		}

		/**
		 * Author User Nicename
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_nicename( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_nicename' );
		}

		/**
		 * Author User Pass
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_pass( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_pass' );
		}

		/**
		 * Author User Registered
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_registered( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_registered' );
		}

		/**
		 * Author User Status
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_status( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_status' );
		}

		/**
		 * Author User Url
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_user_url( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'user_url' );
		}

		/**
		 * Author Yim
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return string
		 */
		function author_yim( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts
			);

			$author_id = ! empty( $atts['id'] ) ? absint( $atts['id'] ) : get_the_author_meta( 'ID' );

			return $this->get_author_field( $author_id, 'yim' );
		}

		/**
		 * Get invalid user field Message
		 *
		 * @since 0.0.1
		 *
		 * @param  string $field User field.
		 * @return string
		 */
		function get_invalid_user_field_message( $field = '' ) {
			/* translators: %1$s is field name. */
			return sprintf( __( 'Error! User field <b>%1$s</b> is not a valid field. Please use a valid user field. See <a href="%2$s" target="_blank">all valid user fields</a>.', 'shortcodehub' ), $field, 'https://developer.wordpress.org/reference/functions/get_the_author_meta/#description' );
		}

		/**
		 * User valid fields
		 *
		 * @return array
		 */
		function valid_user_fields() {
			return array(
				'admin_color',
				'aim',
				'comment_shortcuts',
				'description',
				'display_name',
				'first_name',
				'jabber',
				'last_name',
				'nickname',
				'plugins_last_view',
				'plugins_per_page',
				'rich_editing',
				'syntax_highlighting',
				'user_activation_key',
				'user_description',
				'user_email',
				'user_firstname',
				'user_lastname',
				'user_level',
				'user_login',
				'user_nicename',
				'user_pass',
				'user_registered',
				'user_status',
				'user_url',
				'yim',
			);
		}

		/**
		 * Get Author Field
		 *
		 * @param  int    $author_id  Author ID.
		 * @param  string $field  Field key.
		 * @return mixed
		 */
		function get_author_field( $author_id, $field ) {
			if ( in_array( $field, $this->valid_user_fields() ) ) {
				return get_the_author_meta( $field, $author_id );
			} elseif ( is_user_logged_in() ) {
				return $this->get_invalid_user_field_message( $field );
			}
			return '';
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Useful_Shortcodes_Author::get_instance();

endif;

if ( ! function_exists( 'sh_useful_shortcode_author_instance' ) ) :
	/**
	 * Class instance
	 *
	 * @since 0.0.1
	 *
	 * @return mixed
	 */
	function sh_useful_shortcode_author_instance() {
		return Sh_Useful_Shortcodes_Author::get_instance();
	}
endif;

if ( ! function_exists( 'sh_valid_user_fields' ) ) :
	/**
	 * Get valid author meta keys
	 *
	 * @since 0.0.1
	 *
	 * @return mixed
	 */
	function sh_valid_user_fields() {
		return sh_useful_shortcode_author_instance()->valid_user_fields();
	}
endif;

if ( ! function_exists( 'sh_get_author_field' ) ) :
	/**
	 * Get Author Field
	 *
	 * @since 0.0.1
	 *
	 * @param  int    $author_id  Author ID.
	 * @param  string $field  Field key.
	 * @return mixed
	 */
	function sh_get_author_field( $author_id, $field ) {
		return sh_useful_shortcode_author_instance()->get_author_field( $author_id, $field );
	}
endif;

if ( ! function_exists( 'sh_get_invalid_user_field_message' ) ) :
	/**
	 * Get invalid user field Message
	 *
	 * @since 0.0.1
	 *
	 * @param  string $field User field.
	 * @return string
	 */
	function sh_get_invalid_user_field_message( $field = '' ) {
		return sh_useful_shortcode_author_instance()->get_invalid_user_field_message( $field );
	}
endif;
