<?php
/**
 * Component: Page Comments.
 *
 * Display the comments of a specified page. The settings are retrieved from the "Content & Comments" section.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options, $post, $id, $wpdb, $comments, $wp_query;
 
 /* Get "Comments" component to recognise the homepage layout as a "page". */
 $wp_query->is_page = true;
 
 /* Setup options for this component. */
 $component_token = 'pagecomments';
 
 $settings = array(
 	'page' => 0, 
 	'commentstitle' => ''
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_pagecontent_' . $o] ) && $woo_options['woo_pagecontent_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_pagecontent_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 /* The Query. */
 $page = array();
 $page_title = '';
 $page_content = '';
 $has_page = false;
 $title = '';
 if ( $settings['commentstitle'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['commentstitle']) . '</h2>' . "\n"; }
 
 if ( $settings['page'] > 0 ) {
 	$page = get_page( $settings['page'], OBJECT, 'display' );
 }
 
 if ( ! empty( $page ) ) {
 	$page_title = apply_filters( 'the_title', $page->post_title );
 	$page_content = apply_filters( 'the_content', $page->post_content );
 	$has_page = true;
 }
?>
<?php if ( $has_page == true ) { ?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="pagecomments" class="component col-full pagecomments">
<?php echo $title; ?>
<?php
	$current_page_id = $post->ID; // Preserve this for use later.
	$GLOBALS['current_page_id'] = $current_page_id;
	
	$id = $settings['page']; // Set this so the comments template assigns comments to our selected page.
	$post = $page; // Set this so the comments template assigns comments to our selected page.
	$withcomments = true; // Set this so the comments template assigns comments to our selected page.

	comments_template();
?>
</div><!--/#pagecomments .component col-full pagecomments-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>