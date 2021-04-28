<?php
/**
 * Plugin Name: BK-Ninja: Ads Widget
 * Plugin URI: http://bk-ninja.com
 * Description: Displays ads in any section.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://BK-Ninja.com
 *
 */
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'bk_register_ads_widget');

function bk_register_ads_widget(){
	register_widget('bk_ads');
}

class bk_ads extends WP_Widget {
    
/**
 * Widget setup.
 */
	function bk_ads() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-ads', 'description' => __('Displays Ads in any section.', 'bkninja') );

		/* Create the widget. */
		$this->WP_Widget( 'bk_ads', __('*BK: Widget Ads', 'bkninja'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		
		echo $before_widget;
		?>
			<a class="ads-link" target="_blank" href="<?php echo esc_url( $instance['linkurl'] ); ?>">
				<img class="ads" src="<?php echo esc_url( $instance['imgurl'] ); ?>" alt="">
			</a>
		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, $this->default );
		$instance['imgurl'] = strip_tags( $new_instance['imgurl'] );
		$instance['linkurl'] = strip_tags( $new_instance['linkurl'] );

		return $instance;
	}

	function form( $instance ) {
        $defaults = array('imgurl' => 'http://', 'linkurl' => 'http://');
		$instance = wp_parse_args((array) $instance, $defaults);

		$imgurl = strip_tags( $instance['imgurl'] );
		$linkurl = strip_tags( $instance['linkurl'] );
?>
		<!-- Ads Image URL -->
		<p>
			<label for="<?php echo $this->get_field_id('imgurl'); ?>"><?php _e('Ads Image Url:','bkninja'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('imgurl'); ?>" name="<?php echo $this->get_field_name('imgurl'); ?>" type="text" value="<?php echo esc_attr($imgurl); ?>" />
		</p>

		<!-- link url -->
		<p>
			<label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('Link Url:','bkninja'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" name="<?php echo $this->get_field_name('linkurl'); ?>" type="text" value="<?php echo esc_attr($linkurl); ?>" />
		</p>
<?php
	}
}
