<?php get_header(); ?>
<?php 
    $social_share = array();
    $share_box = $bk_option['bk-sharebox-sw'];

    $social_share['fb'] = $bk_option['bk-fb-sw'];
    $social_share['tw'] = $bk_option['bk-tw-sw'];
    $social_share['gp'] = $bk_option['bk-gp-sw'];
    $social_share['pi'] = $bk_option['bk-pi-sw'];
    $social_share['tbl'] = $bk_option['bk-tbl-sw'];
    $social_share['li'] = $bk_option['bk-li-sw'];
    $social_share['su'] = $bk_option['bk-su-sw'];

    $authorbox_sw = $bk_option['bk-authorbox-sw'];
    $postnav_sw = $bk_option['bk-postnav-sw'];
    $related_sw = $bk_option['bk-related-sw'];
?>
    <div class="single-page container" id="body-wrapper">
        <div class="row">    
    	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php 
                $postID = get_the_ID();
                $bk_review_checkbox = get_post_meta($postID,'bk_review_checkbox',true);
                $bk_title_align = get_post_meta($postID,'bk_post_title_align',true);
                $bk_title_position = get_post_meta($postID,'bk_post_title_position',true);
                $feature_image_position = get_post_meta($postID,'bk_feature_image_position',true);
                $review_box_position = get_post_meta($postID,'bk_review_box_position',true);
                $page_fw = get_post_meta($postID,'bk_post_fullwidth_checkbox',true);
                if($page_fw == '1') {
                    $feature_image_position = 'fullwidth';
                }
            ?>
    		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                <?php setPostViews($postID);?>
                <?php if (($page_fw == '1') || ($feature_image_position == 'fullwidth')) {?>
                    <?php bk_title_and_feature_image_display($postID, $social_share, $bk_title_position, $bk_title_align, $feature_image_position);?> 
                <?php }?>
                <div class="content-wrap <?php if ($page_fw == '1') { echo 'col-md-12';} else {echo 'col-md-8';};?>" <?php if ( $bk_review_checkbox != '1' ) { echo 'itemscope itemtype="http://schema.org/BlogPosting"'; } else { echo 'itemscope itemtype="http://schema.org/Review"'; } ?>>
                    <?php if (($page_fw != '1') && ($feature_image_position != 'fullwidth')) {?>
                        <?php bk_title_and_feature_image_display($postID, $social_share, $bk_title_position, $bk_title_align, $feature_image_position);?>  
                    <?php }?>   
        			<div class="entry clearfix <?php if((has_post_format( 'image') && ($bk_title_position == 'below') && (($page_fw == '1') || ($feature_image_position == 'fullwidth'))) 
                                                    ||(!has_post_format() && ($bk_title_position == 'below') && (($page_fw == '1') || ($feature_image_position == 'fullwidth'))))
                                                    {echo 'fw-below';}?> ">
                        <?php if ($bk_title_position == 'below') {?>
                                <?php if(($feature_image_position == 'fullwidth') || ($page_fw == '1')) {?>
                                <?php bk_display_single_top($postID, $social_share);?> 
                                <?php }?>                       
                                <?php bk_single_title_display($bk_title_align,  $bk_review_checkbox);?>
                        <?php }?>                    
                        <?php
                            if (($review_box_position != 'below') && ($bk_review_checkbox)) {?>
                                <div class="single-rating-box <?php echo $review_box_position;?>">
                                    <h4>Our Rating</h4>
                                    <?php echo (bk_post_review_boxes($postID));?>
                                </div>
                        <?php }?>
        				<div class="article-content" <?php if ( $bk_review_checkbox == '1' ) { echo 'itemprop="reviewBody"'; } else { echo 'itemprop="articleBody"'; } ?>>
                            <?php bk_single_content($postID);?>
                        </div>
                        <?php
                            if (($review_box_position == 'below') && ($bk_review_checkbox)) {?>
                                <div class="single-rating-box <?php echo $review_box_position;?>">
                                    <h4>Our Rating</h4>
                                    <?php echo (bk_post_review_boxes($postID));?>
                                </div>
                        <?php }?>
                        <?php wp_link_pages( array(
    							'before' => '<div class="post-page-links">',
    							'pagelink' => '<span>%</span>',
    							'after' => '</div>',
    						)
    					 ); 
                        ?>
                        <?php 
                			$tags = get_the_tags();
                            if ($tags): ?>
                            <div class="tag-bottom">
                                <span class="post-tags-title">Tags:</span>
                                <?php
                					foreach ($tags as $tag):
                						echo '<a class="tag-btn" href="'. get_tag_link($tag->term_id) .'" title="'. esc_attr(sprintf(__("View all posts tagged %s",'bkninja'), $tag->name)) .'">'. $tag->name.'</a>';
                					endforeach;
                                ?>
                            </div>
                    	<?php endif; ?>
        			</div>
                    <?php if ($share_box) {?>
                        <div class="share-box-wrap clearfix">
                            <div class="label"><h3><span><?php _e('Share on', 'bkninja');?></span></h3></div>
                             <?php bk_share_box($social_share, $postID);?>
                        </div>
                    <?php }?>

                    <?php if ($postnav_sw) {?>
                        <?php
                        	$next_post = get_next_post();
                        	$prev_post = get_previous_post();
                        	if (!empty($prev_post) || !empty($next_post)): ?>

                        	<nav class="post-nav clearfix">
                        		<?php if (!empty($prev_post)): ?>
                                <div class="post-nav-link  post-nav-link-prev">
                                    <div class="thumb">
                                        <?php 
                                            if(has_post_thumbnail( $prev_post->ID )) {
                                                echo get_the_post_thumbnail($prev_post->ID, 'bk485_300');
                                            }else {
                                                echo '<img width="500" height="200" src="'.get_template_directory_uri().'/images/bkdefault500_200.jpg">';
                                            }
                                        ?>
                                    </div>
                					<div class="post-nav-link-title">
                                        <div class="inner"> 
                                            <div class="inner-cell">
                                                <?php previous_post_link( '%link','<span class="sub-title">'.__("Previous Article").'</span>
                                                <h3>%title</h3>' ); ?>
                                            </div>
                                        </div>
                					</div>
                                    <a class="bk-cover-link" href="<?php echo get_permalink( $prev_post->ID ); ?>"></a>
                                </div>
                        		<?php endif; ?>
                   		     <?php if (!empty($next_post)): ?>
                                <div class="post-nav-link  post-nav-link-next">
                                    <div class="thumb">
                                        <?php 
                                            if(has_post_thumbnail( $next_post->ID )) {
                                                echo get_the_post_thumbnail($next_post->ID, 'bk485_300');
                                            }else {
                                                echo '<img width="500" height="200" src="'.get_template_directory_uri().'/images/bkdefault500_200.jpg">';
                                            }
                                        ?>
                                    </div>
                					<div class="post-nav-link-title">
                                        <div class="inner"> 
                                            <div class="inner-cell">
                                                <?php next_post_link( '%link','<span class="sub-title">'.__("Next Article").'</span>
                                                <h3> %title</h3>' ); ?>
                                            </div>
                                        </div>
                					</div>
                                    <a class="bk-cover-link" href="<?php echo get_permalink( $next_post->ID ); ?>"></a>
                                </div>
                        		<?php endif; ?>
                            </nav>                    	
                            <?php endif; ?>
                    <?php }?>    
                    
                    <?php if ($authorbox_sw) {?>
                        <div class="author-box-wrap">
                            <div class="label"><h3><span><?php _e('About author', 'bkninja');?></span></h3></div>
                            <?php $bk_author_id = $post->post_author; echo bk_author_details($bk_author_id); ?>
                        </div>
                    <?php }?>     
                                        
                    <?php if ($related_sw){?>  
                        <div class="related-box-wrap">
                            <div class="label"><h3><span><?php _e('Related articles', 'bkninja');?></span></h3></div>
                            <?php if ($page_fw == '1') {
                                    $bk_related_num = 3;
                                }else{
                                    $bk_related_num = 2;
                                } 
                                echo (bk_related_posts($bk_related_num));?>
                        </div>
                    <?php }?>
                    <?php if ( comments_open() ) : ?>
                        <div class="comment-box-wrap">
                            <?php if (is_user_logged_in()) {?>
                            <div class="label"><h3><span><?php _e('Leave a reply', 'bkninja');?></span></h3></div>
                            <?php }?>
                            <?php comments_template(); ?>
                        </div>
                    <?php endif;?>
                </div>
                <!-- Sidebar -->
                <?php if ($page_fw != '1') {?>
                <div class="sidebar col-md-4" <?php if ($feature_image_position == 'fullwidth'){echo ('style="margin-top: 30px;"');}?>>
                    <?php get_sidebar(); ?>
                </div>
                <?php }?>
    		</div>
    
    	<?php endwhile; endif; ?>
	   </div>
    </div>
    <?php if ($bk_option['bk-recommend-box'] == 1) {?>
        <?php get_template_part( 'templates/bk_recommend_box');?>
    <?php }?>
<?php get_footer(); ?>