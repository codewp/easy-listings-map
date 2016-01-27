<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$subscribed = get_option( '_elm_subscribe', false );

if ( ! $subscribed ) {
	?>
	<p class="about-description"><?php _e( 'You can download Easy Listings Map documentation to getting started by subscribing to Easy Listings Map news from below form.', 'elm' ); ?></p>
	<div class="subscribe-form">
		<div id="subscribe-message" class="message" style="display: none;"></div>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><strong><?php _e( 'Name', 'elm' ) ?></strong></th>
					<td><input type="text" class="popup-input" name="name" placeholder="<?php _e( 'Name', 'elm' ) ?>" id="name"></td>
				</tr>
				<tr>
					<th scope="row"><strong><?php _e( 'Email', 'elm' ) ?></strong></th>
					<td><input type="email" class="popup-input" name="email" placeholder="<?php _e( 'Email', 'elm' ) ?>" id="email"></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<button id="subscribe" class="button button-primary"><?php _e( 'Subscribe', 'elm' ) ?></button>
		</p>
	</div>
	<?php
} else {
	echo '<p class="about-description">' . __( sprintf( 'Download Easy Listings Map documentation from <a href="%s">here</a> to getting started.', 'https://www.dropbox.com/s/iuq50ftxk41wu3m/easy-listings-map.pdf?dl=1' ), 'elm' ) . '</p>';
}
