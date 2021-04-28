<?php
/* -----------------------------------------------------------------------------
 * Render Sections
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_page_builder' ) ) {
	function bk_page_builder( $args=array() ) {
		$page_id = get_queried_object_id();

		for ( $counter=1; $counter < 50; $counter++ ) { 
			$field_prefix = 'bk_section_'.$counter;
			$section_type = get_post_meta( $page_id, $field_prefix, true );
			if ( ! $section_type ) break;

            if ($section_type == 'fullwidth'){?>
                <div class="fullwidth container bksection">
                    <div class="row">
                        <div class='content col-md-12'>
                            <?php
                            for ($mcount=1; $mcount <50; $mcount ++) {
                                $module_prefix = 'bk_fullwidth_module_'.$counter.'_'.$mcount;
                                $module_type = get_post_meta( $page_id, $module_prefix, true );
                                if ( ! $module_type ) break;
                                call_user_func( 'bk_'.$module_type.'_render', $page_id, $module_prefix );
                            }?>
                        </div>
                    </div>
                </div>
            <?php
            }else if($section_type == 'has-rsb') {
                $sidebar_prefix = 'bk_sidebar_'.$counter;
                $sidebar = get_post_meta( $page_id, $sidebar_prefix, true );?>
                
                <div class="has-sb container bksection">
                    <div class="row">
                        <div class="content-wrap col-md-8">
                        <?php
                            for ($mcount=1; $mcount <50; $mcount ++) {
                                $module_prefix = 'bk_has_rsb_module_'.$counter.'_'.$mcount;
                                $module_type = get_post_meta( $page_id, $module_prefix, true );
                                if ( ! $module_type ) break;
                                call_user_func( 'bk_'.$module_type.'_render', $page_id, $module_prefix );
                            }?>
                        </div>
                    
                        <div class='sidebar col-md-4'>
                            <aside class="sidebar-wrap">
                                <?php dynamic_sidebar( $sidebar );?>
                            </aside>
                        </div>
                    </div>
                </div>
            <?php
            }else if($section_type == 'has-innersb') {
                $sidebar_prefix = 'bk_sidebar_'.$counter;
                $sidebar = get_post_meta( $page_id, $sidebar_prefix, true );
                ?>
                <div class="has-sb has-sbinner bksection container">
                    <div class="row">
                        <div class="content-wrap col-md-8">
                            <div class="row">
                                <div class="content col-md-9">
                                    <?php
                                    for ($mcount=1; $mcount <50; $mcount ++) {
                                        $module_prefix = 'bk_leftsec_module_'.$counter.'_'.$mcount;
                                        $module_type = get_post_meta( $page_id, $module_prefix, true );
                                        if ( ! $module_type ) break;
                                        call_user_func( 'bk_'.$module_type.'_render', $page_id, $module_prefix );
                                    }?>
                                </div>
                                <div class="innersb col-md-3">
                                    <?php
                                    for ($mcount=1; $mcount <50; $mcount ++) {
                                        $module_prefix = 'bk_rsec_module_'.$counter.'_'.$mcount;
                                        $module_type = get_post_meta( $page_id, $module_prefix, true );
                                        if ( ! $module_type ) break;
                                        call_user_func( 'bk_'.$module_type.'_render', $page_id, $module_prefix );
                                    }?>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar col-md-4">
                            <aside class="sidebar-wrap">
                                <?php dynamic_sidebar( $sidebar );?>
                            </aside>
                        </div>
                    </div>
                </div>
            <?php
            }
		}
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: BK Main Slider
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_mainslider_render' ) ) {
	function bk_mainslider_render( $page_id, $module_prefix ) {
	   global $bk_option;
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $feature = get_post_meta( $page_id, $module_prefix.'_feature', true );
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
        $feat_tag = '';
        if (isset($bk_option)):
            if ($bk_option['feat-tag'] != ''){
                $feat_tag = $bk_option['feat-tag'];
            }
        endif;
        if ($feature == 'yes') {
            if ($feat_tag != '') {
                $args = array(
    				'tag__in' => $feat_tag,
        			'post_status' => 'publish',
        			'ignore_sticky_posts' => 1,
        			'posts_per_page' => $number,
                    'offset' => $offset,
                    'orderby' =>  $order,
                );   
            } else {
                $args = array(
    				'post__in'  => get_option( 'sticky_posts' ),
    				'post_status' => 'publish',
    				'ignore_sticky_posts' => 1,
    				'posts_per_page' => $number,
                    'offset' => $offset,
                    'orderby' =>  $order,
                );
            }         
        }else {
    		$args = array(
    			'post_type' => 'post',
    			'orderby' => 'post_date',
    			'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
    			'posts_per_page' => $number,
                'offset' => $offset,
                'orderby' =>  $order,
    			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
    		);
        }
        if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-mainslider clearfix">
            <?php bk_mainslider( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Grid
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_grid_render' ) ) {
	function bk_grid_render( $page_id, $module_prefix ) {
	   global $bk_option;
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
		$feature = get_post_meta( $page_id, $module_prefix.'_feature', true );
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
        $feat_tag = '';
        if (isset($bk_option)):
            if ($bk_option['feat-tag'] != ''){
                $feat_tag = $bk_option['feat-tag'];
            }
        endif;
        if ($feature == 'yes') {
            if ($feat_tag != '') {
                $args = array(
    				'tag__in' => $feat_tag,
        			'post_status' => 'publish',
        			'ignore_sticky_posts' => 1,
        			'posts_per_page' => $number,
                    'offset' => $offset,
                    'orderby' =>  $order,                    
                );   
            } else {
                $args = array(
    				'post__in'  => get_option( 'sticky_posts' ),
    				'post_status' => 'publish',
    				'ignore_sticky_posts' => 1,
    				'posts_per_page' => $number,
                    'offset' => $offset,
                    'orderby' =>  $order,                    
                );
            }         
        }else {
    		$args = array(
    			'post_type' => 'post',
    			'orderby' => 'post_date',
    			'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
    			'posts_per_page' => $number,
                'offset' => $offset,
                'orderby' =>  $order,                
    			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
    		);
        }
        if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-maingrid clearfix">
            <?php bk_grid( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Grid_w_ajax
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_grid_w_ajax_render' ) ) {
	function bk_grid_w_ajax_render( $page_id, $module_prefix ) {
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }         
        $args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
            'post_status' => 'publish',
			'ignore_sticky_posts' => true,
            'posts_per_page' => 11,
            'offset' => $offset,
            'orderby' =>  $order,            
		);
        if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $query_all = new WP_Query( $args );
        if ($query_all->post_count < 10) {
            $no_more = 1;
        }else {
            $no_more = 0;
        }
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
            'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => 5,
            'offset' => $offset,
            'orderby' =>  $order,            
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-grid-ajax clearfix">
            <?php bk_grid_ajax( $page_id, $module_prefix, $the_query, $no_more );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Row
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_row_render' ) ) {
	function bk_row_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true )) * 3;
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
            'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-row three-cols clearfix">
            <?php bk_row( $page_id, $module_prefix, $the_query, 'three_cols' );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Row with Background
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_row_wbg_render' ) ) {
	function bk_row_wbg_render( $page_id, $module_prefix ) {
	   global $bk_option;
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = 3; //Hardcoded 3 for this module
        $background_color = esc_attr(get_post_meta( $page_id, $module_prefix.'_background_color', true ));
		$feature = get_post_meta( $page_id, $module_prefix.'_feature', true );
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
        $feat_tag = '';
        if (isset($bk_option)):
            if ($bk_option['feat-tag'] != ''){
                $feat_tag = $bk_option['feat-tag'];
            }
        endif;
        if ($feature == 'yes') {
            if ($feat_tag != '') {
                $args = array(
    				'tag__in' => $feat_tag,
        			'post_status' => 'publish',
        			'ignore_sticky_posts' => 1,
        			'posts_per_page' => $number,
                    'offset' => $offset,
                    'orderby' =>  $order,                    
                );   
            } else {
                $args = array(
    				'post__in'  => get_option( 'sticky_posts' ),
    				'post_status' => 'publish',
    				'ignore_sticky_posts' => 1,
    				'posts_per_page' => $number,
                    'offset' => $offset,
                    'orderby' =>  $order,                    
                );
            }         
        }else {
    		$args = array(
    			'post_type' => 'post',
    			'orderby' => 'post_date',
    			'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
    			'posts_per_page' => $number,
                'offset' => $offset,
                'orderby' =>  $order,                
    			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
    		);
        }
        if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-row-wbg three-cols clearfix" style="background-color: <?php echo esc_attr($background_color);?>">
            <?php bk_row_wbg( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Small pieces
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_small_pieces_render' ) ) {
	function bk_small_pieces_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
            'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-small-pieces clearfix">
            <?php bk_small_pieces( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/*
 *  Has sidebar
 */
 /* -----------------------------------------------------------------------------
 * Render Module: Row
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_row_2cols_render' ) ) {
	function bk_row_2cols_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true )) * 2;
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
            'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-row two-cols clearfix">
            <?php bk_row( $page_id, $module_prefix, $the_query, 'two_cols' );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: 1l & 2 side m
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_1l_2m_side_render' ) ) {
	function bk_1l_2m_side_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );        
        $main_post_position = get_post_meta( $page_id, $module_prefix.'_main_post_position', true );  
        $number = 3;
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        } 
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
            'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-1l-2m-side <?php if($main_post_position == 'left') {echo 'main-left';}else {echo 'main-right';}?> clearfix">
            <?php bk_1l_2m_side( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}

/* -----------------------------------------------------------------------------
 * Render Module: Blog Small
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_blog_small_render' ) ) {
	function bk_blog_small_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );        
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }     
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule bk-blog-small clearfix"> <!-- Blog -->
            <?php bk_blog_small( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
} 
/* -----------------------------------------------------------------------------
 * Render Module: Large Blog
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_large_blog_render' ) ) {
	function bk_large_blog_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );        
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }    
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule bk-large-blog clearfix"> <!-- Blog -->
            <?php bk_large_blog( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
} 
/* -----------------------------------------------------------------------------
 * Render Module: 1l and list post side
 * -------------------------------------------------------------------------- */

