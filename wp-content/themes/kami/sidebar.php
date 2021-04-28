<!--<home sidebar widget>-->
<?php
global $bk_option;?>
<div class="sidebar-wrap">
    <?php            
        if (is_front_page()) {
            dynamic_sidebar('home_sidebar');
        }else if(is_single()){
            if (( function_exists('bbpress') && ( is_bbpress() == true ))) {
                if(isset($bk_option['forum-page-sidebar'])) {
                    $sidebar = $bk_option['forum-page-sidebar'];
                }else {
                    $sidebar = '';
                }
            }else if (class_exists('Woocommerce') &&  ( is_woocommerce() == true ) && (is_product() == true)) {
                if(isset($bk_option['product-page-sidebar'])) {
                    $sidebar = $bk_option['product-page-sidebar'];
                }else {
                    $sidebar = '';
                }
            }else if(isset($bk_option['single-page-sidebar'])) {
                $sidebar = $bk_option['single-page-sidebar'];
            }else {
                $sidebar = '';
            } 
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if(is_category()) {
            if(isset($bk_option['category-page-sidebar'])) {
                $sidebar = $bk_option['category-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_author()){
            if(isset($bk_option['author-page-sidebar'])) {
                $sidebar = $bk_option['author-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else if (is_archive()) {
            if (class_exists('Woocommerce') &&  ( is_woocommerce() == true ) && (is_shop() == true)) {
                if(isset($bk_option['shop-page-sidebar'])) {
                    $sidebar = $bk_option['shop-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else if (( function_exists('bbpress') && ( is_bbpress() == true ))) {
                if(isset($bk_option['forum-page-sidebar'])) {
                    $sidebar = $bk_option['forum-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else {
                if(isset($bk_option['archive-page-sidebar'])) {
                    $sidebar = $bk_option['archive-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }
        }else if (is_search()) {
            if(isset($bk_option['search-page-sidebar'])) {
                $sidebar = $bk_option['search-page-sidebar'];
            }else {
                $sidebar = '';
            }
            if (strlen($sidebar)) {
                dynamic_sidebar($sidebar);
            }else {
                dynamic_sidebar('home_sidebar');
            }
        }else {
            wp_reset_query();
            if (class_exists('Woocommerce') &&  ( is_woocommerce() == true ) && (is_product() == true)) {
                if(isset($bk_option['product-page-sidebar'])) {
                    $sidebar = $bk_option['product-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else if (( function_exists('bbpress') && ( is_bbpress() == true ))) {
                if(isset($bk_option['forum-page-sidebar'])) {
                    $sidebar = $bk_option['forum-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else if (is_page_template('blog.php')) {
                if(isset($bk_option['blog-page-sidebar'])) {
                    $sidebar = $bk_option['blog-page-sidebar'];
                }else {
                    $sidebar = '';
                }
                if (strlen($sidebar)) {
                    dynamic_sidebar($sidebar);
                }else {
                    dynamic_sidebar('home_sidebar');
                }
            }else {                     
                dynamic_sidebar('home_sidebar');
            }
        }
    ?>  	
</div>
<!--</home sidebar widget>-->