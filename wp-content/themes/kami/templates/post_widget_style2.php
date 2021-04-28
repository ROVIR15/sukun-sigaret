<div class="widget-post-wrap">
    <div class="thumb">
        <a href="<?php the_permalink();?>">
            <?php 
                if(has_post_thumbnail( get_the_ID() )) {
                    echo get_the_post_thumbnail(get_the_ID(), 'bk360_145');
                }else {
                    echo '<img width="500" height="200" src="'.get_template_directory_uri().'/images/bkdefault500_200.jpg">';
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
