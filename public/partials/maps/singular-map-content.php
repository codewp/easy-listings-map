<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var int $map_height
 * @var string $map_id
 */
?>
<div class="map_container" style="height: <?php echo absint( $map_height ) ? absint( $map_height ) : '500' ?>px;">
	<div class="elm google-maps" id="<?php echo esc_attr( $map_id ) ?>" style="height: <?php echo absint( $map_height ) ? absint( $map_height ) : '500' ?>px; padding: 0px; margin: 0px;"></div>
	<div id="gmap-loading">
		<?php _e( 'Loading Map', 'elm' ); ?>
  		<div class="spinner map_loader" id="listing_loader_maps">
     		<div class="rect1"></div>
     		<div class="rect2"></div>
     		<div class="rect3"></div>
     		<div class="rect4"></div>
     		<div class="rect5"></div>
 		</div>
	</div>
</div>
