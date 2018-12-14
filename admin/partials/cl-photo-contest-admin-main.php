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

$state          = '';
$now            = time();
$order_field    = 'creation_date';
$order          = 'ASC';
$limit          = 30;
$wp_date_format = get_option( 'date_format' );
$nonce          = wp_create_nonce( 'contest-order' );
$base_url       = admin_url( 'admin.php?page=cl-photo-contest' );
$url            = wp_nonce_url( $base_url, 'contest-order', '_nonce_order' );

if ( ! empty( $_GET['_nonce_order'] ) && wp_verify_nonce( $_GET['_nonce_order'], 'contest-order' ) ) {
	if ( ! empty( $_GET['order_field'] ) ) {
		$order_field = $_GET['order_field'];
	}
	if ( ! empty( $_GET['order'] ) ) {
		$order = $_GET['order'];
	}
}

$res = $this->get_photo_contests( $order_field, $order, $limit );

if ( 'id' === $order_field && 'DESC' === $order ) {
	$url_order_id   = add_query_arg( array(
		'order_field' => 'id',
		'order'       => 'ASC',
	), $url );
	$class_order_id = 'desc';
} else {
	$url_order_id   = add_query_arg( array(
		'order_field' => 'id',
		'order'       => 'DESC',
	), $url );
	$class_order_id = 'asc';
}

if ( 'creation_date' === $order_field && 'DESC' === $order ) {
	$url_order_creation_date   = add_query_arg( array(
		'order_field' => 'creation_date',
		'order'       => 'ASC',
	), $url );
	$class_order_creation_date = 'desc';
} else {
	$url_order_creation_date   = add_query_arg( array(
		'order_field' => 'creation_date',
		'order'       => 'DESC',
	), $url );
	$class_order_creation_date = 'asc';
}

if ( 'title' === $order_field && 'DESC' === $order ) {
	$url_order_title   = add_query_arg( array(
		'order_field' => 'title',
		'order'       => 'ASC',
	), $url );
	$class_order_title = 'desc';
} else {
	$url_order_title   = add_query_arg( array(
		'order_field' => 'title',
		'order'       => 'DESC',
	), $url );
	$class_order_title = 'asc';
}

if ( 'active_from' === $order_field && 'DESC' === $order ) {
	$url_order_active_from   = add_query_arg( array(
		'order_field' => 'active_from',
		'order'       => 'ASC',
	), $url );
	$class_order_active_from = 'desc';
} else {
	$url_order_active_from   = add_query_arg( array(
		'order_field' => 'active_from',
		'order'       => 'DESC',
	), $url );
	$class_order_active_from = 'asc';
}

if ( 'active_to' === $order_field && 'DESC' === $order ) {
	$url_order_active_to   = add_query_arg( array(
		'order_field' => 'active_to',
		'order'       => 'ASC',
	), $url );
	$class_order_active_to = 'desc';
} else {
	$url_order_active_to   = add_query_arg( array(
		'order_field' => 'active_to',
		'order'       => 'DESC',
	), $url );
	$class_order_active_to = 'asc';
}
?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Photo Contests', 'cl-photo-contest' ); ?></h1>
	<a href="<?php echo admin_url( 'admin.php?page=cl-photo-contest-new' ); // WPCS: XSS ok. ?>" class="page-title-action"><?php esc_html_e( 'Add new', 'cl-photo-contest' ); ?></a>
	<hr class="wp-header-end">

	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<th scope="col" id="id" class="manage-column column-rating sortable <?php echo esc_attr( $class_order_id ); ?>">
					<a href="<?php echo $url_order_id; // WPCS: XSS ok. ?>"><span><?php esc_html_e( 'Id', 'cl-photo-contest' ); ?></span>
					<span class="sorting-indicator"></span></a>
				</th>
				<th scope="col" id="id" class="manage-column column-rating">
					<?php esc_html_e( 'State', 'cl-photo-contest' ); ?>
				</th>
				<th scope="col" id="id" class="manage-column column-title">
					<?php esc_html_e( 'Shortcode', 'cl-photo-contest' ); ?>
				</th>
				<th scope="col" id="created" class="manage-column column-date sortable <?php echo esc_attr( $class_order_creation_date ); ?>">
					<a href="<?php echo $url_order_creation_date; // WPCS: XSS ok. ?>"><span><?php esc_html_e( 'Creation date', 'cl-photo-contest' ); ?></span>
					<span class="sorting-indicator"></span></a>
				</th>
				<th scope="col" id="title" class="manage-column column-title sortable <?php echo esc_attr( $class_order_title ); ?>">
					<a href="<?php echo $url_order_title; // WPCS: XSS ok. ?>"><span><?php esc_html_e( 'Title', 'cl-photo-contest' ); ?></span>
					<span class="sorting-indicator"></span></a>
				</th>
				<th scope="col" id="date_from" class="manage-column column-date sortable <?php echo esc_attr( $class_order_active_from ); ?>">
					<a href="<?php echo $url_order_active_from; // WPCS: XSS ok. ?>"><span><?php esc_html_e( 'Active from', 'cl-photo-contest' ); ?></span>
					<span class="sorting-indicator"></span></a>
				</th>
				<th scope="col" id="date_to" class="manage-column column-date sortable <?php echo esc_attr( $class_order_active_to ); ?>">
					<a href="<?php echo $url_order_active_to; // WPCS: XSS ok. ?>"><span><?php esc_html_e( 'Active to', 'cl-photo-contest' ); ?></span>
					<span class="sorting-indicator"></span></a>
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		<?php
		foreach ( $res as $contest ) :
			if ( $now >= strtotime( $contest->active_from ) && $now <= strtotime( $contest->active_to ) ) {
				$state     = __( 'Active', 'cl-photo-contest' );
				$state_css = 'cl-contest-state-active';
			} elseif ( $now > strtotime( $contest->active_to ) ) {
				$state     = __( 'Ended', 'cl-photo-contest' );
				$state_css = 'cl-contest-state-ended';
			} elseif ( $now < strtotime( $contest->active_from ) ) {
				$state     = __( 'Programmed', 'cl-photo-contest' );
				$state_css = 'cl-contest-state-programmed';
			}
		?>
			<tr id="contest-<?php echo $contest->id; // WPCS: XSS ok. ?>" class="iedit author-self level-0 post-13554 type-post status-publish format-standard has-post-thumbnail hentry category-noticias-eventos tag-lavazza tag-notas-de-prensa" data-id="13554">
				<td><?php echo $contest->id; // WPCS: XSS ok. ?></td>
				<td><span class="<?php echo esc_attr( $state_css ); ?>"><?php echo $state; // WPCS: XSS ok. ?></span></td>
				<td><em>[cl-photo-contest id="<?php echo $contest->id; // WPCS: XSS ok. ?>"]</em></td>
				<td><?php echo date_i18n( $wp_date_format, strtotime( $contest->creation_date ) ); // WPCS: XSS ok. ?></td>
				<td><strong><?php echo $contest->title; // WPCS: XSS ok. ?></strong></td>
				<td><?php echo date_i18n( $wp_date_format, strtotime( $contest->active_from ) ); // WPCS: XSS ok. ?></td>
				<td><?php echo date_i18n( $wp_date_format, strtotime( $contest->active_to ) ); // WPCS: XSS ok. ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
