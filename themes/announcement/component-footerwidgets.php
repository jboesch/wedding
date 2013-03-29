<?php
/**
 * Component: Footer Widgets.
 *
 * Optionally display up to 4 widgetized footer regions.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'footer';
 
 $settings = array(
 	'title' => '', 
 	'sidebars' => 4
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_footer_' . $o] ) && $woo_options['woo_footer_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_footer_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }

?>
<?php			   
if ( ( woo_active_sidebar( 'footer-1') ||
	   woo_active_sidebar( 'footer-2') || 
	   woo_active_sidebar( 'footer-3') || 
	   woo_active_sidebar( 'footer-4') ) && $settings['sidebars'] > 0 ) {

?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="footer-widgets" class="component col-full col-<?php echo $settings['sidebars']; ?>">
	<?php echo $title; ?>
	<?php $i = 0; while ( $i < $settings['sidebars'] ) { $i++; ?>			
		<?php if ( woo_active_sidebar( 'footer-' . $i ) ) { ?>

	<div class="block footer-widget-<?php echo $i; ?>">
    	<?php woo_sidebar( 'footer-' . $i ); ?>    
	</div>
	        
        <?php } ?>
	<?php } // End WHILE Loop ?>
    		        
	<div class="fix"></div>

</div><!--/#footer-widgets .component col-full-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>