<?php

// Register widgetized areas

if (!function_exists( 'the_widgets_init')) {
	function the_widgets_init() {
	    if ( !function_exists( 'register_sidebar') )
	        return;
		
		register_sidebar(array( 'name' => __( 'Homepage', 'woothemes' ),'id' => 'homepage', 'description' => __( 'The homepage. Place the components you\'d like to display on your homepage in this widgetized area.', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	    register_sidebar(array( 'name' => __( 'Primary', 'woothemes' ),'id' => 'primary','description' => __( 'Normal full width Sidebar', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>')); 
	    register_sidebar(array( 'name' => __( 'Footer 1', 'woothemes' ),'id' => 'footer-1', 'description' => __( 'Widetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	    register_sidebar(array( 'name' => __( 'Footer 2', 'woothemes' ),'id' => 'footer-2', 'description' => __( 'Widetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	    register_sidebar(array( 'name' => __( 'Footer 3', 'woothemes' ),'id' => 'footer-3', 'description' => __( 'Widetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	    register_sidebar(array( 'name' => __( 'Footer 4', 'woothemes' ),'id' => 'footer-4', 'description' => __( 'Widetized footer', 'woothemes' ), 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	}
}

add_action( 'init', 'the_widgets_init' );


    
?>