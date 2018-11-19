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
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version           The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cl-photo-contest-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cl-photo-contest-public.js', array( 'jquery' ), $this->version, false );
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

		$res = $wpdb->get_row( $wpdb->prepare(
			"SELECT id, active_from, active_to FROM {$wpdb->prefix}cl_photo_contests WHERE id = %d",
			$id_contest
		) );

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
	 * Shortcode for Show input form for upload photosto contest.
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

}
