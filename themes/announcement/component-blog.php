<?php
/**
 * Component: Blog.
 *
 * Display your recent blog posts.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options, $wp_query;
 
 /* Setup options for this component. */
 $component_token = 'blog';
 
 $settings = array(
 	'title' => '', 
 	'entries' => 10
 );
 
  /* Setup alignment variable */
    $post_head_align = 'alignleft';

if ( is_array( $woo_options ) && @$woo_options['woo_thumb_align'] == 'alignleft' ) {
    $post_head_align = 'alignright';
}

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_blog_' . $o] ) && $woo_options['woo_blog_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_blog_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* The Query Arguments. */
 if ( $wp_query->query_vars['paged'] ) { $paged = $wp_query->query_vars['paged']; } elseif ( $wp_query->query_vars['page'] ) { $paged = $wp_query->query_vars['page']; } else { $paged = 1; }
 
 /* Make sure the filter to display comments doesn't interfere with the blog posts query. */
 remove_filter( 'pre_get_posts', 'woo_register_home_page', 10 );
      	
 $query_args = array(
					'post_type' => 'post', 
					'paged' => $paged, 
					'posts_per_page' => $settings['entries']
				);

 $query_args = apply_filters( 'woo_blog_template_query_args', $query_args ); // Do not remove. Used to exclude categories from displaying here.

 /* The Query. */
 $query = new WP_Query( $query_args );
 
 /* The Variables. */
 $thumb_width = '100';
 if ( isset( $woo_options['woo_thumb_w'] ) && ( $woo_options['woo_thumb_w'] != '' ) ) { $thumb_width = $woo_options['woo_thumb_w']; }
 
 $thumb_height = '100';
 if ( isset( $woo_options['woo_thumb_h'] ) && ( $woo_options['woo_thumb_h'] != '' ) ) { $thumb_height = $woo_options['woo_thumb_h']; }
 
 $thumb_align = 'alignright';
 if ( isset( $woo_options['woo_thumb_align'] ) && ( $woo_options['woo_thumb_align'] != '' ) ) { $thumb_align = $woo_options['woo_thumb_align']; }
 
?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="blog" class="component col-full blog">
<?php echo $title; ?>
<?php
if ( $query->have_posts() ) {
		$count = 0;
		while ( $query->have_posts() ) { $query->the_post(); $count++;
?>                                                            
    <div <?php post_class(); ?>>
    
		<div class="post-head <?php echo $post_head_align; ?>">
		                        
        <h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        
        <?php woo_post_meta(); ?>
        
        </div>
        
        <div class="container">
        
        <div class="entry">
        	<?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] != 'content' ) { woo_image( 'width=' . $thumb_width . '&height=' . $thumb_height . '&class=thumbnail ' . $thumb_align); } ?> 
            <?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'content' ) { the_content( __( 'Continue Reading &rarr;', 'woothemes' ) ); } else { the_excerpt(); } ?>
        </div>
        
        <?php woo_post_more(); ?>   
        
      </div><!-- /.container -->       
                      
    </div><!-- /.post -->
                                        
<?php
		} // End WHILE Loop
		
		woo_pagenav();
	
	} else {
?>
    <div <?php post_class(); ?>>
        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
    </div><!-- /.post -->
<?php } // End IF Statement ?>
</div><!--/#blog .component col-full blog-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>