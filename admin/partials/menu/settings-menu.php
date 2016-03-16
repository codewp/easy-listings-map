<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var array $view_args[
 *      @type array tabs
 * ]
 */

$subscribed = get_option( '_elm_subscribe', false );
$active_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $view_args['tabs'] ) ? $_GET['tab'] : 'general';
?>
<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<?php
		foreach ( $view_args['tabs'] as $tab_id => $tab_name ) {
			$tab_url = esc_url_raw( add_query_arg( array(
				'settings-updated' => false,
				'tab'              => $tab_id,
			) ) );

			$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

			echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">' .
					esc_html( $tab_name ) . '</a>';
		}
		?>
	</h2>
	<?php
	if ( ! $subscribed ) {
		?>
		<div class="subscribe-container">
			<p id="subscribe-info"><strong><?php _e( sprintf( 'Subscribe to our list to get %s of Easy Listings Map and news about it.', '<span>updated documentation</span>' ), 'elm' ); ?></strong></p>
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
		</div>
		<?php
	}
	?>
	<div id="tab-container">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'elm_settings' );
			do_settings_sections( 'elm_settings_' . $active_tab );

			submit_button();
			?>
		</form>
	</div>
</div>
