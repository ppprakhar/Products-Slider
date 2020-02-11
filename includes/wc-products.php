<header class="clearfix">
	<h1>Creative Multi-Products Slider <!-- <span>Category slider with CSS animations</span> --></h1>
</header>

<?php
	/*$args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_date',//for random- 'rand'
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => $post,
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
	);*/

 	/*$taxonomy_objects = get_object_taxonomies( 'post' );
   echo '<pre>'; print_r( $taxonomy_objects); echo '</pre>';*/

$cats_name = array();
	if( empty($categories) ){
		$categories = get_categories(
			$args = array(
	  			'taxonomy' => 'product_cat'
	  		)
		);
		//echo '<pre>'; var_dump( $categories); echo '</pre>';
		foreach ($categories as $cat) {
			$cats_name[] = $cat->name;
			//echo '<pre>'; var_dump( $cats_name); echo '</pre>';
		}			
	}else{
		$cats_name = explode(',', $categories);
		//echo "<pre>"; var_dump($cats_name); echo "</pre>";
	} //unset($cats_name); //echo "<pre>"; var_dump($cats_name); echo "</pre>";


	if( empty($cats_name)) $slides = $slides;
	else $slides = count($cats_name);

?>	
<div class="main">
	<div id="mi-slider" class="mi-slider">

	<?php for ($i=0; $i < $slides ; $i++) : ?>
		<?php $cat_name = $cats_name[$i];  ?>
		<?php
			$args = array(
				'posts_per_page' => 4,
				'post_type' => $post_type,
				'product_cat' => $cat_name,
				'orderby' => 'post_date',
				'order' => $order,
				'meta_key' => '_featured',  
    			'meta_value' => 'yes', 
				);
			
			$posts = new WP_Query( $args );
			//var_dump( $post );
		?>
		<ul>
		<?php  while ( $posts->have_posts() ) : $posts->the_post(); ?>	
			<li class="post post_<?php the_ID(); ?>">
			<?php //var_dump( get_product( $posts->post->ID ) ); ?>
				<a href="<?php the_permalink(); ?>"> 
					<?php do_action( 'woocommerce_before_shop_loop_item_title' );//the_post_thumbnail(); ?>
					<h4><?php the_title(); ?></h4>
					<h3>
					<?php 
						$product = new WC_Product( get_the_ID() );
						//var_dump($product);
						//echo $price = $product->price; 
						do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
					</h3>
				</a>
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			</li>	
			<?php endwhile; ?>
		</ul>
	<?php endfor; ?>

	<nav>
		<?php  for ($i=0; $i < $slides ; $i++) : ?>
			<a href="#"><?php echo $cats_name[$i]; ?></a>
		<?php endfor; ?>
	</nav>
	
	</div>
</div>
	<script>
		(jQuery)(function($) {
			$( '#mi-slider' ).catslider();
		});
	</script>
