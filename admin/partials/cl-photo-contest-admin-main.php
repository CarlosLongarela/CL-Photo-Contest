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
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Photo Contests', 'cl-photo-contest' ); ?></h1>
	<a href="<?php echo admin_url( 'admin.php?page=cl-photo-contest-new' ); // WPCS: XSS ok. ?>" class="page-title-action"><?php esc_html_e( 'Add new', 'cl-photo-contest' ); ?></a>
	<hr class="wp-header-end">

<!--
	<div>
		<h3><?php esc_html_e( 'Contest list', 'cl-photo-contest' ); ?></h3>
		<ul>
			<li>Primer concurso</li>
			<li>Segundo concurso</li>
			<li>Tercer concurso</li>
		</ul>
	</div>
-->
</div>
