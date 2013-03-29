<?php
/**
 * Component: Occassion Details.
 *
 * Display the content of a specified page, aimed at providing details for the occassion.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options, $woothemes_column_generator;
 
 $woothemes_column_generator->current_column = 2;
 
 /* Setup options for this component. */
 $component_token = 'occassiondetails';
 
 $settings = array(
 	'page' => 0
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_occassiondetails_' . $o] ) && $woo_options['woo_occassiondetails_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_occassiondetails_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 /* The Query. */
 $post = array();
 $has_page = false;
 
 if ( $settings['page'] > 0 ) {
 	$post = get_page( $settings['page'], OBJECT, 'display' );
 }
 
 if ( ! empty( $post ) ) {
 	setup_postdata( $post );
 	$has_page = true;
 }
?>
<?php if ( $has_page == true ) { ?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="occassiondetails" <?php woo_section_class( 'component col-full', 'occassiondetails' ); ?>>
<h2 class="component-title"><?php the_title(); ?></h2>
<div class="entry">
<div class="column column-01">
<?php the_content(); ?>
</div><!--/.column-->
</div><!--/.entry-->
</div><!--/#occassiondetails .component col-full occassiondetails-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>