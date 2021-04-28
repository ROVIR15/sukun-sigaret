<?php
/**
 * Plugin Name: BK-Ninja: Slider Widget
 * Plugin URI: http://bk-ninja.com
 * Description: Slider widget in sidebar
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'bk_register_slider_widget');

function bk_register_slider_widget(){
	register_widget('bk_slider');
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */ 
class bk_slider extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function bk_slider(){
		/* Widget settings. */	
		$widget_ops = array('classname' => 'widget-slider', 'description' => __('[Sidebar widget] Displays a slider in sidebar.', 'bkninja'));
		
		/* Create the widget. */
		$this->WP_Widget('bk_slider', __('BK-Ninja: Widget Slider','bkninja'), $widget_ops);
	}
	
	/**
	 * display the widget on the screen.
	 */
	function widget($args, $instance){	
		extract($args);
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
		$cat_id = $instance['category'];
        echo $before_widget;
        if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_attr($title) . $after_title;?>
            </div>
        <?php }
              
		$args = array(
				'cat' => $cat_id,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $entries_display
                );
        ?>
		<div class="flexslider" >
			<ul class="slides">
				<?php $query = new WP_Query( $args ); ?>
				<?php while($query->have_posts()): $query->the_post(); ?>
                        <?php $postid = get_the_ID();?>		
                        <li class="content-in">
                            <div class="widget-post-wrap">
                                <div class="thumb">
                                    <a href="<?php the_permalink();?>">
                                        <?php 
                                            if(has_post_thumbnail( get_the_ID() )) {
                                                echo get_the_post_thumbnail(get_the_ID(), 'bk485_300');
                                            }else {
                                                echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                                            }
                                        ?>
                                    </a>
                                </div>
                                <div class="article-content-wrap">
                                    <h4 class="title">
                                        <a href="<?php the_permalink();?>">
                                    		<?php 
                                    			$title = get_the_title();
                                 			    echo esc_attr($title);
                                    		?>
                                        </a>
                                    </h4>
                                    <div class="meta-bottom">
                                        <div class="post-date"><span><i class="fa fa-clock-o"></i></span>
                                            <?php echo get_the_date('M j, Y'); ?>
                                        </div>
                                        <?php if ( comments_open() ) : ?>
                                    	<div class="meta-comment">
                                    		<span><i class="fa fa-comments-o"></i></span>
                                    		<?php comments_popup_link( __('0', 'bkninja'), __('1', 'bkninja'), __('%', 'bkninja')); ?>
                                    	</div>		
                                        <?php endif; ?> 
                                    </div>
                                </div>
                                <a class="bk-cover-link" href="<?php the_permalink();?>"></a>
                            </div>	
						</li>	
                    																				
				<?php endwhile; ?>
			</ul>
		</div>			
		<?php
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['category'] = $new_instance['category'];
		$instance['entries_display'] = $new_instance['entries_display'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form($instance){
		$defaults = array('title' => '', 'category' => 'all', 'entries_display' => 5);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
        
		<!-- Title: Text Input -->     
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e('Title: ','bkninja');?></strong></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
        		
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
        
		<p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php _e('Number of entries to display: ', 'bkninja'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo esc_attr($instance['entries_display']); ?>" style="width:100%;" /></p>

	<?php }
}
?>