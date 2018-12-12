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

	<form method="post" name="createuser" id="createuser" class="validate" novalidate="novalidate">

		<input name="action" type="hidden" value="createuser">
		<input type="hidden" id="_wpnonce_create-user" name="_wpnonce_create-user" value="e5bf5d5009"><input type="hidden" name="_wp_http_referer" value="/wp-admin/user-new.php">

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="user_login">Nombre de usuario <span class="description">(obligatorio)</span></label>
					</th>
					<td>
						<input name="user_login" type="text" id="user_login" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="email">Correo electrónico <span class="description">(obligatorio)</span></label>
					</th>
					<td>
						<input name="email" type="email" id="email" value="">
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="first_name">Nombre </label>
					</th>
					<td>
						<input name="first_name" type="text" id="first_name" value="">
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="last_name">Apellidos </label>
					</th>
					<td>
						<input name="last_name" type="text" id="last_name" value="">
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="url">Web</label>
					</th>
					<td>
						<input name="url" type="url" id="url" class="code" value="">
					</td>
				</tr>
				<tr>
					<th scope="row">
						Enviar aviso al usuario
					</th>
					<td>
						<input type="checkbox" name="send_user_notification" id="send_user_notification" value="1" checked="checked">
						<label for="send_user_notification">Envía al usuario nuevo un correo electrónico con información sobre su cuenta.</label>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="role">Perfil</label>
					</th>
					<td>
						<select name="role" id="role">
							<option selected="selected" value="subscriber">Suscriptor</option>
							<option value="contributor">Colaborador</option>
							<option value="author">Autor</option>
							<option value="editor">Editor</option>
							<option value="administrator">Administrador</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" name="createuser" id="createusersub" class="button button-primary" value="Añadir nuevo usuario">
		</p>

	</form>

</div>
