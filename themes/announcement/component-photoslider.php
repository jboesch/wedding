<?php
/**
 * Component: Photograph Slider
 *
 * A full-width photograph slider, using the "slide" custom post type.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'photograph-slider';
 
 $settings = array(
 	'slides' => array(), 
 	'start_slide' => 1, 
 	'visibleentries' => 1, 
 	'limit' => -1, // To return all slides, set this to -1.
 	'slide-category' => 'all', 
 	'auto' => 'false', 
 	'interval' => 4, 
 	'speed' => '0.6', 
 	'scrolling' => 'circular'
 );
 
 /* Setup for use with woo_image(). */
 $image_args = array(
 					'width' => 350, 
 					'height' => 350
 					);
 
 /* Setup dynamic variables. */
 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_slider_' . $o] ) && $woo_options['woo_slider_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_slider_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $image_args = woo_get_slide_dimensions( $settings['visibleentries'] );
 $image_args['link'] = 'img';
 $image_args['return'] = 'true';

 /* The Query. */
 $query_args = array(
 					'post_type' => 'slide', 
 					'post_status' => 'publish', 
 					'posts_per_page' => $settings['limit'], 
 					'orderby' => 'menu_order', 
 					'order' => 'ASC'
 					);
 
 if ( $settings['slide-category'] != 'all' ) {
	
		$query_args['tax_query'] = array( array(
							'taxonomy' => 'slide-category',
							'field' => 'id',
							'terms' => $settings['slide-category']
						) );
	
 }
 
 query_posts( $query_args );
 
 /* Reorder the posts to make sure they display with the first one in the middle. Also, make sure we have images for each slide. */
 if ( have_posts() ) { $count = 0;
 	while( have_posts() ) { the_post(); $count++;
		
 		$id = $post->ID;

 		if ( woo_image( 'return=true' ) != '' || ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $id ) ) ) {
			$settings['slides'][] = $post;
 		}
 		
 	} // End WHILE Loop

	if ( count( $settings['slides'] ) > 1 ) {
	 	
	 	$settings['start_slide'] = floor( ( count( $settings['slides'] ) ) / 2 );
	
		/* Take the first X slides after the start slide and move them to the front. */
		$slides_to_move = array_slice( $settings['slides'], $settings['start_slide'] + 1, count( $settings['slides'] ) );
		
		$iterate = count( $slides_to_move );
		
		$popped_slides = array();
		
		while( ( $iterate-- ) != false ) {
		    $popped_slides[] = array_pop( $settings['slides'] );
		}
		
		/* Add our slides to the beginning. */
		if ( is_array( $popped_slides ) && count( $popped_slides ) > 0 ) {
			foreach ( $popped_slides as $s ) {
				array_unshift( $settings['slides'], $s );
			}
		}
 	
 	}
 	
 } // End IF Statement
 
 /* The Variables. */
 $delimiter = '?';
 if ( get_option( 'permalink_structure' ) == '' ) { $delimiter = '&'; }
 
 $css_class = '';
 
 if ( $settings['auto'] == 'true' ) { $css_class .= ' auto-start'; }
 
 /* The Loop. */
 if ( count( $settings['slides'] ) > 0 ) { $count = 0;
?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="photograph-slider" class="component photograph-slider hidden visible-<?php echo $settings['visibleentries']; echo $css_class; ?>">
	<div id="slides" class="slides">
		<ul>
<?php
	foreach ( $settings['slides'] as $k => $post ) {
		setup_postdata( $post ); $count++;
		
		if ( ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $post->ID ) ) && ( get_post_meta( $post->ID, 'image', true ) == '' ) ) {
			$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			$image_args['src'] = $attachment[0];
		} else {
			unset( $image_args['src'] );
		}
		
		// Prepare the slide image.
		$image_args['alt'] = esc_attr( strip_tags( get_the_title() ) );
		
		// Slide Link Variables
		$slide_link = woo_image( 'return=true&link=url' );
		$slide_rel = 'prettyPhoto[slides]';
		
		if ( $woo_options['woo_slide_link'] == 'post' ) {
			$slide_link = get_permalink( $post->ID );
			$slide_rel = 'post';
		}
		
		// Cater for custom slide links. If the slide has a custom link, go directly to it, with no lightbox.
		$custom_link = get_post_meta( $post->ID, 'url', true );
		if ( $custom_link != '' ) {
			$slide_link = $custom_link;
			$slide_rel = '';
		}
?>
			<li id="slide-<?php the_ID(); ?>" class="slide slide-<?php echo $count; ?> inactive">
				<a rel="<?php echo $slide_rel; ?>" href="<?php echo $slide_link; ?>" title="<?php echo esc_attr( strip_tags( get_the_content() ) ); ?>">
					<?php
						echo woo_image( $image_args );
					?>
				</a>
			</li>
<?php } // End FOREACH Loop ?>
		</ul>
	</div><!--/#slides-->
</div><!--/#photograph-slider .component photograph-slider hidden visible-<?php echo $settings['visibleentries']; ?>-->	    	
<?php
	} // End IF Statement

/* Reset the query. */
wp_reset_query();
?>
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>