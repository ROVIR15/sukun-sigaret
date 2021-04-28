<?php
/**
 * Plugin Name: BK-Ninja: Recent Topics For bbp
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the recent topic (bbp).
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */
/**
* Add function to widgets_init that'll load our widget.
*/
add_action( 'widgets_init', 'bk_register_recent_topics_widget' );
function bk_register_recent_topics_widget() {
	register_widget( 'bk_recent_topics' );
}
     
class bk_recent_topics extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function bk_recent_topics() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_recent_topics', 'description' => __('[BBP widget] Displays latest topics in sidebar.', 'bkninja') );

		/* Create the widget. */
		$this->WP_Widget( 'bk_recent_topics', __('BK-Ninja: Widget Latest Topics  (BBPRESS)', 'bkninja'), $widget_ops);
	}

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
                
		if( (!isset($entries_display)) || ($entries_display == NULL)){ 
            $entries_display = '5'; 
        }
        
        $orderby = ( ! empty( $instance['entries_display'] ) ) ? strip_tags( $instance['order_by'] ) : 'newness';

        if ( $orderby == 'newness') {
            $meta_key = $order_by = NULL;
        } elseif ( $orderby == 'popular' ) {
            $meta_key =  '_bbp_reply_count';
            $order_by = 'meta_value';
        } elseif ( $orderby == 'freshness') {
            $meta_key =  '_bbp_last_active_time';
            $order_by = 'meta_value';
        }
        
        $args = array( 
                    'post_type' => bbp_get_topic_post_type(), 
                    'post_status' => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ), 
                    'order'  => 'DESC', 
                    'posts_per_page' => $entries_display, 
                    'ignore_sticky_posts' => true, 
                    'no_found_rows' => true, 
                    'meta_key' => $meta_key, 
                    'orderby' => $order_by 
                ) ;
        $the_query = new WP_Query( $args );

        echo $before_widget;
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_attr($title) . $after_title;?>
            </div>
        <?php }?>
        <div class="widget-recent-topics">
            <ul class="list topic-list">

            <?php while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
                <?php $reply_id   = bbp_get_reply_id( $the_query->post->ID );?>   
                <li class="clearfix">
                    <div class="author">                                
						<div class="thumbnail">
							<?php echo bbp_get_reply_author_link( array( 'post_id' => $reply_id, 'type' => 'avatar', 'size' => 60 ) ); ?>
						</div>
                    </div> 
                    <div class="details">
                        <h4 class="post-title">
                            <a href="<?php echo esc_url( bbp_get_reply_url( $reply_id ) ); ?>"><?php echo esc_attr( bbp_get_reply_topic_title( $reply_id ) ); ?></a>
                        </h4>
                        <div class="comment-author">
                            <div class="author-name">
                                <?php _e('Started by ', 'bkninja'); echo bbp_get_reply_author_link( array( 'post_id' => $reply_id, 'type' => 'name' ) );?>
                            </div>
                        </div>
					</div>
                </li>

            <?php endwhile; ?>

        </ul>

<?php 
        echo $after_widget;

        // Reset the $post global
        wp_reset_postdata();
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['entries_display'] = absint( $new_instance['entries_display'] );
        $instance['order_by'] = strip_tags( $new_instance['order_by'] );

        return $instance;
    }

    function form( $instance ) {
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $entries_display = isset( $instance['entries_display'] ) ? absint( $instance['entries_display'] ) : 5;
        $orderby = isset( $instance['order_by'] ) ? strip_tags( $instance['order_by'] ) : 'newness';

?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bbpress' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><?php _e( 'Number of Topics to show:', 'bbpress' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'entries_display' ); ?>" name="<?php echo $this->get_field_name( 'entries_display' ); ?>" type="text" value="<?php echo $entries_display; ?>" size="3" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order By:',        'bbpress' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'order_by' ); ?>" id="<?php echo $this->get_field_name( 'order_by' ); ?>">
                <option <?php selected( $orderby, 'newness' );   ?> value="newness"><?php _e( 'Newest Topics',                'bbpress' ); ?></option>
                <option <?php selected( $orderby, 'popular' );   ?> value="popular"><?php _e( 'Popular Topics',               'bbpress' ); ?></option>
                <option <?php selected( $orderby, 'freshness' ); ?> value="freshness"><?php _e( 'Topics With Recent Replies', 'bbpress' ); ?></option>
            </select>
        </p>
<?php
    }
}
?>