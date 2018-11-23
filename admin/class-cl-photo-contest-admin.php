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
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cl_Photo_Contest_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cl_Photo_Contest_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( CL_PHOTO_CONTEST_PLUGIN_NAME, plugin_dir_url( __FILE__ ) . 'css/cl-photo-contest-admin.css', array(), CL_PHOTO_CONTEST_PLUGIN_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cl_Photo_Contest_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cl_Photo_Contest_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( CL_PHOTO_CONTEST_PLUGIN_NAME, plugin_dir_url( __FILE__ ) . 'js/cl-photo-contest-admin.js', array( 'jquery' ), CL_PHOTO_CONTEST_PLUGIN_VERSION, false );
	}

	/**
	 * Register admin menu
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function register_menu_cl_photo_contest() {
		//$menu_slug       = $this->plugin_name . '/admin/cl-photo-contest-menu.php';
		//$sub_menu_slug_1 = $this->plugin_name . '/admin/cl-photo-contest-menu-paginas.php';
		//$sub_menu_slug_2 = $this->plugin_name . '/admin/cl-photo-contest-menu-stats-paginas.php';

		//add_menu_page( __( 'Admin Photo Contest', 'cl-photo-contest' ), __( 'Photo Contest', 'cl-photo-contest' ), 'edit_pages', $menu_slug, '', 'dashicons-images-alt', '26.1' );
		//add_submenu_page( $menu_slug, __( 'Contest', 'cl-photo-contest' ), __( 'Contest creation', 'cl-photo-contest' ), 'manage_options', $sub_menu_slug_1 );
		//add_submenu_page( $menu_slug, __( 'Photos', 'cl-photo-contest' ), __( 'Photos admin', 'cl-photo-contest' ), 'manage_options', $sub_menu_slug_2 );

		add_menu_page( esc_html__( 'Admin Photo Contest', 'cl-photo-contest' ), esc_html__( 'Admin', 'cl-photo-contest' ), 'edit_pages', CL_PHOTO_CONTEST_PLUGIN_NAME, array( $this, 'show_admin_page_main' ), 'dashicons-images-alt', '26' );

		//add_submenu_page( CL_PHOTO_CONTEST_PLUGIN_NAME, esc_html__( 'Drafts', 'cl-photo-contest' ), esc_html__( 'Drafts', 'cl-photo-contest' ), 'manage_options', 'cl-mailing-submenu-drafts', array( $this, 'show_page_drafts' ) );
	}
}
