<?php
/**
 * Component: Occassion Hosts.
 *
 * Display the hosts of the occassion with an optional title.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'occassionhosts';
 
 $settings = array(
 	'title' => '', 
 	'text' => ''
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_occassionhosts_' . $o] ) && $woo_options['woo_occassionhosts_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_occassionhosts_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* The Query. */
 $hosts = '';
 
 if ( $settings['text'] != '' ) {
 	$host_names = explode( ',', $settings['text'] );
 	if ( is_array( $host_names ) && ( count( $host_names ) > 0 ) ) {
 		for ( $i = 0; $i < count( $host_names ); $i++ ) {
 			$delimiter = ', ';
 			$name = trim( $host_names[$i] );
 			if ( $name != '' ) {
 				if ( $i == ( count( $host_names ) - 1 ) ) {
 					$delimiter = ''; // Remove the delimiter for the last post.
 				}
 				
 				if ( $i == ( count( $host_names ) - 2 ) && count( $host_names ) > 1 ) {
					$delimiter = ' <span class="ampersand"><span>&amp;</span></span> ';
				}
 				
 				$hosts .= $name . $delimiter;
 			}
 		}
 	}
 }
?>
<?php if ( $host_names != '' ) { ?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="occassionhosts" class="component col-full occassionhosts">
<?php echo $title; ?>
<div class="host_names">
<?php echo $hosts; ?>
</div><!--/.host_names-->
</div><!--/#occassionhosts .component col-full occassionhosts-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>