<?php
/**
 * Layout: Graduate.
 *
 * A collection of components used to display the "Graduate" layout preset.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Photograph slider component. */
 get_template_part( 'component', 'photoslider' );
 
 /* "Page Content" component. */
 get_template_part( 'component', 'pagecontent' );
			
 /* Registry/Links component. */
 get_template_part( 'component', 'links' );
 
 /* 4-Column Widgetised Footer component. */
 get_template_part( 'component', 'footerwidgets' );
 
 /* Comments component. */
 get_template_part( 'component', 'comments' );
?>