<?php

/**
 * @package  SerkanAlgurPlugins
 */

/*
 * Plugin Name: Flarum to WordPress
 * Plugin URI: http://serkanalgur.com.tr
 * Description: You can convert Flarum Forum System contents to WordPress Post-Comment System. Easy to migrate.
 * Version: 1.0.0-alpha
 * Author: Serkan Algur
 * Author URI: http://serkanalgur.com.tr
 * Text Domain: flarum-to-wordpress
 * Domain Path: /languages/
*/

// Disable directly access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FTW_MIN_PHP_VERSION', '7.2' );
define( 'FTW_APP_MIN_WP_VERSION', '5.6' );
define( 'FTW_APP_DIR_BASE', plugin_basename( __FILE__ ) );
define( 'FTW_APP_DIR_FILE', __FILE__ );
define( 'FTW_APP_DIR_LNG', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
define( 'FTW_APP_DIR_URL', plugin_dir_url( FTW_APP_DIR_FILE ) );

// PHP version check has to go here because the below code uses namespaces
if ( version_compare( PHP_VERSION, FTW_MIN_PHP_VERSION, '<' ) ) {
	// We need to load "plugin.php" manually to call "deactivate_plugins"
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	deactivate_plugins( FTW_APP_DIR_BASE, true );
	wp_die(
		'<p>The Flarum to WordPress plugin requires a PHP version of at least ' . FTW_MIN_PHP_VERSION . '; you have ' . PHP_VERSION . '.</p>',
		'Plugin Activation Error',
		array(
			'response'  => 200,
			'back_link' => true,
		)
	);
}

if ( ! class_exists( 'Flarum_To_WordPress' ) ) {

	class Flarum_To_WordPress {
		private $admin_page;
		public function __construct() {

			$this->initftw();

		}

		/**
		 * It adds a link to the settings page in the plugin list.
		 */
		public function initftw() {
			add_action( 'init', array( $this, 'ftw_languages' ) );
			add_filter( 'plugin_action_links_' . FTW_APP_DIR_BASE, array( $this, 'ftw_add_link' ) );
			add_action( 'admin_menu', array( $this, 'ftw_add_admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_page_scripts' ) );
			add_action( 'wp_ajax_check_other_database', array( $this, 'check_database_connection' ) );
		}

		/**
		 * It loads the plugin's language files
		 */
		public function ftw_languages() {
			load_plugin_textdomain( 'flarum-to-wordpress', false, FTW_APP_DIR_LNG );
		}

		/**
		 * It adds a link to the plugin's page in the WordPress admin area
		 *
		 * @param links (array) (required) An array of the existing links.
		 *
		 * @return The  array is being returned.
		 */
		public function ftw_add_link( $links ) {

			$developer_link = '<a href="https://serkanalgur.com.tr" target="_blank">Serkan Algur</a>';

			array_push( $links, $developer_link );

			return $links;
		}

		/**
		 * It adds a menu page to the WordPress admin menu
		 */
		public function ftw_add_admin_menu() {
			$this->admin_page = add_menu_page( __( 'Flarum to WordPress', 'flarum-to-wordpress' ), __( 'Flarum to WordPress', 'flarum-to-wordpress' ), 'manage_options', 'flarum-to-wordpress', array( $this, 'ftw_menu_page' ), 'dashicons-superhero', 6 );
		}

		/**
		 * It adds a menu item to the WordPress admin menu
		 */
		public function ftw_menu_page() {
			$html      = "<div class='wrap'>";
				$html .= '<h1>' . __( 'Flarum to WordPress', 'flarum-to-wordpress' ) . '</h1>';
				$html .= '<div id="app"></div>';
			$html     .= '</div>';

			echo $html;
		}

		public function add_admin_page_scripts( $hook ) {
			if ( $hook !== $this->admin_page ) {
				return;
			}
			// For Debug
			wp_enqueue_script( 'ftw', 'http://project.local:8083/flarum_to_wordpress.bundle.js', array( 'jquery' ), true, true );

			wp_localize_script(
				'ftw',
				'ftw_object',
				array(
					'ajaxurl'  => admin_url( 'admin-ajax.php' ),
					'language' => $this->language_strings(),
					'security' => wp_create_nonce( 'ftw_sec' ),
				)
			);

			// For Production
			//wp_enqueue_script( 'ftw', plugin_dir_url( __FILE__ ) . '/dist/flarum_to_wordpress.bundle.js, array( 'jquery' ), true, true );
		}

		public function check_database_connection() {
			check_ajax_referer( 'ftw_sec', 'security' );
			$fhost = sanitize_text_field( $_POST['flarum_db_host'] );
			$ftabl = sanitize_text_field( $_POST['flarum_db_table'] );
			$fuser = sanitize_text_field( $_POST['flarum_db_username'] );
			$fpass = sanitize_text_field( $_POST['flarum_db_password'] );
			$fdbpo = sanitize_text_field( $_POST['flarum_db_port'] );

			$fd_bas = new wpdb( $fuser, $fpass, $ftabl, $fhost, $fhost );

			echo wp_send_json_success( $fd_bas, 200 );
			wp_die();
		}

		public function language_strings() {

			$lang_files = array(
				'rtheme'    => __( 'Recommended Theme', 'flarum-to-wordpress' ),
				'author'    => __( 'About Author', 'flarum-to-wordpress' ),
				'fsettings' => __( 'Flarum Informations', 'flarum-to-wordpress' ),
				'fdh'       => __( 'Flarum DB Host', 'flarum-to-wordpress' ),
				'fdt'       => __( 'Flarum DB Table', 'flarum-to-wordpress' ),
				'fdu'       => __( 'Flarum DB Username', 'flarum-to-wordpress' ),
				'fdp'       => __( 'Flarum DB Password', 'flarum-to-wordpress' ),
				'fdbp'      => __( 'Flarum DB Port', 'flarum-to-wordpress' ),
			);

			return $lang_files;
		}


	}

	$ftw = new Flarum_To_WordPress();

}
