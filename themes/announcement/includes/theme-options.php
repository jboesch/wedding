<?php

if (!function_exists( 'woo_options')) {
function woo_options() {
	
// THEME VARIABLES
$themename = "Announcement";
$themeslug = "announcement";

// STANDARD VARIABLES. DO NOT TOUCH!
$shortname = "woo";
$manualurl = 'http://www.woothemes.com/support/theme-documentation/'.$themeslug.'/';   
       
//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );    
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }
$woo_pages_tmp = array_unshift($woo_pages, "Select a page:" );       

//Stylesheets Reader
$alt_stylesheet_path = get_template_directory() . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$other_entries = array( "Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19" );

// Setup an array of categories for a dropdown.
$args = array( 'echo' => 0, 'hierarchical' => 1 );
$cats_dropdown = wp_dropdown_categories( $args );
$cats = array();

// Quick string hack to make sure we get the pages with the indents.
$cats_dropdown = str_replace( "<select name='cat' id='cat' class='postform' >", '', $cats_dropdown );
$cats_dropdown = str_replace( '</select>', '', $cats_dropdown );
$cats_split = explode( '</option>', $cats_dropdown );

$cats[] = __( 'Select a Category:', 'woothemes' );

foreach ( $cats_split as $k => $v ) {
	
	$id = '';
	
	// Get the ID value.
	preg_match( '/value="(.*?)"/i', $v, $matches );
	
	if ( isset( $matches[1] ) ) {
	
		$id = $matches[1];
		
		$cats[$id] = trim( strip_tags( $v ) );
	
	}
	
} // End FOREACH Loop

$woo_categories = $cats;

// Setup an array of tags for a dropdown.
$args = array( 'echo' => 0, 'hierarchical' => 1, 'taxonomy' => 'post_tag' );
$tags_dropdown = wp_dropdown_categories( $args );
$tags = array();

// Quick string hack to make sure we get the tags with the indents.
$tags_dropdown = str_replace( "<select name='cat' id='cat' class='postform' >", '', $tags_dropdown );
$tags_dropdown = str_replace( '</select>', '', $tags_dropdown );
$tags_split = explode( '</option>', $tags_dropdown );

$tags[] = __( 'Select a Tag:', 'woothemes' );

foreach ( $tags_split as $k => $v ) {
	
	$id = '';
	
	// Get the ID value.
	preg_match( '/value="(.*?)"/i', $v, $matches );
	
	if ( isset( $matches[1] ) ) {
		
		$id = $matches[1];
		
		$tags[$id] = trim( strip_tags( $v ) );
		
	}
	
} // End FOREACH Loop

$woo_tags = $tags;

// Setup an array of slide categories for a dropdown.
$args = array( 'echo' => 0, 'hierarchical' => 1, 'taxonomy' => 'slide-category' );
$tags_dropdown = wp_dropdown_categories( $args );
$tags = array();

// Quick string hack to make sure we get the slide categories with the indents.
$tags_dropdown = str_replace( "<select name='cat' id='cat' class='postform' >", '', $tags_dropdown );
$tags_dropdown = str_replace( '</select>', '', $tags_dropdown );
$tags_split = explode( '</option>', $tags_dropdown );

$tags['all'] = __( 'All', 'woothemes' );

foreach ( $tags_split as $k => $v ) {
	
	$id = '';
	
	// Get the ID value.
	preg_match( '/value="(.*?)"/i', $v, $matches );
	
	if ( isset( $matches[1] ) ) {
	
		$id = $matches[1];
		
		$tags[$id] = trim( strip_tags( $v ) );
	
	}
	
} // End FOREACH Loop

$woo_slide_categories = $tags;

// Setup an array of pages for a dropdown.
$args = array( 'echo' => 0 );
$pages_dropdown = wp_dropdown_pages( $args );
$pages = array();

// Quick string hack to make sure we get the pages with the indents.
$pages_dropdown = str_replace( '<select name="page_id" id="page_id">', '', $pages_dropdown );
$pages_dropdown = str_replace( '</select>', '', $pages_dropdown );
$pages_split = explode( '</option>', $pages_dropdown );

$pages[] = __( 'Select a Page:', 'woothemes' );

foreach ( $pages_split as $k => $v ) {
	
	$id = '';
	
	// Get the ID value.
	preg_match( '/value="(.*?)"/i', $v, $matches );
	
	if ( isset( $matches[1] ) ) {
		
		$id = $matches[1];
		
		$pages[$id] = trim( strip_tags( $v ) );
	
	}
	
} // End FOREACH Loop

// Setup an array of numbers.
$numbers = array();
for ( $i = 1; $i <= 20; $i++ ) {
	$numbers[] = $i;
}

// THIS IS THE DIFFERENT FIELDS
$options = array();
  
// General

$options[] = array( "name" => __( 'General Settings', 'woothemes' ),
					"type" => "heading",
					"icon" => "general" );

$options[] = array( 'name' => __( 'Quick Start', 'woothemes' ),
    				'type' => 'subheading' );
                
$options[] = array( "name" => __( 'Theme Stylesheet', 'woothemes' ),
					"desc" => __( 'Select your themes alternative color scheme.', 'woothemes' ),
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);

$options[] = array( "name" => __( 'Custom Logo', 'woothemes' ),
					"desc" => __( 'Upload a logo for your theme, or specify an image URL directly.', 'woothemes' ),
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload" );    
                                                                                     
$options[] = array( "name" => __( 'Text Title', 'woothemes' ),
					"desc" => sprintf( __( 'Enable text-based Site Title and Tagline. Setup title & tagline in %1$s.', 'woothemes' ), '<a href="' . home_url() . '/wp-admin/options-general.php">' . __( 'General Settings', 'woothemes' ) . '</a>' ),
					"id" => $shortname."_texttitle",
					"std" => "false",
					"class" => "collapsed",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'Site Title', 'woothemes' ),
					"desc" => __( 'Change the site title typography.', 'woothemes' ),
					"id" => $shortname."_font_site_title",
					"std" => array( 'size' => '70','unit' => 'px','face' => 'StMarie-Thin','style' => 'normal','color' => '#3E3E3E'),
					"class" => "hidden",
					"type" => "typography" );  

$options[] = array( "name" => __( 'Site Description', 'woothemes' ),
					"desc" => __( 'Enable the site description/tagline under site title.', 'woothemes' ),
					"id" => $shortname."_tagline",
					"class" => "hidden",
					"std" => "false",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'Site Description', 'woothemes' ),
					"desc" => __( 'Change the site description typography.', 'woothemes' ),
					"id" => $shortname."_font_tagline",
					"std" => array( 'size' => '26','unit' => 'px','face' => 'BergamoStd-Italic','style' => 'italic','color' => '#3E3E3E'),
					"class" => "hidden last",
					"type" => "typography" );  
					          
