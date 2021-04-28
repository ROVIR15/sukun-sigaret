<?php
/**
 * Plugin Name: BK-Ninja: Latest Review Widget
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays Latest Review posts.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_latest_reviews_widget' );

function bk_register_latest_reviews_widget() {
	register_widget( 'bk_latest_review' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_latest_review extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function bk_latest_review() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-latest-review', 'description' => __('[Sidebar widget] Displays recent review posts in sidebar.', 'bkninja') );

		/* Create the widget. */
		$this->WP_Widget( 'bk_latest_review', __('BK-Ninja: Widget Latest Reviews', 'bkninja'), $widget_ops);
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
        if(isset($instance['category'])){
            $cat_id = $instance['category'];
        }else {
            $cat_id = '';
        }
        
		if( (!isset($entries_display)) || ($entries_display == NULL)){ 
            $entries_display = '5'; 
        }
		echo $before_widget;
?>      
    <?php
		$args = array(
            'cat' => $cat_id,
			'post_type' => 'post',
			'ignore_sticky_posts' => 1,
            'orderby' => 'date',
            'order'=> 'DESC',
			'posts_per_page' => $entries_display,
			'meta_query' => array(
				array(
					'key' => 'bk_review_checkbox',
					'value' => '1',
				)
             )		
		);
        $review_posts = new WP_Query( $args );
        
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_attr($title) . $after_title;?>
            </div>
        <?php }
        if ( $review_posts -> have_posts() ) : ?>  
        <div class="widget_latest_review"> 
       	    <ul class="list post-review-list">
                <?php
            	while ( $review_posts -> have_posts() ) : $review_posts -> the_post();
                    $bk_review_checkbox = get_post_meta(get_the_ID(), 'bk_review_checkbox', true );
                    $bk_final_score = get_post_meta(get_the_ID(), 'bk_final_score', true ); 
                    $bk_title = get_the_title();
                    $bk_title =  the_excerpt_limit($bk_title, 7);
                    ?>
                    <li class="bk-review-box clearfix">
                        <h4 class="bk-review-title post-title"><a href="<?php the_permalink(); ?>"><?php echo esc_attr($bk_title) ;?></a></h4>
                        <span class="bk-final-score"> <?php echo $bk_final_score;?></span>
                        <span class="bk-overlay"><span class="bk-zero-trigger" style="width: <?php echo ($bk_final_score*10);?>%"></span></span>                        
                    </li>
                        
                <?php endwhile;?>
       	    </ul>
        </div>
        <?php endif;?>
		<?php echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = $new_instance['title'];
		$instance['entries_display'] = strip_tags($new_instance['entries_display']);
        $instance['category'] = $new_instance['category'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Latest Reviews', 'entries_display' => 5, 'category' => 'all');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
    <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e('Title:', 'bkninja'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
	</p>
            
    <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php _e('Number of entries to display: ', 'bkninja'); ?></strong></label>
	<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo esc_attr($instance['entries_display']); ?>" style="width:100%;" /></p>        
	
    <p>
		<label for="<?php echo $this->get_field_id('category'); ?>"><strong><?php _e('Filter by Category: ','bkninja');?></strong></label> 
		<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ('all' == $instance['category']) echo 'selected="selected"'; ?>><?php _e( 'All Categories', 'bkninja' ); ?></option>
			<?php $categories = get_categories('hide_empty=1&type=post'); ?>
			<?php foreach($categories as $category) { ?>
			<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['category']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
	</p>     	
	<?php
	}
}
?>