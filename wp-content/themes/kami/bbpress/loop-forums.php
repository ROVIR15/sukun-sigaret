<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">
    <?php if ( bbp_forums() ) : bbp_the_forum(); ?>
                        
        <?php if (!(bbp_is_forum_category() && !bbp_get_forum_parent_id())): ?>
            <li class="bbp-header">
        
        		<ul class="forum-titles">
        			<li class="bbp-topic-title bk-forum-header-font"><?php _e( 'Forums', 'bbpress' ); ?></li>
        			<li class="bbp-topic-voice-count bk-forum-header-font"><?php _e( 'Voice', 'bbpress' ); ?></li>
        			<li class="bbp-topic-reply-count bk-forum-header-font"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></li>
        			<li class="bbp-topic-freshness bk-forum-header-font"><?php _e( 'Freshness', 'bbpress' ); ?></li>
        		</ul>
        
        	</li>
			<?php endif; ?>        
	<?php endif;?>
    <?php while ( bbp_forums() ) : bbp_the_forum(); ?> <?php endwhile;
    // restore query
    $orig_query = clone bbpress()->forum_query;
    bbpress()->forum_query = $orig_query;
    ?>
	<li class="bbp-body bk-forum-loop">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
                        
            <?php if (bbp_is_forum_category() && !bbp_get_forum_parent_id()): ?>                
            <div class="bk-forum-section ">
    			<div class="forum-cat forum-cat-header">
    		
    				<ul class="forum-titles clearfix">
    					<li class="bbp-forum-info bk-forum-header-font"><?php bbp_forum_title(); ?></li>
    					<li class="bbp-forum-topic-count bk-forum-header-font"><?php _e( 'Topics', 'bbpress' ); ?></li>
    			        <li class="bbp-forum-reply-count bk-forum-header-font"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></li>
    					<li class="bbp-forum-freshness bk-forum-header-font"><?php _e( 'Freshness', 'bbpress' ); ?></li>
    				</ul>
    		
    			</div>
    
    				<?php 
    				
    					// get sub-forums
    					$orig_query = clone bbpress()->forum_query;
    					bbp_has_forums(array('post_parent' => bbp_get_forum_id()));
    					
    					while (bbp_forums()): 
    						bbp_the_forum();				
    				?>
    					
    					<?php bbp_get_template_part('loop', 'single-forum'); ?>
    										
    				<?php 
    					endwhile;
    
    					// restore query
    					bbpress()->forum_query = $orig_query;
    						
    				?>
    		</div>		
			<?php else: ?>
                        
				<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
			
			<?php endif; ?>
                                         
		<?php endwhile; ?>

	</li><!-- .bbp-body -->

</ul><!-- .forums-directory -->

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
