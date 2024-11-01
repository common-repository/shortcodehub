<?php
/**
 * Theme Shortcodes
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Useful_Shortcodes_Theme' ) ) :

	/**
	 * Theme Shortcodes
	 *
	 * @since 0.0.1
	 */
	class Sh_Useful_Shortcodes_Theme {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class Instance.
		 * @since 0.0.1
		 */
		private static $instance;

		/**
		 * Current Theme
		 *
		 * @access private
		 * @var object Current Theme.
		 * @since 0.0.1
		 */
		private $current_theme;

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
				'theme',                     // Shortcode - [sh_theme].
				'theme_list',                // Shortcode - [sh_theme_list].
				'theme_name',                // Shortcode - [sh_theme_name].
				'theme_url',                 // Shortcode - [sh_theme_url].
				'theme_title',               // Shortcode - [sh_theme_title].
				'theme_status',              // Shortcode - [sh_theme_status].
				'theme_version',             // Shortcode - [sh_theme_version].
				'theme_parent_theme',        // Shortcode - [sh_theme_parent_theme].
				'theme_template_dir',        // Shortcode - [sh_theme_template_dir].
				'theme_stylesheet_dir',      // Shortcode - [sh_theme_stylesheet_dir].
				'theme_template',            // Shortcode - [sh_theme_template].
				'theme_stylesheet',          // Shortcode - [sh_theme_stylesheet].
				'theme_screenshot',          // Shortcode - [sh_theme_screenshot].
				'theme_screenshot_url',      // Shortcode - [sh_theme_screenshot_url].
				'theme_description',         // Shortcode - [sh_theme_description].
				'theme_author',              // Shortcode - [sh_theme_author].
				'theme_author_link',         // Shortcode - [sh_theme_author_link].
				'theme_root',                // Shortcode - [sh_theme_root].
				'theme_root_uri',            // Shortcode - [sh_theme_root_uri].
				'theme_template_file_names', // Shortcode - [sh_theme_template_file_names].
				'theme_template_file_links', // Shortcode - [sh_theme_template_file_links].
				'theme_tags',                // Shortcode - [sh_theme_tags].
				'theme_download',            // Shortcode - [sh_theme_download].
			);

			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( 'sh_' . $shortcode, array( $this, $shortcode ) );
			}
		}

		/**
		 * Theme
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'slug'               => '',
					'format'             => 'link', // plain.
					'show_version'       => 'yes',
					'show_author'        => 'yes',

					'theme_link_target'  => '_blank',
					'author_link_target' => '_blank',
					'link_of'            => 'theme_uri',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			if ( 'plain' === $atts['format'] ) {
				return $theme->name;
			}

			// Link.
			$link = ! empty( $theme->get( 'ThemeURI' ) ) ? $theme->get( 'ThemeURI' ) : '';
			if ( empty( $link ) ) {
				$output = $theme->name;
			} else {
				$output = '<a href="' . $link . '" target="' . $atts['theme_link_target'] . '">' . $theme->name . '</a>';
			}

			if ( 'yes' === $atts['show_version'] ) {
				$output .= ' v' . $theme->version;
			}

			if ( 'yes' === $atts['show_author'] ) {
				$output .= ' by <a href="' . $theme->get( 'AuthorURI' ) . '" target="' . $atts['author_link_target'] . '">' . $theme->get( 'Author' ) . '</a>';
			}

			return $output;
		}

		/**
		 * Theme List
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_list( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'format'       => 'link', // plain.
					'show_version' => 'yes',
					'show_author'  => 'yes',

					'filter_by'    => '', // E.g. 'author'.
					'filter_term'  => '', // E.g. 'ShortcodeHub'.
				),
				$atts
			);

			$themes = wp_get_themes();

			ob_start();
			if ( $themes ) { ?>
				<ul>
					<?php
					foreach ( $themes as $key => $theme ) {
						switch ( $atts['filter_by'] ) {
							case 'author':
								if ( $theme->get( 'Author' ) === $atts['filter_term'] ) {
									echo '<li>' . do_shortcode( '[sh_theme show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" slug="' . esc_attr( $theme->stylesheet ) . '"]' ) . '</li>';
								}
								break;
							default:
									echo '<li>' . do_shortcode( '[sh_theme show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" slug="' . esc_attr( $theme->stylesheet ) . '"]' ) . '</li>';
								break;
						}
					}
					?>
				</ul>
				<?php
			}
			return ob_get_clean();
		}

		/**
		 * Theme Name
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_name( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->name;
		}

		/**
		 * Theme URL
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_url( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->get( 'ThemeURI' );
		}

		/**
		 * Theme Title
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_title( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->title;
		}

		/**
		 * Theme Status
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_status( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->offsetGet( 'Status' );
		}

		/**
		 * Theme Status
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_version( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->version;
		}

		/**
		 * Theme Parent Theme
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_parent_theme( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->parent_theme;
		}

		/**
		 * Theme Template Directory
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_template_dir( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->template_dir;
		}

		/**
		 * Theme Stylesheet Directory
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_stylesheet_dir( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->stylesheet_dir;
		}

		/**
		 * Theme Template
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_template( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->template;
		}

		/**
		 * Theme Stylesheet
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_stylesheet( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->stylesheet;
		}

		/**
		 * Theme Screenshot
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_screenshot( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return '<img src="' . esc_url( $theme->get_screenshot() ) . '" alt="' . esc_attr( $theme->title ) . '" />';
		}

		/**
		 * Theme Screenshot URL
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_screenshot_url( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->get_screenshot();
		}

		/**
		 * Theme Description
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_description( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->description;
		}

		/**
		 * Theme Author
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_author( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->author;
		}

		/**
		 * Theme Author Link
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_author_link( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->display( 'AuthorURI' );
		}

		/**
		 * Theme Root
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_root( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->theme_root;
		}

		/**
		 * Theme Root URI
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_root_uri( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return $theme->theme_root_uri;
		}

		/**
		 * Theme Template File Names
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_template_file_names( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug'   => '',
					'format' => 'inline',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			if ( 'list' === $atts['format'] ) {
				return implode( '<br/>', array_keys( $theme->offsetGet( 'Template Files' ) ) );
			}

			return implode( ', ', array_keys( $theme->offsetGet( 'Template Files' ) ) );
		}

		/**
		 * Theme Template File Links
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_template_file_links( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			return implode( '<br/>', array_values( $theme->offsetGet( 'Template Files' ) ) );
		}

		/**
		 * Theme Tags
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_tags( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug' => '',
				),
				$atts
			);

			$theme = $this->get_theme( $atts['slug'] );

			if ( empty( $theme ) ) {
				return;
			}

			if ( ! empty( $theme->tags ) ) {
				return implode( ', ', $theme->tags );
			}

			return '';
		}

		/**
		 * Theme Download
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function theme_download( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug'   => '',
					'format' => '', // Accepts, link. Default button.
					'text'   => 'Download',
				),
				$atts
			);

			$link = 'https://downloads.wordpress.org/theme/' . $atts['slug'] . '.latest-stable.zip';

			if ( 'link' === $atts['format'] ) {
				return '<a href="' . esc_url( $link ) . '">' . esc_attr( $atts['text'] ) . '</a>';
			}

			return '<a href="' . esc_url( $link ) . '"><button>' . esc_attr( $atts['text'] ) . '</button></a>';
		}

		/**
		 * Get Theme
		 *
		 * @param  string $slug Theme Slug.
		 * @return object
		 */
		function get_theme( $slug = '' ) {
			if ( ! empty( $slug ) ) {
				return wp_get_theme( $slug );
			}

			return $this->get_current_theme();
		}

		/**
		 * Get current theme
		 *
		 * @return object
		 */
		function get_current_theme() {

			if ( ! empty( $this->current_theme ) ) {
				return $this->current_theme;
			}

			$this->current_theme = wp_get_theme();

			return $this->current_theme;
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Useful_Shortcodes_Theme::get_instance();

endif;
