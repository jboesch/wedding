<?php
/*-----------------------------------------------------------------------------------*/
/* Load frontend JavaScript */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) { add_action( 'wp_print_scripts', 'woothemes_add_javascript' ); }

if ( ! function_exists( 'woothemes_add_javascript' ) ) {
	function woothemes_add_javascript() {
		global $woo_options;
		   
		wp_register_script( 'jcarousel', get_template_directory_uri() . '/includes/js/jquery.jcarousel.min.js', array( 'jquery' ) );
		wp_register_script( 'jquery-countdown', get_template_directory_uri() . '/includes/js/jquery.countdown.min.js', array( 'jquery' ) );
		wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/includes/js/jquery.prettyPhoto.js', array( 'jquery' ) );
		wp_register_script( 'jquery-scrollto', get_template_directory_uri() . '/includes/js/jquery.scrollTo-min.js', array( 'jquery' ) );
		wp_register_script( 'jquery-localscroll', get_template_directory_uri() . '/includes/js/jquery.localscroll-min.js', array( 'jquery', 'jquery-scrollto' ) );
		wp_register_script( 'jquery-masonry', get_template_directory_uri() . '/includes/js/jquery.masonry.min.js', array( 'jquery' ) );
		wp_register_script( 'jquery-textfill', get_template_directory_uri() . '/includes/js/jquery-textfill-0.1.js', array( 'jquery' ) );

		if ( is_singular() ) { wp_enqueue_script( 'jquery-ui-tabs' ); }

		wp_enqueue_script( 'general', get_template_directory_uri() . '/includes/js/general.js', array( 'jquery', 'jcarousel', 'jquery-countdown', 'prettyPhoto', 'jquery-scrollto', 'jquery-localscroll', 'jquery-masonry', 'jquery-textfill' ), '1.0.0' );
		
		// Load comment reply script on the front page.
		if ( is_front_page() || is_home() ) { wp_enqueue_script( 'comment-reply' ); }
		
		/* Setup dynamic variables. */
		$settings = array(
		 	'visibleentries' => 1, 
		 	'auto' => 'false', 
		 	'interval' => 4, 
		 	'speed' => '0.6', 
		 	'scrolling' => 'circular'
		);
		
		/* Make sure our dynamic settings override the defaults, if available. */ 
		foreach ( array_keys( $settings ) as $o ) {
			if ( isset( $woo_options['woo_slider_' . $o] ) && $woo_options['woo_slider_' . $o] != '' ) {
				$settings[$o] = $woo_options['woo_slider_' . $o];
			}
		}
		
		// Allow our JavaScript file (the general one) to see our slider setup data.
		$data = array(
				'autoStart' => $settings['auto'], 
				'interval' => $settings['interval'], 
				'speed' => $settings['speed'] * 1000, // Convert seconds value to milliseconds value 
				'visible' => $settings['visibleentries'], 
				'scroll' => 1, 
				'scrolling' => $settings['scrolling']
				);
		
		// Allow child themes/plugins to filter here.
		$data = apply_filters( 'woo_slider_javascript_settings', $data );
		
		wp_localize_script( 'general', 'woo_jcarousel_settings', $data );
		
		// Setup translation strings for the countdown.
		$data = array(
				'years' => __( 'Years', 'woothemes' ), 
				'months' => __( 'Months', 'woothemes' ), 
				'weeks' => __( 'Weeks', 'woothemes' ), 
				'days' => __( 'Days', 'woothemes' ), 
				'hours' => __( 'Hours', 'woothemes' ), 
				'minutes' => __( 'Minutes', 'woothemes' ), 
				'seconds' => __( 'Seconds', 'woothemes' ), 
				'year' => __( 'Year', 'woothemes' ), 
				'month' => __( 'Month', 'woothemes' ), 
				'week' => __( 'Week', 'woothemes' ), 
				'day' => __( 'Day', 'woothemes' ), 
				'hour' => __( 'Hour', 'woothemes' ), 
				'minute' => __( 'Minute', 'woothemes' ), 
				'second' => __( 'Second', 'woothemes' )
				);
		
		// Allow child themes/plugins to filter here.
		$data = apply_filters( 'woo_countdown_translation_strings', $data );
		
		wp_localize_script( 'jquery-countdown', 'woo_localized_data', $data );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Theme Frontend CSS */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) { add_action( 'wp_print_styles', 'woothemes_add_css' ); }

if ( ! function_exists( 'woothemes_add_css' ) ) {
	function woothemes_add_css() {  
		wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/includes/css/prettyPhoto.css' );
		
		// Conditionally load the prettyPhoto CSS, where needed.
		$load_prettyphoto_css = true;
			 
		// Allow child themes/plugins to load the prettyPhoto CSS when they need it.
		$load_prettyphoto_css = apply_filters( 'woo_load_prettyphoto_css', $load_prettyphoto_css );
	
		if ( $load_prettyphoto_css ) { wp_enqueue_style( 'prettyPhoto' ); }
		
		do_action( 'woothemes_add_css' );
	} // End woothemes_add_css()
}

/*-----------------------------------------------------------------------------------*/
/* Theme Admin JavaScript */
/*-----------------------------------------------------------------------------------*/

if ( is_admin() ) { add_action( 'admin_print_scripts', 'woothemes_add_admin_javascript' ); }
if ( is_admin() ) { add_action( 'admin_print_styles', 'woothemes_add_admin_css' ); }

if ( ! function_exists( 'woothemes_add_admin_javascript' ) ) {
	function woothemes_add_admin_javascript() {
		global $pagenow;
		
		if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
			wp_enqueue_script( 'woo-post-meta-options', get_template_directory_uri() . '/includes/js/theme-options.js', array( 'jquery', 'jquery-ui-tabs' ), '1.0.0' );
		}
		
		if ( $pagenow == 'admin.php' || get_query_var( 'page' ) == 'woothemes' ) {
			wp_enqueue_script( 'woo-theme-options-custom-toggle', get_template_directory_uri() . '/includes/js/theme-options-custom-toggle.js', array( 'jquery' ), '1.0.0' );
		}
		
	} // End woothemes_add_admin_javascript()
}

if ( ! function_exists( 'woothemes_add_admin_css' ) ) {
	function woothemes_add_admin_css() {
		wp_enqueue_style( 'woo-post-meta-options', get_template_directory_uri() . '/includes/css/meta-options.css' );
	} // End woothemes_add_admin_css()
}
?>