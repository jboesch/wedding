<?php
/**
 * Component: Subscribe & Connect.
 *
 * A component for the "Subscribe & Connect" module.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'subscribe-connect';
 
 $settings = array(
 	'title' => '', 
 	'content' => '', 
 	'newsletter_id' => '', 
 	'mailchimp_list_url' => '', 
 	'rss' => 'true', 
 	'twitter' => '', 
 	'facebook' => '', 
 	'youtube' => '', 
 	'flickr' => '', 
 	'linkedin' => '', 
 	'delicious' => '', 
 	'googleplus' => '', 
 	'related' => 'true'
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_connect_' . $o] ) && $woo_options['woo_connect_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_connect_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="subscribe-connect" class="component col-full subscribe-connect">
<?php woo_subscribe_connect( 'true', 'true', '', '', true ); ?>
</div><!--/#subscribe-connect .component col-full subscribe-connect-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>