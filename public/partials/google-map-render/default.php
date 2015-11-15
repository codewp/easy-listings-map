<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var ELM_Public_Google_Map_Render $controller
 * @var string 						 $content
 * @var string 						 $map_id
 * @var int    						 $height
 * @var array  						 $map_types
 * @var int    						 $zoom
 * @var string 						 $js_url
 * @var string 						 $css_url
 * @var string 						 $images_url
 * @var int    						 $cluster_size
 * @var string 						 $default_latitude
 * @var string 						 $default_longitude
 * @var int    						 $auto_zoom
 */

// Registering scripts and styles for Google Maps.
$controller->register_scripts();

if ( strlen( $content ) ) {
	echo '<h2 class="elm listing-map-title">' . esc_html( $content ) . '</h2>';
}
?>
<div class="shortcode map_container" style="height: <?php echo absint( $height ) ? absint( $height ) : '500' ?>px;">
	<div class="elm google-maps" id="<?php echo esc_attr( $map_id ) ?>"
	style="height: <?php echo absint( $height ) ? absint( $height ) : '500' ?>px; padding: 0px; margin: 0px;"></div>
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
