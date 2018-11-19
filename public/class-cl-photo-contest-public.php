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

	public function show_upload_photo_form() {
	?>
		<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'submit_content', 'my_nonce_field' ); ?>

			<p><label><input type="text" name="post_title" placeholder="<?php esc_html_e( 'Enter a photo title', 'cl-photo-contest' ); ?>"></label></p>
			<p><label><textarea name="post_content" placeholder="<?php esc_html_e( 'Optional photo description', 'cl-photo-contest' ); ?>"></textarea></label></p>

			<p><input type="file" name="image" accept='image/*'></p>

			<p>
				<input type="hidden" name="action" value="submit_content">
				<input type="submit" value="<?php esc_html_e( 'Submit Photo', 'cl-photo-contest' ); ?>">
			</p>
		</form>
	<?php
	}

}
