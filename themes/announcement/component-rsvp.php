<?php
/**
 * Component: RSVP Details.
 *
 * Display the content of a specified page, aimed at providing details for the occassion.
 *
 * @package WordPress
 * @subpackage WooFramework
 */

global $woo_options, $woothemes_column_generator;

$woothemes_column_generator->current_column = 2;

/* Setup options for this component. */
$component_token = 'rsvp';

$settings = array(
    'page' => 64 // hard-coded rsvp page id
);

/* The Query. */
$post = array();
$has_page = false;

if ( $settings['page'] > 0 ) {
    $post = get_page( $settings['page'], OBJECT, 'display' );
}

if ( ! empty( $post ) ) {
    setup_postdata( $post );
    $has_page = true;
}
?>
<?php if ( $has_page == true ) { ?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="rsvp" <?php woo_section_class( 'component col-full', 'rsvp' ); ?>>
    <h2 class="component-title"><?php the_title(); ?></h2>
    <div class="entry">
        <div class="column column-01">
            <?php the_content(); ?>
            <? include('custom-rsvp.php'); ?>
        </div><!--/.column-->
    </div><!--/.entry-->
</div><!--/#rsvp .component col-full rsvp-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php } // End IF Statement ?>