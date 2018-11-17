<?php

/**
 * Fired during plugin activation
 *
 * @link       https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/includes
 * @author     Carlos Longarela <carlos@longarela.eu>
 */
class Cl_Photo_Contest_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// If content photos folder doesn't exist, create folder.
		if ( ! file_exists( CL_PHOTO_CONTEST_UPLOAD_PATH ) ) {
			wp_mkdir_p( CL_PHOTO_CONTEST_UPLOAD_PATH );
		}

		$sql = array();

		// If db table doesen't exists, we'll create it.
		// Our table names.
		$table_name_1 = $wpdb->prefix . 'cl_photo_contests';
		$table_name_2 = $wpdb->prefix . 'cl_photo_contests_photos';

		// This is rather picky see https://codex.wordpress.org/Creating_Tables_with_Plugins for spaces, syntax...
		$charset_collate = $wpdb->get_charset_collate();

		$sql[] = 'CREATE TABLE ' . $table_name_1 . " (
		id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,
		creation_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		title varchar(255),
		active_from datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		active_to datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		PRIMARY KEY  (id)
		) " . $charset_collate . ';';

		$sql[] = 'CREATE TABLE ' . $table_name_2 . " (
		id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,
		author_name varchar(255) NULL DEFAULT NULL,
		author_mail varchar(255) NULL DEFAULT NULL,
		photo_title varchar(255) NULL DEFAULT NULL,
		photo_size_bytes mediumint(9) UNSIGNED NULL DEFAULT NULL,
		photo_comment text NULL,
		upload_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
		id_contest mediumint(9) UNSIGNED NULL DEFAULT NULL,
		photo_validated tinyint(1) UNSIGNED NULL DEFAULT '0',
		PRIMARY KEY  (id)
		) " . $charset_collate . ';';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
