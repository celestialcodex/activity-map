<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * 
 * 
 *
 * @link       https://github.com/celestialcodex/activity-map
 * @since      1.0.0
 *
 * @package    Activity_Map
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

/**
 * uninstall_activity_map
 * Delete the activity map table
 * @return void
 */
function uninstall_activity_map()
{
	global $wpdb;
	$admin_role = get_role('administrator');
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}activity_map`;");
	/**to do run a backup

	export a csv/html data **/
	delete_option('activity_map_db_version');
}


uninstall_activity_map();
