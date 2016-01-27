<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var  array $view_args[
 *       @type string plugin_version
 * ]
 */
?>
<h1>
	<?php printf( __( 'Welcome to Easy Listings Map %s', 'elm' ), $view_args['plugin_version'] ) ?>
</h1>
<div class="about-text">
	<?php printf( __( 'Thank you for updating to the latest version! Easy Listings Map %s is ready to make beautiful maps for your real estate website!', 'elm' ), $view_args['plugin_version'] ) ?>
</div>
