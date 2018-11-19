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
	 * The ID of this plugin.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string    $plugin_name  The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string   $version  The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 * @param   string $plugin_name   The name of this plugin.
	 * @param   string $version       The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
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

	public function cl_get_image_dimensions( $image_path ) {
		$image_dimensions = getimagesize( $image_path );

		$res['image_width']      = $image_dimensions['width'];
		$res['image_height']     = $image_dimensions['height'];
		$res['image_proportion'] = $res['image_width'] / $res['image_height'];

		if ( 1 < $res['image_proportion'] ) { // Image is in landscape mode.
			$res['image_mode'] = 'landscape';
		if ( 1 === $res['image_proportion'] ) { // Image is square (1:1).
			$res['image_mode'] = 'square';
		} else { // Image is portrait mode.
			$res['image_mode'] = 'portrait';
		}

		return $res;
	}

	public function cl_upload_file( $file ) {
		$upload = wp_upload_bits( $file['name'], '', wp_remote_get( $file['tmp_name'] ) );

		$wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );

		wp_redirect( site_url() . '/thank-you/' );
	}

	public function cl_image_resize( $image_path ) {
		$image = wp_get_image_editor( $image_path );
		if ( ! is_wp_error( $image ) ) {
			$image->resize( 300, 300, true );
			$image->save( 'new_image.jpg' );
		}
	}
}
