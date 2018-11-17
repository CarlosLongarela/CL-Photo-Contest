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

		// If db table doesen't exists, we'll create it.
		// Our table name.
		$table_name = $wpdb->prefix . 'cl_photo_contests';

		// This is rather picky see https://codex.wordpress.org/Creating_Tables_with_Plugins for spaces, syntax...
		$charset_collate = $wpdb->get_charset_collate();

		$sql = 'CREATE TABLE ' . $table_name . " (
		id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,
		date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		mail varchar(255),
		post_data text NOT NULL,
		total_questions smallint(3) UNSIGNED DEFAULT '0',
		empatia decimal(5,2) UNSIGNED DEFAULT '0',
		resiliencia decimal(5,2) UNSIGNED DEFAULT '0',
		integridad decimal(5,2) UNSIGNED DEFAULT '0',
		responsabilidad decimal(5,2) UNSIGNED DEFAULT '0',
		ejemplaridad decimal(5,2) UNSIGNED DEFAULT '0',
		tolerancia decimal(5,2) UNSIGNED DEFAULT '0',
		autoconocimiento decimal(5,2) UNSIGNED DEFAULT '0',
		paciencia decimal(5,2) UNSIGNED DEFAULT '0',
		curiosidad decimal(5,2) UNSIGNED DEFAULT '0',
		esperanza decimal(5,2) UNSIGNED DEFAULT '0',
		PRIMARY KEY  (id)
		) " . $charset_collate . ';';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
