<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/admin
 * @author     Carlos Longarela <carlos@longarela.eu>
 */
class Cl_Photo_Contest_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// phpcs:ignore
		wp_enqueue_style( CL_PHOTO_CONTEST_PLUGIN_NAME, CL_PHOTO_CONTEST_PLUGIN_URL . 'admin/css/cl-photo-contest-admin.min.css', array(), null, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// phpcs:ignore
		wp_enqueue_script( CL_PHOTO_CONTEST_PLUGIN_NAME, CL_PHOTO_CONTEST_PLUGIN_URL . 'admin/js/cl-photo-contest-admin.min.js', array(), null, true );
	}

	/**
	 * Register admin menu
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function register_menu_cl_photo_contest() {
		add_menu_page( esc_html__( 'Admin Photo Contest', 'cl-photo-contest' ), esc_html__( 'Photo Contests', 'cl-photo-contest' ), 'edit_pages', CL_PHOTO_CONTEST_PLUGIN_NAME, array( $this, 'show_admin_page_main' ), 'dashicons-images-alt', '26' );

		add_submenu_page( CL_PHOTO_CONTEST_PLUGIN_NAME, esc_html__( 'Contest Stats', 'cl-photo-contest' ), esc_html__( 'Stats', 'cl-photo-contest' ), 'edit_pages', 'cl-photo-contest-submenu-stats', array( $this, 'show_admin_page_stats' ) );

		// Pages without menu entry.
		add_submenu_page( null, null, null, 'edit_pages', 'cl-photo-contest-new', array( $this, 'show_admin_page_contest_new' ) );
	}

	/**
	 * List Photo Contests
	 *
	 * @param string $order_field Field to order the query.
	 * @param string $order       Order ASC or DESC.
	 * @param int    $limit       Number or registers to return.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_photo_contests( $order_field = 'creation_date', $order = 'ASC', $limit = 30 ) {
		global $wpdb;

		if ( 'ASC' === $order ) {
			$order = 'ASC';
		} else {
			$order = 'DESC';
		}

		switch ( $order_field ) {
			case 'creation_date':
				$order_field = 'creation_date';
				break;
			case 'id':
				$order_field = 'id';
				break;
			case 'title':
				$order_field = 'title';
				break;
			case 'active_from':
				$order_field = 'active_from';
				break;
			case 'active_to':
				$order_field = 'active_to';
				break;
			default:
				$order_field = 'creation_date';
				break;
		}

		// phpcs:disable
		$res = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id, creation_date, title, active_from, active_to
				FROM {$wpdb->prefix}cl_photo_contests
				ORDER BY $order_field $order
				LIMIT %d",
				$limit
			)
		);
		// phpcs:enable

		return $res;
	}

	/**
	 * Create Photo Contest
	 *
	 * @param array $data Post data for new Photo Contest.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_photo_contest( $data ) {
		global $wpdb;

		$title     = esc_html( $data['contest_title'] );
		$date_from = esc_attr( $data['contest_from_date'] );
		$date_to   = esc_attr( $data['contest_to_date'] );
		$date_now  = current_time( 'mysql' );

		if ( empty( $title ) ) {
			return esc_html__( 'Contest title can not be empty', 'cl-photo-contest' );
		} elseif ( empty( $date_from ) ) {
			return esc_html__( 'Contest active from date can not be empty', 'cl-photo-contest' );
		} elseif ( empty( $date_to ) ) {
			return esc_html__( 'Contest active until date can not be empty', 'cl-photo-contest' );
		} elseif ( strtotime( $date_from ) >= strtotime( $date_to ) ) {
			return esc_html__( 'Contest active until date must be greater than from date', 'cl-photo-contest' );
		}

		$res = $wpdb->insert(
			"{$wpdb->prefix}cl_photo_contests",
			array(
				'creation_date' => $date_now,
				'title'         => $title,
				'active_from'   => date( 'Y-m-d H:i:s', strtotime( $date_from ) ),
				'active_to'     => date( 'Y-m-d H:i:s', strtotime( $date_to ) ),
			)
		);

		if ( false === $res ) {
			return esc_html__( 'An error occurred while saving the new photo contest', 'cl-photo-contest' );
		} else {
			return true;
		}
	}
	/**
	 * Admin menu method for show principal page.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function show_admin_page_main() {
		require_once CL_PHOTO_CONTEST_PLUGIN_PATH . 'admin/partials/cl-photo-contest-admin-main.php';
	}

	/**
	 * Admin menu method for show stats page.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function show_admin_page_stats() {
		require_once CL_PHOTO_CONTEST_PLUGIN_PATH . 'admin/partials/cl-photo-contest-admin-stats.php';
	}

	/**
	 * Admin menu method for show stats page.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function show_admin_page_contest_new() {
		require_once CL_PHOTO_CONTEST_PLUGIN_PATH . 'admin/partials/cl-photo-contest-admin-new.php';
	}
}
