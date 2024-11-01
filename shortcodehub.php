<?php
/**
 * Plugin Name: ShortcodeHub
 * Plugin URI: https://surror.com/shortcodehub/
 * Description: Unleash the Power of Shortcodes with the Ultimate All-in-One Multi-Purpose Shortcode Builder! 🚀
 * Version: 1.7.1
 * Author: Surror
 * Author URI: https://surror.com/
 * Text Domain: shortcodehub
 *
 * @package ShortcodeHub
 *   _____ __               __                 __     __  __      __
 *  / ___// /_  ____  _____/ /__________  ____/ /__  / / / /_  __/ /_
 *  \__ \/ __ \/ __ \/ ___/ __/ ___/ __ \/ __  / _ \/ /_/ / / / / __ \
 * ___/ / / / / /_/ / /  / /_/ /__/ /_/ / /_/ /  __/ __  / /_/ / /_/ /
 * ____/_/ /_/\____/_/   \__/\___/\____/\__,_/\___/_/ /_/\__,_/_.___/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Set Constants.
define( 'SHORTCODEHUB_VER', '1.7.1' );
define( 'SHORTCODEHUB_FILE', __FILE__ );
define( 'SHORTCODEHUB_BASE', plugin_basename( SHORTCODEHUB_FILE ) );
define( 'SHORTCODEHUB_DIR', plugin_dir_path( SHORTCODEHUB_FILE ) );
define( 'SHORTCODEHUB_URI', plugins_url( '/', SHORTCODEHUB_FILE ) );

require_once SHORTCODEHUB_DIR . 'inc/classes/class-sh-loader.php';