$options[] = array( "name" => __( 'Custom Favicon', 'woothemes' ),
					"desc" => __( 'Upload a 16px x 16px <a href="http://www.faviconr.com/">ico image</a> that will represent your website\'s favicon.', 'woothemes' ),
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload" ); 
                                               
$options[] = array( "name" => __( 'Tracking Code', 'woothemes' ),
					"desc" => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'woothemes' ),
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea" );        

$options[] = array( 'name' => __( 'Subscription Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'RSS URL', 'woothemes' ),
					"desc" => __( 'Enter your preferred RSS URL. (Feedburner or other)', 'woothemes' ),
					"id" => $shortname."_feed_url",
					"std" => "",
					"type" => "text" );
                    
$options[] = array( "name" => __( 'E-Mail Subscription URL', 'woothemes' ),
					"desc" => __( 'Enter your preferred E-mail subscription URL. (Feedburner or other)', 'woothemes' ),
					"id" => $shortname."_subscribe_email",
					"std" => "",
					"type" => "text" );

$options[] = array( "name" => __( 'Contact Form E-Mail', 'woothemes' ),
					"desc" => __( 'Enter your E-mail address to use on the Contact Form Page Template. Add the contact form by adding a new page and selecting "Contact Form" as page template.', 'woothemes' ),
					"id" => $shortname."_contactform_email",
					"std" => "",
					"type" => "text" );

$options[] = array( 'name' => __( 'Display Options', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Custom CSS', 'woothemes' ),
                    "desc" => __( 'Quickly add some CSS to your theme by adding it to this block.', 'woothemes' ),
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea" );

$options[] = array( "name" => __( 'Post/Page Comments', 'woothemes' ),
					"desc" => __( 'Select if you want to enable/disable comments on posts and/or pages.', 'woothemes' ),
					"id" => $shortname."_comments",
					"std" => "both",
					"type" => "select2",
					"options" => array( "post" => __( 'Posts Only', 'woothemes' ), "page" => __( 'Pages Only', 'woothemes' ), "both" => __( 'Pages / Posts', 'woothemes' ), "none" => __( 'None', 'woothemes' ) ) );                                                          
    
$options[] = array( "name" => __( 'Post Content', 'woothemes' ),
					"desc" => __( 'Select if you want to show the full content or the excerpt on posts.', 'woothemes' ),
					"id" => $shortname."_post_content",
					"type" => "select2",
					"options" => array( "excerpt" => __( 'The Excerpt', 'woothemes' ), "content" => __( 'Full Content', 'woothemes' ) ) );                                                          

$options[] = array( "name" => __( 'Post Author Box', 'woothemes' ),
					"desc" => sprintf( __( 'This will enable the post author box on the single posts page. Edit description in %1$s.', 'woothemes' ), '<a href="' . home_url() . '/wp-admin/profile.php">' . __( 'Profile', 'woothemes' ) . '</a>' ),
					"id" => $shortname."_post_author",
					"std" => "true",
					"type" => "checkbox" );
					
$options[] = array( "name" => __( 'Display Breadcrumbs', 'woothemes' ),
					"desc" => __( 'Display dynamic breadcrumbs on each page of your website.', 'woothemes' ),
					"id" => $shortname."_breadcrumbs_show",
					"std" => "false",
					"type" => "checkbox" );
				
$options[] = array( "name" => __( 'Pagination Style', 'woothemes' ),
					"desc" => __( 'Select the style of pagination you would like to use on the blog.', 'woothemes' ),
					"id" => $shortname."_pagination_type",
					"type" => "select2",
					"options" => array( "paginated_links" => __( 'Numbers', 'woothemes' ), "simple" => __( 'Next/Previous', 'woothemes' ) ) );
					
$options[] = array( "name" => __( 'Exclude specific categories from the homepage', 'woothemes' ),
					"desc" => __( 'Specify either the IDs or slugs, separated by commas, that you\'d like to have excluded from your homepage (eg: uncategorized).', 'woothemes' ),
					"id" => $shortname."_exclude_cats_home",
					"std" => "",
					"type" => "text" );
					
$options[] = array( "name" => __( 'Exclude specific categories from the "Blog" page template', 'woothemes' ),
					"desc" => __( 'Specify either the IDs or slugs, separated by commas, that you\'d like to have excluded from your "Blog" page template (eg: uncategorized).', 'woothemes' ),
					"id" => $shortname."_exclude_cats_blog",
					"std" => "",
					"type" => "text" );
					
// Styling 

$options[] = array( "name" => __( 'Styling', 'woothemes' ),
					"type" => "heading",
					"icon" => "styling" );

$options[] = array( 'name' => __( 'Background', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Body Background Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for background color of the theme e.g. #697e09', 'woothemes' ),
					"id" => "woo_body_color",
					"std" => "",
					"type" => "color" );
					
$options[] = array( "name" => __( 'Body background image', 'woothemes' ),
					"desc" => __( 'Upload an image for the theme\'s background', 'woothemes' ),
					"id" => $shortname."_body_img",
					"std" => "",
					"type" => "upload" );
					
$options[] = array( "name" => __( 'Background image repeat', 'woothemes' ),
                    "desc" => __( 'Select how you would like to repeat the background-image', 'woothemes' ),
                    "id" => $shortname."_body_repeat",
                    "std" => "no-repeat",
                    "type" => "select",
                    "options" => array( "no-repeat","repeat-x","repeat-y","repeat"));

$options[] = array( "name" => __( 'Background image position', 'woothemes' ),
                    "desc" => __( 'Select how you would like to position the background', 'woothemes' ),
                    "id" => $shortname."_body_pos",
                    "std" => "top",
                    "type" => "select",
                    "options" => array( "top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right"));

$options[] = array( 'name' => __( 'Links', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Link Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for links or add a hex color code e.g. #697e09', 'woothemes' ),
					"id" => "woo_link_color",
					"std" => "",
					"type" => "color" );   

$options[] = array( "name" =>  __( 'Link Hover Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for links hover or add a hex color code e.g. #697e09', 'woothemes' ),
					"id" => "woo_link_hover_color",
					"std" => "",
					"type" => "color" );                    

$options[] = array( "name" =>  __( 'Button Color', 'woothemes' ),
					"desc" => __( 'Pick a custom color for buttons or add a hex color code e.g. #697e09', 'woothemes' ),
					"id" => "woo_button_color",
					"std" => "",
					"type" => "color" );         

$options[] = array( 'name' => __( 'Filagree', 'woothemes' ),
    				'type' => 'subheading' );
                                                                                     
$options[] = array( "name" => __( 'Filagree', 'woothemes' ),
					"desc" => __( 'Enable the filagree design element on line breaks.', 'woothemes' ),
					"id" => $shortname."_filagree",
					"std" => "true",
					"type" => "checkbox" );
					
$options[] = array( "name" => __( 'Custom Filagree', 'woothemes' ),
					"desc" => __( 'Upload a custom filagree image.', 'woothemes' ),
					"id" => $shortname."_filagree_image",
					"std" => "",
					"type" => "upload" );    

/* Typography */	
				
$options[] = array( "name" => __( 'Typography', 'woothemes' ),
					"type" => "heading",
					"icon" => "typography" );   

$options[] = array( "name" => __( 'Enable Custom Typography', 'woothemes' ) ,
					"desc" => __( 'Enable the use of custom typography for your site. Custom styling will be output in your sites HEAD.', 'woothemes' ) ,
					"id" => $shortname."_typography",
					"std" => "false",
					"type" => "checkbox" ); 									   

$options[] = array( "name" => __( 'General Typography', 'woothemes' ) ,
					"desc" => __( 'Change the general font.', 'woothemes' ) ,
					"id" => $shortname."_font_body",
					"std" => array( 'size' => '12','unit' => 'px','face' => 'FontSiteSans-Roman','style' => '','color' => '#3E3E3E'),
					"type" => "typography" );  

$options[] = array( "name" => __( 'Navigation', 'woothemes' ) ,
					"desc" => __( 'Change the navigation font.', 'woothemes' ),
					"id" => $shortname."_font_nav",
					"std" => array( 'size' => '18','unit' => 'px','face' => 'FontSiteSans-Cond','style' => '','color' => '#3E3E3E'),
					"type" => "typography" );  

$options[] = array( "name" => __( 'Post Title', 'woothemes' ) ,
					"desc" => __( 'Change the post title.', 'woothemes' ) ,
					"id" => $shortname."_font_post_title",
					"std" => array( 'size' => '21','unit' => 'px','face' => 'BergamoStd','style' => 'bold','color' => '#3E3E3E'),
					"type" => "typography" );  

$options[] = array( "name" => __( 'Post Meta', 'woothemes' ),
					"desc" => __( 'Change the post meta.', 'woothemes' ) ,
					"id" => $shortname."_font_post_meta",
					"std" => array( 'size' => '16','unit' => 'px','face' => 'BergamoStd','style' => '','color' => '#3E3E3E'),
					"type" => "typography" );  
					          
$options[] = array( "name" => __( 'Post Entry', 'woothemes' ) ,
					"desc" => __( 'Change the post entry.', 'woothemes' ) ,
					"id" => $shortname."_font_post_entry",
					"std" => array( 'size' => '18','unit' => 'px','face' => 'BergamoStd','style' => '','color' => '#3E3E3E'),
					"type" => "typography" );  

$options[] = array( "name" => __( 'Widget Titles', 'woothemes' ) ,
					"desc" => __( 'Change the widget titles.', 'woothemes' ) ,
					"id" => $shortname."_font_widget_titles",
					"std" => array( 'size' => '18','unit' => 'px','face' => 'FontSiteSans-Cond','style' => 'bold','color' => '#3E3E3E'),
					"type" => "typography" );
					
$options[] = array( "name" => __( 'Component Titles', 'woothemes' ),
					"desc" => __( 'Change the titles of the homepage components.', 'woothemes' ),
					"id" => $shortname . '_font_component_titles',
					"std" => array( 'size' => '24','unit' => 'px','face' => 'BergamoStd-Italic','style' => 'normal','color' => '#3E3E3E'),
					"type" => "typography" );  

/* Layout */ 

$options[] = array( "name" => __( 'Layout', 'woothemes' ),
					"type" => "heading",
					"icon" => "layout" );   

$options[] = array( "name" => __( 'Layout Styles', 'woothemes' ),
					"desc" => "",
					"id" => $shortname."_layoutstyle_notice",
					"std" => sprintf( __( 'Custom layouts can be created using the %s screen. These layouts override the layout selected here.' , 'woothemes' ), '<a href="#">' . __( 'Widgets', 'woothemes' ) . '</a>' ),
					"type" => "info");

$options[] = array( "name" => __( 'Layout Style', 'woothemes' ),
					"desc" => __( 'Choose a layout style for use on your homepage.', 'woothemes' ),
					"id" => $shortname."_layoutstyle",
					"type" => "select2",
					"std" => 'business', 
					"options" => array( 'birth' => __( 'Birth', 'woothemes' ), 'graduate' => __( 'Graduate', 'woothemes' ), 'business' => __( 'Business', 'woothemes' ), 'wedding' => __( 'Wedding', 'woothemes' ) ) );
					 					                   
$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( "name" => __( 'Main Layout', 'woothemes' ),
					"desc" => __( 'Select which layout you want for your site.', 'woothemes' ),
					"id" => $shortname."_site_layout",
					"std" => "layout-left-content",
					"type" => "images",
					"options" => array(
						'layout-left-content' => $url . '2cl.png',
						'layout-right-content' => $url . '2cr.png')
					);

$options[] = array( "name" => __( 'Homepage', 'woothemes' ),
					"icon" => 'homepage',
					"type" => 'heading' );

/* Module: Slider */
					
$options[] = array( "name" => __( 'Photograph Slider', 'woothemes' ),
					"icon" => "slider",
					"type" => "subheading");

$options[] = array(    "name" => __( 'Visible Slider Entries', 'woothemes' ),
                    "desc" => __( 'Select the number of entries that should be visible at a single time.', 'woothemes' ),
                    "id" => $shortname."_slider_visibleentries",
                    "std" => "3",
                    "type" => "select",
                    "options" => array( '1', '2', '3', '4' ) );

$options[] = array(    "name" => __( 'Animation Speed', 'woothemes' ),
                    "desc" => __( 'The time in <b>seconds</b> the animation between frames will take.', 'woothemes' ),
                    "id" => $shortname."_slider_speed",
                    "std" => "0.6",
					"type" => "select",
					"options" => array( '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0' ) );

$options[] = array(    "name" => __( 'Auto Start', 'woothemes' ),
                    "desc" => __( 'Set the slider to start sliding automatically.', 'woothemes' ),
                    "id" => $shortname."_slider_auto",
                    "std" => "false",
                    "type" => "checkbox");   
                    
$options[] = array(    "name" => __( 'Auto Slide Interval', 'woothemes' ),
                    "desc" => __( 'The time in <b>seconds</b> each slide pauses for, before sliding to the next.', 'woothemes' ),
                    "id" => $shortname."_slider_interval",
                    "std" => "4",
					"type" => "select",
					"options" => array( '1', '2', '3', '4', '5', '6', '7', '8', '9', '10' ) );

$options[] = array(    "name" => __( 'Slide Category to Display', 'woothemes' ),
                    "desc" => __( 'Select the category of slides you\'d like to display.', 'woothemes' ),
                    "id" => $shortname."_slider_slide-category",
                    "std" => '0',
                    "type" => "select2", 
                    "options" => $woo_slide_categories );
                    
$options[] = array(    "name" => __( 'Slide Scrolling', 'woothemes' ),
                    "desc" => __( 'Should the slide scroll in a circular, carousel-like fashion, or should it jump back to the start/end when reaching either side?', 'woothemes' ),
                    "id" => $shortname."_slider_scrolling",
                    "std" => "circular",
					"type" => "select2",
					"options" => array( 'circular' => __( 'Circular', 'woothemes' ), 'both' => __( 'Jump to start/end', 'woothemes' ) ) );
					
$options[] = array( "name" => __( 'Slide Link', 'woothemes' ),
					"desc" => __( 'Select if you want the slides to link to the image (lightbox) or the post', 'woothemes' ),
					"id" => $shortname."_slide_link",
					"std" => "image",
					"type" => "select2",
					"options" => array('image' => __( 'Image', 'woothemes' ), 'post' => __( 'Post', 'woothemes' )));                                                          


/* Module: Registry/Links */

$options[] = array( "name" => __( 'Registry / Links', 'woothemes' ),
					"icon" => "links",
					"type" => "subheading");

global $wp_version;
$active_plugins = get_option( 'active_plugins' );
if ( version_compare( $wp_version, '3.5', '>=' ) && ! in_array( 'link-manager/link-manager.php', (array)$active_plugins ) ) {
	$options[] = array( "name" => __( 'Managing Registry / Links', 'woothemes' ),
					"desc" => '',
					"id" => $shortname . '_links_notice',
					"std" => sprintf( __( 'Since WordPress version 3.5, the "Links" feature has been removed. Please install the %sLink Manager%s plugin to manage your registry / links.', 'woothemes' ), '<a href="' . esc_url( 'http://wordpress.org/extend/plugins/link-manager/' ) . '"><strong>', '</strong></a>' ),
					"type" => "info");
}

$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the links grid.', 'woothemes' ),
                    "id" => $shortname."_links_title",
                    "std" => '',
                    "type" => "text");

$options[] = array(    "name" => __( 'Maximum number of Links', 'woothemes' ),
                    "desc" => __( 'The maximum number of links to display.', 'woothemes' ),
                    "id" => $shortname."_links_number",
                    "std" => "5",
                    "type" => "text");

$link_categories = array( 'all' => __( 'All', 'woothemes' ) );
$terms = get_terms( 'link_category' );
if ( count( $terms ) ) {
	foreach ( $terms as $t ) { $link_categories[$t->term_id] = $t->name; }
}

$options[] = array(    "name" => __( 'Link Category', 'woothemes' ),
                    "desc" => __( 'Optionally select a link category from which to display items.', 'woothemes' ),
                    "id" => $shortname."_links_category",
                    "std" => "all",
                    "type" => "select2",
                    "options" => $link_categories );
                   
$options[] = array(    "name" => __( 'Order Links By', 'woothemes' ),
                    "desc" => __( 'Select which information to use when ordering the links.', 'woothemes' ),
                    "id" => $shortname."_links_orderby",
                    "std" => "name",
                    "type" => "select2",
                    "options" => array(
                    					'id' => __( 'ID value', 'woothemes' ), 
                    					'url' => __( 'URL', 'woothemes' ), 
                    					'name' => __( 'Name', 'woothemes' ), 
                    					'updated' => __( 'Last Updated', 'woothemes' ), 
                    					'length' => __( 'Length of the name', 'woothemes' ), 
                    					'rand' => __( 'Random', 'woothemes' )
                    					)
                  );
                  
$options[] = array(    "name" => __( 'Order Direction', 'woothemes' ),
                    "desc" => __( 'Select which direction to use when ordering the links.', 'woothemes' ),
                    "id" => $shortname."_links_order",
                    "std" => "ASC",
                    "type" => "select2",
                    "options" => array(
                    					'ASC' => __( 'Ascending', 'woothemes' ), 
                    					'DESC' => __( 'Descending', 'woothemes' )
                    					)
                  );
                  
$options[] = array(    "name" => __( 'Include Links', 'woothemes' ),
                    "desc" => __( 'Optionally explicitly include specific links that must be displayed. Place their ID values here, separated by commas.', 'woothemes' ),
                    "id" => $shortname."_links_include",
                    "std" => "",
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Exclude Links', 'woothemes' ),
                    "desc" => __( 'Optionally explicitly exclude specific links that must not be displayed. Place their ID values here, separated by commas.', 'woothemes' ),
                    "id" => $shortname."_links_exclude",
                    "std" => "",
                    "type" => "text");

/* Module: Countdown */
					
$options[] = array( "name" => __( 'Countdown', 'woothemes' ),
					"icon" => "layout",
					"type" => "subheading");

$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the countdown.', 'woothemes' ),
                    "id" => $shortname."_countdown_title",
                    "std" => __( 'Countdown', 'woothemes' ),
                    "type" => "text");

$options[] = array( "name" => __( 'Deadline Date', 'woothemes' ),
					"desc" => __( 'Select the date to which the countdown is working towards.', 'woothemes' ),
					"id" => $shortname."_countdown_date",
					"std" => date( 'm/d/Y', time()+86400 ),
					"type" => "calendar" );
					
$options[] = array( "name" => __( 'Deadline Time', 'woothemes' ),
					"desc" => __( 'Select the time on "Deadline Date" to which the countdown is working towards (eg: 20:30).', 'woothemes' ),
					"id" => $shortname."_countdown_time",
					"std" => '00:00',
					"type" => "text" );
					
/* Module: Baby Statistics */
					
$options[] = array( "name" => __( 'Baby Statistics', 'woothemes' ),
					"icon" => "smiley",
					"type" => "subheading");

$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the baby statistics.', 'woothemes' ),
                    "id" => $shortname."_babystats_title",
                    "std" => __( 'The Stats & Story', 'woothemes' ),
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Pounds', 'woothemes' ),
                    "desc" => __( 'How many pounds did your baby weigh at birth?', 'woothemes' ),
                    "id" => $shortname."_babystats_pounds",
                    "std" => __( '1', 'woothemes' ),
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Inches', 'woothemes' ),
                    "desc" => __( 'How many inches tall was your baby at birth?', 'woothemes' ),
                    "id" => $shortname."_babystats_inches",
                    "std" => __( '1', 'woothemes' ),
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Eye Color', 'woothemes' ),
                    "desc" => __( 'Select your baby\'s eye color.', 'woothemes' ),
                    "id" => $shortname."_babystats_eyecolor",
                    "std" => __( '', 'woothemes' ),
                    "type" => "color");
                    
$options[] = array(    "name" => __( 'Hair Color', 'woothemes' ),
                    "desc" => __( 'Select your baby\'s hair color.', 'woothemes' ),
                    "id" => $shortname."_babystats_haircolor",
                    "std" => __( '', 'woothemes' ),
                    "type" => "color");
                    
$options[] = array(    "name" => __( 'About Page', 'woothemes' ),
                    "desc" => __( 'Select the page that tells more about your baby.', 'woothemes' ),
                    "id" => $shortname."_babystats_aboutpage",
                    "std" => '',
                    "type" => "select2", 
                    "options" => $pages );

$options[] = array(    "name" => __( 'Hide Page Title', 'woothemes' ),
                    "desc" => __( 'Optionally hide the page title in the About page.', 'woothemes' ),
                    "id" => $shortname."_babystats_hidetitle",
                    "std" => "false",
                    "type" => "checkbox"); 
                   
/* Modules: Page Content & Comments */
					
$options[] = array( "name" => __( 'Content & Comments', 'woothemes' ),
					"icon" => "main",
					"type" => "subheading");

$options[] = array(    "name" => __( 'Page to Display', 'woothemes' ),
                    "desc" => __( 'Select the page you\'d like to display the content from.<br /><br /><strong>NOTE:</strong> This page is also the page to which comments from the "Comments" component will be assigned to.', 'woothemes' ),
                    "id" => $shortname."_pagecontent_page",
                    "std" => '0',
                    "type" => "select2", 
                    "options" => $pages );

$options[] = array(    "name" => __( 'Hide Page Title', 'woothemes' ),
                    "desc" => __( 'Optionally hide the page title in the "Page Content" component.', 'woothemes' ),
                    "id" => $shortname."_pagecontent_hidetitle",
                    "std" => "false",
                    "type" => "checkbox"); 
                    
$options[] = array(    "name" => __( 'Comments Title', 'woothemes' ),
                    "desc" => __( 'Optionally hide the page title in the "Page Content" component.', 'woothemes' ),
                    "id" => $shortname."_pagecontent_commentstitle",
                    "std" => __( 'Comments', 'woothemes' ),
                    "type" => "text");
                    
$options[] = array( "name" => "Hide Comment Avatars",
					"desc" => "Optionally hide the avatar image in your theme comments.",
					"id" => $shortname."_comments_hideavatar",
					"std" => "true",
					"type" => "checkbox" );

 
/* Modules: Occassion Details */
					
$options[] = array( "name" => __( 'Occassion Details', 'woothemes' ),
					"icon" => "main",
					"type" => "subheading");

$options[] = array(    "name" => __( 'Page to Display', 'woothemes' ),
                    "desc" => __( 'Select the page you\'d like to display the content from.', 'woothemes' ),
                    "id" => $shortname."_occassiondetails_page",
                    "std" => '0',
                    "type" => "select2", 
                    "options" => $pages );
                    
/* Modules: Blog */
					
$options[] = array( "name" => __( 'Blog', 'woothemes' ),
					"icon" => "post",
					"type" => "subheading");
                    
$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the blog section.', 'woothemes' ),
                    "id" => $shortname."_blog_title",
                    "std" => __( 'Blog', 'woothemes' ),
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Blog entries to display', 'woothemes' ),
                    "desc" => __( 'Select the number of entries to display in the blog component..', 'woothemes' ),
                    "id" => $shortname."_blog_entries",
                    "std" => "5",
                    "type" => "select",
                    "options" => $numbers );
                    
/* Modules: Headline */
					
$options[] = array( "name" => __( 'Headline', 'woothemes' ),
					"icon" => "header",
					"type" => "subheading");
                    
$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the headline text.', 'woothemes' ),
                    "id" => $shortname."_headline_title",
                    "std" => '',
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Headline Text', 'woothemes' ),
                    "desc" => __( 'Add headline text.', 'woothemes' ),
                    "id" => $shortname."_headline_text",
                    "std" => '',
                    "type" => "text");
                    
/* Modules: Occassion Hosts */
					
$options[] = array( "name" => __( 'Occassion Hosts', 'woothemes' ),
					"icon" => "profile",
					"type" => "subheading");
                    
$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the hosts text.', 'woothemes' ),
                    "id" => $shortname."_occassionhosts_title",
                    "std" => '',
                    "type" => "text");
                    
