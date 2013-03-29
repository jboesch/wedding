<?php

if(isset($_GET['rsvp'])){

    global $wpdb;

    $data = array(
        'coming' => $_GET['coming'],
        'email' => $_GET['email'],
        'full_name' => $_GET['full_name'],
        'allergies' => $_GET['allergies'],
        'guests' => isset($_GET['guests']) ? join(',', $_GET['guests']) : '',
        'guests_count' => isset($_GET['guests']) ? count($_GET['guests']) : 0,
        'date_created' => date('Y-m-d H:i:s')
    );

    if($wpdb->insert('rsvps', $data)){
        echo json_encode(array('status' => 'success', 'message' => 'Thanks! Your RSVP has been noted in our little online black book.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'An error occurred on our end. Contact 306-737-2529 to RSVP the \'ol fashion way.'));
    }

    die;
}

/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// Set path to WooFramework and theme specific functions
$functions_path = get_template_directory() . '/functions/';
$includes_path = get_template_directory() . '/includes/';

// Define the theme-specific key to be sent to PressTrends.
define( 'WOO_PRESSTRENDS_THEMEKEY', '0p81xhy7sg54mw51nx5a3vyc784gk60f2' );

// WooFramework
require_once ( $functions_path . 'admin-init.php' );			// Framework Init

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 								// Options panel settings and custom settings
				'includes/theme-functions.php', 							// Custom theme functions
				'includes/theme-plugins.php', 								// Theme specific plugins integrated in a theme
				'includes/theme-actions.php', 								// Theme actions & user defined hooks
				'includes/theme-comments.php', 								// Custom comments/pingback loop
				'includes/theme-js.php', 									// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 								// Initialize widgetized areas
				'includes/theme-widgets.php'								// Theme widgets
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );
			
foreach ( $includes as $i ) {
	locate_template( $i, true );
}

require_once( $includes_path . 'woo-column-generator/woo-column-generator.php' ); 	// Button to generate content columns

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/




/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>