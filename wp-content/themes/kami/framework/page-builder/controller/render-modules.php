<?php 
/*************************** Module Function ******************************/
/* -----------------------------------------------------------------------------
 * Module BK Main Slider
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_mainslider' ) ) {
	function bk_mainslider( $page_id, $module_prefix, $the_query ) {?>
        <?php global $main_slider;?>
        <?php $uid = uniqid();?>
        <?php $mainslider_id = 'slider_'.$uid?>
        <?php $carousel_ctr_id = 'carousel_ctrl_'.$uid?>
        <?php $main_slider[] = $uid;?>
        <?php wp_localize_script( 'customjs', 'main_slider', $main_slider );?>
        <?php if ( $the_query->have_posts() ) :?>
                <div id="<?php echo $mainslider_id;?>" class="slider-wrap flexslider" style="height:300px;">
                    <ul class="slides" style="height:300px;">
                        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>	
                        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'bkmain_slider');?>
                            <li class="item" style="height:300px;">
                                <div class="slider-background" style="background-image:url(<?php echo $thumb['0'];?>);background-size:cover;background-position:50% 50%;background-repeat:no-repeat;height:300px;"></div>
                                <div class="post-content" style="height:300px;">
                                    <div class="inner" style="height:300px;">
                                        <div class="inner-cell" style="height:300px;">
                                            <div class="meta-top"style="height:300px;">
                                                
                                            </div>
                                            <h2 class="title" style="height:300px;">
                                                <a href="<?php the_permalink();?>">
                                            		<?php 
                                            			
                                            		?>
                                                </a>
                                            </h2>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="bkdate">
                                    
                                </div>
                            </li>
                        <?php endwhile;?>
                    </ul>
                </div>
                <!-- rewind -->
                <?php rewind_posts(); ?>
               
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK ajax grid
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_grid_ajax' ) ) {
	function bk_grid_ajax( $page_id, $module_prefix, $the_query, $no_more ) { 
        global $loadmore;        
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));  
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );          
        $uid = uniqid('row');
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = 10;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = null;
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
       ?>
        <?php if ( $the_query->have_posts() ) :?>   
            <div class="content-wrap bk-fw">
                <ul class="item-list clearfix">
                    <?php echo bk_get_ajax_grid_content($the_query);?>
                </ul>
            </div>
            <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                <div class="loadmore-wrap" id="<?php echo $uid;?>">
                    <div class="loadmore previous ajax_grid no-more"></div>
                    
                    <div class="loadmore next ajax_grid <?php if ($no_more == 1) { echo 'no-more';}?>"></div>
                </div>
            <?php }?>
        <?php endif;?>            
        
<?php        
  }
}
/* -----------------------------------------------------------------------------
 * Module BK Grid
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_grid' ) ) {
	function bk_grid( $page_id, $module_prefix, $the_query ) {
        if ($the_query->post_count > 5) {?>
            <?php if ( $the_query->have_posts() ) :?>
                    <?php bk_get_module_title($page_id, $module_prefix);?>
                    <div class="feature-post">
                        <div class="flexslider grid-slider clearfix">
                            <ul class="slides clearfix">
                                <?php foreach( range( 1, $the_query->post_count - 5 ) as $i ):?>
                                <?php $the_query->the_post(); ?>
                                    <li class="item content-in">
                                        <?php get_template_part( 'templates/post_684x452' );?> 
                                    </li>            
                                <?php endforeach?>                                	
                            </ul>
                        </div>
                    </div>
                    <div class="sub-post right">
                        <ul class="subpost-list">
                            <?php foreach( range( 1, 2 ) as $i ):?>
                            <?php $the_query->the_post(); ?>
                                <li class="item content-in <?php echo 'item'.$i;?>">
                                    <?php get_template_part( 'templates/post_456x226' );?>
                                </li>
                            <?php endforeach?> 
                        </ul>
                    </div>
                    <div class="sub-post horizontal">
                        <ul class="subpost-list">
                            <?php foreach( range( 1, 3 ) as $i ):?>
                            <?php $the_query->the_post(); ?>
                                <li class="item content-in <?php echo 'item'.$i;?>">
                                    <?php get_template_part( 'templates/post_485x300' );?>
                                </li>
                            <?php endforeach?> 
                        
                        </ul>
                    </div>
            <?php endif;?>
        <?php }else {
            echo ("Warning: The module (BK Grid) is required at least 6 posts for display correctly");
        }?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Row
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_row' ) ) {
	function bk_row( $page_id, $module_prefix, $the_query, $bk_layout ) {
        global $loadmore;        
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true )); 
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );                
        $uid = uniqid('row');
        if ($bk_layout == 'three_cols') {
            $entries = get_post_meta( $page_id, $module_prefix.'_number', true ) * 3;
        }else {
            $entries = get_post_meta( $page_id, $module_prefix.'_number', true ) * 2;
        }
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = $entries;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = $bk_layout;
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
        ?>
            <?php if ( $the_query->have_posts() ) :?>
                        
                    <?php bk_get_module_title($page_id, $module_prefix);?>
                                        
                    <div class="content-wrap">
                        <ul class="item-list row">
                            <?php echo bk_get_row_content($the_query, $bk_layout);?>
                        </ul>
                    </div>
                    <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                        <div class="loadmore-wrap" id="<?php echo $uid;?>">
                            <div class="loadmore previous m_row no-more">
                                <div class="load-more-text">
                                    <span>
                                        <i class="fa fa-long-arrow-left"></i>                                                
                                    </span>
                                </div>
                            </div>
                            
                            <div class="loadmore next m_row <?php if ($the_query->post_count < $entries) {echo 'no-more';}?>">
                                <div class="load-more-text">
                                    <span>
                                        <i class="fa fa-long-arrow-right"></i>                                                
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php }?>
            <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Small Pieces
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_small_pieces' ) ) {
	function bk_small_pieces( $page_id, $module_prefix, $the_query ) {
        ?>
        <?php if ( $the_query->have_posts() ) :?>
            <?php bk_get_module_title($page_id, $module_prefix);?>                    
                <div class="content-wrap">
                    <ul class="item-list row">
                        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
                            <?php $category = get_the_category(get_the_ID());?>
                            <li class="col-sm-2 col-xs-4 content-out">
                                <a class="thumb <?php if (is_array($category)) { if(isset($category[0])) {echo "thumb-bg-".$category[0]->term_id;}}?> bk-tipper-bottom" data-title="<?php if (is_array($category)) { if(isset($category[0])) {echo esc_attr($category[0]->cat_name);}}?>: <?php echo get_the_title();?>"
                                href="<?php the_permalink();?>">
                                    <?php 
                                        if(has_post_thumbnail( get_the_ID() )) {
                                            echo get_the_post_thumbnail(get_the_ID(), 'bk230_140');
                                        }else {
                                            echo '<img width="400" height="300" src="'.get_template_directory_uri().'/images/bkdefault400_300.jpg">';
                                        }
                                        echo bk_get_post_icon(get_the_ID());
                                    ?>
                                </a>
                            </li>
                        <?php endwhile;?>
                    </ul>
                </div>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Row with Background
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_row_wbg' ) ) {
	function bk_row_wbg( $page_id, $module_prefix, $the_query ) {
        global $text_color;
		$title = esc_attr(get_post_meta( $page_id, $module_prefix.'_title', true ));
        $sub_title = esc_attr(get_post_meta( $page_id, $module_prefix.'_sub_title', true ));

        $text_color = esc_attr(get_post_meta( $page_id, $module_prefix.'_text_color', true )); 
        $background_color = esc_attr(get_post_meta( $page_id, $module_prefix.'_background_color', true ));
        ?>
            <?php if ( $the_query->have_posts() ) :?>
                <?php if ($title != '') {?>	
                    <div class="module-title title-in" style="background-color: <?php echo esc_attr($background_color);?>">
						<h3 style="color: <?php echo esc_attr($text_color);?>"><?php echo esc_attr($title); ?></h3>
                        <?php if(strlen($sub_title)!=0) {?>
                        <h4 style="color: <?php echo esc_attr($text_color);?>; border-color: <?php echo esc_attr($text_color);?> ;" class="sub-title"><?php echo esc_attr($sub_title); ?></h4>
                        <?php }?>
					</div>
                    <?php }?>
                    <ul class="item-list row">
                        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
                        <?php
                            $category = get_the_category(get_the_ID());        
                        ?>
                            <li class="col-md-4">
        						<div class="item content-out co-type1">
                                    <div class="thumb <?php if (is_array($category)) { if(isset($category[0])) {echo "thumb-bg-".$category[0]->term_id;}}?>">
                                        <a href="<?php the_permalink();?>">
                                        <?php 
                                            if(has_post_thumbnail( get_the_ID() )) {
                                                echo get_the_post_thumbnail(get_the_ID(), 'bk485_300');
                                            }else {
                                                echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                                            }
                                        ?>
                                        </a>
                                        <?php
                                            echo bk_get_post_icon(get_the_ID());
                                        ?>
                                    </div>
                                    <h4 class="title" style="color: <?php echo esc_attr($text_color);?>">
                                        <a href="<?php the_permalink();?>">
                                    		<?php 
                                    			$title = get_the_title();
                                    			echo esc_attr($title);
                                                //echo the_excerpt_limit($title, 15);
                                    		?>
                                        </a>
                                    </h4>
                                </div>
                                <div class="meta-bottom" style="color: <?php echo esc_attr($text_color);?>">
                                    
                                </div>
                            </li>
                        <?php endwhile;?>
                    </ul>
            <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}

/*
 *  Has right sidebar module
 */
 /* -----------------------------------------------------------------------------
 * Module BK 1l and 2 side m
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_1l_2m_side' ) ) {
	function bk_1l_2m_side( $page_id, $module_prefix, $the_query ) {
        global $loadmore;
        
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true ); 
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        
        $uid = uniqid('1l_2m_side');
        $entries = 3;
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = $entries;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = null;
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
        ?>        
        <?php if ( $the_query->have_posts() ) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap">
                    <div class="row">
                        <?php echo bk_get_1l_2m_side_content($the_query)?>
                    </div>  
                </div>
                <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                    <div class="loadmore-wrap" id="<?php echo $uid;?>">
                        <div class="loadmore previous 1l_2m_side no-more">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-left"></i>                                                
                                </span>
                            </div>
                        </div>
                        <div class="loadmore next 1l_2m_side <?php if ($the_query->post_count < $entries) {echo 'no-more';}?>">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-right"></i>                                                
                                </span>
                            </div>
                        </div>         
                    </div>    
                <?php }?>                       
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}

/* -----------------------------------------------------------------------------
 * Module BK Blog Small
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_blog_small' ) ) {
	function bk_blog_small( $page_id, $module_prefix, $the_query ) {
        global $loadmore;
        
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true ); 
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        
        $uid = uniqid('blog_small');
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = $number;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = null;
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
        $section_check = explode("_",$module_prefix);
        ?>
        <?php if ( $the_query->have_posts() ) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap">
                    <ul class="item-list blog-post-list row">
                        <?php 
                            if ($section_check[1] == 'leftsec') {
                                echo bk_get_blog_small_leftsec_content($the_query);
                            }else {
                                echo bk_get_blog_small_content($the_query);
                            }
                        ?>
                    </ul>
                </div>
                <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                    <div class="loadmore-wrap" id="<?php echo $uid;?>">
                        <div class="loadmore previous <?php if ($section_check[1] == 'leftsec') {echo ('blog_small_leftsec');}else {echo ('blog_small');}?> no-more">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-left"></i>                                                
                                </span>
                            </div>
                        </div>
                        <div class="loadmore next <?php if ($section_check[1] == 'leftsec') {echo ('blog_small_leftsec');}else {echo ('blog_small');}?>">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-right"></i>                                                
                                </span>
                            </div>
                        </div> 
                    </div>    
                <?php }?>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Large Blog
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_large_blog' ) ) {
	function bk_large_blog( $page_id, $module_prefix, $the_query ) {
        global $loadmore;
        
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true ); 
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        
        $uid = uniqid('large_blog');
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = $number;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = null;
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
        $section_check = explode("_",$module_prefix);
        ?>
        <?php if ( $the_query->have_posts() ) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap">
                    <ul class="item-list blog-post-list row">
                        <?php 
                            if ($section_check[1] == 'leftsec') {
                                echo bk_get_large_blog_content($the_query);
                            }else {
                                echo bk_get_large_blog_content($the_query);
                            }
                        ?>
                    </ul>
                </div>
                <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                    <div class="loadmore-wrap" id="<?php echo $uid;?>">
                        <div class="loadmore previous large_blog no-more">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-left"></i>                                                
                                </span>
                            </div>
                        </div>
                        <div class="loadmore next large_blog">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-right"></i>                                                
                                </span>
                            </div>
                        </div> 
                    </div>    
                <?php }?>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Windows
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_windows' ) ) {
	function bk_windows( $page_id, $module_prefix, $the_query ) {
        global $loadmore;
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true ); 
        $bk_layout = get_post_meta( $page_id, $module_prefix.'_columns', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        
        if ($bk_layout == 'three_cols'){$entries = $number*3;}else {$entries = $number*2;}
        
        $uid = uniqid('windows');
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = $entries;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = $bk_layout;
        
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
        ?>        
        <?php if ( $the_query->have_posts() ) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap">
                    <ul class="row">
                        <?php echo (bk_get_windows_content($the_query, $bk_layout));?>
                    </ul>
                </div>
                <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                    <div class="loadmore-wrap" id="<?php echo $uid;?>">
                        <div class="loadmore previous windows no-more">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-left"></i>                                                
                                </span>
                            </div>
                        </div>
                        <div class="loadmore next windows <?php if ($the_query->post_count < $entries) {echo 'no-more';}?>">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-right"></i>                                                
                                </span>
                            </div>
                        </div>
                    </div>
                <?php }?>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Block One
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_block_one' ) ) {
	function bk_block_one( $page_id, $module_prefix, $the_query_1, $the_query_2 ) {
        ?>        
        <?php if (( $the_query_1->have_posts() ) || ( $the_query_2->have_posts() )) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap row">
                    <div class="bkcol-half col-md-6">
                        <?php echo (bk_get_block_one($the_query_1));?> 
                    </div>
                    <div class="bkcol-half col-md-6">
                        <?php echo (bk_get_block_one($the_query_2));?> 
                    </div>                    
                </div>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Block Two
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_block_two' ) ) {
	function bk_block_two( $page_id, $module_prefix, $the_query ) {
        ?>        
        <?php if ($the_query->have_posts()) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap row">
                    <div class="bkcol-half col-md-6">
                        <div class="main-post">
                           <?php foreach( range( 1, 1 ) as $i ):?>
                                <?php $the_query->the_post(); ?>
                                <?php $category = get_the_category(get_the_ID());?>
                                <div class="content-out co-type1 post-element">
                                    <?php get_template_part( 'templates/post_485x300_row' );?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="bkcol-half col-md-6">
                        <?php if ($the_query->post_count > 1) {?>
                            <div class="subpost">
                                <ul class="list post-list row">
                                    <?php foreach( range( 1, ($the_query->post_count - 1) ) as $i ):?>
                                    <?php $the_query->the_post(); ?>
                                        <li class="item content-out co-type3 col-md-12 clearfix">
                                            <?php get_template_part( 'templates/post_widget_style1' );?>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        <?php }?>
                    </div>
                </div>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK 1l and list post side
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_1l_list_side' ) ) {
	function bk_1l_list_side( $page_id, $module_prefix, $the_query ) {
        global $loadmore; 
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $ajax_load = get_post_meta( $page_id, $module_prefix.'_ajax_load', true );
        $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true ); 
        
        $entries = 5;
        $uid = uniqid('1l_list_side');
        $loadmore['offset'][$uid] = $offset;
        $loadmore['cat'][$uid] = $category;
        $loadmore['entry'][$uid] = $entries;
        $loadmore['background_color'][$uid] = null;
        $loadmore['text_color'][$uid] = null;
        $loadmore['bk_layout'][$uid] = null;
        
        wp_localize_script( 'customjs', 'loadmore', $loadmore );
        ?>        
        <?php if ( $the_query->have_posts() ) :?>
                <?php bk_get_module_title($page_id, $module_prefix);?>
                <div class="content-wrap">
                    <div class="row">
                        <?php echo (bk_get_1l_list_side_content($the_query));?> 
                    </div>
                </div>
                <?php if(($ajax_load == 'enable') && ($order!= 'rand')) {?>
                    <div class="loadmore-wrap" id="<?php echo $uid;?>">
                        <div class="loadmore previous 1l_list_side no-more">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-left"></i>                                                
                                </span>
                            </div>
                        </div>
                        <div class="loadmore next 1l_list_side <?php if ($the_query->post_count < $entries) {echo 'no-more';}?>">
                            <div class="load-more-text">
                                <span>
                                    <i class="fa fa-long-arrow-right"></i>                                                
                                </span>
                            </div>
                        </div>
                    </div>
                <?php }?>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/*** Inner Sidebar ***/