if ( ! function_exists( 'bk_1l_list_side_render' ) ) {
	function bk_1l_list_side_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = 5;
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }     
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $number,
            'offset' => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-1l-list-side clearfix">
            <?php bk_1l_list_side( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
} 


/* -----------------------------------------------------------------------------
 * Render Module: Windows
 * -------------------------------------------------------------------------- */

if ( ! function_exists( 'bk_windows_render' ) ) {
	function bk_windows_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }        
        $bk_layout = get_post_meta( $page_id, $module_prefix.'_columns', true );
        if ($bk_layout == 'three_cols'){$entries = $number*3;}else {$entries = $number*2;}
        
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $entries,
            'offset'    => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-windows <?php if ($bk_layout == 'three_cols'){echo 'three-cols';}else {echo 'two-cols';}?> clearfix">
            <?php bk_windows( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Block One
 * -------------------------------------------------------------------------- */

if ( ! function_exists( 'bk_block_one_render' ) ) {
	function bk_block_one_render( $page_id, $module_prefix ) {
		$category_1 = get_post_meta( $page_id, $module_prefix.'_category_1', true );
        $order_1 = get_post_meta( $page_id, $module_prefix.'_order_1', true );
        $category_2 = get_post_meta( $page_id, $module_prefix.'_category_2', true );
        $order_2 = get_post_meta( $page_id, $module_prefix.'_order_2', true );
        $entries = 4;
        if($order_1 == 'rand') {
            $offset_1 = 0;
        }else {
            $offset_1 = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset_1', true ));
        }  
        if($order_2 == 'rand') {
            $offset_2 = 0;
        }else {
            $offset_2 = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset_2', true ));
        }      
        
		$args_1 = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $entries,
            'offset'    => $offset_1,
            'orderby' =>  $order_1,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category_1 >= 1 ) {
			$args_1[ 'cat' ] = $category_1;
		}
        
		$args_2 = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $entries,
            'offset'    => $offset_2,
            'orderby' =>  $order_2,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category_2 >= 1 ) {
			$args_2[ 'cat' ] = $category_2;
		}
        $the_query_1 = new WP_Query( $args_1 );
        $the_query_2 = new WP_Query( $args_2 );
        ?>
        <div class="bkmodule module-block-one clearfix">
            <?php bk_block_one( $page_id, $module_prefix, $the_query_1, $the_query_2 );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Block Two
 * -------------------------------------------------------------------------- */

if ( ! function_exists( 'bk_block_two_render' ) ) {
	function bk_block_two_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        $entries = 5;
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }  
        
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $entries,
            'offset'    => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
        <div class="bkmodule module-block-two clearfix">
            <?php bk_block_two( $page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Custom HTML
 * -------------------------------------------------------------------------- */

if ( ! function_exists( 'bk_custom_html_render' ) ) {
	function bk_custom_html_render( $page_id, $module_prefix ) {
	   $custom_html = get_post_meta( $page_id, $module_prefix.'_custom_html', true );
        ?>
        <div class="bkmodule module-custom_html clearfix">
            <?php bk_get_module_title($page_id, $module_prefix);?>
            <?php echo $custom_html;?>
        </div>
    <?php
	}
}
/*
 * InnerSidebar
 */
 
/* -----------------------------------------------------------------------------
 * Render Module: Most Commented 
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_most_commented_render' ) ) {
	function bk_most_commented_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));       
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }      
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $number,
            'orderby' => 'comment_count',
            'offset'    => $offset,
            'orderby' =>  $order,            
            'order' => 'DESC'	
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);
 
		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
       <div class="module-most-commented"> 
            <?php bk_most_commented($page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Latest 
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_latest_render' ) ) {
	function bk_latest_render( $page_id, $module_prefix ) {
		$category = get_post_meta( $page_id, $module_prefix.'_category', true );
        $number = esc_attr(get_post_meta( $page_id, $module_prefix.'_number', true ));
        $order = get_post_meta( $page_id, $module_prefix.'_order', true );
        if($order == 'rand') {
            $offset = 0;
        }else {
            $offset = esc_attr(get_post_meta( $page_id, $module_prefix.'_offset', true ));
        }         
		$args = array(
			'post_type' => 'post',
			'orderby' => 'post_date',
			'ignore_sticky_posts' => true,
            'post_status' => 'publish',
			'posts_per_page' => $number,
            'offset'    => $offset,
            'orderby' =>  $order,            
			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
		);

		if ( $category >= 1 ) {
			$args[ 'cat' ] = $category;
		}
        $the_query = new WP_Query( $args );
        ?>
       <div class="module-latest">
            <?php bk_latest($page_id, $module_prefix, $the_query );?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Ads 
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_ads_render' ) ) {
	function bk_ads_render( $page_id, $module_prefix ) {
    ?>
       <div class="bkmodule module-ads">
            <?php bk_ads($page_id, $module_prefix);?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Ads (Two Cols)
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_two_col_ads_render' ) ) {
	function bk_two_col_ads_render( $page_id, $module_prefix ) {
    ?>
       <div class="bkmodule module-ads ad-cols">
            <?php bk_two_col_ads($page_id, $module_prefix);?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Ads (Three Cols)
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_three_col_ads_render' ) ) {
	function bk_three_col_ads_render( $page_id, $module_prefix ) {
    ?>
       <div class="bkmodule module-ads ad-cols">
            <?php bk_three_col_ads($page_id, $module_prefix);?>
        </div>
    <?php
	}
}
/* -----------------------------------------------------------------------------
 * Render Module: Adsense
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_adsense_render' ) ) {
	function bk_adsense_render( $page_id, $module_prefix ) {
    ?>
       <div class="bkmodule module-ads">
            <?php bk_adsense($page_id, $module_prefix);?>
        </div>
    <?php
	}
}
