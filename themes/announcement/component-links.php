<?php
/**
 * Component: Registry/Links
 *
 * A collection of links, using the "Links" post type.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Setup options for this component. */
 $component_token = 'registry-links';
 
 $settings = array(
 	'title' => '', 
 	'number' => 5, 
 	'category' => 'all', 
 	'orderby' => 'name', 
 	'order' => 'ASC', 
 	'include' => '', 
 	'exclude' => '', 
 	'image_width' => 180, 
 	'image_height' => 75, 
 	'link_break' => 3
 );

 $query_args = array();

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_links_' . $o] ) && $woo_options['woo_links_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_links_' . $o];
 	}
 }

 /* Setup the query arguments. */ 
 $options = array(
 	'number' => 'limit', 
 	'category' => 'category', 
 	'orderby' => 'orderby', 
 	'order' => 'order', 
 	'include' => 'include', 
 	'exclude' => 'exclude'
 );

 foreach ( $options as $k => $o ) {
 	if ( isset( $settings[$k] ) && $settings[$k] != '' ) {
 		
 		/* Setup the query arguments. */
 		if ( $settings[$k] != 'all' ) { $query_args[$o] = $settings[$k]; }
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 $query_args = apply_filters( 'woo_component_' . $component_token . '_queryargs', $query_args );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* The Query. */
 $bookmarks = get_bookmarks( $query_args );

 if ( count( $bookmarks ) > 0 ) { $count = 0;
?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="registry-links" class="component registry-links col-full">
<?php echo $title; ?>
<?php
	foreach ( $bookmarks as $b ) {
		$count++;
		
		$target = '';
		if ( $b->link_target != '' ) {
			$target = ' target="' . $b->link_target . '"';
		}
		
		$class = 'link-text';
		$anchor_content = $b->link_name;
		
		if ( isset( $b->link_image ) && $b->link_image != '' ) {
			$class = 'link-image';
			$anchor_content = woo_image( 'width=' . $settings['image_width'] . '&height=' . $settings['image_height'] . '&return=true&link=img&src=' . $b->link_image . '&id=' . $b->link_id );
		}	
?> 
	<div id="link-<?php echo $b->link_id; ?>" class="link link-<?php echo $count . ' ' . $class; ?>">
		<a href="<?php echo $b->link_url; ?>"<?php echo $target; ?>><?php echo $anchor_content; ?></a>
	</div><!--/#link-<?php echo $b->link_id; ?> .link link-<?php echo $count; ?>-->
	<?php if ( $count % $settings['link_break'] == 0 ) { echo '<div class="fix"></div>'; }  ?>
<?php
	}
?>
</div><!--/#registry-links .component registry-links col-full-->
<?php } ?>
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>