<?php
/**
 * Layout: Business.
 *
 * A collection of components used to display the "Business" layout preset.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Photograph slider component. */
 get_template_part( 'component', 'photoslider' );
 
 /* Countdown component. */
 get_template_part( 'component', 'countdown' );
 
 /* "Page Content" component. */
 get_template_part( 'component', 'pagecontent' );

 /* "Subscribe & Connect" component. */
 get_template_part( 'component', 'subscribe' );
 
 /* Video Embed component. */
 get_template_part( 'component', 'embed' );
 
 /* "Blog" component. */
 get_template_part( 'component', 'blog' );
 
 /* 4-Column Widgetised Footer component. */
 get_template_part( 'component', 'footerwidgets' );
 
 /* Comments component. */
 get_template_part( 'component', 'comments' );
?>