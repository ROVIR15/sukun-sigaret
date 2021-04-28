<?php get_header();?>
<?php
global $bk_option;
if (isset($bk_option) && ($bk_option != '')): 
    $bk_layout = $bk_option['bk-blog-layout'];
endif;
?>
<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts('post_type=post&post_status=publish&paged=' . $paged);
?>
<div id="body-wrapper">
    <div class="container">		
        <div class="row">			
            <div class="bk-blog-content content <?php if ((!($bk_layout == 'row-3-columns')) && (!($bk_layout == 'windows-3-columns')) && (!($bk_layout == 'windows-2-columns-fullwidth'))): echo 'col-md-8'; else: echo 'col-md-12';  endif;?>">
                <div class="module-title">
			         <h3 class="heading"><span><?php _e( 'Latest Articles', 'bkninja' );?></span></h3> 
                </div>
                <div class="row">
                    <div id="main-content" class="clear-fix" role="main">
                		
                    <?php
                        if (have_posts()) { 
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