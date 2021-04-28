<?php
/**
 * Plugin Name: BK-Ninja: Latest Reply for bbp
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the most recent replies (bbp) with author avatar
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */
/**
* Add function to widgets_init that'll load our widget.
*/
add_action( 'widgets_init', 'bk_register_latest_replies_widget' );
function bk_register_latest_replies_widget() {
	register_widget( 'bk_latest_replies' );
}
/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_latest_replies extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function bk_latest_replies() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_latest_replies', 'description' => __('[BBP widget] Displays latest replies in sidebar.', 'bkninja') );

		/* Create the widget. */
		$this->WP_Widget( 'bk_latest_replies', __('BK-Ninja: Widget Latest Replies  (BBPRESS)', 'bkninja'), $widget_ops);
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
                'post_type' => bbp_get_reply_post_type(), 
                'post_status' => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ), 
                'posts_per_page' => $entries_display, 
                'ignore_sticky_posts' => true, 
                'no_found_rows' => true 
                );

        $the_query = new WP_Query( $args );

        echo $before_widget;
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_attr($title) . $after_title;?>
            </div>
        <?php }?>
        <div class="widget-recent-replies">
            <ul class="list comment-list">
    
                <?php while ( $the_query->have_posts() ) : $the_query->the_post();?>
                    <?php $reply_id   = bbp_get_reply_id( $the_query->post->ID );?>   
                    <li class="clearfix">
                        <div class="author-comment-wrap post-wrap hide-content">
                            <div class="author">                                
								<div class="thumbnail">
									<?php echo bbp_get_reply_author_link( array( 'post_id' => $reply_id, 'type' => 'avatar', 'size' => 30 ) ); ?>
								</div>
                            </div>                                    
							<div class="details">
                                <h4 class="post-title post-title-commented">
                                    <a href="<?php echo esc_url( bbp_get_reply_url( $reply_id ) ); ?>"><?php echo esc_attr( bbp_get_reply_topic_title( $reply_id ) ); ?></a>
                                </h4>
                                <div class="content">
									<div class="comment-text">
										<?php echo esc_attr( bbp_get_reply_excerpt( $reply_id, 80 ) ); ?>
									</div>
                                </div>
                                <div class="comment-author">
                                    <div class="author-name">
                                        <?php echo bbp_get_reply_author_link( array( 'post_id' => $reply_id, 'type' => 'name' ) );?>
                                    </div>
                                </div>
							</div>
                        </div>

    
                    </li>
    
                <?php endwhile; ?>
    
            </ul>
        </div>
    <?php echo $after_widget;

    // Reset the $post global
    wp_reset_postdata();
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['entries_display'] = absint( $new_instance['entries_display'] );

        return $instance;
    }

    function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $entries_display = isset( $instance['entries_display'] ) ? absint( $instance['entries_display'] ) : 5;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bbpress' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><?php _e( 'Entries_display of replies to show:', 'bbpress' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'entries_display' ); ?>" name="<?php echo $this->get_field_name( 'entries_display' ); ?>" type="text" value="<?php echo $entries_display; ?>" size="3" /></p>
<?php
    }
}
?>