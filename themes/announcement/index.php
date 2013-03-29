<?php
/**
 * Template: Homepage
 *
 * This is the main template file, used to display the homepage and as
 * a fallback template if a more appropriate template file doesn't exist.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 get_header();
 global $woo_options;
 
 /* Setup options for this template. */
 $settings = array(
 	'layoutstyle' => 'business'
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_' . $o] ) && $woo_options['woo_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_layout_settings', $settings );
?>
    <div id="content" class="page components-page">
		<div id="main" class="fullwidth">      
                    
		<?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
			<div id="breadcrumbs" class="col-full">
				<?php woo_breadcrumbs(); ?>
			</div><!--/#breadcrumbs -->
		<?php } ?>  
		<?php
			/* Make sure we switch to the selected layout if a custom layout isn't set. */
			if ( ! is_active_sidebar( 'homepage' ) ) {
				get_template_part( 'layout', $settings['layoutstyle'] );
			} else {
				dynamic_sidebar( 'homepage' );
			}
		?>
		</div><!-- /#main -->
    </div><!-- /#content -->
		
<?php get_footer(); ?>