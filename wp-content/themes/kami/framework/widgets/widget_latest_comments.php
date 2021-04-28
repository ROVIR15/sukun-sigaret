<?php
/**
 * Plugin Name: BK-Ninja: Latest Comments
 * Plugin URI: http://bk-ninja.com/
 * Description: This widhet displays the most recent comments with author avatar in the tabs.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_latest_comments_widget' );

function bk_register_latest_comments_widget() {
	register_widget( 'bk_latest_comments' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_latest_comments extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function bk_latest_comments() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_latest_comments', 'description' => __('[Sidebar widget] Displays latest comments in sidebar.', 'bkninja') );

		/* Create the widget. */
		$this->WP_Widget( 'bk_latest_comments', __('BK-Ninja: Widget Latest Comments', 'bkninja'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
        
		if( (!isset($entries_display)) || ($entries_display == NULL)){ 
            $entries_display = '5'; 
        }
		
		$args = array(
		   'status' => 'approve',
			'number' => $entries_display
		);
		
		echo $before_widget;
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_attr($title) . $after_title;?>
            </div>
        <?php }?>
        
		<div class="widget_comment">
			<ul class="list comment-list">
				<?php 
					//get recent comments
						
					$comments = get_comments($args);
					
					foreach($comments as $comment) :							
							$commentcontent = strip_tags($comment->comment_content);			
                            $commentcontent = the_excerpt_limit($commentcontent, 10);

                            
							$commentauthor = $comment->comment_author;
							$commentauthor = the_excerpt_limit($commentauthor, 5);			

							$commentid = $comment->comment_ID;
							$commenturl = get_comment_link($commentid); 
                            
                            $bk_postid = $comment->comment_post_ID;
                            $title = get_the_title($bk_postid);
                            $short_title = the_excerpt_limit($title, 10);
		                   ?>
						   <li class="clearfix">
                                <div class="author-comment-wrap post-wrap hide-content">
                                    <div class="author">                                
    									<div class="thumbnail">
    										<?php echo get_avatar( $comment, '30' ); ?>
    									</div>
                                    </div>                                    
									<div class="details">
                                        <h4 class="post-title post-title-commented">
                                                <a href="<?php echo get_permalink($bk_postid) ?>"><?php echo esc_attr($short_title); ?></a>
                                        </h4>
                                        <div class="content">
    										<div class="comment-text">
    											<a href="<?php echo esc_url($commenturl); ?>"><?php echo esc_attr($commentcontent); ?></a>
    										</div>
                                        </div>
                                        <div class="comment-author">
                                            <div class="author-name">
                                                <?php echo esc_attr($commentauthor); ?>
                                            </div>
                                        </div>
									</div>
                                </div>
							</li>
				<?php endforeach; ?>
			</ul>
		</div>
    <?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = $new_instance['title'];
		$instance['entries_display'] = strip_tags($new_instance['entries_display']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Latest Comments', 'entries_display' => 5);
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e('Title:', 'bkninja'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
                
        <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php _e('Number of entries to display: ', 'bkninja'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo esc_attr($instance['entries_display']); ?>" style="width:100%;" /></p>        
<?php
	}
}
?>
