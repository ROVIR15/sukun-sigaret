<?php
/**
 * The template for displaying Author archive pages
 *
 */
 ?> 
<?php get_header();?>
<?php
global $bk_option;
$cat_bg_img = null;
if (isset($bk_option) && ($bk_option != '')): 
    $bk_layout = $bk_option['bk-category-layout'];
    $category_color_settings = $bk_option['bk-category-color-select'];
    $cur_cat_id = $wp_query->get_queried_object_id();
    $cat_opt = get_option('bk_cat_opt');
    $cat_feat = '';    
    $cat_layout = 0;
    $cat_title = 0;
    $bk_page_title = $bk_option['archive-page-title'];
endif;
$meta = array();
$meta = get_option('bk_cat_opt');
if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('cat_layout',$cat_opt[$cur_cat_id])) { $cat_layout = $cat_opt[$cur_cat_id]['cat_layout'];};
if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('cat_feat',$cat_opt[$cur_cat_id])) { $cat_feat = $cat_opt[$cur_cat_id]['cat_feat'];};
if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('cat_bg_img',$cat_opt[$cur_cat_id])) { $cat_bg_img = $cat_opt[$cur_cat_id]['cat_bg_img'];};
if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('cat_title',$cat_opt[$cur_cat_id])) { $cat_title = $cat_opt[$cur_cat_id]['cat_title'];};
if ($cat_feat == '') { $cat_feat = 0;};
if ((strlen($cat_layout) != 0)&&($cat_layout != 'global')) { $bk_layout = $cat_layout;};
if ((strlen($cat_title) != 0)&&($cat_title != 'global')) { $bk_page_title = $cat_title;};
if ($cat_bg_img != null) {
    $bg_url = wp_get_attachment_image_src($cat_bg_img[0], 'full');
?>
<style>
    body {
        background-image: none;
    }
</style>
<script>
    jQuery(document).ready(function($){
        jQuery('body').css('background-image', 'url(<?php echo $bg_url[0];?>)');
    });
</script>
<?php }?>