$options[] = array(    "name" => __( 'Hosts', 'woothemes' ),
                    "desc" => __( 'Add the names of the hosts of the occassion, each separated by commas (for example: John, Jane).', 'woothemes' ),
                    "id" => $shortname."_occassionhosts_text",
                    "std" => '',
                    "type" => "text");
                    
/* Modules: Video Embed */
					
$options[] = array( "name" => __( 'Video Embed', 'woothemes' ),
					"icon" => "media",
					"type" => "subheading");
                    
$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the embedded videos.', 'woothemes' ),
                    "id" => $shortname."_embed_title",
                    "std" => 'Sneak Peak Video',
                    "type" => "text");

$options[] = array( "name" => __( 'Video Embed Dimensions', 'woothemes' ),
					"desc" => __( 'Enter an integer value i.e. 250 for the image size. Max width is 576.', 'woothemes' ),
					"id" => $shortname."_embed_dimensions",
					"std" => "",
					"class" => "",
					"type" => array( 
									array(  'id' => $shortname. '_embed_width',
											'type' => 'text',
											'std' => 560,
											'meta' => __( 'Width', 'woothemes' ) ),
									array(  'id' => $shortname. '_embed_height',
											'type' => 'text',
											'std' => 315,
											'meta' => __( 'Height', 'woothemes' ) )
								  ));

