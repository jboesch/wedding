<?php
/**
 * Layout: Birth.
 *
 * A collection of components used to display the "Birth" layout preset.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options;
 
 /* Photograph slider component. */
 get_template_part( 'component', 'photoslider' );
 
 /* "Heading" component. */
 get_template_part( 'component', 'headline' );
 
 /* Baby Stats component. */
 get_template_part( 'component', 'babystats' );

 /* "Occassion Host" component. */
 get_template_part( 'component', 'occassionhosts' );
 
 /* "Page Content" component. */
 get_template_part( 'component', 'pagecontent' );
			
 /* Registry/Links component. */
 get_template_part( 'component', 'links' );
 
 /* 4-Column Widgetised Footer component. */
 get_template_part( 'component', 'footerwidgets' );
 
 /* Comments component. */
 get_template_part( 'component', 'comments' );
?>