<?php
/**
 * Plugin Name:       Sticky Buttons
 * Plugin URI:        https://wordpress.org/plugins/sticky-buttons/
 * Description:       Easily create sticky buttons of varying complexity.
 * Version:           3.2.4
 * Author:            Wow-Company
 * Author URI:        https://wow-estore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sticky-buttons
 * Domain Path:       /languages
 *
 * PHP version 5.3.0
 *
 * @category    Wordpress_Plugin
 * @package     Wow_Plugin
 * @author      Dmytro Lobov <i@lobov.dev>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.1
 */

// Required set the namespace for plugin.
namespace sticky_buttons;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wow_Plugin' ) ) :

	/**
	 * Main Wow_Plugin Class.
	 *
	 * @since 1.0
	 */
	final class Wow_Plugin {

		private static $_instance;

		// Set the database name.
		const PREF = 'sbtn';
		private $admin = '';
		private $public = '';

		/**
		 * Main Wow_Plugin Instance.
		 *
		 * Insures that only one instance of Wow_Plugin exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @return object|Wow_Plugin The one true Wow_Plugin for Current plugin
		 *
		 * @uses      Wow_Plugin::_includes() Include the required files.
		 * @uses      Wow_Plugin::text_domain() load the language files.
		 * @since     1.0
		 * @static
		 * @staticvar array $instance
		 */
		public static function instance() {

			if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof Wow_Plugin ) ) {

				$info = array(
					'plugin' => array(
						'name'      => esc_attr( 'Sticky Buttons'), // Plugin name
						'menu'      => esc_attr( 'Sticky Buttons'), // Plugin name in menu
						'author'    => 'Wow-Company', // Author
						'prefix'    => self::PREF, // Prefix for database
						'text'      => 'sticky-buttons',    // Text domain for translate files
						'version'   => '3.2.4', // Current version of the plugin
						'file'      => __FILE__, // Main file of the plugin
						'slug'      => dirname( plugin_basename( __FILE__ ) ), // Name of the plugin folder
						'url'       => plugin_dir_url( __FILE__ ), // filesystem directory path for the plugin
						'dir'       => plugin_dir_path( __FILE__ ), // URL directory path for the plugin
						'shortcode' => 'Sticky-Buttons',

					),
					'url'    => array(
						'author'   => 'https://wow-estore.com/',
						'home'     => 'https://wordpress.org/plugins/sticky-buttons/',
						'support'  => 'https://wordpress.org/support/plugin/sticky-buttons/',
						'facebook' => 'https://www.facebook.com/wowaffect/',
					),
					'rating' => array(
						'website' => esc_attr__( 'WordPress.org', 'sticky-buttons' ), // Name site for rating plugin
						'url'     => 'https://wordpress.org/support/plugin/sticky-buttons/reviews/',
						'wp_url'   => 'https://wordpress.org/support/plugin/sticky-buttons/reviews/#new-post',
						'wp_home'  => 'https://wordpress.org/plugins/sticky-buttons/',
						'wp_title' => 'Sticky Buttons – floating buttons builder',
					),
				);

				self::$_instance = new Wow_Plugin;

				register_activation_hook( __FILE__, array( self::$_instance, 'plugin_activate' ) );
				add_action( 'plugins_loaded', array( self::$_instance, 'text_domain' ) );

				self::$_instance->_includes();
				self::$_instance->admin  = new Wow_Plugin_Admin( $info );
				self::$_instance->public = new Wow_Plugin_Public( $info );
			}

			return self::$_instance;
		}

		/**
		 * Throw error on object clone.
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @return void
		 * @since  1.0
		 * @access protected
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'sticky-buttons' ), '0.1' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @return void
		 * @since  1.0
		 * @access protected
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'sticky-buttons' ), '0.1' );
		}


		/**
		 * Include required files.
		 *
		 * @access private
		 * @return void
		 * @since  1.0
		 */
		private function _includes() {
			if ( ! class_exists( 'Wow_Company' ) ) {
				include_once 'includes/class-wow-company.php';
			}
			include_once 'admin/class-admin.php';
			include_once 'public/class-public.php';
		}

		/**
		 * Activate the plugin.
		 * create the database
		 * create the folder in wp-upload
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function plugin_activate() {
			global $wpdb;
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			// Create the database for plugin
			$table = $wpdb->prefix . 'wow_' . self::PREF;
			$charset_collate = $wpdb->get_charset_collate();
			$sql   = "CREATE TABLE " . $table . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				title VARCHAR(200) NOT NULL,
				param TEXT,
				UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql );

			deactivate_plugins( 'sticky-buttons-pro/sticky-buttons-pro.php' );
		}
		/**
		 * Download the folder with languages.
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function text_domain() {
			$languages_folder = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			load_plugin_textdomain( 'sticky-buttons', false, $languages_folder );
		}
	}

endif; // End if class_exists check.

/**
 * The main function for that returns Wow_Plugin
 *
 * @since 1.0
 */
function Wow_Plugin_run() {
	return Wow_Plugin::instance();
}

// Get Running.
Wow_Plugin_run();
