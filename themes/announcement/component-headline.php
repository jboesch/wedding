<?php
/**
 * Component: Headline Text.
 *
 * Display headline text with an optional title.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'headline';
 
 $settings = array(
 	'title' => '', 
 	'text' => ''
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_headline_' . $o] ) && $woo_options['woo_headline_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_headline_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* The Query. */
 $headline = '';
 if ( $settings['text'] != '' ) { $headline = $settings['text']; }
?>
<?php if ( $headline != '' ) { ?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="headline" class="component col-full headline">
<?php echo $title; ?>
<h2 class="headline-text"><?php echo $headline; ?></h2>
</div><!--/#headline .component col-full headline-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>