<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tabernawp.com/
 * @since             1.0.0
 * @package           Cl_Photo_Contest
 *
 * @wordpress-plugin
 * Plugin Name:       CL Photo Contest
 * Plugin URI:        https://tabernawp.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Carlos Longarela
 * Author URI:        https://tabernawp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cl-photo-contest
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CL_PHOTO_CONTEST_VERSION', '1.0.0' );

define( 'CL_PHOTO_CONTEST_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // plugin URL.
define( 'CL_PHOTO_CONTEST_PLUGIN_PATH', plugin_dir_path( __FILE__ ) ); // plugin PATH.

$cl_photo_contest_upload_dir = wp_upload_dir();
define( 'CL_PHOTO_CONTEST_UPLOAD_PATH', $cl_photo_contest_upload_dir['basedir'] . '/cl-photo-contest/' ); // Photo files path.

/**
 * Create a helper function for easy Freemius SDK access.
 */
function cl_photo_contest_fs() {
	global $cl_photo_contest_fs;

	if ( ! isset( $cl_photo_contest_fs ) ) {
		// Include Freemius SDK.
		require_once plugin_dir_path( __FILE__ ) . 'freemius/start.php';

		$cl_photo_contest_fs = fs_dynamic_init( array(
			'id'             => '2865',
			'slug'           => 'cl-photo-contest',
			'type'           => 'plugin',
			'public_key'     => 'pk_27c3ae44a0e5a3728f1d9a3554c55',
			'is_premium'     => false,
			'has_addons'     => false,
			'has_paid_plans' => false,
			'menu'           => array(
				'slug' => 'cl-photo-contest',
			),
		) );
	}

	return $cl_photo_contest_fs;
}

// Init Freemius.
cl_photo_contest_fs();

// Signal that SDK was initiated.
do_action( 'cl_photo_contest_fs_loaded' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cl-photo-contest-activator.php
 */
function activate_cl_photo_contest() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cl-photo-contest-activator.php';
	Cl_Photo_Contest_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cl-photo-contest-deactivator.php
 */
function deactivate_cl_photo_contest() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cl-photo-contest-deactivator.php';
	Cl_Photo_Contest_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cl_photo_contest' );
register_deactivation_hook( __FILE__, 'deactivate_cl_photo_contest' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cl-photo-contest.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cl_photo_contest() {

	$plugin = new Cl_Photo_Contest();
	$plugin->run();

}
run_cl_photo_contest();
