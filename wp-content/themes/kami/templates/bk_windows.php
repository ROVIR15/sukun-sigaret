<div class="widget-post-wrap">
    <div class="thumb">
        <a href="<?php the_permalink();?>">
            <?php 
                if(has_post_thumbnail( get_the_ID() )) {
                    echo get_the_post_thumbnail(get_the_ID(), 'bk485_300');
                }else {
                    echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                }
                echo bk_get_post_icon(get_the_ID());
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
        <div class="excerpt">
        <?php 
            $string = get_the_excerpt();
            echo the_excerpt_limit($string, 20); 
        ?>
        </div>
        <div class="meta-bottom">
            <?php $category = get_the_category(get_the_ID()); ?>
            
            <div class="post-cat">
                <span><i class="fa fa-folder"></i></span>
                <a href="<?php if (is_array($category)) { if(isset($category[0])) {echo get_category_link($category[0]->term_id );}}?>"><?php if (is_array($category)) { if(isset($category[0])) {echo ($category[0]->cat_name);}}?></a>
            </div>
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