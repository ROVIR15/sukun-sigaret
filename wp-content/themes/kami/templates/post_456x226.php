<div class="thumb">
    <?php 
        if(has_post_thumbnail( get_the_ID() )) {
            echo get_the_post_thumbnail(get_the_ID(), 'bk456_226');
        }else {
            echo '<img width="456" height="226" src="'.get_template_directory_uri().'/images/bkdefault456_226.jpg">';
        }
    ?>
</div>
<div class="bkdate">
    <div class="day"><?php echo get_the_date('j'); ?></div>
    <div class="month"><?php echo get_the_date('M'); ?></div>
</div>
<div class="article-content-wrap">
    <div class="meta-top">
        <?php echo bk_get_category_link(get_the_ID());?>
        <?php echo bk_review_score(get_the_ID());?>
    </div> 
    <h4 class="title">
        <a href="<?php the_permalink();?>">
    		<?php 
    			$title = get_the_title();
    			echo the_excerpt_limit($title, 15);
    		?>
        </a>
    </h4>
    <div class="meta-bottom">
        <div class="meta-author">
            <span class="avatar">
                <i class="fa fa-user"></i>
            </span>
            <?php the_author_posts_link();?>           
        </div>
        <?php if ( comments_open() ) : ?>
    		<div class="meta-comment">
    			<span><i class="fa fa-comments-o"></i></span>
    			<?php comments_popup_link( __('0', 'bkninja'), __('1', 'bkninja'), __('%', 'bkninja')); ?>
    		</div>		
        <?php endif; ?> 
    </div>
</div>