$options[] = array(    "name" => __( 'Category', 'woothemes' ),
                    "desc" => __( 'Optionally select a category from which to display videos.', 'woothemes' ),
                    "id" => $shortname."_embed_category",
                    "std" => "all",
                    "type" => "select2",
                    "options" => $woo_categories );
                    
$options[] = array(    "name" => __( 'Tag', 'woothemes' ),
                    "desc" => __( 'Optionally select a post tag from which to display videos.', 'woothemes' ),
                    "id" => $shortname."_embed_tag",
                    "std" => "all",
                    "type" => "select2",
                    "options" => $woo_tags ); 

/* Dynamic Images */
$options[] = array( "name" => __( 'Dynamic Images', 'woothemes' ),
					"type" => "heading",
					"icon" => "image" );    

$options[] = array( 'name' => __( 'Resizer Settings', 'woothemes' ),
    				'type' => 'subheading' );
				    				   
$options[] = array( "name" => __( 'Dynamic Image Resizing', 'woothemes' ),
					"desc" => "",
					"id" => $shortname."_wpthumb_notice",
					"std" => __( 'There are two alternative methods of dynamically resizing the thumbnails in the theme, <strong>WP Post Thumbnail</strong> or <strong>TimThumb - Custom Settings panel</strong>. We recommend using WP Post Thumbnail option.', 'woothemes' ),
					"type" => "info");					