/* -----------------------------------------------------------------------------
 * Module BK Most Commented
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_most_commented' ) ) {
	function bk_most_commented( $page_id, $module_prefix, $the_query ) {
		$title = esc_attr(get_post_meta( $page_id, $module_prefix.'_title', true ));
        $sub_title = esc_attr(get_post_meta( $page_id, $module_prefix.'_sub_title', true )); 
        ?>
        <?php if ( $the_query->have_posts() ) :?>
            <?php if ($title != '') {?>	
                    <h3 class="title"><?php echo esc_attr($title); ?></h3>
                <?php }?>
                <ul class="post-list">
                    <?php while ( $the_query->have_posts() ): $the_query->the_post(); 
                        $category = get_the_category(get_the_ID());
                    ?>
                    <li class="item content-out co-type1 clearfix">
                        <div class="thumb <?php if (is_array($category)) { if(isset($category[0])) {echo "thumb-bg-".$category[0]->term_id;}}?>">
                            <?php 
                                if(has_post_thumbnail( get_the_ID() )) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'bk230_140');
                                }else {
                                    echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                                }
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
                        </div>
                    </li>
                    <?php endwhile;?>
                </ul>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Latest
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_latest' ) ) {
	function bk_latest( $page_id, $module_prefix, $the_query ) {
		$title = esc_attr(get_post_meta( $page_id, $module_prefix.'_title', true ));
        $sub_title = esc_attr(get_post_meta( $page_id, $module_prefix.'_sub_title', true )); 
        ?>
        <?php if ( $the_query->have_posts() ) :?>
            <?php if ($title != '') {?>	
                    <h3 class="title"><?php echo esc_attr($title); ?></h3>
                <?php }?>
                <div class="main-post content-out co-type1 clearfix">
                    <?php foreach( range( 1, 1 ) as $i ):?>
                        <?php $the_query->the_post(); 
                            $category = get_the_category(get_the_ID());
                        ?>
                        <div class="thumb <?php if (is_array($category)) { if(isset($category[0])) {echo "thumb-bg-".$category[0]->term_id;}}?>">
                            <?php 
                                if(has_post_thumbnail( get_the_ID() )) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'bk230_140');
                                }else {
                                    echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                                }
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
                        </div>
                    <?php endforeach;?>
                </div>
                <ul class="post-list">
                    <?php foreach( range( 1, ($the_query->post_count - 1) ) as $i ):?>
                    <?php $the_query->the_post(); ?>
                    <li class="item">
                        <h4 class="title">
                            <i class="fa fa-square"></i> 
                            <a href="<?php the_permalink();?>">
                        		<?php 
                        			$title = get_the_title();
                        			echo the_excerpt_limit($title, 15);
                        		?>
                            </a>
                        </h4>
                    </li>
                    <?php endforeach;?>
                </ul>
        <?php endif;?>
        <?php 
		wp_reset_postdata();
	}
}
/* -----------------------------------------------------------------------------
 * Module BK Ads
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_ads' ) ) {
	function bk_ads( $page_id, $module_prefix ) {
		$image_url = get_post_meta( $page_id, $module_prefix.'_image_url', true );
        $url = get_post_meta( $page_id, $module_prefix.'_url', true );?>
        <div class="bk-ads"> 
            <?php if (strlen($image_url) > 0) {?>
        	<a class="ads-banner-link" target="_blank" href="<?php echo esc_url($url); ?>"> 
    			<img class="ads-banner" src="<?php echo esc_url($image_url); ?>" alt=""/>
    		</a>
            <?php }?>                   
        </div> 
    <?php
    }        
} 
/* -----------------------------------------------------------------------------
 * Module BK Ads (Two Cols)
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_two_col_ads' ) ) {
	function bk_two_col_ads( $page_id, $module_prefix ) {
		$image_url1 = get_post_meta( $page_id, $module_prefix.'_image_url1', true );
        $url1 = get_post_meta( $page_id, $module_prefix.'_url1', true );
        $image_url2 = get_post_meta( $page_id, $module_prefix.'_image_url2', true );
        $url2 = get_post_meta( $page_id, $module_prefix.'_url2', true );?>
        <ul class="bk-ads row"> 
            <?php 
            if (strlen($image_url1) > 0) {?>
            <li class="col-md-6">
            	<a class="ads-banner-link" target="_blank" href="<?php echo esc_url($url1); ?>"> 
        			<img class="ads-banner" src="<?php echo esc_url($image_url1); ?>" alt=""/>
        		</a>
            </li>
            <?php }
            if (strlen($image_url2) > 0) {?>
            <li class="col-md-6">
            	<a class="ads-banner-link" target="_blank" href="<?php echo esc_url($url2); ?>"> 
        			<img class="ads-banner" src="<?php echo esc_url($image_url2); ?>" alt=""/>
        		</a>
            </li>
            <?php }?> 
                              
        </ul> 
    <?php
    }        
} 
/* -----------------------------------------------------------------------------
 * Module BK Ads (Three Cols)
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_three_col_ads' ) ) {
	function bk_three_col_ads( $page_id, $module_prefix ) {
		$image_url1 = get_post_meta( $page_id, $module_prefix.'_image_url1', true );
        $url1 = get_post_meta( $page_id, $module_prefix.'_url1', true );
        $image_url2 = get_post_meta( $page_id, $module_prefix.'_image_url2', true );
        $url2 = get_post_meta( $page_id, $module_prefix.'_url2', true );
        $image_url3 = get_post_meta( $page_id, $module_prefix.'_image_url3', true );
        $url3 = get_post_meta( $page_id, $module_prefix.'_url3', true );?>
        <ul class="bk-ads row"> 
            <?php 
            if (strlen($image_url1) > 0) {?>
            <li class="col-md-4">
            	<a class="ads-banner-link" target="_blank" href="<?php echo esc_url($url1); ?>"> 
        			<img class="ads-banner" src="<?php echo esc_url($image_url1); ?>" alt=""/>
        		</a>
            </li>
            <?php }
            if (strlen($image_url2) > 0) {?>
            <li class="col-md-4">
            	<a class="ads-banner-link" target="_blank" href="<?php echo esc_url($url2); ?>"> 
        			<img class="ads-banner" src="<?php echo esc_url($image_url2); ?>" alt=""/>
        		</a>
            </li>
            <?php }
            if (strlen($image_url3) > 0) {?>
            <li class="col-md-4">
            	<a class="ads-banner-link" target="_blank" href="<?php echo esc_url($url3); ?>"> 
        			<img class="ads-banner" src="<?php echo esc_url($image_url3); ?>" alt=""/>
        		</a>
            </li>
            <?php }?> 
                              
        </ul> 
    <?php
    }        
} 
/* -----------------------------------------------------------------------------
 * Module BK Adsense
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_adsense' ) ) {
	function bk_adsense( $page_id, $module_prefix ) {
        $adsense_code = get_post_meta( $page_id, $module_prefix.'_adsense_code', true );?>
        <div class="bk-ads ">
            <?php if (strlen($adsense_code) > 0) {?>
                <?php echo ($adsense_code);?>   
            <?php }?> 
        </div> 
    <?php
    }        
}
