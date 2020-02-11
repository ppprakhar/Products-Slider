<?php
/*
Plugin Name: Products Slider
*/

/**
* Item Slider with woocommerce
*/
error_reporting( E_ALL );
//error_reporting( 0 );

if (!class_exists('Wp_Wc_Products_Slider')){
	class Wp_Wc_Products_Slider {

		public $settings;
		public $ajax;
		
		function __construct() {
			// Set constans needed by the plugin.
			add_action( 'plugins_loaded', array( $this, 'define_constants' ), 1 );

			//add script and style in frontend
			add_action('wp_enqueue_scripts', array($this, 'frontend_scripts') );

			//add script and style in frontend
			add_action('admin_enqueue_scripts', array($this, 'backend_scripts') );

			// register shortcode
			add_shortcode( 'products-slider', array($this, 'show_shortcode') );

			// Setup all dependent class
			add_action( 'after_setup_theme', array( $this, 'setup' ), 4 );
		}

		/**
		 * Define constants used by the plugin.
		 *
		 * @access public
		 * @action plugins_loaded
		 * @return void
		*/
		public function define_constants() {
			// Set constant path to the plugin directory.
			define( 'PRODUCTS_SLIDER_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			// Set constant path to the includes directory.
			define( 'PRODUCTS_SLIDER_INCLUDES_DIR', PRODUCTS_SLIDER_DIR . trailingslashit( 'includes' ) );

			// Plugin url
			$plugin_dirname = basename( dirname( __FILE__ ) );
			define( 'PRODUCTS_SLIDER_URL', trailingslashit( plugin_dir_url( '' ) ) . $plugin_dirname );
		}

		/**
		* Setup all classes needed for the plugin
		*
		* @access public
		* @action plugins_loaded
		* @return void
		*/
		public function setup(){
			// Register settings
			require_once( PRODUCTS_SLIDER_INCLUDES_DIR . '/products-slider-settings.php' );
			$this->settings = new Product_Slider_Settings;

			require_once( PRODUCTS_SLIDER_INCLUDES_DIR . '/products-slider-ajax.php' );
			//$this->ajax = new ps_ajax;
		}

		/*
		*  register scritps and style files for frontend
		*/
		public function frontend_scripts(){
			wp_enqueue_script('item-slider-js', PRODUCTS_SLIDER_URL.'/js/modernizr.custom.63321.js', array('jquery') );
			wp_enqueue_script('item-slider-cat-js', PRODUCTS_SLIDER_URL.'/js/jquery.catslider.js', array('jquery') );
			wp_enqueue_style('item-slider-css', PRODUCTS_SLIDER_URL.'/css/style.css');
		}

		/*
		*  register scritps and style files for backend
		*/
		public function backend_scripts(){
			wp_enqueue_script('ps-backend-js', PRODUCTS_SLIDER_URL.'/js/products-slider.js', array('jquery'), true, false);
			wp_localize_script(
				'jquery',
				'products_slider',
				array(
					'action' => 'get_posts_type'
				)
			);
		}

		/*
		* generates shortcode for showing slider
		*/
		public function show_shortcode($atts){
			ob_start();

			$atts = shortcode_atts( array(
				'id' => array(),
				'post_type' => array('post'),
				'categories' => array(),
				'posts_per_page'   => 5,
				'slides' => 4,
				'order' => 'asc'
		    ), $atts );

		    extract($atts);

		    if ( $post_type == 'product'){
				if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
					require_once( PRODUCTS_SLIDER_INCLUDES_DIR.'/wc-products.php' );
					return ;
				}else{
					return '<h4>Please, Activate/Install Woocommerce Plugin</h4>';
				}
				
		    }else{
		    	require_once( PRODUCTS_SLIDER_INCLUDES_DIR.'/post-products.php' );
		    	return ob_get_clean();
		    }
			
		}
	}

	$itemSlider = new Wp_Wc_Products_Slider();

}



