<?php
	
// Do not delete these lines

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'woothemes' ) ?></p>

<?php return; } ?>
<?php $comments_by_type = &separate_comments($comments); ?>    
<?php
	// Comment reply form.
	comment_form();
?>
<!-- You can start editing here. -->

<div id="comments">

<?php if ( have_comments() ) : ?>

	<?php if ( ! empty($comments_by_type['comment']) ) : ?>
		<?php if(!is_front_page()) { ?>
		<span class="comment-header-border"></span>
		<div id="comment-header">
		<h3><?php comments_number(__( '0', 'woothemes' ), __( '1', 'woothemes' ), __( '%', 'woothemes' ) );?> <?php _e( 'Comments', 'woothemes' ) ?></h3>
		</div>
		<span class="comment-header-border"></span>
		<?php } ?>
		<ol class="commentlist">
	
			<?php wp_list_comments( 'avatar_size=26&callback=custom_comment&type=comment' ); ?>
		
		</ol>    

		<div class="navigation">
			<div class="fl"><?php previous_comments_link() ?></div>
			<div class="fr"><?php next_comments_link() ?></div>
			<div class="fix"></div>
		</div><!-- /.navigation -->
	<?php endif; ?>
		    
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
    		
        <h3 id="pings"><?php _e( 'Trackbacks/Pingbacks', 'woothemes' ) ?></h3>
    
        <ol class="pinglist">
            <?php wp_list_comments( 'type=pings&callback=list_pings' ); ?>
        </ol>
    	
	<?php endif; ?>
    	
<?php else : // this is displayed if there are no comments so far ?>

		<?php if ( 'open' == $post->comment_status) : ?>
			<!-- If comments are open, but there are no comments. -->
			<p class="nocomments"><?php _e( 'Be the first to leave a comment!', 'woothemes' ) ?><span></span></p>

		<?php else : // comments are closed ?>
			<!-- If comments are closed. -->
			<p class="nocomments"><?php _e( 'Comments are closed.', 'woothemes' ) ?></p>

		<?php endif; ?>

<?php endif; ?>

</div> <!-- /#comments_wrap -->

<?php if ( 'open' == $post->comment_status) : ?>

<?php endif; // if you delete this the sky will fall on your head ?>
