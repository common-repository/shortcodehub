<?php
/**
 * Plugin Shortcodes
 *
 * @since 0.0.1
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Useful_Shortcodes_Plugin' ) ) :

	/**
	 * Plugin Shortcodes
	 *
	 * @since 0.0.1
	 */
	class Sh_Useful_Shortcodes_Plugin {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class Instance.
		 * @since 0.0.1
		 */
		private static $instance;

		/**
		 * Active Plugins
		 *
		 * @access private
		 * @var object Active Plugins.
		 * @since 0.0.1
		 */
		private $active_plugins = array();

		/**
		 * Plugins
		 *
		 * @access private
		 * @var object Plugins.
		 * @since 0.0.1
		 */
		private $plugins = array();

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
				'plugin',               // Shortcode - [sh_plugin].
				'plugin_name',          // Shortcode - [sh_plugin_name].
				'plugin_uri',           // Shortcode - [sh_plugin_uri].
				'plugin_version',       // Shortcode - [sh_plugin_version].
				'plugin_description',   // Shortcode - [sh_plugin_description].
				'plugin_author',        // Shortcode - [sh_plugin_author].
				'plugin_author_uri',    // Shortcode - [sh_plugin_author_uri].
				'plugin_author_url',    // Shortcode - [sh_plugin_author_url].
				'plugin_textdomain',    // Shortcode - [sh_plugin_textdomain].
				'plugin_domainpath',    // Shortcode - [sh_plugin_domainpath].
				'plugin_network',       // Shortcode - [sh_plugin_network].
				'plugin_title',         // Shortcode - [sh_plugin_title].
				'plugin_author_name',   // Shortcode - [sh_plugin_author_name].
				'plugin_list',          // Shortcode - [sh_plugin_list].
				'plugin_active_list',   // Shortcode - [sh_plugin_active_list].
				'plugin_inactive_list', // Shortcode - [sh_plugin_inactive_list].
				'plugin_download',      // Shortcode - [sh_plugin_download].
			);

			foreach ( $shortcodes as $key => $shortcode ) {
				add_shortcode( 'sh_' . $shortcode, array( $this, $shortcode ) );
			}
		}

		/**
		 * Plugin
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init'               => '',

					'slug'               => '',
					'format'             => 'link', // plain.
					'show_version'       => 'yes',
					'show_author'        => 'yes',
					'plugin_link_target' => '_blank',
					'author_link_target' => '_blank',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			$output = '';

			if ( empty( $plugin ) ) {
				return $output;
			}

			$output = $plugin['Name'];
			if ( 'link' === $atts['format'] ) {

				// Link.
				$link = ! empty( $plugin['PluginURI'] ) ? trim( $plugin['PluginURI'] ) : '';
				if ( ! empty( $link ) ) {
					$output = '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $atts['plugin_link_target'] ) . '">' . esc_html( $plugin['Name'] ) . '</a>';
				}
					$output = '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $atts['plugin_link_target'] ) . '">' . esc_html( $plugin['Name'] ) . '</a>';
			}

			// Show Version.
			if ( 'yes' === $atts['show_version'] && ! empty( $plugin['Version'] ) ) {
				$output .= ' v' . esc_html( $plugin['Version'] );
			}

			// Show Author.
			if ( 'yes' === $atts['show_author'] && ! empty( $plugin['Author'] ) ) {
				$output .= ' by <a href="' . esc_url( $plugin['AuthorURI'] ) . '" target="' . esc_attr( $atts['author_link_target'] ) . '">' . esc_html( $plugin['AuthorName'] ) . '</a>';
			}

			return $output;
		}

		/**
		 * Plugin Name
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_name( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init'        => '',
					'format'      => 'link',
					'link_target' => '_blank',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			// Link.
			if ( 'link' === $atts['format'] ) {
				$link = ! empty( $plugin['PluginURI'] ) ? trim( $plugin['PluginURI'] ) : '';
				if ( ! empty( $link ) ) {
					return '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $atts['link_target'] ) . '">' . $plugin['Name'] . '</a>';
				}
			}

			return $plugin['Name'];
		}

		/**
		 * Plugin URI
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_uri( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['PluginURI'];
		}

		/**
		 * Plugin Version
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_version( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['Version'];
		}

		/**
		 * Plugin Description
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_description( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['Description'];
		}

		/**
		 * Plugin Author
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_author( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init'        => '',
					'format'      => 'link',
					'link_target' => '_blank',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			// Link.
			if ( 'link' === $atts['format'] ) {
				$link = ! empty( $plugin['AuthorURI'] ) ? trim( $plugin['AuthorURI'] ) : '';
				if ( ! empty( $link ) ) {
					return '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $atts['link_target'] ) . '">' . esc_html( $plugin['Author'] ) . '</a>';
				}
			}

			return $plugin['Author'];
		}

		/**
		 * Plugin Author URL
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_author_url( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['AuthorURI'];
		}

		/**
		 * Plugin Author URI
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_author_uri( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['AuthorURI'];
		}

		/**
		 * Plugin Textdomain
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_textdomain( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['TextDomain'];
		}

		/**
		 * Plugin Domain Path
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_domainpath( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['DomainPath'];
		}

		/**
		 * Plugin Network
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_network( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['Network'];
		}

		/**
		 * Plugin Title
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_title( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['Title'];
		}

		/**
		 * Plugin Author Name
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_author_name( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'init' => '',
				),
				$atts
			);

			if ( empty( $atts['init'] ) ) {
				return;
			}

			$plugin = $this->get_plugin( $atts['init'] );

			if ( empty( $plugin ) ) {
				return;
			}

			return $plugin['AuthorName'];
		}

		/**
		 * Plugin All List
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_list( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'format'       => 'link',
					'show_author'  => 'yes',
					'show_version' => 'yes',

					'filter_by'    => '', // E.g. 'author'.
					'filter_term'  => '', // E.g. 'ShortcodeHub'.
				),
				$atts
			);

			$plugins = $this->get_plugins();

			ob_start();
			if ( $plugins ) { ?>
				<ul>
					<?php
					foreach ( $plugins as $plugin_init => $plugin ) {
						switch ( $atts['filter_by'] ) {
							case 'author':
								if ( $plugin['Author'] == $atts['filter_term'] ) {
									echo '<li>' . do_shortcode( '[sh_plugin show_version="' . esc_attr( $atts['show_version'] ) . '" show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" init="' . esc_attr( $plugin_init ) . '"]' ) . '</li>';
								}
								break;
							default:
									echo '<li>' . do_shortcode( '[sh_plugin show_version="' . esc_attr( $atts['show_version'] ) . '" show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" init="' . esc_attr( $plugin_init ) . '"]' ) . '</li>';
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
		 * Plugin Active List
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_active_list( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'format'       => 'link',
					'show_author'  => 'yes',
					'show_version' => 'yes',

					'filter_by'    => '', // E.g. 'author'.
					'filter_term'  => '', // E.g. 'ShortcodeHub'.
				),
				$atts
			);

			$active_plugins = $this->get_active_plugins();
			$plugins        = $this->get_plugins();

			ob_start();
			if ( $active_plugins ) {
				?>
				<ul>
					<?php
					foreach ( $active_plugins as $key => $plugin_init ) {

						if ( ! in_array( $plugin_init, $active_plugins ) ) {
							return;
						}

						switch ( $atts['filter_by'] ) {
							case 'author':
								if ( $plugins[ $plugin_init ]['Author'] == $atts['filter_term'] ) {
									echo '<li>' . do_shortcode( '[sh_plugin show_version="' . esc_attr( $atts['show_version'] ) . '" show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" init="' . esc_attr( $plugin_init ) . '"]' ) . '</li>';
								}
								break;
							default:
									echo '<li>' . do_shortcode( '[sh_plugin show_version="' . esc_attr( $atts['show_version'] ) . '" show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" init="' . esc_attr( $plugin_init ) . '"]' ) . '</li>';
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
		 * Plugin Inactive List
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_inactive_list( $atts = array() ) {

			$atts = shortcode_atts(
				array(
					'format'       => 'link',
					'show_author'  => 'yes',
					'show_version' => 'yes',

					'filter_by'    => '', // E.g. 'author'.
					'filter_term'  => '', // E.g. 'ShortcodeHub'.
				),
				$atts
			);

			$active_plugins = $this->get_active_plugins();
			$plugins        = $this->get_plugins();

			ob_start();
			if ( $plugins ) {
				?>
				<ul>
					<?php
					foreach ( $plugins as $plugin_init => $plugin ) {
						if ( ! in_array( $plugin_init, $active_plugins, false ) ) {
							switch ( $atts['filter_by'] ) {
								case 'author':
									if ( $plugin['Author'] === $atts['filter_term'] ) {
										echo '<li>' . do_shortcode( '[sh_plugin show_version="' . esc_attr( $atts['show_version'] ) . '" show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" init="' . esc_attr( $plugin_init ) . '"]' ) . '</li>';
									}
									break;
								default:
										echo '<li>' . do_shortcode( '[sh_plugin show_version="' . esc_attr( $atts['show_version'] ) . '" show_author="' . esc_attr( $atts['show_author'] ) . '" format="' . esc_attr( $atts['format'] ) . '" init="' . esc_attr( $plugin_init ) . '"]' ) . '</li>';
									break;
							}
						}
					}
					?>
				</ul>
				<?php
			}

			return ob_get_clean();
		}

		/**
		 * Plugin Download
		 *
		 * @since 0.0.1
		 *
		 * @param  array $atts Shortcode Parameters.
		 * @return int
		 */
		function plugin_download( $atts = array() ) {
			$atts = shortcode_atts(
				array(
					'slug'   => '',
					'format' => '', // Accepts, link. Default button.
					'text'   => 'Download',
				),
				$atts
			);

			$link = 'https://downloads.wordpress.org/plugin/' . esc_attr( $atts['slug'] ) . '.latest-stable.zip';

			if ( 'link' === $atts['format'] ) {
				return '<a href="' . esc_url( $link ) . '">' . esc_html( $atts['text'] ) . '</a>';
			}

			return '<a href="' . esc_url( $link ) . '"><button>' . esc_html( $atts['text'] ) . '</button></a>';
		}

		/**
		 * Get active plugins
		 *
		 * @return array
		 */
		function get_active_plugins() {
			if ( ! empty( $this->active_plugins ) ) {
				return $this->active_plugins;
			}

			$this->active_plugins = get_option( 'active_plugins', array() );

			return $this->active_plugins;
		}

		/**
		 * Get Plugins
		 *
		 * @return array
		 */
		function get_plugins() {
			if ( ! empty( $this->plugins ) ) {
				return $this->plugins;
			}

			/** WordPress Plugins. */
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$this->plugins = get_plugins();

			return $this->plugins;
		}

		/**
		 * Get Plugin
		 *
		 * @param  string $plugin_init Plugin Init File.
		 * @return mixed
		 */
		function get_plugin( $plugin_init = '' ) {
			$plugins = $this->get_plugins();

			if ( array_key_exists( $plugin_init, $plugins ) ) {
				return $plugins[ $plugin_init ];
			}

			return array();
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Useful_Shortcodes_Plugin::get_instance();

endif;
