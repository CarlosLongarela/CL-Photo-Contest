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
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete DB version from options table.
delete_option( 'cl_photo_contests_db_version' );

if ( true === $delete_installed_tables ) { // TODO: Method for user select if tables will be dropped on uninstall.
	global $wpdb;

	$table_name_1 = $wpdb->prefix . 'cl_photo_contests';
	$table_name_2 = $wpdb->prefix . 'cl_photo_contests_photos';

	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}cl_photo_contests" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}cl_photo_contests_photos" );
}
