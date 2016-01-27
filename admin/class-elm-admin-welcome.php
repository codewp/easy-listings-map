<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Welcome controller of the plugin.
 *
 * @package    Easy_Listings_Map
 * @subpackage Easy_Listings_Map/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */
class ELM_Admin_Welcome extends ELM_Admin_Controller {

	/**
	 * Version of the plugin.
	 *
	 * @since 1.2.1
	 * @var   string
	 */
	private $plugin_version;

	/**
	 * @since 1.2.1
	 * @var   string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Constructor.
	 *
	 * @since 1.2.1
	 * @param Easy_Listings_Map_Loader $loader
	 */
	public function __construct( Easy_Listings_Map_Loader $loader, $plugin_version ) {
		$this->plugin_version = $plugin_version;
		$loader->add_action( 'admin_menu', $this, 'admin_menus' );
		$loader->add_action( 'admin_init', $this, 'welcome' );
		$loader->add_action( 'wp_ajax_send_subscribe_email', $this, 'send_subscribe_email' );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @since  1.2.1
	 * @return void
	 */
	public function admin_menus() {
		// Getting started page.
		add_dashboard_page(
			__( 'Getting started', 'elm' ),
			__( 'Getting started', 'elm' ),
			$this->minimum_capability,
			'elm-getting-started',
			array( $this, 'getting_started_screen' )
		);
	}

	/**
	 * Tabs of the welcome.
	 *
	 * @since  1.2.1
	 * @return void
	 */
	private function tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'elm-getting-started';
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'elm-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'elm-getting-started' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Getting Started', 'elm' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Send subscription email.
	 *
	 * @since  1.2.1
	 * @return void
	 */
	public function send_subscribe_email() {
		if ( isset( $_POST['subscribe_nonce'] ) && wp_verify_nonce( $_POST['subscribe_nonce'], 'elm_subscribe_email_send' ) ) {
			if ( isset( $_POST['email'] ) && is_email( $_POST['email'] ) &&
				isset( $_POST['name'] ) && strlen( trim( $_POST['name'] ) ) ) {
				$response = wp_remote_post( 'https://fast-hollows-4459.herokuapp.com/send',
					array(
						'method'      => 'POST',
						'timeout'     => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => array(),
						'body'        => array( 'name' => trim( $_POST['name'] ), 'email' => $_POST['email'], 'plugin' => 'easy-listings-map' ),
						'cookies'     => array()
					)
				);
				if ( is_wp_error( $response ) ) {
					die( json_encode( array( 'success' => '0', 'message' => __( 'Some error occurred in subscription.', 'elm' ) ) ) );
				} else {
					// Setting subscription to true in order to doesn't show subscribe popup again.
					update_option( '_elm_subscribe', true );
					die( json_encode( array( 'success' => '1', 'message' => __( 'Thank you for subscribing to Easy Listings Map, please check your inbox to download new documentation of Easy Listings Map.', 'elm' ) ) ) );
				}
			} else {
				die( json_encode( array( 'success' => '0', 'message' => __( 'Please validate entered name and email address.', 'elm' ) ) ) );
			}
		}
	}

	/**
	 * Renders getting started screen.
	 *
	 * @since  1.2.1
	 * @return void
	 */
	public function getting_started_screen() {
		echo '<div class="wrap about-wrap">';
		$this->render_view(
			'welcome.easy-listings-map',
			array( 'plugin_version' => $this->plugin_version )
		);
		$this->tabs();
		$this->render_view( 'welcome.getting-started' );
		echo '</div>';
	}

	/**
	 * Sends user to the Welcome page on first activation of ELM as well as each
	 * time ELM is upgraded to a new version
	 *
	 * @since  1.2.1
	 * @return void
	 */
	public function welcome() {
		// Bail if no activation redirect
		if ( ! get_transient( '_elm_activation_redirect' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_elm_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// First time install
		wp_safe_redirect( admin_url( 'index.php?page=elm-getting-started' ) );

		exit();
	}

}
