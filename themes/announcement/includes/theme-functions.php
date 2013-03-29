<?php

/*-------------------------------------------------------------------------------------

TABLE OF CONTENTS

- Exclude categories from displaying on the "Blog" page template.
- Exclude categories from displaying on the homepage.
- Register WP Menus
- Page navigation
- Post Meta
- Subscribe & Connect
- Comment Form Fields
- Comment Form Settings
- Custom Post Type - Slides
- woo_slides_add_sortable_columns() - Make "menu_order" column in admin sortable.
- woo_slides_add_custom_column_headings() - Add custom column headings for "slide" post type admin.
- woo_slides_add_custom_column_data() - Add custom column data for "slide" post type admin.
- woo_get_slide_dimensions() - Get slider image dimensions based on visible slides.
- woo_setup_link_metabox() - Setup JavaScript for "Link" items admin.
- woo_link_advanced_meta_box() - Advanced settings for "Link" items.
- woo_add_filagree_break() - Add filagree image after each component.
- woo_component_before() - Hook for adding items before components.
- woo_component_after() - Hook for adding items after components.
- Generate dynamic CSS for Baby Stats eye and hair colour.
- Make sure comments form redirects to the correct place.
- Add post/page-specific content classes via a filter on woo_content_class
- woo_section_class()
- Use single-columns.php if a non-standard column layout option is selected
- Modify WooFramework Google Fonts.
- Register custom component widgets.
- WPML Compatibility for Page IDs in Theme Options

-------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Exclude categories from displaying on the "Blog" page template.
/*-----------------------------------------------------------------------------------*/

// Exclude categories on the "Blog" page template.
add_filter( 'woo_blog_template_query_args', 'woo_exclude_categories_blogtemplate' );

function woo_exclude_categories_blogtemplate ( $args ) {
	
	if ( ! function_exists( 'woo_prepare_category_ids_from_option' ) ) { return $args; }
	
	$excluded_cats = array();
	
	// Process the category data and convert all categories to IDs.
	$excluded_cats = woo_prepare_category_ids_from_option( 'woo_exclude_cats_blog' );
	
	// Homepage logic.
	if ( count( $excluded_cats ) > 0 ) {
		
		// Setup the categories as a string, because "category__not_in" doesn't seem to work
		// when using query_posts().
		
		foreach ( $excluded_cats as $k => $v ) { $excluded_cats[$k] = '-' . $v; }
		$cats = join( ',', $excluded_cats );
	
		$args['cat'] = $cats;
	}
	
	return $args;

} // End woo_exclude_categories_blogtemplate()

/*-----------------------------------------------------------------------------------*/
/* Exclude categories from displaying on the homepage.
/*-----------------------------------------------------------------------------------*/

// Exclude categories on the homepage.
add_filter( 'pre_get_posts', 'woo_exclude_categories_homepage' );

function woo_exclude_categories_homepage ( $query ) {

	if ( ! function_exists( 'woo_prepare_category_ids_from_option' ) ) { return $query; }

	$excluded_cats = array();
	
	// Process the category data and convert all categories to IDs.
	$excluded_cats = woo_prepare_category_ids_from_option( 'woo_exclude_cats_home' );
	
	// Homepage logic.
	if ( is_home() && ( count( $excluded_cats ) > 0 ) ) {
		$query->set( 'category__not_in', $excluded_cats );
	}
	
	$query->parse_query();
	
	return $query;

} // End woo_exclude_categories_homepage()

/*-----------------------------------------------------------------------------------*/
/* Register WP Menus */
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
	register_nav_menus( array( 'primary-menu' => __( 'Primary Menu', 'woothemes' ) ) );
	register_nav_menus( array( 'top-menu' => __( 'Top Menu', 'woothemes' ) ) );
}


/*-----------------------------------------------------------------------------------*/
/* Page navigation */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'woo_pagenav')) {
	function woo_pagenav() {

		global $woo_options;

		// If the user has set the option to use simple paging links, display those. By default, display the pagination.
		if ( array_key_exists( 'woo_pagination_type', $woo_options ) && $woo_options[ 'woo_pagination_type' ] == 'simple' ) {
			if ( get_next_posts_link() || get_previous_posts_link() ) {
		?>
            <div class="nav-entries">
                <?php next_posts_link( '<span class="nav-prev fl">'. __( '<span class="meta-nav">&larr;</span> Older posts', 'woothemes' ) . '</span>' ); ?>
                <?php previous_posts_link( '<span class="nav-next fr">'. __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'woothemes' ) . '</span>' ); ?>
                <div class="fix"></div>
            </div>
		<?php
			}
		} else {
			woo_pagination();

		} // End IF Statement

	} // End woo_pagenav()
} // End IF Statement

