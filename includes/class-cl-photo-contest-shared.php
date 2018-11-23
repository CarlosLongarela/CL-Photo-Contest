<?php
/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @author            Carlos Longarela <carlos@longarela.eu>
 * @link              https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/includes
 */

/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/includes
 * @author     Carlos Longarela <carlos@longarela.eu>
 */
class Cl_Photo_Contest_Shared {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Put contents in WordPress API filesystem.
	 *
	 * @param string $file_path    File path where to save file.
	 * @param string $data         Data to write in file.
	 */
	public function cl_wp_file_put_contents( $file_path, $data ) {
		// Include file for WordPress filesystem API.
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$access_type = get_filesystem_method();
		if ( 'direct' === $access_type ) {
			// Obtain credentials.
			$creds = request_filesystem_credentials( site_url(), '', false, false, array() );

			// Start API.
			if ( ! WP_Filesystem( $creds ) ) {
				echo '<h2>' . esc_html__( 'The file system API could not be initialized, you do not have sufficient permissions', 'cl-photo-contest' ) . '.</h2>';
				die();
			}

			global $wp_filesystem;
		} else {
			echo '<h2>' . esc_html__( 'Unable to access the file system', 'cl-photo-contest' ) . '.</h2>';
			die();
		}
		$wp_filesystem->put_contents(
			$file_path,
			$data,
			FS_CHMOD_FILE // Permisos de archivo predefinidos para WP.
		);
	}

	/**
	 * Return image dimensions and proportion.
	 *
	 * @param string $image_path    Valid image name and path.
	 */
	public function cl_get_image_dimensions( $image_path ) {
		$image_dimensions = getimagesize( $image_path );

		if ( false === $image_dimensions ) { // No recognised as image type.
			return false;
		}

		$res['image_width']      = $image_dimensions[0];
		$res['image_height']     = $image_dimensions[1];
		$res['image_proportion'] = $res['image_width'] / $res['image_height'];

		if ( 1 < $res['image_proportion'] ) { // Image is in landscape mode.
			$res['image_mode'] = 'landscape';
		} elseif ( 1 === $res['image_proportion'] ) { // Image is square (1:1).
			$res['image_mode'] = 'square';
		} else { // Image is portrait mode.
			$res['image_mode'] = 'portrait';
		}

		return $res;
	}

	/**
	 * Upload a file to directory.
	 *
	 * @param array $file    File array.
	 */
	public function cl_upload_file( $file ) {
		$upload = wp_upload_bits( $file['name'], '', wp_remote_get( $file['tmp_name'] ) );
	}

	/**
	 * Resize a image and save serult file.
	 *
	 * @param string $image_path     Original image path.
	 * @param int    $image_quality  New image quality from 0 to 100 (default 70).
	 * @param int    $image_width    New image width.
	 * @param int    $image_height   New image height.
	 * @param string $new_image_path Path and image name for save it.
	 */
	public function cl_image_resize( $image_path, $image_quality = 70, $image_width, $image_height, $new_image_path ) {
		$image = wp_get_image_editor( $image_path );
		if ( ! is_wp_error( $image ) ) {
			$image->set_quality( $image_quality );
			$image->resize( $image_width, $image_height, true );
			$image->save( $new_image_path );
		}
	}

	/**
	 * Total photos validated submited to contest with that Id.
	 *
	 * @param int $id_contest  Id contest to obtain total photos number.
	 */
	public function get_total_num_photos( $id_contest ) {
		global $wpdb;

		$n_photos = 0;
		$n_photos = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(id) FROM {$wpdb->prefix}cl_photo_contests_photos WHERE id_contest = %d AND photo_validated = 1",
			$id_contest
		) );

		return $n_photos;
	}

	/**
	 * Retrieve photos data for this page.
	 *
	 * @param int    $id_contest    Id contest to obtain photos data.
	 * @param int    $page_num      Number of page to show.
	 * @param int    $n_photos_show Number of photos to show in actual page.
	 * @param string $order      Databse order for results.
	 */
	public function get_contest_photos_data( $id_contest, $page_num, $n_photos_show, $order = 'DESC' ) {
		$id_contest    = absint( $id_contest );
		$page_num      = absint( $page_num );
		$n_photos_show = absint( $n_photos_show );
		$order         = esc_attr( $order );

		if ( 1 === $page_num ) { // First page.
			$res = $wpdb->get_results( $wpdb->prepare(
				"SELECT author_name, author_mail, photo_title, photo_size_bytes, photo_comment, upload_date
				FROM {$wpdb->prefix}cl_photo_contests_photos
				WHERE id_contest = %d AND photo_validated = 1
				ORDER BY id %s
				LIMIT %d",
				$id_contest,
				$order,
				$n_photos_show
			) );
		} else { // Second and consecutive pages.
			$offset = absint( ( $page_num * $n_photos_show ) - 1 );
			/**
			 * Obtain Id with The Seek Method:
			 * https://www.eversql.com/faster-pagination-in-mysql-why-order-by-with-limit-and-offset-is-slow/
			 * https://use-the-index-luke.com/es/sql/resultados-parciales/paginar
			 */
			$id_from = $wpdb->get_var( $wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}cl_photo_contests_photos
				WHERE id_contest = %d AND photo_validated = 1
				ORDER BY id %s
				LIMIT 1 OFFSET %d",
				$id_contest,
				$order,
				$offset
			) );

			if ( 'ASC' === $order ) {
				$res = $wpdb->get_results( $wpdb->prepare(
					"SELECT author_name, author_mail, photo_title, photo_size_bytes, photo_comment, upload_date
					FROM {$wpdb->prefix}cl_photo_contests_photos
					WHERE id > %d AND id_contest = %d AND photo_validated = 1
					ORDER BY id ASC
					LIMIT %d",
					$id_from,
					$id_contest,
					$n_photos_show
				) );
			} else {
				$res = $wpdb->get_results( $wpdb->prepare(
					"SELECT author_name, author_mail, photo_title, photo_size_bytes, photo_comment, upload_date
					FROM {$wpdb->prefix}cl_photo_contests_photos
					WHERE id < %d AND id_contest = %d AND photo_validated = 1
					ORDER BY id DESC
					LIMIT %d",
					$id_from,
					$id_contest,
					$n_photos_show
				) );
			}
		}

		return $res;
	}

}
