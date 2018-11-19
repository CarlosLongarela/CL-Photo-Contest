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
<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="cl-photo-contest-upload-form" class="cl-photo-contest-upload-form" enctype="multipart/form-data">
	<?php wp_nonce_field( 'submit_photo_contest_form', 'cl_photo_contest_upload' ); ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo (int) $cl_upload_max_size; ?>" />

	<div class="cl-label-input">
		<label for="cl-author-name"><?php esc_html_e( 'Your name', 'cl-photo-contest' ); ?></label>
		<input type="text" id="cl-author-name" name="cl-author-name" placeholder="<?php esc_html_e( 'Enter your name', 'cl-photo-contest' ); ?>" required>
	</div>

	<div class="cl-label-input">
		<label for="cl-author-email"><?php esc_html_e( 'Your e-mail', 'cl-photo-contest' ); ?></label>
		<input type="email" id="cl-author-email" name="cl-author-email" placeholder="<?php esc_html_e( 'Enter your e-mail', 'cl-photo-contest' ); ?>" required>
	</div>

	<div class="cl-label-input">
		<label for="cl-photo-title"><?php esc_html_e( 'Photo title', 'cl-photo-contest' ); ?></label>
		<input type="text" id="cl-photo-title" name="cl-photo-title" placeholder="<?php esc_html_e( 'Enter a photo title', 'cl-photo-contest' ); ?>" required>
	</div>

	<div class="cl-label-input">
		<label for="cl-photo-comment"><?php esc_html_e( 'Comments', 'cl-photo-contest' ); ?></label>
		<textarea id="cl-photo-comment" name="cl-photo-comment" placeholder="<?php esc_html_e( 'Your comments about the photo', 'cl-photo-contest' ); ?>"></textarea>
	</div>

	<div class="cl-label-file">
		<label for="cl-photo-file"><?php esc_html_e( 'Select your photo to upload', 'cl-photo-contest' ); ?></label>
		<input type="file" id="cl-photo-file" name="cl-photo-file" accept='image/*' required>
	</div>

	<div class="cl-label-btn">
		<input type="submit" value="<?php esc_html_e( 'Submit photo and data', 'cl-photo-contest' ); ?>">
	</div>
</form>
