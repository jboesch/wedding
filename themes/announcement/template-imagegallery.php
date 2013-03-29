<?php
/*
Template Name: Image Gallery
*/

get_header();
global $wp_query;
?>
    <div id="content" class="page col-full">
		<div id="main" class="col-left">
                                                                            
		<?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
			<div id="breadcrumbs">
				<?php woo_breadcrumbs(); ?>
			</div><!--/#breadcrumbs -->
		<?php } ?>  

            <div <?php post_class(); ?>>

			    <h1 class="title"><?php the_title(); ?></h1>
                
				<div class="entry">
		            <?php
		            	if ( have_posts() ) { the_post();
		            		the_content();
		            	}
		            
		            	query_posts( 'showposts=60&post_type=post' );
		            	
		            	if ( have_posts() ) {
		            		while ( have_posts() ) { the_post();
		            			$wp_query->is_home = false;
		            			woo_image( 'single=true&class=thumbnail alignleft' );
                			}
                		}
               		?>	
                </div>

            </div><!-- /.post -->
            <div class="fix"></div>                
                                                            
		</div><!-- /#main -->
        <?php get_sidebar(); ?>
    </div><!-- /#content -->
<?php get_footer(); ?>