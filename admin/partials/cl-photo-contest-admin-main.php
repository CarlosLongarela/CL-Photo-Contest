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
	<h1><?php esc_html_e( 'CL Photo Contest Admin', 'cl-photo-contest' ); ?></h1>

	<div class="">
		<button calss="button button-primary"><?php esc_html_e( 'Create new contest', 'cl-photo-contest' ); ?></button>
	</div>

	<div>
		<h3><?php esc_html_e( 'Contest list', 'cl-photo-contest' ); ?></h3>
		<ul>
			<li>Primer concurso</li>
			<li>Segundo concurso</li>
			<li>Tercer concurso</li>
		</ul>
	</div>
</div>
