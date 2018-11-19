<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/public/partials
 */

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
