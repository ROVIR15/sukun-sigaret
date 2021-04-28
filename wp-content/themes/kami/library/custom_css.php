<?php
add_action('wp_head','custom_css',20);
if ( ! function_exists( 'custom_css' ) ) {
    function custom_css() {
        global $bk_option;
        if ( isset($bk_option)):
            $primary_color = $bk_option['bk-primary-color'];
            $review_color = $bk_option['bk-review-color'];
            $category_color_settings = $bk_option['bk-category-color-select'];
            $cat_opt = get_option('bk_cat_opt');  
            $header_top = $bk_option['bk-header-top-switch'];  
            $sb_location = $bk_option['bk-sb-location-sw']; 
            $sb_responsive_sw = $bk_option['bk-sb-responsive-sw'];
            $main_nav_layout = $bk_option['bk-main-nav-layout'];   
            $meta_review = $bk_option['bk-meta-review-sw'];
            $meta_author = $bk_option['bk-meta-author-sw'];
            $meta_date = $bk_option['bk-meta-date-sw'];
            $meta_comments = $bk_option['bk-meta-comments-sw'];        
            $custom_css = $bk_option['bk-css-code'];                
?>
    
    <style type='text/css' media="all">
        <?php
            if ( ($meta_review) == 0) echo ('.review-score {display: none !important;}'); 
            if ( ($meta_author) == 0) echo ('.meta-author {display: none !important;}'); 
            if ( ($meta_date) == 0) echo ('.post-date {display: none !important;}'); 
            if ( ($meta_comments) == 0) echo ('.meta-comment {display: none !important;}');
            if ( ($header_top) == 0) echo ('.top-bar {display: none !important;}');
            if ( ($sb_location) == 'left') echo ('.has-sb > div > .content-wrap {float: right;} .has-sb .sidebar {float: left;}'); 
        ?>
        ::selection {color: #FFF; background: <?php echo esc_attr($primary_color); ?>}
        ::-webkit-selection {color: #FFF; background: <?php echo esc_attr($primary_color); ?>}
        <?php if ( ($primary_color) != null) {?> 
            #main-mobile-menu .expand i, #single-top  .social-share li a:hover, #pagination .page-numbers, .widget_recent_comments .comment-author-link,
            .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .bbp-topic-freshness-author a, .bbp-topic-started-by a,
            #bbpress-forums div.bbp-reply-author a.bbp-author-name, div.bbp-template-notice a.bbp-author-name, #bk-404-wrap .redirect-home, .widget_rss cite,
            .co-type1 .title a:hover, .co-type3 .title a:hover, .co-type2 .title a:hover, .module-1l-list-side .subpost-list .title a:hover,
            .widget_latest_comments .post-title a:hover, .bk-review-title.post-title a:hover, .woocommerce-page ul.product_list_widget li a:hover, 
            .woocommerce-page ul.products li.product h3:hover, .product-name a:hover, .bk-sub-sub-menu > li a:hover, .bk-sub-menu li > a:hover,
            #top-menu>ul>li .sub-menu li > a:hover, .bk-sub-posts .post-title a:hover, .bk-forum-title:hover, .bbp-breadcrumb a:hover, 
            .woocommerce-page .woocommerce-breadcrumb a:hover, .widget_archive ul li a:hover, .widget_categories ul li a:hover, .widget_product_categories ul li a:hover, .widget_display_views ul li a:hover,
            .widget_display_topics ul li a:hover, .widget_display_replies ul li a:hover, .widget_display_forums ul li a:hover, .widget_pages li a:hover, .widget_meta li:hover,
            .widget_pages li a:hover, .widget_meta li a:hover, .widget_recent_comments .recentcomments > a:hover, .widget_recent_entries a:hover, .widget_rss ul li a:hover, 
            .widget_nav_menu li a:hover, .woocommerce-page .widget_layered_nav ul li:hover, .menu-location-title, #mobile-inner-header .mobile-menu-close i,
            .recommend-box .entries h4 a:hover, .loadmore, .innersb .module-latest .post-list .title:hover,
            .single-page .article-content > p:first-of-type:first-letter, p > a, p > a:hover, .post-page-links a, .bk-404-header .error-number h4,
            .single-page .article-content li a 
            {color: <?php echo esc_attr($primary_color); ?>} 
            
            .module-title, .widget-title,
            .loadmore:hover,.module-maingrid .bkdate .day, .module-maingrid .sub-post .bkdate .day, .module-mainslider .bkdate .day,
            .cat-slider .bkdate .day, .flickr li a img:hover, .instagram li a img:hover, #single-top  .social-share li a:hover, #pagination .page-numbers 
            ,.gallery-wrap #bk-carousel-gallery-thumb .slides > .flex-active-slide,
            .module-mainslider .carousel-ctrl ul li.flex-active-slide .ctrl-wrap, .module-mainslider .carousel-ctrl ul li:hover .ctrl-wrap, 
            .bk-mega-column-menu .bk-sub-menu > li > a, .menu-location-title, i.post-icon, .flex-direction-nav li a, .bk-mega-column-menu, 
            .footer .module-title h3, .footer .widget-title h3, .post-page-links span, .post-page-links a, .post-page-links > span
            {border-color: <?php echo esc_attr($primary_color); ?>;}
            
            .meta-top .post-cat a, .loadmore:hover:after, .widget_tag_cloud a, #share-menu-btn .menu-toggle, #single-top .social-share li a, 
            .post-nav .post-nav-link .sub-title, #comment-submit, .submit-button, #pagination .page-numbers.current,
                        
            /*** Shop ***/
            .button, .woocommerce-page input.button.alt, .woocommerce-page input.button, .woocommerce-page div.product form.cart .button,
            .woocommerce-page .woocommerce-message .button, .woocommerce-page a.button,
            .button:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page input.button:hover, .woocommerce-page div.product form.cart .button:hover,
            .woocommerce-page .woocommerce-message .button:hover, .woocommerce-page a.button:hover,
            .woocommerce-page ul.products li.product .added_to_cart.wc-forward, .woocommerce-page #review_form #respond .form-submit #submit, .woocommerce-page #review_form #respond .form-submit #submit:hover
            ,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-page .cart-collaterals .shipping_calculator .button, .woocommerce-page .widget_price_filter .price_slider_amount .button 
            ,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
            .widget_product_tag_cloud a, .subscription-toggle, .bbp-pagination-links a:hover, .bbp-pagination-links span.current, .bbp-row-actions #favorite-toggle span.is-favorite a,
            .bbp-row-actions #subscription-toggle span.is-subscribed a, .bbp-login-form .bbp-submit-wrapper #user-submit, .woocommerce span.onsale, .woocommerce-page span.onsale
            ,#back-top, .module-title h3:before, .page-title h3:before, .forum-title h3:before, .topic-title h3:before, .single-page .label h3:before,
            .widget-title:before, .post-page-links > span, .single-page .article-content input[type=submit]
            {background-color: <?php echo esc_attr($primary_color); ?>;}
            .main-nav .menu > li.current-menu-item > a, .main-nav .menu > li:hover > a, .current_page_parent
            {background-color: <?php echo hex2rgba ($primary_color, 1); ?>;}
            .main-nav .menu > li:hover .bk-dropdown-menu, .main-nav .menu > li:hover .bk-mega-menu 
            {border-color: <?php echo hex2rgba ($primary_color, 1); ?>;}
            
            
            /*** Review Color ***/
            .bk-bar-ani, .single-page .bk-score-box, #single-top .tag-top .review-score
            ,.meta-top .review-score 
            {background-color: <?php echo esc_attr($review_color); ?>;}
            
            .woocommerce-page .star-rating span, .woocommerce-page p.stars a {color: <?php echo esc_attr($review_color); ?>;}

        <?php }?>
        <?php
        if ( $sb_responsive_sw == 0) {?>
            @media (max-width: 767px){
                .sidebar {display: none !important}
            }
        <?php };
        if ( $main_nav_layout == 'center') {?>
            @media (min-width: 991px){
                .main-nav{
                    text-align: center;
                }
            }
        <?php };?>
        <?php
        if (($category_color_settings == 'custom_category_color') && (is_array($cat_opt))) {
            foreach ($cat_opt as $key => $value) {
                if ((is_array($value))&&(count($value) > 0 )) {
                    if (array_key_exists('cat_color',$value)) {
                        echo ('.cat-bg-'.$key.', .title-cat-'.$key.' h3:before {background-color: '.hex2rgba($value['cat_color'], 1).' !important;}'); 
                        echo ('.thumb-bg-'.$key.', .co-type2  .thumb-bg-'.$key.'+ .row .bkdate-inner {background-color: '.$value['cat_color'].' !important}');         
                        echo ('.main-nav .menu > li.menu-category-'.$key.':hover>a, .main-nav .menu > li.menu-category-'.$key.'.current-menu-item > a,
                                #main-menu > ul > li.current-post-ancestor.menu-category-'.$key.' > a
                               {background-color: '.hex2rgba($value['cat_color'], 1).' !important;}');  
                        echo ('.main-nav .menu > li.menu-category-'.$key.':hover .bk-mega-menu
                                {border-color: '.hex2rgba($value['cat_color'], 1).' !important;}');  
                    }           
                } 
                 
            }
        }else {
            echo ('.co-type2  .thumb+ .row .bkdate-inner,
                    .thumb, .post-cat a, .main-nav .menu > li.menu-item.current-menu-item > a,
                    .main-nav .menu > li.menu-item:hover > a,
                    #main-menu > ul > li.current-post-ancestor.menu-item > a
                   {background-color: '.$primary_color.';}');  
            echo ('.main-nav .menu > li.menu-item:hover .bk-mega-menu
                    {border-color: '.$primary_color.';}');  

        }
        if ($custom_css != '') echo ($custom_css);
        ?>
        
    </style>
    <?php endif;?>
    <?php }?>
<?php }?>