<?php
/**
 * Component: Countdown.
 *
 * A countdown to a specified date/time.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'countdown';
 
 $settings = array(
 	'title' => '', 
 	'date' => date( 'm/d/Y', time()+86400 ), 
 	'time' => '00:00'
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_countdown_' . $o] ) && $woo_options['woo_countdown_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_countdown_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* Setup date and time pieces. */
 $date_bits = explode( '/', $settings['date'] );
 $time_bits = explode( ':', $settings['time'] );
 
 /* Setup an array of countdown elements. */
 $elements = array(
 					'year' => $date_bits[2], 
 					'month' => $date_bits[0], 
 					'day' => $date_bits[1], 
 					'hour' => $time_bits[0], 
 					'minute' => $time_bits[1]
 				  );
?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="countdown" class="component countdown col-full">
	<?php echo $title; ?>
	<div class="countdown-timer">
		<?php
			foreach ( $elements as $k => $v ) {
		?>
			<span class="<?php echo $k; ?>"><?php echo $v; ?></span><!--/.<?php echo $k; ?>-->
		<?php	
			}
		?>
	</div><!--/.countdown-timer-->
</div><!--/#countdown .component countdown col-full-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>