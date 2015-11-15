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
