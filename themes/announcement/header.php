<?php 
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 */
 global $woo_options;
 
 $filagree = get_template_directory_uri() . '/images/filagree.png';
 if ( isset( $woo_options['woo_filagree'] ) && ( $woo_options['woo_filagree'] == 'true' ) ) {
	
	if ( isset( $woo_options['woo_filagree_image'] ) && ( $woo_options['woo_filagree_image'] != '' ) ) { $filagree = $woo_options['woo_filagree_image']; } else {
		$filagree = get_template_directory_uri() . '/images/filagree.png';
	}

 }
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
<?php woo_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php woo_top(); ?>

<div id="wrapper">

	<?php if ( function_exists( 'has_nav_menu') && has_nav_menu( 'top-menu' ) ) { ?>
	
	<div id="top">
		<div class="col-full">
			<?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'top-nav', 'menu_class' => 'nav fl', 'theme_location' => 'top-menu' ) ); ?>
		</div>
	</div><!-- /#top -->
	
    <?php } ?>
           
	<div id="header" class="col-full">
	
 		<div id="filagree"><img src="<?php echo $filagree; ?>" alt="filagree" /></div>  
 		     
		<div id="logo">
	       
	       	<span class="site-description"><?php bloginfo( 'description' ); ?></span>
	       
		<?php if ( isset( $woo_options['woo_texttitle'] ) && $woo_options['woo_texttitle'] != 'true' ) { $logo = $woo_options['woo_logo']; ?>
			<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'description' ); ?>">
				<img src="<?php if ( $logo ) { echo $logo; } else { echo get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
        <?php } ?> 
        
        <?php if( is_singular() && !is_front_page() ) { ?>
			<span class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></span>
        <?php } else { ?>
			<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <?php } ?>
	      	
		</div><!-- /#logo -->
	              
	</div><!-- /#header -->
    
	<div id="navigation" class="col-full">
		<?php
		if ( function_exists( 'has_nav_menu') && has_nav_menu( 'primary-menu') ) {
			wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) );
		} else {
		?>
        <ul id="main-nav" class="nav">
			<?php 
        	if ( isset($woo_options[ 'woo_custom_nav_menu' ]) AND $woo_options[ 'woo_custom_nav_menu' ] == 'true' ) {
        		if ( function_exists( 'woo_custom_navigation_output') )
					woo_custom_navigation_output();
			} else { ?>
	            <?php if ( is_page() ) $highlight = "page_item"; else $highlight = "page_item current_page_item"; ?>
	            <li class="<?php echo $highlight; ?>"><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'woothemes' ) ?></a></li>
	            <?php 
	    			wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); 
			}
			?>
        </ul><!-- /#nav -->
        <?php } ?>
        
	</div><!-- /#navigation -->