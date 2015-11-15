<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The controller class for rendering Google Maps.
 *
 * @since      1.2.0
 * @package    Easy_Listings_Map
 * @subpackage Easy_Listings_Map/public
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELM_Public_Google_Map_Render extends ELM_Public_Controller {

	/**
	 * Properties of the class.
	 *
	 * @since 1.2.0
	 * @var   array
	 */
	private $data = array(
		'listings'          => null,
		'markers'           => '',
		'map_id'            => '',
		'output_map_div'    => true,
		'content'           => '',
		'map_style_height'  => 500,
		'default_latitude'  => '39.911607',
		'default_longitude' => '-100.853613',
		'zoom'              => 1,
		'zoom_events'       => 0,
		'cluster_size'      => -1,
		'map_types'         => array( 'ROADMAP' ),
		'auto_zoom'         => 1,
		'clustering'        => true,
	);

	/**
	 * Object of ELM_Properties class.
	 *
	 * @since 1.2.0
	 * @var   ELM_Properties
	 */
	private $elm_properties;

	/**
	 * Constructor.
	 *
	 * @since 1.2.0
	 * @param array               $data
	 * @param ELM_Properties|null $elm_properties
	 */
	public function __construct( array $data = array(), ELM_Properties $elm_properties = null ) {
		$this->elm_properties = null === $elm_properties ? ELM_IOC::make( 'properties' ) : $elm_properties;
		if ( count( $data ) ) {
			foreach ( $data as $key => $value ) {
				if ( array_key_exists( $key, $this->data ) ) {
					$this->data[ $key ] = $value;
				}
			}
		}
		if ( ! strlen( trim( $this->data['map_id'] ) ) ) {
			$this->data['map_id'] = 'elm_google_maps_' . current_time( 'timestamp' );
		}
	}

	/**
	 * Creating a map based on listings property of the object.
	 *
	 * @since  1.2.0
	 * @return void
	 */
	public function create_map() {
		$markers = array();
		if ( $this->data['listings'] instanceof WP_Query ) {
			if ( $this->data['listings']->have_posts() ) {
				while ( $this->data['listings']->have_posts() ) {
					$this->data['listings']->the_post();
					// Adding property marker with it's information to markers array.
					$this->set_property_marker( $markers );
				}
				wp_reset_postdata();
			}
		}
		$this->draw_map( $markers );
	}

	/**
	 * Drawing a map in front-end based on markers sent to it.
	 *
	 * @since   1.2.0
	 * @param   array 	$markers
	 * @return  string
	 */
	public function draw_map( array $markers ) {
		// Merging markers that are in same coordinates.
		$markers               = $this->merge_markers( $markers );
		// Adding markers to properties of the class.
		$this->data['markers'] = json_encode( $markers );
		$data                  = array(
			'controller'        => $this,
			'content'           => trim( $this->data['content'] ),
			'map_id'            => $this->data['map_id'],
			'map_types'         => $this->data['map_types'],
			'zoom'              => (int) $this->data['zoom'],
			'zoom_events'       => absint( $this->data['zoom_events'] ),
			'height'            => $this->data['map_style_height'],
			'js_url'            => $this->get_js_url(),
			'css_url'           => $this->get_css_url(),
			'images_url'        => $this->get_images_url(),
			'cluster_size'      => (int) $this->data['cluster_size'],
			'default_latitude'  => $this->data['default_latitude'],
			'default_longitude' => $this->data['default_longitude'],
			'auto_zoom'         => $this->data['auto_zoom'],
			'markers'           => $this->data['markers'],
		);
		/*
		 * if $output_map_div == 0 don't output map div. In other words developer wants
		 * to output map to else where by specifying map output_div and it's id.
		 */
		if ( $this->data['output_map_div'] ) {
			$this->render_view( 'google-map-render.default', $data );
		} else {
			$this->render_view( 'google-map-render.scripts', $data );
		}
	}

	/**
	 * Merging markers if they are in same coordinates.
	 *
	 * @since   1.2.0
	 * @param   array $markers
	 * @return  array
	 */
	public function merge_markers( array $markers ) {
		$merged_markers = array();
		if ( count( $markers ) ) {
			// Getting multiple marker icon.
			$elm_settings = ELM_IOC::make( 'settings' )->get_settings();
			$multiple_marker = ! empty( $elm_settings['map_multiple_marker'] ) ? trim( $elm_settings['map_multiple_marker'] ) :
				ELM_IOC::make( 'asset_manager' )->get_admin_images() . 'markers/multiple.png';

			for ( $i = 0; $i < count( $markers ); $i++ ) {
				// Did merged current marker already so don't use it again.
				if ( isset( $markers[ $i ]['merged'] ) ) {
					continue;
				}
				$merged_marker = array(
					'listing_id'  => array( $markers[ $i ]['listing_id'] ),
					'latitude'    => $markers[ $i ]['latitude'],
					'longitude'   => $markers[ $i ]['longitude'],
					'marker_icon' => $markers[ $i ]['marker_icon'],
					'info'        => array(
						$markers[ $i ],
					),
				);

				for ( $j = 0; $j < count( $markers ); $j++ ) {
					if ( $i == $j ) {
						continue;
					}
					if ( $markers[ $i ]['latitude'] == $markers[ $j ]['latitude'] && $markers[ $i ]['longitude'] == $markers[ $j ]['longitude'] ) {
						// Merging details of markers that are in same coordinates.
						$merged_marker['info'][] = $markers[ $j ];
						// Adding listing id to merged marker.
						$merged_marker['listing_id'][] = $markers[ $j ]['listing_id'];
						// Setting marker icon to multiple property icon.
						$merged_marker['marker_icon'] = esc_url( $multiple_marker );
						// Marker that is in position j are merged so don't use it again.
						$markers[ $j ]['merged'] = true;
					}
				}
				$merged_markers[] = $merged_marker;
			}
		}
		return $merged_markers;
	}

	/**
	 * Adding property coordinates ( latitude and longitude ) and other information about property to markers.
	 *
	 * @since   1.2.0
	 * @param   array $markers
	 */
	public function set_property_marker( array & $markers, $listing = null ) {
		$listing_id = absint( $listing );
		if ( null === $listing ) {
			$listing_id = get_the_ID();
		} else if ( $listing instanceof WP_Post ) {
			$listing_id = $listing->ID;
		}
		$property_coordinates = $this->elm_properties->get_property_coordinates( $listing_id );
		if ( count( $property_coordinates ) ) {
			// Getting extra info about property, like it's image and etc.
			$image_url = '<img src="' . $this->get_images_url() .
				'map/default-infowindow-image.png" style="width: 300px; height: 200px;" class="elm-infobubble-image" alt="' . trim( get_the_title() ) . '" />';
			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail( get_the_ID(), 'epl-image-medium-crop', array( 'class' => 'elm-infobubble-image' ) );
			}

			/**
			 * Setting property marker icon.
			 * Using marker that set in settings or use default marker for it.
			 */
			$property_status = get_post_meta( get_the_ID(), 'property_status', true );
			$marker_icon     = $this->elm_properties->get_property_marker( get_post_type(), $property_status );

			$markers[] = array(
				'listing_id'	  => get_the_ID(),
				'latitude'        => $property_coordinates['latitude'],
				'longitude'       => $property_coordinates['longitude'],
				'image_url'       => $image_url,
				'url'             => esc_url( get_permalink() ),
				'title'           => wp_trim_words( get_the_title(), 6 ),
				'tab_title'		  => wp_trim_words( get_the_title(), 2 ),
				'icons'           => $this->elm_properties->get_property_icons(),
				// 'price'           => epl_get_property_price(),
				'marker_icon'     => esc_url( $marker_icon ),
				'property_status' => $property_status,
				'property_type'   => get_post_type(),
			);
		}
	}

	/**
	 * Registering scripts ans styles of Google Maps.
	 *
	 * @since  1.2.0
	 * @return void
	 */
	public function register_scripts() {
		// Registering scripts.
		$protocol   = is_ssl() ? 'https' : 'http';
		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix     = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$js_url     = $this->get_js_url();
		$css_url    = $this->get_css_url();
		$images_url = $this->get_images_url();
		wp_enqueue_script( 'google-map-v-3', $protocol . '://maps.googleapis.com/maps/api/js?v=3.exp' );
		wp_enqueue_script( 'google-maps-clusters', $js_url . 'maps/markerclusterer' . $suffix . '.js',
			array(), false, true );
		wp_enqueue_script( 'google-maps-infobubble', $js_url . 'maps/infobubble' . $suffix . '.js',
			array(), false, true );
		wp_enqueue_script( 'elm_google_maps', $js_url . 'maps/elm-google-maps' . $suffix . '.js',
			array( 'jquery', 'google-map-v-3', 'google-maps-clusters', 'google-maps-infobubble' ), false, true );
		$elm_google_maps = array(
			'nonce'             => wp_create_nonce( 'elm_bound_markers' ),
			'markers'			=> $this->data['markers'],
			'default_latitude'  => $this->data['default_latitude'],
			'default_longitude' => $this->data['default_longitude'],
			'auto_zoom'         => $this->data['auto_zoom'],
			'map_id'            => $this->data['map_id'],
			'map_types'         => $this->data['map_types'],
			'zoom'              => (int) $this->data['zoom'],
			'zoom_events'		=> absint( $this->data['zoom_events'] ),
			'cluster_size'      => (int) $this->data['cluster_size'],
			'info_window_close' => $images_url . 'map/info-window-close-button.png',
			'cluster_style'     => array(
				(object) array(
					'url'       => $images_url . 'map/m1.png',
					'height'    => 53,
					'width'     => 53,
				),
				(object) array(
					'url'       => $images_url . 'map/m2.png',
					'height'    => 56,
					'width'     => 56,
				),
				(object) array(
					'url'       => $images_url . 'map/m3.png',
					'height'    => 66,
					'width'     => 66,
				),
				(object) array(
					'url'       => $images_url . 'map/m4.png',
					'height'    => 78,
					'width'     => 78,
				),
				(object) array(
					'url'       => $images_url . 'map/m5.png',
					'height'    => 90,
					'width'     => 90,
				),
			),
		);
		wp_localize_script( 'elm_google_maps', 'elm_google_maps', $elm_google_maps );
		// Registering styles.
		wp_enqueue_style( 'elm-google-maps', $css_url . 'elm-google-maps' . $suffix . '.css' );
	}

}