$options[] = array( "name" => __( 'WP Post Thumbnail', 'woothemes' ),
					"desc" => __( 'Use WordPress post thumbnail to assign a post thumbnail. Will enable the <strong>Featured Image panel</strong> in your post sidebar where you can assign a post thumbnail.', 'woothemes' ),
					"id" => $shortname."_post_image_support",
					"std" => "true",
					"class" => "collapsed",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'WP Post Thumbnail - Dynamic Image Resizing', 'woothemes' ),
					"desc" => __( 'The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>', 'woothemes' ),
					"id" => $shortname."_pis_resize",
					"std" => "true",
					"class" => "hidden",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'WP Post Thumbnail - Hard Crop', 'woothemes' ),
					"desc" => __( 'The post thumbnail will be cropped to match the target aspect ratio (only used if "Dynamic Image Resizing" is enabled).', 'woothemes' ),
					"id" => $shortname."_pis_hard_crop",
					"std" => "true",
					"class" => "hidden last",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'TimThumb - Custom Settings Panel', 'woothemes' ),
					"desc" => sprintf( __( 'This will enable the %1$s (thumb.php) script which dynamically resizes images added through the <strong>custom settings panel below the post</strong>. Make sure your themes <em>cache</em> folder is writable. %2$s', 'woothemes' ), '<a href="http://code.google.com/p/timthumb/">TimThumb</a>', '<a href="http://www.woothemes.com/2008/10/troubleshooting-image-resizer-thumbphp/">Need help?</a>' ),
					"id" => $shortname."_resize",
					"std" => "true",
					"type" => "checkbox" );

