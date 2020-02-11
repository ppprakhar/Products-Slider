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
	  			'taxonomy' => 'category'
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
				'category_name' => $cat_name,
				'orderby' => 'post_date',
				'order' => $order
				);
			
			$posts = new WP_Query( $args );
			//var_dump( $post );
		?>
		<ul>
		<?php  while ( $posts->have_posts() ) : $posts->the_post(); ?>	
			<li>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail(); ?>
					<h4><?php the_title(); ?></h4>
				</a>
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
