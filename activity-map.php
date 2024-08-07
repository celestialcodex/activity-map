<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/celestialcodex/activity-map
 * @since             1.0.0
 * @package           Activity_Map
 *
 * @wordpress-plugin
 * Plugin Name:       Activity Map
 * Plugin URI:       https://github.com/celestialcodex/activity-map
 * Description:       Activity Map plugin is a simple tool designed to help you monitor and analyze user interactions on your WordPress site.
 * Version:           1.0.0
 * Author:            Celestialcodex
 * Author URI:        https://github.com/celestialcodex
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       activity-map
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('ACTIVITY_MAP__FILE__', __FILE__);
define('ACTIVITY_MAP_BASE', plugin_basename(ACTIVITY_MAP__FILE__));

define('ACTIVITY_MAP_VERSION', '1.0.0');


include('classes/class-am-hooks.php');
include('classes/class-am-db-store.php');
include('admin/class-activity-map-admin-ui.php');

include('includes/class-activity-map-activator.php');
include('includes/class-activity-map-deactivator.php');

require_once plugin_dir_path(__FILE__) .'includes/global-helpers.php';


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activity-map-activator.php
 */
function activate_activity_map()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-activity-map-activator.php';
	Activity_Map_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-activity-map-deactivator.php
 */
function deactivate_activity_map()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-activity-map-deactivator.php';
	Activity_Map_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_activity_map');
register_deactivation_hook(__FILE__, 'deactivate_activity_map');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-activity-map.php';

final class AM_Main
{

	private static $_instance = null;

	public $hooks;

	public $admin_ui;

	public $db_store;


	/**
	 * Load text domain
	 */
	public function load_textdomain()
	{
		load_plugin_textdomain('activity-map');
	}

	/**
	 * Construct
	 */
	protected function __construct()
	{
		global $wpdb;

		$this->hooks         = new AM_Hooks();
		$this->db_store      = new AM_Db_Store();
		$this->admin_ui      = new AM_Map_Admin_Ui();

		// set up our DB name globaly
		$wpdb->activity_map = $wpdb->prefix . 'activity_map';
		add_action('plugins_loaded', array(&$this, 'load_textdomain'));
	}

	public static function instance()
	{
		if (is_null(self::$_instance))
			self::$_instance = new AM_Main();
		return self::$_instance;
	}
}

AM_Main::instance();