$options[] = array( "name" => __( 'Automatic Image Thumbnail', 'woothemes' ),
					"desc" => __( 'If no thumbnail is specifified then the first uploaded image in the post is used.', 'woothemes' ),
					"id" => $shortname."_auto_img",
					"std" => "false",
					"type" => "checkbox" );

$options[] = array( 'name' => __( 'Thumbnail Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Thumbnail Image Dimensions', 'woothemes' ),
					"desc" => __( 'Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.', 'woothemes' ),
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_thumb_w',
											'type' => 'text',
											'std' => 100,
											'meta' => __( 'Width', 'woothemes' ) ),
									array(  'id' => $shortname. '_thumb_h',
											'type' => 'text',
											'std' => 100,
											'meta' => __( 'Height', 'woothemes' ) )
								  ));
                                                                                                
$options[] = array( "name" => __( 'Thumbnail Image alignment', 'woothemes' ),
					"desc" => __( 'Select how to align your thumbnails with posts.', 'woothemes' ),
					"id" => $shortname."_thumb_align",
					"std" => "alignright",
					"type" => "radio",
					"options" => array( "alignleft" => __( 'Left', 'woothemes' ), "alignright" => __( 'Right', 'woothemes' ), "aligncenter" => __( 'Center', 'woothemes' ) )); 

$options[] = array( "name" => __( 'Show thumbnail in Single Posts', 'woothemes' ),
					"desc" => __( 'Show the attached image in the single post page.', 'woothemes' ),
					"id" => $shortname."_thumb_single",
					"class" => "collapsed",
					"std" => "false",
					"type" => "checkbox" );    

$options[] = array( "name" => __( 'Single Image Dimensions', 'woothemes' ),
					"desc" => __( '"Enter an integer value i.e. 250 for the image size. Max width is 576.', 'woothemes' ),
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"class" => "hidden last",
					"type" => array( 
									array(  'id' => $shortname. '_single_w',
											'type' => 'text',
											'std' => 200,
											'meta' => __( 'Width', 'woothemes' ) ),
									array(  'id' => $shortname. '_single_h',
											'type' => 'text',
											'std' => 200,
											'meta' => __( 'Height', 'woothemes' ) )
								  ));

$options[] = array( "name" => __( 'Single Post Image alignment', 'woothemes' ),
					"desc" => __( 'Select how to align your thumbnail with single posts.', 'woothemes' ),
					"id" => $shortname."_thumb_single_align",
					"std" => "alignright",
					"type" => "radio",
					"class" => "hidden",
					"options" => array( "alignleft" => __( 'Left', 'woothemes' ), "alignright" => __( 'Right', 'woothemes' ), "aligncenter" => __( 'Center', 'woothemes' ) )); 

$options[] = array( "name" => __( 'Add thumbnail to RSS feed', 'woothemes' ),
					"desc" => __( 'Add the the image uploaded via your Custom Settings to your RSS feed', 'woothemes' ),
					"id" => $shortname."_rss_thumb",
					"std" => "false",
					"type" => "checkbox" );  
					
/* Footer */
$options[] = array( "name" => __( 'Footer Customization', 'woothemes' ),
					"type" => "heading",
					"icon" => "footer" );    
					

$options[] = array(    "name" => __( 'Title', 'woothemes' ),
                    "desc" => __( 'Add a heading for the widgetized footer regions.', 'woothemes' ),
                    "id" => $shortname."_footer_title",
                    "std" => '',
                    "type" => "text");

