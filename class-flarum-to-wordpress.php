<?php

/**
 * @package  SerkanAlgurPlugins
 */

/*
 * Plugin Name: Flarum to WordPress
 * Plugin URI: http://serkanalgur.com.tr
 * Description: You can convert Flarum Forum System contents to WordPress Post-Comment System. Easy to migrate.
 * Version: 1.0
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

		public function __construct() {

			$this->initftw();

		}

		public function initftw() {
			add_action( 'init', array( $this, 'ftw_languages' ) );
			add_filter( 'plugin_action_links_' . FTW_APP_DIR_BASE, array( $this, 'ftw_add_link' ) );

		}

		// Languages
		public function ftw_languages() {
			load_plugin_textdomain( 'flarum-to-wordpress', false, FTW_APP_DIR_LNG );
		}

		// Settings
		public function ftw_add_link( $links ) {

			// Referral Link
			$developer_link = '<a href="https://serkanalgur.com.tr" target="_blank">Serkan Algur</a>';

			array_push( $links, $developer_link );

			return $links;
		}

	}

	$ftw = new Flarum_To_WordPress();

}