<?php if ($category_color_settings == 'custom_category_color') {?>
<script>
    jQuery(document).ready(function($){
        $('.page-numbers').css({'border-color': '<?php echo esc_attr($cat_opt[$cur_cat_id]['cat_color']);?>','color': '<?php echo esc_attr($cat_opt[$cur_cat_id]['cat_color']);?>'});
        $('.page-numbers.current').css({'background-color': '<?php echo esc_attr($cat_opt[$cur_cat_id]['cat_color']);?>', 'color': '#fff'});
    });
</script>
<?php }?>
<div id="body-wrapper">
    <div class="container">		
        <div class="row">			
            <div class="bk-category-content content <?php if ((!($bk_layout == 'row-3-columns')) && (!($bk_layout == 'windows-3-columns')) && (!($bk_layout == 'windows-2-columns-fullwidth'))): echo 'col-md-8'; else: echo 'col-md-12';  endif;?>">
                <?php if($bk_page_title != 'hide'){?>
                <div class="module-title title-cat-<?php echo $cur_cat_id;?>">
        			<h3 class="heading"><span><?php single_cat_title();?></span></h3>
                    <?php if ( category_description() ) : // Show an optional category description ?>
        				    <div class="archive-meta"><?php echo category_description(); ?></div>
        			<?php endif;?>
                </div>
                <?php }?>
                <div class="row">
                    <div id="main-content" class="clear-fix" role="main">
                		
                    <?php
                        if (have_posts()) { 
/**
 *  
 * Category Feature Slider 
 */                            
                            if ($cat_feat) {
                                $feat_tag = '';
                                if ($bk_option['feat-tag'] != ''){
                                    $feat_tag = $bk_option['feat-tag'];
                                }                                
                                if ($feat_tag != '') {
                                    $args = array(
                        				'tag__in' => $feat_tag,
                                        'cat' => $cur_cat_id,
                            			'post_status' => 'publish',
                            			'ignore_sticky_posts' => 1,
                            			'posts_per_page' => 5,
                                    );   
                                } else {
                                    $args = array(
                        				'post__in'  => get_option( 'sticky_posts' ),
                                        'cat' => $cur_cat_id,
                        				'post_status' => 'publish',
                        				'ignore_sticky_posts' => 1,
                        				'posts_per_page' => 5,
                                    );
                                }
                                $the_query = new WP_Query( $args );?>
                                <?php if ( $the_query->have_posts() ) :?>   
                                    <div class="col-md-12">
                                        <div class="cat-slider flexslider">
                                            <ul class="slides">
                                                <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>	
                                                    <li class="item content-in">
                                                        <div class="thumb">
                                                            <?php 
                                                                if(has_post_thumbnail( get_the_ID() )) {
                                                                    echo get_the_post_thumbnail(get_the_ID(), 'bk684_452');
                                                                }else {
                                                                    echo '<img width="684" height="452" src="'.get_template_directory_uri().'/images/bkdefault684_452.jpg">';
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="post-content">
                                                            <div class="inner">
                                                                <div class="inner-cell">
                                                                    <h2 class="title">
                                                                        <a href="<?php the_permalink();?>">
                                                                    		<?php 
                                                                    			$title = get_the_title();
                                                                    			echo esc_attr($title);
                                                                    		?>
                                                                        </a>
                                                                    </h2>
                                                                    <a class="readmore-btn" href="<?php the_permalink();?>">
                                                                        <span><?php _e('Read More','bkninja');?></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bkdate">
                                                            <div class="day"><?php echo get_the_date('j'); ?></div>
                                                            <div class="month"><?php echo get_the_date('M'); ?></div>
                                                        </div>
                                                    </li>
                                                <?php endwhile;?>
                                            </ul>
                                        </div>
                                     </div>  
                                <?php endif;?>
                                                                
                          <?php }             
/**
 *  Small Blog Style 
 * 
 */            
                            if ($bk_layout == 'blog-small') { ?>
                                <div class="content-wrap bk-blog-small">
                                    <ul class="item-list blog-post-list">
                                        <?php while (have_posts()): the_post(); ?>  	
                                        <li class="col-md-12">
                                            <div class="item content-out co-type3 post-element clearfix">
                                                <?php get_template_part( 'templates/bk_blog_small' );?>
                                            </div>
                                        </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>  
                            <?php } 
/**
 *  Large Blog Style 
 * 
 */            
                            else if ($bk_layout == 'large-blog') { ?>
                                <div class="content-wrap bk-large-blog clearfix">
                                    <ul class="item-list blog-post-list">
                                        <?php while (have_posts()): the_post(); ?>  	
                                        <li class="col-md-12">
                                            <div class="item content-out co-type1 post-element clearfix">
                                                <?php get_template_part( 'templates/large_blog' );?>
                                            </div>
                                        </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>  
                            <?php } 
/**
 * windows
 * 
 */   
                            else if (($bk_layout == 'windows-2-columns') || ($bk_layout == 'windows-3-columns') || ($bk_layout == 'windows-2-columns-fullwidth')) {?>
                                <div class="content-wrap module-windows <?php if ($bk_layout == 'windows-3-columns'){echo 'three-cols';}else {echo 'two-cols';} if($bk_layout == 'windows-2-columns-fullwidth') {echo ' fullwidth';}?> clearfix">
                                    <ul>
                                        <?php while (have_posts()): the_post(); ?>  
                                            <li class="<?php if ($bk_layout == 'windows-3-columns'){echo 'col-md-4 col-sm-6';}else {echo 'col-sm-6';}?>">
                                                <div class="content-in">
                                                    <?php get_template_part( 'templates/bk_windows' );?>
                                                 </div>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?> 
                            <?php
/**
 * Row
 * 
 */                         
                             }else if (($bk_layout == 'row-2-columns') || ($bk_layout == 'row-3-columns')) {?>
                                <div class="content-wrap module-row <?php if ($bk_layout == 'row-3-columns'){echo 'three-cols';}else {echo 'two-cols';}?> clearfix">
                                    <ul>
                                        <?php while (have_posts()): the_post(); ?>  
                                            <li class="<?php if ($bk_layout == 'row-3-columns'){echo 'col-md-4 col-sm-6';}else {echo 'col-sm-6';}?> ">
                                                <div class="item content-out co-type1">
                                                    <?php get_template_part( 'templates/post_485x300_row' );?>
                                                 </div>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?> 
                            <?php
                            }else { ?>
                                <div class="content-wrap bk-blog-small">
                                    <ul class="item-list blog-post-list">
                                        <?php while (have_posts()): the_post(); ?>  	
                                        <li class="col-md-12">
                                            <div class="item content-out co-type3 post-element clearfix">
                                                <?php get_template_part( 'templates/bk_blog_small' );?>
                                            </div>
                                        </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>
                            <?php }
                        } else { _e('No post to display','bkninja');} ?>
            
    	            </div> <!-- end #main -->
                </div>
            </div> <!-- end #bk-content -->
            <?php
                if ((!($bk_layout == 'row-3-columns')) && (!($bk_layout == 'windows-3-columns')) && (!($bk_layout == 'windows-2-columns-fullwidth'))) {?>
                    <div class="sidebar col-md-4">
                    <?php get_sidebar();?>
                    </div>
                <?php }
            ?>
        </div>
    </div>
</div>   
<?php get_footer(); ?>