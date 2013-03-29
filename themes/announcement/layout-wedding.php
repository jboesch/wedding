<?php
/**
 * Layout: Wedding.
 *
 * A collection of components used to display the "Wedding" layout preset.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Photograph slider component. */
 get_template_part( 'component', 'photoslider' );

 /* "Occassion Host" component. */
 get_template_part( 'component', 'occassionhosts' );

 /* "Page Content" component. */
 get_template_part( 'component', 'pagecontent' );
 
 /* "Heading" component. */
 get_template_part( 'component', 'headline' );
 
 /* Occasion Details component. */
 get_template_part( 'component', 'occassiondetails' );
			
 /* Registry/Links component. */
 get_template_part( 'component', 'links' );
 
 /* 4-Column Widgetised Footer component. */
 get_template_part( 'component', 'footerwidgets' );
 
 /* Comments component. */
 get_template_part( 'component', 'comments' );
?>