<?php
/*---------------------------------------------------------------------------------*/
/* Twitter widget */
/*---------------------------------------------------------------------------------*/
class Woo_Twitter extends WP_Widget {

   function Woo_Twitter() {
	   $widget_ops = array( 'description' => 'Add your Twitter feed to your sidebar with this widget.' );
       parent::WP_Widget(false, __( 'Woo - Twitter Stream', 'woothemes' ),$widget_ops);      
   }
   
   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];
    $limit = $instance['limit']; if (!$limit) $limit = 5;
	$username = $instance['username'];
	$unique_id = $args['widget_id'];
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) echo $before_title . $title . $after_title; else { ?>
        <h3 class="tlogo"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="Twitter" /></h3>
		<?php } ?>        
        <div class="back"><ul id="twitter_update_list_<?php echo $unique_id; ?>"><li></li></ul>
        <p><?php _e( 'Follow', 'woothemes' ); ?> <a href="http://twitter.com/<?php echo $username; ?>"><strong>@<?php echo $username; ?></strong></a> <?php _e( 'on Twitter', 'woothemes' ); ?></p></div><div class="clear"></div>
        <?php echo woo_twitter_script($unique_id,$username,$limit); //Javascript output function ?>	 
        <?php echo $after_widget; ?>
        
   		
	<?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       $title = esc_attr($instance['title']);
       $limit = esc_attr($instance['limit']);
	   $username = esc_attr($instance['username']);
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'woothemes' ); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:', 'woothemes' ); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name( 'username' ); ?>"  value="<?php echo $username; ?>" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'woothemes' ); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name( 'limit' ); ?>"  value="<?php echo $limit; ?>" class="" size="3" id="<?php echo $this->get_field_id( 'limit' ); ?>" />

       </p>
      <?php
   }
   
} 
register_widget( 'Woo_Twitter' );
?>