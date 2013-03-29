<?php
/**
 * Component: Baby Statistics.
 *
 * Display specific statistics about your newborn.
 *
 * @package WordPress
 * @subpackage WooFramework
 */
 
 global $woo_options, $woothemes_column_generator;
 
 /* Turn off the column generator. */
 $woothemes_column_generator->toggle_filters( true );
 
 $woothemes_column_generator->current_column = 2;
 
 /* Setup options for this component. */
 $component_token = 'babystats';
 
 $settings = array(
 	'title' => '', 
 	'pounds' => 1, 
 	'inches' => 1, 
 	'eyecolor' => '', 
 	'haircolor' => '', 
 	'aboutpage' => 0, 
 	'hidetitle' => 'false'
 );

 /* Make sure our dynamic settings override the defaults, if available. */ 
 foreach ( array_keys( $settings ) as $o ) {
 	if ( isset( $woo_options['woo_babystats_' . $o] ) && $woo_options['woo_babystats_' . $o] != '' ) {
 		$settings[$o] = $woo_options['woo_babystats_' . $o];
 	}
 }
 
 /* Allow child themes/plugins to modify these settings. */
 $settings = apply_filters( 'woo_component_' . $component_token . '_settings', $settings );
 
 $title = '';
 if ( $settings['title'] != '' ) { $title = '<h2 class="component-title">' . stripslashes($settings['title']) . '</h2>' . "\n"; }
 
 /* The Query. */
 $page = array();
 $page_title = '';
 $page_content = '';
 $has_page = false;
 
 if ( $settings['aboutpage'] > 0 ) {
 	$page = get_page( $settings['aboutpage'], OBJECT, 'display' );
 }
 
 if ( ! empty( $page ) ) {
 	$page_title = apply_filters( 'the_title', $page->post_title );
 	$page_content = apply_filters( 'the_content', $page->post_content );
 	$has_page = true;
 }
 
 /* The Stats. */
 $stats = $settings; // Clone the settings array.
 unset( $stats['title'] ); // Remove the "title" and "aboutpage" settings, as they aren't stats.
 unset( $stats['aboutpage'] );
 unset( $stats['hidetitle'] );
 
 /* The Stats Labels. */
 $stats_labels = array(
 	'pounds' => __( 'Pounds', 'woothemes' ), 
 	'inches' => __( 'Inches', 'woothemes' ), 
 	'eyecolor' => __( 'Eye Color', 'woothemes' ), 
 	'haircolor' => __( 'Hair Color', 'woothemes' )
 );
?>
<?php woo_component_before( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<div id="babystats" class="component babystats col-full">
	<?php echo $title; ?>
	<div id="stats" class="stats alignleft">
		<?php
			$html = '';
			foreach ( $stats as $k => $v ) {
				if ( $v != '' ) {
					$html .= '<span class="stat stat-' . $k . '">' . "\n";
						$html .= '<span class="stat-content">' . "\n";
						
							if ( in_array( $k, array( 'pounds', 'inches' ) ) ) {
								$html .= '<span class="dyntextval">' . "\n";
							}
						
							if ( in_array( $k, array( 'eyecolor', 'haircolor' ) ) ) {
								$html .= '<span class="color-display"><span class="color-ring"></span><span class="gradient-display"></span><!--/.gradient-display--></span><!--/.color-display-->' . "\n";
							} else {
								$html .= $v;
							}
							
							if ( in_array( $k, array( 'pounds', 'inches' ) ) ) {
								$html .= '</span><!--/.dyntextval-->' . "\n";
							}

						
						$html .= '</span><!--/.stat-content-->' . "\n";
						$html .= '<span class="stat-label">' . "\n";
							$html .= $stats_labels[$k];
						$html .= '</span><!--/.stat-label-->' . "\n";
					$html .= '</span><!--/.stat stat-' . $k . '-->' . "\n";
					
					if ( $k == 'inches' ) { $html .= '<div class="fix"></div>' . "\n"; }
				}
			}
			echo $html;
		?>
	</div><!--/#stats .stats fl-->
	<?php if ( $has_page == true ) { ?>
	<div id="about-the-baby" class="about-the-baby">
		<?php
			if ( $page_title != '' && ( $settings['hidetitle'] == 'false' ) ) { echo '<h2 class="title">' . $page_title . '</h2>' . "\n"; }
			if ( $page_content != '' ) { echo '<div class="entry"><div class="column column-01">' . $page_content . '</div></div>' . "\n"; }
		?>
	</div><!--/#about-the-baby .about-the-baby fr hentry post-->
	<?php } // End IF Statement ?>
</div><!--/#babystats .component babystats col-full-->
<?php woo_component_after( $component_token ); // Add action for child themes/plugins to hook onto. ?>
<?php
	/* Turn on the column generator. */
 	$woothemes_column_generator->toggle_filters();
?>