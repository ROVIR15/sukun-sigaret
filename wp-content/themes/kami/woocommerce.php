<?php
/**
 * The main template file.
 */

get_header(); 
global $bk_option;
?>

<div class="page-wrap container">
    <div class="row">
        <section class="shop-page <?php if (isset($bk_option['bk-shop-sidebar']) && ($bk_option['bk-shop-sidebar'] == 'on')){ echo 'col-md-8 col-sm-12 three-cols';}else { echo 'col-sm-12 four-cols'; }?>">
        <?php $classes = array();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
     			<?php if ( ! is_shop() ) {
    				if (function_exists('woocommerce_breadcrumb')) woocommerce_breadcrumb();
    			} ?>
                <?php if ( ! is_singular( 'product' ) ) : ?>
                    <div class="page-title">
    				    <h3><span><?php woocommerce_page_title(); ?></span></h3> 
                    </div>
    			<?php endif; ?>
    
    			<?php woocommerce_content(); ?>    
            
        </article><!-- #post-<?php the_ID(); ?> -->
        
        </section>
        <?php
            if (isset($bk_option['bk-shop-sidebar']) && ($bk_option['bk-shop-sidebar'] == 'on')) {?>
                <aside id="page-sidebar" class="sidebar col-md-4 col-sm-12">
        			<?php get_sidebar(); ?>
        		</aside>
        <?php }?>
    </div>
</div>
		
<?php get_footer(); ?>