<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://tabernawp.com/
 * @since      1.0.0
 *
 * @package    Cl_Photo_Contest
 * @subpackage Cl_Photo_Contest/admin/partials
 */

?>

<div class="wrap">
	<h1><?php esc_html_e( 'Add new Photo Contest', 'cl-photo-contest' ); ?></h1>

	<form method="post" name="create_contest" id="create_contest" class="validate">

		<?php
		wp_nonce_field( 'cl_create_contest', 'cl_photo_contest_new' );

		if ( ! empty( $res ) ) {
			echo $res;
		}
		?>

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="contest_title"><?php esc_html_e( 'Title', 'cl-photo-contest' ); ?> <span class="description">(<?php esc_html_e( 'required', 'cl-photo-contest' ); ?>)</span></label>
					</th>
					<td>
						<input name="contest_title" type="text" id="contest_title" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="200" required>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="contest_from_date"><?php esc_html_e( 'Active from', 'cl-photo-contest' ); ?> <span class="description">(<?php esc_html_e( 'required', 'cl-photo-contest' ); ?>)</span></label>
					</th>
					<td>
						<input name="contest_from_date" type="date" id="contest_from_date" value="" required>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="contest_to_date"><?php esc_html_e( 'Active until', 'cl-photo-contest' ); ?> <span class="description">(<?php esc_html_e( 'required', 'cl-photo-contest' ); ?>)</span></label>
					</th>
					<td>
						<input name="contest_to_date" type="date" id="contest_to_date" value="" required>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" name="create_contest_submit" id="create_contest_submit" class="button button-primary" value="<?php esc_html_e( 'Add new Photo Contest', 'cl-photo-contest' ); ?>">
		</p>

	</form>

</div>