$options[] = array( "name" => __( 'Enable Footer Widgets on Inner Screens', 'woothemes' ),
					"desc" => __( 'Optionally display the footer widgets on all screens other than the homepage.', 'woothemes' ),
					"id" => $shortname . '_enable_footer_widgets',
					"std" => 'false',
					"type" => 'checkbox' );

$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( "name" => __( 'Footer Widget Areas', 'woothemes' ),
					"desc" => __( 'Select how many footer widget areas you want to display.', 'woothemes' ),
					"id" => $shortname."_footer_sidebars",
					"std" => "4",
					"type" => "images",
					"options" => array(
						'0' => $url . 'layout-off.png',
						'1' => $url . 'footer-widgets-1.png',
						'2' => $url . 'footer-widgets-2.png',
						'3' => $url . 'footer-widgets-3.png',
						'4' => $url . 'footer-widgets-4.png')
					); 		   
										
$options[] = array( "name" => __( 'Custom Affiliate Link', 'woothemes' ),
					"desc" => __( 'Add an affiliate link to the WooThemes logo in the footer of the theme.', 'woothemes' ),
					"id" => $shortname."_footer_aff_link",
					"std" => "",
					"type" => "text" );	
									
$options[] = array( "name" => __( 'Enable Custom Footer (Left)', 'woothemes' ),
					"desc" => __( 'Activate to add the custom text below to the theme footer.', 'woothemes' ),
					"id" => $shortname."_footer_left",
					"std" => "false",
					"type" => "checkbox" );    

$options[] = array( "name" => __( 'Custom Text (Left)', 'woothemes' ),
					"desc" => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'woothemes' ),
					"id" => $shortname."_footer_left_text",
					"std" => "",
					"type" => "textarea" );
						
$options[] = array( "name" => __( 'Enable Custom Footer (Right)', 'woothemes' ),
					"desc" => __( 'Activate to add the custom text below to the theme footer.', 'woothemes' ),
					"id" => $shortname."_footer_right",
					"std" => "false",
					"type" => "checkbox" );    

$options[] = array( "name" => __( 'Custom Text (Right)', 'woothemes' ),
					"desc" => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'woothemes' ),
					"id" => $shortname."_footer_right_text",
					"std" => "",
					"type" => "textarea" );

/* Subscribe & Connect */
$options[] = array( "name" => __( 'Subscribe & Connect', 'woothemes' ),
					"type" => "heading",
					"icon" => "connect" ); 

