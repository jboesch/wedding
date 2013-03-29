<?php
	get_header();
	global $woo_options;
	
	/* The Variables. */
	$thumb_width = '200';
	if ( isset( $woo_options['woo_single_w'] ) && ( $woo_options['woo_single_w'] != '' ) ) { $thumb_width = $woo_options['woo_single_w']; }
	
	$thumb_height = '200';
	if ( isset( $woo_options['woo_single_h'] ) && ( $woo_options['woo_single_h'] != '' ) ) { $thumb_height = $woo_options['woo_single_h']; }
	
	$thumb_align = 'alignright';
	if ( isset( $woo_options['woo_thumb_single_align'] ) && ( $woo_options['woo_thumb_single_align'] != '' ) ) { $thumb_align = $woo_options['woo_thumb_single_align']; }
?>
       
    <div id="content" class="col-full">
		<div id="main"<?php woo_section_class( 'col-left' ); ?>>
		           
		<?php if ( $woo_options['woo_breadcrumbs_show'] == 'true' ) { ?>
			<div id="breadcrumbs">
				<?php woo_breadcrumbs(); ?>
			</div><!--/#breadcrumbs -->
		<?php } ?>  

        <?php if ( have_posts() ) { $count = 0; ?>
        <?php while ( have_posts() ) { the_post(); $count++; ?>
        
			<div <?php post_class(); ?>>

				<?php echo woo_embed( 'width=580' ); ?>

                <h1 class="title"><?php the_title(); ?></h1>
                                
                <?php woo_post_meta(); ?>
                
                <?php if ( isset( $woo_options['woo_thumb_single'] ) && $woo_options['woo_thumb_single'] == 'true' && !woo_embed( '' ) ) woo_image( 'width=' . $thumb_width . '&height=' . $thumb_height . '&class=thumbnail ' . $thumb_align ); ?>
                
                <div class="entry">
                	<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
				</div>
									
				<?php the_tags( '<p class="tags">'.__( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>
                                
            </div><!-- .post -->

				<?php if ( isset( $woo_options['woo_post_author'] ) && $woo_options['woo_post_author'] == 'true' ) { ?>
				<div id="post-author">
					<div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), '70' ); ?></div>
					<div class="profile-content">
						<h3 class="title"><?php printf( esc_attr__( 'About %s', 'woothemes' ), get_the_author() ); ?></h3>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="profile-link">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'woothemes' ), get_the_author() ); ?>
							</a>
						</div><!-- #profile-link	-->
					</div><!-- .post-entries -->
					<div class="fix"></div>
				</div><!-- #post-author -->
				<?php } ?>
				<?php woo_subscribe_connect(); ?>

	        <div id="post-entries">
	            <div class="nav-prev fl"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?></div>
	            <div class="nav-next fr"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ); ?></div>
	            <div class="fix"></div>
	        </div><!-- #post-entries -->
            
           <?php
	            	$comm = '';
	            	if ( isset( $woo_options['woo_comments'] ) && ( $woo_options['woo_comments'] != '' ) ) {
	            		$comm = $woo_options['woo_comments'];
	            	}
	            	if ( ( $comm == 'post' || $comm == 'both' ) ) {
	            		comments_template();
	            	}
            	
				} // End WHILE Loop
			} else {
		?>
			<div <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
			</div><!-- .post -->             
       	<?php } ?>  
        
		</div><!-- #main -->

        <?php get_sidebar(); ?>

    </div><!-- #content -->
		
<?php get_footer(); ?>