<?php

if(isset($_GET['rsvp'])){

    require_once('libs/Postmark.php');
    global $wpdb;

    $rsvps_data = array(
        'coming' => $_GET['coming'],
        'email' => $_GET['email'],
        'full_name' => $_GET['full_name'],
        'allergies' => $_GET['allergies'],
        'vegetarian' => isset($_GET['vegetarian']) ? $_GET['vegetarian'] : 0,
        'date_created' => date('Y-m-d H:i:s')
    );

    if($wpdb->insert('rsvps', $rsvps_data)){
        $id = (int) $wpdb->insert_id;

        $guests = isset($_GET['guests']) ? $_GET['guests'] : array();

        foreach($guests as $guest){
            $rsvps_guests_data = array(
                'rsvp_id' => $id,
                'full_name' => $guest['full_name'],
                'vegetarian' => $guest['vegetarian']
            );
            $wpdb->insert('rsvps_guests', $rsvps_guests_data);
        }

        define('POSTMARKAPP_API_KEY', '194dd5c5-f392-4089-9dcf-3b1c6e2b3dd2');
        define('POSTMARKAPP_MAIL_FROM_ADDRESS', 'jordan@7shifts.com');
        define('POSTMARKAPP_MAIL_FROM_NAME', 'Jordan Boesch');

        $msg = "All set! Thanks for the RSVP. Here are your submitted details:\n\n";

        $msg .= "Full name: " . $_GET['full_name'] . "\n";
        $msg .= "Email: " . $_GET['email'] . "\n";
        $msg .= "Coming: " . ($_GET['coming'] ? 'Yes' : 'No') . "\n";
        $msg .= "Vegetarian: " . ($_GET['vegetarian'] ? 'Yes' : 'No') . "\n";
        $msg .= "Allergies: " . $_GET['allergies'] . "\n\n";

        if(count($guests)){
            $msg .= "-------------------\nGuests (" . count($guests) . ")\n-------------------\n\n";
        }

        foreach($guests as $guest){
            $msg .= "Full name: " . $guest['full_name'] . "\n";
            $msg .= "Vegetarian: " . ($guest['vegetarian'] ? 'Yes' : 'No') . "\n";
            $msg .= "-------------------\n";
        }

        $msg .= "\nIf you need to make any changes to this RSVP, you can email us at jboesch26@gmail.com or phone us at 306-737-2529. \nRemember to check http://www.gettingmarriedcomejoin.us for any wedding information.\n\n- Muchos love from Andrée and Jordan";

        try {
            Mail_Postmark::compose()
                ->addTo($_GET['email'])
                ->addBcc('jboesch26@gmail.com')
                ->addBcc('andree.carpentier@gmail.com')
                ->subject('Wedding RSVP')
                ->messagePlain($msg)
                ->send();
        } catch(Exception $e){
            echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
            die;
        }
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