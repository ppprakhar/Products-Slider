<?php
/**
 * Settings class
 */
class Product_Slider_Settings {

	/**
	 * Settings key/identifier
	 */
	const KEY = 'products-slider';

	/**
	 * Plugin settings
	 * @var array
	 */
	public static $options = array();

	/**
	 * Public constructor
	 *
	 * @return \Mentionable_Settings
	 */
	public function __construct() {
		// Register settings page
		add_action( 'admin_menu', array( $this, 'register_menu' ) );

		// Register settings, and fields
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		$defaults = array(
			'post_types'              => array( 'post' ),
			'autocomplete_post_types' => array( 'post' ),
			'load_template'           => false,
		);

		self::$options = apply_filters(
			self::KEY.'_options',
			wp_parse_args(
				(array) get_option( self::KEY, array() ),
				$defaults
			)
		);
	}

	/**
	 * Register menu page
	 *
	 * @action admin_menu
	 * @return void
	 */
	public function register_menu() {
		if ( current_user_can( 'manage_options' ) ) {
			add_options_page(
				__( 'Product Slider', self::KEY ),
				__( 'Product Slider', self::KEY ),
				'manage_options',
				self::KEY,
				array( $this, 'settings_page' )
			);
		}
	}

	/**
	 * Render settings page
	 * @return void
	 */
	public function settings_page() {
		?>
		<div class="wrap">
			<?php screen_icon( 'tools' ); ?>
			<h2><?php _e( 'Product Slider Options', self::KEY ) ?></h2>

			<form method="post" action="options.php">
				<?php
				settings_fields( self::KEY );
				do_settings_sections( self::KEY );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Registers settings fields and sections
	 * @return void
	 */
	public function register_settings() {	
		//register_setting( self::KEY, self::KEY );

		add_settings_section(
			'post_types',
			__( 'Post Types', self::KEY ),
			'__return_false',
			self::KEY
		);

		add_settings_field(
			'post_types',
			__( 'Post Types', self::KEY ),
			array( $this, 'output_field_post_types' ),
			self::KEY,
			'post_types',
			array(
				'key' => 'post_types',
				'description' => __( 'Select a Post Type from above field.', self::KEY ),
			)
		);

		add_settings_section(
			'post_categories',
			__( 'Related Categories', self::KEY ),
			'__return_false',
			self::KEY
		);

		add_settings_field(
			'post_categories',
			__( 'Post Types', self::KEY ),
			array( $this, 'output_field_categories' ),
			self::KEY,
			'post_categories',
			array(
				'key' => 'post_categories',
				'description' => __( 'Select a Category from above field.', self::KEY ),
			)
		);

	}

	/**
	 * Render Callback for post_types field
	 *
	 * @param $args
	 *
	 * @return void
	 */
	public function output_field_post_types( $args ) {
		global $wp_post_types;
		$posts_slug = array_keys($wp_post_types);
		$posts_name = wp_list_pluck($wp_post_types, 'label');
		$types = array_combine( $posts_slug, $posts_name );
		$types = array_diff_key( $types, array_flip( array( 'nav_menu_item', 'revision', 'attachment', 'page' ) ) );
		$value = self::$options[ $args['key'] ];		

		$output = sprintf( '<select name="%s" >', esc_attr( $args['key'] ) );
		$output .= sprintf( '<option value="" >--Post Types--</option>' );
		foreach ( $types as $slug => $name ) {
			$output .= sprintf( '<option value="%1$s" %3$s>%2$s</option>', $slug, $name, selected( in_array( $slug, $name ), true, false ) );
		}
		$output .= '</select>';

		$output .= sprintf(
			'<p class="description">%s</p>',
			$args[ 'description' ]
		);

		echo balanceTags( $output );
	}

	/**
	*
	*@param $args
	*
	*@return void
	*/
	public function output_field_categories( $args ){
		$output = sprintf( '<select name="%s" multiple >', esc_attr( $args['key'] ) );
		$output .= sprintf( '<option value="" >--Categories--</option>' );
		/*foreach ( $types as $slug => $name ) {
			$output .= sprintf( '<option value="%1$s" %3$s>%2$s</option>', $slug, $name, selected( in_array( $slug, $name ), true, false ) );
		}*/
		$output .= '</select>';

		$output .= sprintf(
			'<p class="description">%s</p>',
			$args[ 'description' ]
		);

		echo balanceTags( $output );
	}
}
