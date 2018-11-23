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
		wp_enqueue_style( CL_PHOTO_CONTEST_PLUGIN_NAME, CL_PHOTO_CONTEST_PLUGIN_URL . 'admin/css/cl-photo-contest-admin.min.css', array(), CL_PHOTO_CONTEST_PLUGIN_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( CL_PHOTO_CONTEST_PLUGIN_NAME, CL_PHOTO_CONTEST_PLUGIN_URL . 'admin/js/cl-photo-contest-admin.min.js', array( 'jquery' ), CL_PHOTO_CONTEST_PLUGIN_VERSION, false );
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
}
