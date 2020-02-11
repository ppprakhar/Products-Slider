<?php
/**
 * Handle the ajax call
 */

class Products_Slider_Ajax {

	/**
	 * Class constructor
	 *
	 * @return \Product_Slider_Ajax
	 */
	public function __construct(){
		add_action( 'wp_ajax_get_posts_type', array( $this, 'handle_ajax' ) );
		add_action( 'wp_ajax_nopriv_get_posts_type', array( $this, 'handle_ajax' ) );
	}

	/**
	 * Handle the aucomplete ajax request
	 *
	 * @return json
	 */
	public function handle_ajax() {
		$post_type = $_POST['post_type'];
		$cats_name = array();

		if( $post_type == 'post'){
			$cat = 'category';
		}
		if( $post_type == 'product'){
			$cat = 'product_cat';
		}

		$categories = get_categories(
		   	$args = array(
	  			'taxonomy' => $cat
	  			)
		   	);

		foreach ($categories as $cat) {
			$cats_name[] = $cat->name;	
		}

		if ( empty( $cats_name ) ) {
			wp_send_json_error( 'No results' );
		} else {
			wp_send_json_success( $cats_name );
		}

	}

}
