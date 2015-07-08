<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var string $content
 * @var string $id
 * @var int $height
 * @var int $width
 */

if ( strlen( $content ) ) {
	echo '<h2 class="elm listing-map-title">' . esc_html( $content ) . '</h2>';
}
?>
<div class="shortcode map_container" style="height: <?php echo absint( $height ) ? absint( $height ) : '500' ?>px; width: <?php echo absint( $width ) ? absint( $width ) : '600' ?>px;">
	<div class="elm google-maps" id="<?php echo esc_attr( $id ) ?>"
	style="width: 100%; height: 100%; padding: 0px; margin: 0px;"></div>
</div>