$options[] = array( 'name' => __( 'Setup', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Enable Subscribe & Connect - Single Post', 'woothemes' ),
					"desc" => sprintf( __( 'Enable the subscribe & connect area on single posts. You can also add this as a %1$s in your sidebar.', 'woothemes' ), '<a href="' . home_url() . '/wp-admin/widgets.php">widget</a>' ),
					"id" => $shortname."_connect",
					"std" => 'false',
					"type" => "checkbox" ); 

$options[] = array( "name" => __( 'Subscribe Title', 'woothemes' ),
					"desc" => __( 'Enter the title to show in your subscribe & connect area.', 'woothemes' ),
					"id" => $shortname."_connect_title",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => __( 'Text', 'woothemes' ),
					"desc" => __( 'Change the default text in this area.', 'woothemes' ),
					"id" => $shortname."_connect_content",
					"std" => '',
					"type" => "textarea" ); 

$options[] = array( "name" => __( 'Enable Related Posts', 'woothemes' ),
					"desc" => __( 'Enable related posts in the subscribe area. Uses posts with the same <strong>tags</strong> to find related posts. Note: Will not show in the Subscribe widget.', 'woothemes' ),
					"id" => $shortname."_connect_related",
					"std" => 'true',
					"type" => "checkbox" );

$options[] = array( 'name' => __( 'Subscribe Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Subscribe By E-mail ID (Feedburner)', 'woothemes' ),
					"desc" => __( 'Enter your <a href="http://www.woothemes.com/tutorials/how-to-find-your-feedburner-id-for-email-subscription/">Feedburner ID</a> for the e-mail subscription form.', 'woothemes' ),
					"id" => $shortname."_connect_newsletter_id",
					"std" => '',
					"type" => "text" ); 					

$options[] = array( "name" => __( 'Subscribe By E-mail to MailChimp', 'woothemes', 'woothemes' ),
					"desc" => __( 'If you have a MailChimp account you can enter the <a href="http://woochimp.heroku.com" target="_blank">MailChimp List Subscribe URL</a> to allow your users to subscribe to a MailChimp List.', 'woothemes' ),
					"id" => $shortname."_connect_mailchimp_list_url",
					"std" => '',
					"type" => "text"); 					

$options[] = array( 'name' => __( 'Connect Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( "name" => __( 'Enable RSS', 'woothemes' ),
					"desc" => __( 'Enable the subscribe and RSS icon.', 'woothemes' ),
					"id" => $shortname."_connect_rss",
					"std" => 'true',
					"type" => "checkbox" ); 

$options[] = array( "name" => __( 'Twitter URL', 'woothemes' ),
					"desc" => __( 'Enter your  <a href="http://www.twitter.com/">Twitter</a> URL e.g. http://www.twitter.com/woothemes', 'woothemes' ),
					"id" => $shortname."_connect_twitter",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => __( 'Facebook URL', 'woothemes' ),
					"desc" => __( 'Enter your  <a href="http://www.facebook.com/">Facebook</a> URL e.g. http://www.facebook.com/woothemes', 'woothemes' ),
					"id" => $shortname."_connect_facebook",
					"std" => '',
					"type" => "text" ); 
					
$options[] = array( "name" => __( 'YouTube URL', 'woothemes' ),
					"desc" => __( 'Enter your  <a href="http://www.youtube.com/">YouTube</a> URL e.g. http://www.youtube.com/woothemes', 'woothemes' ),
					"id" => $shortname."_connect_youtube",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => __( 'Flickr URL', 'woothemes' ),
					"desc" => __( 'Enter your  <a href="http://www.flickr.com/">Flickr</a> URL e.g. http://www.flickr.com/woothemes', 'woothemes' ),
					"id" => $shortname."_connect_flickr",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => __( 'LinkedIn URL', 'woothemes' ),
					"desc" => __( 'Enter your  <a href="http://www.www.linkedin.com.com/">LinkedIn</a> URL e.g. http://www.linkedin.com/in/woothemes', 'woothemes' ),
					"id" => $shortname."_connect_linkedin",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => __( 'Delicious URL', 'woothemes' ),
					"desc" => __( 'Enter your <a href="http://www.delicious.com/">Delicious</a> URL e.g. http://www.delicious.com/woothemes', 'woothemes' ),
					"id" => $shortname."_connect_delicious",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => __( 'Google+ URL', 'woothemes' ),
					"desc" => __( 'Enter your <a href="http://plus.google.com/">Google+</a> URL e.g. https://plus.google.com/104560124403688998123/', 'woothemes' ),
					"id" => $shortname."_connect_googleplus",
					"std" => '',
					"type" => "text" );
						                                              
// Add extra options through function
if ( function_exists( "woo_options_add") )
	$options = woo_options_add($options);

if ( get_option( 'woo_template') != $options) update_option( 'woo_template',$options);      
if ( get_option( 'woo_themename') != $themename) update_option( 'woo_themename',$themename);   
if ( get_option( 'woo_shortname') != $shortname) update_option( 'woo_shortname',$shortname);
if ( get_option( 'woo_manual') != $manualurl) update_option( 'woo_manual',$manualurl);

// Woo Metabox Options
// Start name with underscore to hide custom key from the user
$woo_metaboxes = array();

global $post;

if ( get_post_type() == 'post' || ! get_post_type() ) {

	$woo_metaboxes[] = array (	"name" => "image_heading",
							"label" => "Image/Embed Options",
							"type" => "info",
							"desc" => "" );

	$woo_metaboxes[] = array (	"name" => "image",
								"label" => __( 'Image', 'woothemes' ),
								"type" => "upload",
								"desc" => __( 'Upload an image or enter an URL.', 'woothemes' ) );
	
	if ( get_option( 'woo_resize') == "true" ) {						
		$woo_metaboxes[] = array (	"name" => "_image_alignment",
									"std" => "c",
									"label" => __( 'Image Crop Alignment', 'woothemes' ),
									"type" => "select2",
									"desc" => __( 'Select crop alignment for resized image', 'woothemes' ),
									"options" => array(	"c" => __( 'Center', 'woothemes' ),
														"t" => __( 'Top', 'woothemes' ),
														"b" => __( 'Bottom', 'woothemes' ),
														"l" => __( 'Left', 'woothemes' ),
														"r" => __( 'Right', 'woothemes' ) ) );
	}

	$woo_metaboxes[] = array (  "name"  => "embed",
					            "std"  => "",
					            "label" => __( 'Embed Code', 'woothemes' ),
					            "type" => "textarea",
					            "desc" => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'woothemes' ) );
					            
} // End post

if ( get_post_type() == 'post' || get_post_type() == 'page' || get_post_type() == 'slide' || ! get_post_type() ) {

$woo_metaboxes[] = array (	"name" => "layout_heading",
							"label" => "Layout Options",
							"type" => "info",
							"desc" => "" );

$woo_metaboxes[] = array (	"name" => "_layout",
							"std" => "normal",
							"label" => __( 'Layout', 'woothemes' ),
							"type" => "images",
							"desc" => __( 'Select the layout you want on this specific post/page.', 'woothemes' ),
							"options" => array(
										'layout-default' => $url . 'layout-off.png',
										'layout-full' => get_template_directory_uri() . '/functions/images/' . '1c.png',
										'layout-left-content' => get_template_directory_uri() . '/functions/images/' . '2cl.png',
										'layout-right-content' => get_template_directory_uri() . '/functions/images/' . '2cr.png'));

} // End page

if ( get_post_type() == 'page' || get_post_type() == 'post' || ! get_post_type() ) {
										
/* Column Options */
$woo_metaboxes[] = array (	"name" => "column_heading",
							"label" => "Column Options",
							"type" => "info",
							"desc" => "" );

$woo_metaboxes[] = array (	"name" => "_column_layout",
							"std" => "normal",
							"label" => "Column Layout Style",
							"type" => "images",
							"class" => "collapse",
							"desc" => "Select the post content column layout style you want on this specific post/page.",
							"options" => array(
										'layout-std-full' => get_template_directory_uri() . '/images/' . 'ico-layout-std-full.png',
										'layout-std' => get_template_directory_uri() . '/images/' . 'ico-layout-std.png',
										'layout-3col' => get_template_directory_uri() . '/images/' . 'ico-layout-3col.png', 
										'layout-2colA' => get_template_directory_uri() . '/images/' . 'ico-layout-2colA.png',
										'layout-2colB' => get_template_directory_uri() . '/images/' . 'ico-layout-2colB.png',
										'layout-2colC' => get_template_directory_uri() . '/images/' . 'ico-layout-2colC.png'
										));

$woo_metaboxes[] = array( "label" => "A Note on Column Layout Selection",
					"type" => "info",
					"class" => "collapse last",
					"desc" => "When selecting a column layout option, please be sure to add only the appropriate number of column breaks into the content editor above.<br />For example, if you have selected a two-column layout, only a single column break is required to produce two columns.<br />If you have chosen a three-column layout, two column breaks are required." );

} // End page and post

if( get_post_type() == 'slide' || ! get_post_type() ) {

	$woo_metaboxes[] = array (	"name" => "image_heading",
							"label" => "Image/Embed Options",
							"type" => "info",
							"desc" => "" );

	$woo_metaboxes[] = array (	"name" => "image",
								"label" => __( 'Image', 'woothemes' ),
								"type" => "upload",
								"desc" => __( 'Upload an image to be used as background of this slide. (optional)', 'woothemes' ) );
	
	$woo_metaboxes[] = array (	"name" => "url",
								"label" => __( 'URL', 'woothemes' ),
								"type" => "text",
								"desc" => __( 'Enter URL if you want to add a link to the uploaded image. (optional)', 'woothemes' ) . '<br /><br />' . __( 'Note: When using this field, the image will not be included in the lightbox, as clicking the link will point directly to the custom link you enter in this field.', 'woothemes' ) );
								
} // End slide

// Add extra metaboxes through function
if ( function_exists( 'woo_metaboxes_add' ) )
	$woo_metaboxes = woo_metaboxes_add( $woo_metaboxes );
    
if ( get_option( 'woo_custom_template' ) != $woo_metaboxes ) update_option( 'woo_custom_template', $woo_metaboxes );      

} // END woo_options()
} // END function_exists()

// Add options to admin_head
add_action( 'admin_head','woo_options' );  

//Enable WooSEO on these Post types
$seo_post_types = array( 'post','page' );
define( "SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action( 'init','woo_global_options' );
function woo_global_options(){
	// Populate WooThemes option in array for use in theme
	global $woo_options;
	$woo_options = get_option( 'woo_options' );
}

?>