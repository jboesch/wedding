<?php global $woo_options; ?>
<?php
if ( function_exists( 'woo_get_dynamic_values' ) ) {
	$settings = woo_get_dynamic_values( array( 'enable_footer_widgets' => 'false' ) );
	// Display the footer widgets on pages other than the homepage (which is controlled via the preset layouts and a widgetized region).
	if ( ! is_home() && 'true' == $settings['enable_footer_widgets'] ) {
		get_template_part( 'component', 'footerwidgets' );
	}
}
?>
	<div id="footer" class="col-full">
	
		<div id="copyright" class="col-left">
		<?php if( $woo_options[ 'woo_footer_left' ] == 'true' ) {
		
				echo stripslashes( $woo_options['woo_footer_left_text'] );	

		} else { ?>
			<p><?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', 'woothemes' ); ?></p>
		<?php } ?>
		</div>
		
		<div id="credit" class="col-right">
        <?php if( $woo_options[ 'woo_footer_right' ] == 'true' ){
		
        	echo stripslashes( $woo_options['woo_footer_right_text'] );
       	
		} else { ?>
			<p><?php _e( 'Powered by', 'woothemes' ); ?> <a href="http://www.wordpress.org">WordPress</a>. <?php _e( 'Designed by', 'woothemes' ); ?> <a href="<?php $aff = $woo_options['woo_footer_aff_link']; if(!empty($aff)) { echo esc_url( $aff ); } else { echo 'http://www.woothemes.com'; } ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/woothemes.png" width="74" height="19" alt="Woo Themes" /></a></p>
		<?php } ?>
		</div>
		
	</div><!-- /#footer  -->
    <div id="footer-floor"></div><!-- /#footer-floor  -->
</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<?php woo_foot(); ?>
</body>
</html>