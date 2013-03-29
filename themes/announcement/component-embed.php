<?php
/**
 * Component: Embedded Video.
 *
 * Display embedded videos from a specified category.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'embed';
 
 $settings = array(
  	'title' => '', 
 	'category' => 0, 
 	'tag' => '', 
 	'width' => '', 
 	'height' => '', 
 	'limit' => 5	
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_embed_' . $o] ) && $woo_options['woo_embed_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_embed_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* The Query. */
 $query_args = array(
 					'numberposts' => $settings['limit'], 
 					'suppress_filters' => 0
 					);

 if ( $settings['category'] > 0 ) {
 	$query_args['cat'] = $settings['category'];
 }

 if ( $settings['tag'] > 0 ) {
 	$query_args['tag'] = $settings['tag'];
 }
 
 $videos = get_posts( $query_args );
?>
<?php if ( isset( $videos ) && count( $videos ) > 0 ) { ?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="embed" <?php woo_section_class( 'component col-full', 'embed' ); ?>>
<?php echo $title; ?>
<div class="entry">
<?php
	$post_list = '';
	$count = '';
	$class = '';
	$list_class = ' active';
	
	$html = '';
	
	foreach ( $videos as $v ) {
		$embed = woo_get_embed( 'embed', $settings['width'], $settings['height'], 'widget_video', $v->ID );
		
		if ( $embed != '' ) {
			$count++;
			if ( $count == 2 ) { $class = ' hidden'; $list_class = ''; } // After the first item, set the class to "hidden".
			
			$title = get_the_title( $v->ID );
			
			$html .= '<div class="widget-video-unit' . $class . '">' . "\n";
			$html .= '<h4>' . $title  . '</h4>' . "\n";
			$html .= $embed;
			$html .= '</div><!--/.widget-vide-unit-->' . "\n";
			
			$post_list .= '<li class="video-item' . $list_class . '"><a href="#">' . $title . '</a></li>' . "\n";
		}
	} // End FOREACH Loop
	
	$html .= '<ul class="widget-video-list">' . "\n";
	$html .= $post_list;
	$html .= '</ul>' . "\n";
	
	/* Output the finished code. */
	echo $html;
?>
</div><!--/.entry-->
</div><!--/#embed .component col-full embed-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>