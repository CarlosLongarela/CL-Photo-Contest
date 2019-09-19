<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/public
 * @author     Carlos Longarela <carlos@longarela.eu>
 */
class Cl_Photo_Contest_Public {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// phpcs:ignore
		wp_enqueue_style( CL_PHOTO_CONTEST_PLUGIN_NAME, CL_PHOTO_CONTEST_PLUGIN_URL . 'public/css/cl-photo-contest-public.min.css', array(), null, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// phpcs:ignore
		wp_enqueue_script( CL_PHOTO_CONTEST_PLUGIN_NAME, CL_PHOTO_CONTEST_PLUGIN_URL . 'public/js/cl-photo-contest-public.min.js', array(), null, true );
	}

	/**
	 * Check if Id Contest is valid and active.
	 *
	 * @param int $id_contest Id Contest.
	 *
	 * @since    1.0.0
	 */
	protected function get_valid_contest( $id_contest ) {
		global $wpdb;

		$res = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT id, active_from, active_to FROM {$wpdb->prefix}cl_photo_contests WHERE id = %d",
				$id_contest
			)
		);

		$res->id;
		$res->active_from;
		$res->active_to;
		$now = strtotime( 'now' );

		if ( empty( $res->id ) ) {
			return esc_html__( 'There is no photo contest with that Id', 'cl-photo-contest' );
		}

		if ( ( $now >= strtotime( $res->active_from ) ) && ( $now <= strtotime( $res->active_to ) ) ) {
			return true;
		} elseif ( $now < strtotime( $res->active_from ) ) {
			return esc_html__( 'The contest start date has not yet arrived', 'cl-photo-contest' );
		} elseif ( $now > strtotime( $res->active_to ) ) {
			return esc_html__( 'The contest has finished', 'cl-photo-contest' );
		}
	}

	/**
	 * Shortcode for Show input form for upload photos to contest.
	 *
	 * Shortecode [sc_cl_photo_contest_form id_contest="1972" upload_max_filesize="2097152"].
	 * (id_contest to show form).
	 * (upload max file size in bytes).
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @since    1.0.0
	 */
	public function shortcode_cl_photo_contest_form( $atts ) {
		$id_contest          = (int) $atts['id_contest'];
		$upload_max_filesize = (int) $atts['upload_max_filesize'];

		if ( empty( $id_contest ) ) {
			return esc_html__( 'You must provide a contest Id', 'cl-photo-contest' );
		}

		$valid_contest = $this->get_valid_contest( $id_contest );

		if ( true !== $valid_contest ) {
			return $valid_contest;
		}

		if ( empty( $upload_max_filesize ) ) {
			$cl_upload_max_size = ini_get( 'upload_max_filesize' );
		}

		ob_start();
		require_once CL_PHOTO_CONTEST_PLUGIN_PATH . 'public/partials/cl-photo-contest-public-upload-form.php';
		$res = ob_get_clean();

		return apply_filters( 'cl_photo_contest_form_sc', $res );
	}

	/**
	 * Shortcode for Show input form for upload photosto contest.
	 *
	 * Shortecode [sc_cl_photo_contest_pages id_contest="1972" photos_by_page="40"].
	 * (id_contest to show pages).
	 * (photos_by_page).
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @since    1.0.0
	 */
	public function shortcode_cl_photo_contest_pages( $atts ) {
		$id_contest     = (int) $atts['id_contest'];
		$photos_by_page = (int) $atts['photos_by_page'];

		if ( empty( $id_contest ) ) {
			return esc_html__( 'You must provide a contest Id', 'cl-photo-contest' );
		}

		$valid_contest = $this->get_valid_contest( $id_contest );

		if ( true !== $valid_contest ) {
			return $valid_contest;
		}

		ob_start();
		require_once CL_PHOTO_CONTEST_PLUGIN_PATH . 'public/partials/cl-photo-contest-public-photo-page.php';
		$res = ob_get_clean();

		return apply_filters( 'cl_photo_contest_page_sc', $res );
	}
}