/*-----------------------------------------------------------------------------------*/
/* WooTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'woo_tabs_popular')) {
	function woo_tabs_popular( $posts = 5, $size = 45 ) {
		global $post;
		$popular = get_posts( 'ignore_sticky_posts=1&orderby=comment_count&showposts='.$posts);
		foreach($popular as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) woo_image( 'height='.$size.'&width='.$size.'&class=thumbnail&single=true' ); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Post Meta */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'woo_post_meta')) {
	function woo_post_meta() {
?>
<p class="post-meta">
    <span class="post-date"><span class="small"><?php _e( 'on', 'woothemes' ) ?></span> <?php the_time( get_option( 'date_format' ) ); ?></span>
    <span class="post-author"><span class="small"><?php _e( 'by', 'woothemes' ) ?></span> <?php the_author_posts_link(); ?></span>
    <span class="post-category"> <?php the_category( ', ') ?></span>
    <span class="post-comments"><?php comments_popup_link( __( 'Leave a comment', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?></span>
    <?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
</p>
<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Post More */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'woo_post_more')) {
	function woo_post_more() {
	global $woo_options;
?>
<div class="post-more">      
    <?php if ( $woo_options[ 'woo_post_content' ] == "excerpt" ) { ?>
    <span class="read-more"><a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Continue Reading &rarr;', 'woothemes' ); ?>"><?php _e( 'Continue Reading &rarr;', 'woothemes' ); ?></a></span>
    <?php } ?>
</div>   
<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/* Subscribe / Connect */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'woo_subscribe_connect')) {
	function woo_subscribe_connect($widget = 'false', $title = '', $form = '', $social = '', $is_component = false ) {

		global $woo_options;

		// Setup custom title tag and title CSS class for Announcement.
		$title_tag = 'h3';
		$title_class = '';
		
		if ( $is_component == true ) {
			$title_tag = 'h2';
			$title_class = ' class="component-title"';
			$title = $woo_options['woo_connect_title'];
		}

		// Setup title
		if ( $widget != 'true' )
			$title = $woo_options['woo_connect_title'];

		// Setup related post (not in widget)
		$related_posts = '';
		if ( $woo_options[ 'woo_connect_related' ] == "true" AND $widget != "true" )
			$related_posts = do_shortcode( '[related_posts limit="5"]' );
		
		// Determine whether or not to make columns full	
		$col_css_class = 'class="col-left"';
		$related_css_class = 'col-right';
		if ( is_front_page()) { $col_css_class = 'class="col-full"'; $related_css_class = 'col-full'; }
?>
	<?php if ( $woo_options['woo_connect'] == "true" OR $widget == 'true' ) : ?>
	<div id="connect">
		<<?php echo $title_tag . $title_class; ?>><?php if ( $title ) echo stripslashes( $title ); else _e( 'Subscribe', 'woothemes' ); ?></<?php echo $title_tag; ?>>

		<div <?php if ( $related_posts != '' ) echo $col_css_class; ?>>
			<p><?php if ($woo_options[ 'woo_connect_content' ] != '') echo stripslashes($woo_options[ 'woo_connect_content' ]); else _e( 'Subscribe to our e-mail newsletter to receive updates.', 'woothemes' ); ?></p>

			<?php if ( $woo_options[ 'woo_connect_newsletter_id' ] != "" AND $form != 'on' ) : ?>
			<form class="newsletter-form<?php if ( $related_posts == '' ) echo ' fl'; ?>" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $woo_options[ 'woo_connect_newsletter_id' ]; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520' );return true">
				<input class="email" type="text" name="email" value="<?php esc_attr_e( 'E-mail', 'woothemes' ); ?>" onfocus="if (this.value == '<?php _e( 'E-mail', 'woothemes' ); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'E-mail', 'woothemes' ); ?>';}" />
				<input type="hidden" value="<?php echo $woo_options[ 'woo_connect_newsletter_id' ]; ?>" name="uri"/>
				<input type="hidden" value="<?php bloginfo( 'name' ); ?>" name="title"/>
				<input type="hidden" name="loc" value="en_US"/>
				<input class="submit" type="submit" name="submit" value="<?php _e( 'Submit', 'woothemes' ); ?>" />
			</form>
			<?php endif; ?>

			<?php if ( $woo_options['woo_connect_mailchimp_list_url'] != "" AND $form != 'on' AND $woo_options['woo_connect_newsletter_id'] == "" ) : ?> 
			<!-- Begin MailChimp Signup Form -->
			<div id="mc_embed_signup">
				<form class="newsletter-form<?php if ( $related_posts == '' ) echo ' fl'; ?>" action="<?php echo $woo_options['woo_connect_mailchimp_list_url']; ?>" method="post" target="popupwindow" onsubmit="window.open('<?php echo $woo_options['woo_connect_mailchimp_list_url']; ?>', 'popupwindow', 'scrollbars=yes,width=650,height=520');return true">
					<input type="text" name="EMAIL" class="required email" value="<?php _e('E-mail','woothemes'); ?>"  id="mce-EMAIL" onfocus="if (this.value == '<?php _e('E-mail','woothemes'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('E-mail','woothemes'); ?>';}">
					<input type="submit" value="<?php _e('Submit', 'woothemes'); ?>" name="subscribe" id="mc-embedded-subscribe" class="btn submit button">
				</form>
			</div>
			<!--End mc_embed_signup-->
			<?php endif; ?>

			<?php if ( $social != 'on' ) : ?>
			<div class="social<?php if ( $related_posts == '' AND $woo_options[ 'woo_connect_newsletter_id' ] != "" ) echo ' fr'; ?>">
		   		<?php if ( $woo_options[ 'woo_connect_rss' ] == "true" ) { ?>
		   		<a href="<?php if ( $woo_options[ 'woo_feed_url' ] ) { echo $woo_options[ 'woo_feed_url' ]; } else { echo get_bloginfo_rss( 'rss2_url' ); } ?>" class="subscribe"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-rss.png" title="<?php esc_attr_e( 'Subscribe to our RSS feed', 'woothemes' ); ?>" alt=""/></a>

		   		<?php } if ( $woo_options[ 'woo_connect_twitter' ] != "" ) { ?>
		   		<a href="<?php echo $woo_options[ 'woo_connect_twitter' ]; ?>" class="twitter"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-twitter.png" title="<?php esc_attr_e( 'Follow us on Twitter', 'woothemes' ); ?>" alt="Twitter"/></a>

		   		<?php } if ( $woo_options[ 'woo_connect_facebook' ] != "" ) { ?>
		   		<a href="<?php echo $woo_options[ 'woo_connect_facebook' ]; ?>" class="facebook"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-facebook.png" title="<?php esc_attr_e( 'Connect on Facebook', 'woothemes' ); ?>" alt="Facebook"/></a>

		   		<?php } if ( $woo_options[ 'woo_connect_youtube' ] != "" ) { ?>
		   		<a href="<?php echo $woo_options[ 'woo_connect_youtube' ]; ?>" class="youtube"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-youtube.png" title="<?php esc_attr_e( 'Watch on YouTube', 'woothemes' ); ?>" alt="YouTube"/></a>

		   		<?php } if ( $woo_options[ 'woo_connect_flickr' ] != "" ) { ?>
		   		<a href="<?php echo $woo_options[ 'woo_connect_flickr' ]; ?>" class="flickr"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-flickr.png" title="<?php esc_attr_e( 'See photos on Flickr', 'woothemes' ); ?>" alt="Flickr"/></a>

		   		<?php } if ( $woo_options[ 'woo_connect_linkedin' ] != "" ) { ?>
		   		<a href="<?php echo $woo_options[ 'woo_connect_linkedin' ]; ?>" class="linkedin"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-linkedin.png" title="<?php esc_attr_e( 'Connect on LinkedIn', 'woothemes' ); ?>" alt="LinkedIn"/></a>

		   		<?php } if ( $woo_options[ 'woo_connect_delicious' ] != "" ) { ?>
		   		<a href="<?php echo $woo_options[ 'woo_connect_delicious' ]; ?>" class="delicious"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-delicious.png" title="<?php esc_attr_e( 'Discover on Delicious', 'woothemes' ); ?>" alt="Delicious"/></a>

				<?php } if ( $woo_options[ 'woo_connect_googleplus' ] != "" ) { ?>
		   		<a href="<?php echo esc_url( $woo_options['woo_connect_googleplus'] ); ?>" class="googleplus"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-social-googleplus.png" title="<?php _e('View Google+ profile', 'woothemes'); ?>" alt=""/></a>

				<?php } ?>
			</div>
			<?php endif; ?>

		</div><!-- col-left -->

		<?php if ( $woo_options[ 'woo_connect_related' ] == "true" AND $related_posts != '' ) : ?>
		<div class="related-posts <?php echo $related_css_class; ?>">
			<h4><?php _e( 'Related Posts:', 'woothemes' ); ?></h4>
			<?php echo $related_posts; ?>
		</div><!-- col-right -->
		<?php wp_reset_query(); endif; ?>

        <div class="fix"></div>
	</div>
	<?php endif; ?>
<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Comment Form Fields */
/*-----------------------------------------------------------------------------------*/

	add_filter( 'comment_form_default_fields', 'woo_comment_form_fields' );

	if ( ! function_exists( 'woo_comment_form_fields' ) ) {
		function woo_comment_form_fields ( $fields ) {
		
			$last = '';
			$single_last = ' last';
			if ( is_front_page() ) { $last = ' last'; $single_last = '' ; }
		
			$commenter = wp_get_current_commenter();

			$required_text = ' (' . __( 'Required', 'woothemes' ) . ')';

			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			$name_value = $commenter['comment_author_name'];
			$email_value = $commenter['comment_author_email'];
			$url_value = $commenter['comment_author_url'];

			$name_default = __( 'Your Name', 'woothemes' ) . ( $req ? $required_text : '' );
			$email_default = __( 'Your Email', 'woothemes' ) . ( $req ? $required_text : '' );
			$url_default = __( 'Your Website', 'woothemes' );

			if ( $name_value == '' ) { $name_value = $name_default; }
			if ( $email_value == '' ) { $email_value = $email_default; }
			if ( $url_value == '' ) { $url_value = $url_default; }

			$fields =  array(
				'author' => '<p class="comment-form-author field">' . 
							'<input id="author" class="txt" name="author" type="text" value="' . esc_attr( $name_value ) . '" size="33"' . $aria_req . ' />' . 
							'<label for="author">' . $name_default . '</label> ' . 
							'</p>',
				'email'  => '<p class="comment-form-email field">' . 
				            '<input id="email" class="txt" name="email" type="text" value="' . esc_attr(  $email_value ) . '" size="33"' . $aria_req . ' />' . 
				            '<label for="email">' . $email_default . '</label> ' .
				            '</p>',
				'url'    => '<p class="comment-form-url field">' . 
				            '<input id="url" class="txt" name="url" type="text" value="' . esc_attr( $url_value ) . '" size="33" />' . 
				            '<label for="url">' . $url_default . '</label>' . 
				            '</p>',
			);
		
			return $fields;
		
		} // End woo_comment_form_fields()
	}

/*-----------------------------------------------------------------------------------*/
/* Comment Form Settings */
/*-----------------------------------------------------------------------------------*/

	add_filter( 'comment_form_defaults', 'woo_comment_form_settings' );

	if ( ! function_exists( 'woo_comment_form_settings' ) ) {
		function woo_comment_form_settings ( $settings ) {
			global $user_identity, $id;

			if ( null === $post_id )
				$post_id = $id;
			else
				$id = $post_id;
		
			$last = '';
			$single_last = ' last';
			if ( is_front_page() ) { $last = ' last'; $single_last = '' ; }
		
			$commenter = wp_get_current_commenter();
		
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
		
			$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
			
			$settings['comment_field'] = '<p class="comment-form-comment' . $single_last . '"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="47" rows="8" aria-required="true"></textarea></p>';
			$settings['comment_notes_before'] = '';
			$settings['comment_notes_after'] = '';
			$settings['label_submit'] = __( 'Submit', 'woothemes' );
			$settings['cancel_reply_link'] = __( 'Click here to cancel reply.', 'woothemes' );
		
			// Remove the comment form title if on the front page.
			if ( is_front_page() ) {
				$settings['title_reply'] = '';
				$settings['title_reply_to'] = '';
			}
		
			return $settings;
		
		} // End woo_comment_form_settings()
	}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Slides */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_add_slides' ) ) {

	add_action( 'init', 'woo_add_slides', 10 );

	function woo_add_slides() {
	
		// "Slides" Custom Post Type
		$labels = array(
			'name' => _x( 'Slides', 'post type general name', 'woothemes' ),
			'singular_name' => _x( 'Slide', 'post type singular name', 'woothemes' ),
			'add_new' => _x( 'Add New', 'slide', 'woothemes' ),
			'add_new_item' => __( 'Add New Slide', 'woothemes' ),
			'edit_item' => __( 'Edit Slide', 'woothemes' ),
			'new_item' => __( 'New Slide', 'woothemes' ),
			'view_item' => __( 'View Slide', 'woothemes' ),
			'search_items' => __( 'Search Slides', 'woothemes' ),
			'not_found' =>  __( 'No slides found', 'woothemes' ),
			'not_found_in_trash' => __( 'No slides found in Trash', 'woothemes' ), 
			'parent_item_colon' => ''
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_icon' => get_template_directory_uri() .'/includes/images/slides.png',
			'menu_position' => null, 
			'taxonomies' => array( 'slide-category' ), 
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		);
		
		register_post_type( 'slide', $args );
		
		// "Slide Categories" Custom Taxonomy
		$labels = array(
			'name' => _x( 'Slide Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Slide Categories', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Slide Categories', 'woothemes' ),
			'all_items' => __( 'All Slide Categories', 'woothemes' ),
			'parent_item' => __( 'Parent Slide Category', 'woothemes' ),
			'parent_item_colon' => __( 'Parent Slide Category:', 'woothemes' ),
			'edit_item' => __( 'Edit Slide Category', 'woothemes' ), 
			'update_item' => __( 'Update Slide Category', 'woothemes' ),
			'add_new_item' => __( 'Add New Slide Category', 'woothemes' ),
			'new_item_name' => __( 'New Slide Category Name', 'woothemes' ),
			'menu_name' => __( 'Slide Categories', 'woothemes' )
		); 	
		
		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'slide-category' )
		);
		
		register_taxonomy( 'slide-category', array( 'slide' ), $args );
	}
}

/*-----------------------------------------------------------------------------------*/
/* woo_slides_add_sortable_columns() */
/*-----------------------------------------------------------------------------------*/

	if ( is_admin() ) { add_filter( 'manage_edit-slide_sortable_columns', 'woo_slides_add_sortable_columns', 10, 1 ); }
	
	if ( ! function_exists( 'woo_slides_add_sortable_columns' ) ) {
		function woo_slides_add_sortable_columns ( $columns ) {
			$columns['menu_order'] = 'menu_order';
			return $columns;
		} // End woo_slides_add_sortable_columns()
	}

/*-----------------------------------------------------------------------------------*/
/* woo_slides_add_custom_column_headings() */
/*-----------------------------------------------------------------------------------*/
	
	if ( is_admin() ) { add_filter( 'manage_edit-slide_columns', 'woo_slides_add_custom_column_headings', 10, 1 ); }
	
	if ( ! function_exists( 'woo_slides_add_custom_column_headings' ) ) {
		function woo_slides_add_custom_column_headings ( $defaults ) {
			
			$new_columns['cb'] = '<input type="checkbox" />';
			// $new_columns['id'] = __( 'ID' );
			$new_columns['title'] = _x( 'Slide Title', 'column name' );
			$new_columns['menu_order'] = __( 'Order', 'woothemes' );
			$new_columns['slide-categories'] = __( 'Slide Categories', 'woothemes' );
			$new_columns['author'] = __( 'Added By', 'woothemes' );
	 		$new_columns['date'] = _x('Added On', 'column name');
	 
			return $new_columns;
			
		} // End woo_slides_add_custom_column_headings()
	}
	
/*-----------------------------------------------------------------------------------*/
/* woo_slides_add_custom_column_data() */
/*-----------------------------------------------------------------------------------*/
	
	if ( is_admin() ) { add_action( 'manage_posts_custom_column', 'woo_slides_add_custom_column_data', 10, 2 ); }
	
	if ( ! function_exists( 'woo_slides_add_custom_column_data' ) ) {
		function woo_slides_add_custom_column_data ( $column_name, $id ) {
		
			global $wpdb, $post;
			
			$custom_values = get_post_custom( $id );
			
			switch ($column_name) {
			
				case 'id':
				
					echo $id;
				
				break;
				
				case 'menu_order':
				
					echo $post->menu_order;
				
				break;
				
				case 'slide-categories':
				
					$terms = get_the_term_list( $post->ID, 'slide-category', '', ', ', '' );
					
					if ( $terms ) { echo $terms; } else { echo __( 'No Slide Categories', 'woothemes' ); }
				
				break;
				
				default:
				break;
			
			} // End SWITCH Statement
			
		} // End woo_slides_add_custom_column_data()
	}

/*-----------------------------------------------------------------------------------*/
/* woo_get_slide_dimensions() - Get slider image dimensions based on visible slides. */
/*-----------------------------------------------------------------------------------*/

	function woo_get_slide_dimensions ( $visible = 3 ) {
		
		$dimensions = array( 'width' => 350, 'height' => 350 );
		
		switch ( $visible ) {
			
			case 1:
			
				$dimensions = array( 'width' => 930, 'height' => 630 );
			
			break;
			
			case 2:
			
				$dimensions = array( 'width' => 500, 'height' => 335 );
			
			break;
			
			case 3:
			
				$dimensions = array( 'width' => 320, 'height' => 320 );
			
			break;
			
			case 4:
			
				$dimensions = array( 'width' => 200, 'height' => 145 );
			
			break;
			
		}
		
		// Allow child themes/plugins to filter here.
		$dimensions = apply_filters( 'woo_slide_dimensions', $dimensions, $visible );
		
		return $dimensions;
		
	} // End woo_get_slide_dimensions()
	
/*-----------------------------------------------------------------------------------*/
/* woo_setup_link_metabox() - Setup JavaScript for "Link" items admin. */
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_init', 'woo_setup_link_metabox' );

function woo_setup_link_metabox () {

	global $pagenow;

	if ( $pagenow == 'link.php' || $pagenow == 'link-add.php' ) {

		remove_meta_box( 'linkadvanceddiv', __( 'Advanced' ), 'woo_link_advanced_meta_box', 'link', 'normal', 'core' );
	
		add_meta_box( 'linkadvanceddiv', __( 'Advanced' ), 'woo_link_advanced_meta_box', 'link', 'normal', 'core' );
		
		wp_register_script( 'woo-medialibrary-uploader', get_template_directory_uri() . '/functions/js/woo-medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
		wp_enqueue_script( 'woo-medialibrary-uploader' );
		
		wp_register_style( 'woo-medialibrary-uploader-links', get_template_directory_uri() . '/includes/css/woo-medialibrary-uploader-links.css', array( 'thickbox' ), '1.0.0', 'screen' );
		wp_enqueue_style( 'woo-medialibrary-uploader-links' );
	
	} // End IF Statement
	
} // End woo_setup_link_metabox()

/*-----------------------------------------------------------------------------------*/
/* woo_link_advanced_meta_box() - Advanced settings for "Link" items. */
/*
/* @param object $link
/*-----------------------------------------------------------------------------------*/

function woo_link_advanced_meta_box( $link ) {
?>
<table class="form-table" style="width: 100%;" cellspacing="2" cellpadding="5">
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="link_image"><?php _e('Image Address') ?></label></th>
		<?php /*<td><input type="text" name="link_image" class="code" id="link_image" size="50" value="<?php echo ( isset( $link->link_image ) ? esc_attr($link->link_image) : ''); ?>" style="width: 95%" /></td>*/ ?>
		<td><?php echo woothemes_medialibrary_uploader( 'link_image', $link->link_image, null ); // New AJAX Uploader using Media Library ?></td>
	</tr>
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="rss_uri"><?php _e('RSS Address') ?></label></th>
		<td><input name="link_rss" class="code" type="text" id="rss_uri" value="<?php echo  ( isset( $link->link_rss ) ? esc_attr($link->link_rss) : ''); ?>" size="50" style="width: 95%" /></td>
	</tr>
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="link_notes"><?php _e('Notes') ?></label></th>
		<td><textarea name="link_notes" id="link_notes" cols="50" rows="10" style="width: 95%"><?php echo ( isset( $link->link_notes ) ? $link->link_notes : ''); // textarea_escaped ?></textarea></td>
	</tr>
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="link_rating"><?php _e('Rating') ?></label></th>
		<td><select name="link_rating" id="link_rating" size="1">
		<?php
			for ($r = 0; $r <= 10; $r++) {
				echo('            <option value="'. esc_attr($r) .'" ');
				if ( isset($link->link_rating) && $link->link_rating == $r)
					echo 'selected="selected"';
				echo('>'.$r.'</option>');
			}
		?></select>&nbsp;<?php _e('(Leave at 0 for no rating.)') ?>
		</td>
	</tr>
</table>
<?php
} // End woo_link_advanced_meta_box()

/*-----------------------------------------------------------------------------------*/
/* woo_add_filagree_break() - Add filagree image after each component. */
/*-----------------------------------------------------------------------------------*/

add_action( 'woo_component_after', 'woo_add_filagree_break' );

function woo_add_filagree_break () {

	global $woo_options;
	
	/* Setup default variables. */
	$filagree = '';
	
	if ( isset( $woo_options['woo_filagree'] ) && ( $woo_options['woo_filagree'] == 'true' ) ) {
		
		if ( isset( $woo_options['woo_filagree_image'] ) && ( $woo_options['woo_filagree_image'] != '' ) ) { $filagree = $woo_options['woo_filagree_image']; } else {
			$filagree = get_template_directory_uri() . '/images/filagree.png';
		}
	
	}

	if ( $filagree != '' ) {
?>
	<div class="filagree-break col-full">
		<span>
			<img src="<?php echo $filagree; ?>" alt="Filagree" />
		</span>
	</div>
<?php
	}
} // End woo_add_filagree_break()

/*-----------------------------------------------------------------------------------*/
/* woo_component_before() - Hook for adding items before components. */
/*-----------------------------------------------------------------------------------*/

function woo_component_before ( $component = '' ) {

	do_action( 'woo_component_before' );
	if ( $component != '' ) { do_action( 'woo_component_before_' . sanitize_title( $component ) ); }

} // End woo_component_before()

/*-----------------------------------------------------------------------------------*/
/* woo_component_after() - Hook for adding items after components. */
/*-----------------------------------------------------------------------------------*/

function woo_component_after ( $component = '' ) {

	do_action( 'woo_component_after' );
	if ( $component != '' ) { do_action( 'woo_component_after_' . sanitize_title( $component ) ); }

} // End woo_component_after()

/*-----------------------------------------------------------------------------------*/
/* Generate dynamic CSS for Baby Stats eye and hair colour. */
/*-----------------------------------------------------------------------------------*/
	
add_action( 'template_redirect', 'woo_enqueue_dynamic_css' );
add_action( 'template_redirect', 'woo_load_dynamic_css' );

function woo_enqueue_dynamic_css () {

	$url = home_url();
	$sep = '?';
	if ( get_option( 'permalink_structure' ) == '' && ! is_front_page() ) { $sep = '&'; }
	
	if ( is_singular() ) {
		global $post;
		
		$url = get_permalink( $post->ID );
	}

	wp_register_style( 'woo-dynamic', trailingslashit( $url ) . $sep . 'woo-dynamic-css=load' );
	
	wp_enqueue_style( 'woo-dynamic' );

} // End woo_enqueue_dynamic_css()

function woo_load_dynamic_css () {

	if ( isset( $_GET['woo-dynamic-css'] ) && $_GET['woo-dynamic-css'] == 'load' ) {
		
		header( 'Content-Type: text/css' );
		
		global $woo_options;
		
		// Default variables.
		$settings = array( 'eyecolor' => '', 'haircolor' => '' );
		
		// Begin compiling CSS string.
		$css = '';
		$css .= '/* Begin Dynamic CSS */' . "\n";
		
		/* Make sure our dynamic settings override the defaults, if available. */ 
		foreach ( array_keys( $settings ) as $o ) {
			if ( isset( $woo_options['woo_babystats_' . $o] ) && $woo_options['woo_babystats_' . $o] != '' ) {
		 		$settings[$o] = $woo_options['woo_babystats_' . $o];
		 	}
		 	
		 	if ( $settings[$o] != '' ) {
		 		$css .= '.stat-' . $o . ' .color-display { background-color: ' . $settings[$o] . '; }' . "\n";
		 	}
		}
		
		echo $css;
		
		die();

	}

} // End woo_load_dynamic_css()

/*-----------------------------------------------------------------------------------*/
/* Make sure comments form redirects to the correct place. */
/*-----------------------------------------------------------------------------------*/

add_action( 'comment_form', 'woo_add_comment_redirect_field' );

function woo_add_comment_redirect_field () {

	global $post, $current_page_id;

	$url = '';
	
	if ( is_home() || is_front_page() ) {
		$url = home_url( '/' );
	}
	
	if ( is_page() && ! is_home() && ! is_front_page() ) {
		if ( isset( $current_page_id ) ) {
			$url = get_permalink( $current_page_id );
		} else {
			$url = get_permalink( $post->ID );
		}
	}

	$field = '<input type="hidden" name="redirect_to" id="redirect_to" value="' . $url . '" />' . "\n";
	
	echo $field;

} // End woo_add_comment_redirect_field()

add_action( 'comment_form_after', 'woo_comment_form_after', 10 );

function woo_comment_form_after () {
	echo '<div class="fix"></div>' . "\n";
} // End woo_comment_form_after()

/*-----------------------------------------------------------------------------------*/
/* Add post/page-specific content classes via a filter on woo_content_class */
/*-----------------------------------------------------------------------------------*/

	add_filter( 'woo_section_class', 'woo_add_post_layout_classes', 0, 2 );
	
	function woo_add_post_layout_classes ( $content, $base_class ) {
		
		global $post;
			
			if ( ! isset( $post->ID ) ) { return $content; }
			
			$custom_meta = get_post_custom( $post->ID );
			
			if ( array_key_exists( '_column_layout', (array) $custom_meta ) ) {
				$content .= ' ' . $custom_meta['_column_layout'][0];
			} else {
				$content .= ' layout-std';
			}
			
			$content .= ' column-layout';
		
		return $content;
		
	} // End woo_add_post_layout_classes()

/*-----------------------------------------------------------------------------------*/
/* woo_section_class() */
/*-----------------------------------------------------------------------------------*/

	function woo_section_class( $base, $custom_classes = '' ) {
		
		$output = '';
		
		$classes = strtolower( $base );
		
		if ( $custom_classes != '' ) { $classes .= ' ' . $custom_classes; }
		
		$classes = apply_filters( 'woo_section_class', $classes, $base );
		
		$output = ' class="' . $classes . '"';
		
		echo $output;
		
	} // End woo_section_class()

/*-----------------------------------------------------------------------------------*/
/* Use single-columns.php if a non-standard column layout option is selected */
/*-----------------------------------------------------------------------------------*/

	add_action( 'template_redirect', 'woo_columns_template_redirect' );

	function woo_columns_template_redirect () {
		
		global $post;
		
		if ( ! is_home() && is_singular() && isset( $post->ID ) ) {
		
			$layout = 'layout-std';
			
			$custom_meta = get_post_custom( $post->ID );
	
			if ( array_key_exists( '_column_layout', (array) $custom_meta ) ) {
				$layout = $custom_meta['_column_layout'][0];
			}
			
			if ( $layout != 'layout-std' && $layout != '' ) {
				locate_template( array( 'single-columns.php', 'single.php', 'index.php' ), true );
				
				exit;
			}
		
		}
		
	} // End woo_columns_template_redirect()

/*-----------------------------------------------------------------------------------*/
/* Modify WooFramework Google Fonts. */
/*-----------------------------------------------------------------------------------*/
	
	add_action( 'admin_head', 'woo_add_fontface_fonts', 10 );

	function woo_add_fontface_fonts () {
		global $google_fonts;
		
		$google_fonts[] = array( 'name' => 'StMarie-Thin' );
		$google_fonts[] = array( 'name' => 'FontSiteSans-Roman' );
		$google_fonts[] = array( 'name' => 'FontSiteSans-Cond' );
		$google_fonts[] = array( 'name' => 'BergamoStd' );
		$google_fonts[] = array( 'name' => 'BergamoStd-Italic' );
	} // End woo_add_fontface_fonts()

/*-----------------------------------------------------------------------------------*/
/* Register custom component widgets. */
/*-----------------------------------------------------------------------------------*/

	// Add custom component widgets to widgets to be loaded.
	add_filter( 'woo_widgets', 'woo_add_component_widget', 10 );
	function woo_add_component_widget ( $widgets ) {
		$widgets[] = 'includes/widgets/widget-woo-componentbase.php';
		return $widgets;
	} // End woo_add_component_widget()

/*-----------------------------------------------------------------------------------*/
/* WPML Compatibility for Page IDs in Theme Options */
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'icl_object_id' ) ) {
	add_filter( 'woo_component_babystats_settings', 'woo_wpml_components_page_ids' );
	add_filter( 'woo_component_pagecontent_settings', 'woo_wpml_components_page_ids' );
	add_filter( 'woo_component_occassiondetails_settings', 'woo_wpml_components_page_ids' );

	if ( ! function_exists( 'woo_wpml_components_page_ids' ) ) {
		function woo_wpml_components_page_ids ( $settings ) {
			switch ( current_filter() ) {
				// Baby Statistics
				case 'woo_component_babystats_settings':
				$settings['aboutpage'] = icl_object_id( $settings['aboutpage'], 'page', true );
				break;

				// Page Content
				case 'woo_component_pagecontent_settings':
				$settings['page'] = icl_object_id( $settings['page'], 'page', true );
				break;

				// Occassion Details
				case 'woo_component_occassiondetails_settings':
				$settings['page'] = icl_object_id( $settings['page'], 'page', true );
				break;
			}
			return $settings;
		} // End woo_wpml_components_page_ids()
	} 
}

/*-----------------------------------------------------------------------------------*/
/* END */
/*-----------------------------------------------------------------------------------*/
?>