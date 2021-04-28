<?php
    $category = get_the_category(get_the_ID());        
?>

<div class="thumb <?php if (is_array($category)) { if(isset($category[0])) {echo "thumb-bg-".$category[0]->term_id;}}?>">
    <?php 
        if(has_post_thumbnail( get_the_ID() )) {
            echo get_the_post_thumbnail(get_the_ID(), 'bk230_140');
        }else {
            echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
        }
        echo bk_get_post_icon(get_the_ID());
    ?>
</div>

<h4 class="title">
    <a href="<?php the_permalink();?>">
		<?php 
			$title = get_the_title();
			echo esc_attr($title);
		?>
    </a>
</h4>
<div class="meta-bottom">
    <div class="post-date">
        <span><i class="fa fa-clock-o"></i></span>
      <?php echo get_the_date('M j, Y'); ?>
    </div>
    <?php if ( comments_open() ) : ?>
    	<div class="meta-comment">
    		<span><i class="fa fa-comments-o"></i></span>
    		<?php comments_popup_link( __('0', 'bkninja'), __('1', 'bkninja'), __('%', 'bkninja')); ?>
    	</div>		
    <?php endif; ?> 
</div>