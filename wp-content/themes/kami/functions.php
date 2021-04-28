<?php
require_once(ABSPATH.'wp-includes/class-oembed.php');
require_once get_template_directory().'/framework/page-builder/controller/bk_pd_template.php';
require_once get_template_directory().'/framework/page-builder/controller/bk_pd_cfg.php';
require_once get_template_directory().'/framework/page-builder/controller/bk_pd_save.php';
require_once get_template_directory().'/framework/page-builder/controller/bk_pd_del.php';
require_once get_template_directory().'/framework/page-builder/controller/render-sections.php';
require_once get_template_directory().'/framework/page-builder/controller/render-modules.php';
require_once get_template_directory().'/framework/page-builder/bk_pd_start.php';
require_once get_template_directory().'/framework/sidebar_generator.php';
require_once get_template_directory().'/library/short_code.php';

require_once ('framework/taxonomy-meta/taxonomy-meta.php');
require_once('library/taxonomy-meta-config.php');

$loadmore = array();
$bk_ticker = array();
$main_slider = array();

/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 1200;
}

/**
 * Get ajaxurl
 *---------------------------------------------------
 */
if ( ! function_exists( 'bk_ajaxurl' ) ) {
    function bk_ajaxurl() {
    ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
    <?php
    }
}
add_action('wp_head','bk_ajaxurl');

if ( ! function_exists( 'bk_scripts_method' ) ) {
    function bk_scripts_method() {
        global $bk_option;
        
        if($bk_option['bk-rtl-sw']) {                
            wp_enqueue_style( 'bootstrap-css', get_template_directory_uri().'/framework/bootstrap/css/bootstrap-rtl.css', array(), '' );
        }else {
            wp_enqueue_style( 'bootstrap-css', get_template_directory_uri().'/framework/bootstrap/css/bootstrap.css', array(), '' );        
        }            
        wp_enqueue_style('fa', get_template_directory_uri() . '/css/fonts/awesome-fonts/css/font-awesome.min.css');
        wp_enqueue_style('flexslider', get_template_directory_uri() . '/css/flexslider.css');
        if($bk_option['bk-rtl-sw']) {
            wp_enqueue_style('bkstyle', get_template_directory_uri() . '/css/rtl.css');
            wp_enqueue_style('bkresponsive', get_template_directory_uri() . '/css/responsive_rtl.css');
        }else {
            wp_enqueue_style('bkstyle', get_template_directory_uri() . '/css/bkstyle.css');
            wp_enqueue_style('bkresponsive', get_template_directory_uri() . '/css/responsive.css');
        }
        
        wp_enqueue_style('tipper', get_template_directory_uri() . '/css/jquery.fs.tipper.css');
        wp_enqueue_style('justifiedgallery', get_template_directory_uri() . '/css/justifiedGallery.css');
        wp_enqueue_style('justifiedlightbox', get_template_directory_uri() . '/css/magnific-popup.css');
                             
        wp_enqueue_script( 'bk-cookie',  get_template_directory_uri() . '/js/cookie.min.js', array( 'jquery' ),'', true);
        wp_enqueue_script('imagesloaded-plugin-js', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'),'', true);
        wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/js/SmoothScroll.js', array('jquery'),'', true);
        wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'),'', true);
        wp_enqueue_script('froogaloop2', get_template_directory_uri() . '/js/froogaloop2.min.js', array('jquery'),'', true);
        
        wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/modernizr.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'onviewport', get_template_directory_uri().'/js/onviewport.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'justifiedGallery', get_template_directory_uri().'/js/justifiedGallery.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'justifiedlightbox', get_template_directory_uri().'/js/jquery.magnific-popup.min.js', array( 'jquery' ), false, true );
        
        wp_enqueue_script( 'tipper', get_template_directory_uri().'/js/jquery.fs.tipper.js', array( 'jquery' ), false, true );        
        if($bk_option['bk-rtl-sw']) {
            wp_enqueue_script('ticker-js', get_template_directory_uri() . '/js/ticker_rtl.js', array('jquery'),false,true);
            wp_enqueue_script( 'menu', get_template_directory_uri().'/js/menu_rtl.js', array( 'jquery' ), false, true );
            wp_enqueue_script( 'customjs', get_template_directory_uri().'/js/customjs_rtl.js', array( 'jquery' ), false, true );
        }else {
            wp_enqueue_script('ticker-js', get_template_directory_uri() . '/js/ticker.js', array('jquery'),false,true);
            wp_enqueue_script( 'menu', get_template_directory_uri().'/js/menu.js', array( 'jquery' ), false, true );
            wp_enqueue_script( 'customjs', get_template_directory_uri().'/js/customjs.js', array( 'jquery' ), false, true );
        }
        
     }
}

add_action('wp_enqueue_scripts', 'bk_scripts_method');

if ( ! function_exists( 'bk_post_admin_scripts_and_styles' ) ) {
    function bk_post_admin_scripts_and_styles($hook) {        
    	if( $hook == 'post.php' || $hook == 'post-new.php' ) {
            wp_enqueue_script( 'bk-bootstrap-admin-js', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.js', array(), '', true );
            wp_enqueue_style( 'bk-bootstrap-admin-css', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.css', array(), '' );
            wp_enqueue_style( 'bk-jquery-core-css', 'http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css', array(), '' );
            wp_enqueue_script( 'bk-ui-core-js', 'http://code.jquery.com/ui/1.11.1/jquery-ui.js', '', true );
            wp_register_script( 'post-review-admin',  get_template_directory_uri() . '/js/post-review-admin.js', array(), '', true);
            wp_enqueue_script( 'post-review-admin' ); // enqueue it
   		}
        wp_enqueue_script('bootstrap-colorpicker-js', get_template_directory_uri() . '/js/bootstrap-colorpicker.js', array('jquery')); 
        
        wp_enqueue_style('bootstrap-colorpicker-css', get_template_directory_uri() . '/css/bootstrap-colorpicker.css');
        
        wp_enqueue_style( 'bk-admin-css', get_template_directory_uri().'/css/admin.css', array(), '' );
        
        wp_enqueue_style('fa-admin', get_template_directory_uri() . '/css/fonts/awesome-fonts/css/font-awesome.min.css');
        
        wp_enqueue_script( 'bk-autosize-js', get_template_directory_uri().'/js/jquery.autosize.min.js', array(), '', true );
        
        wp_enqueue_script( 'bk-admin-js', get_template_directory_uri().'/js/admin.js', array('jquery-ui-sortable'), '', true );
        
    }
}
add_action('admin_enqueue_scripts', 'bk_post_admin_scripts_and_styles');
 if ( ! function_exists( 'bk_page_builder_js' ) ) {
    function bk_page_builder_js($hook) {
        if( $hook == 'post.php' || $hook == 'post-new.php' ) {
            wp_enqueue_script( 'bk-page-builder-js', get_template_directory_uri().'/framework/page-builder/controller/js/page-builder.js', array( 'jquery' ), null, true );
            wp_localize_script( 'bk-page-builder-js', 'bkpb_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  		}
    }
 }
 add_action('admin_enqueue_scripts', 'bk_page_builder_js', 9);
/**
 * Register sidebars and widgetized areas.
 *---------------------------------------------------
 */
 if ( ! function_exists( 'bk_widgets_init' ) ) {
    function bk_widgets_init() {

        register_sidebar( array(
    		'name' => __('Sidebar', 'bkninja'),
    		'id' => 'home_sidebar',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );

        register_sidebar( array(
    		'name' => __('Footer Sidebar 1', 'bkninja'),
    		'id' => 'footer_sidebar_1',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => __('Footer Sidebar 2', 'bkninja'),
    		'id' => 'footer_sidebar_2',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => __('Footer Sidebar 3', 'bkninja'),
    		'id' => 'footer_sidebar_3',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
    }
}
add_action( 'widgets_init', 'bk_widgets_init' );

/**
 * Add php library file.
 */
require_once("library/global_var.php");
require_once("library/core.php");
require_once("library/mega_menu.php");
require_once("library/custom_css.php");
require_once("library/translation.php");


/**
 * Add widgets
 */
require_once("framework/widgets/widget_latest_posts.php");
require_once("framework/widgets/widget_most_commented.php");
require_once("framework/widgets/widget_latest_comments.php");
require_once("framework/widgets/widget_google_badge.php");
require_once("framework/widgets/widget_facebook.php");
require_once("framework/widgets/widget_flickr.php");
require_once("framework/widgets/widget_slider.php");
require_once("framework/widgets/widget_latest_review.php");
require_once("framework/widgets/widget_top_review.php");
require_once("framework/widgets/widget_social_counter.php");
require_once("framework/widgets/widget_ads.php");
require_once("framework/widgets/widget_twitter.php");
require_once("framework/widgets/widget_instagram.php");
if ( class_exists('bbpress') ) {
    require_once ( 'framework/widgets/widget-recent-replies-bbp.php' ); 
    require_once ( 'framework/widgets/widget-recent-topics-bbp.php' );
}

//require_once("library/custom_css.php");
/**
 * Integrate Meta box plugin
 */
// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/framework/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_stylesheet_directory() . '/framework/meta-box' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
include("library/meta_box_config.php");

/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'bk_thumbnail_setup' );
if ( ! function_exists( 'bk_thumbnail_setup' ) ){

    function bk_thumbnail_setup() {
        add_image_size( 'bkmain_slider', 99999, 550, true ); //grid slider
        add_image_size( 'bk684_452', 684, 452, true ); //grid slider
        add_image_size( 'bk456_226', 456, 226, true );
        add_image_size( 'bk485_300', 485, 300, true );
        add_image_size( 'bk400_300', 400, 300, true );
        add_image_size( 'bk230_140', 230, 140, true );
        add_image_size( 'bk360_145', 360, 145, true );
        add_image_size( 'bk1000_600', 1000, 600, true );
    } 
}
/**
 * Post Format
 */
 add_action('after_setup_theme', 'bk_add_theme_format', 11);
function bk_add_theme_format() {
    add_theme_support( 'post-formats', array( 'gallery', 'video', 'image', 'audio' ) );
}
/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
}
/**
 * Title
 */
add_filter( 'wp_title', 'bk_wp_title', 10, 2 );
if ( ! function_exists( 'bk_wp_title' ) ) {
    function bk_wp_title( $title, $sep ) {
    	global $paged, $page;
    
    	if ( is_feed() ) {
    		return $title;
    	}
    
    	// Add the site name.
    	$title .= get_bloginfo( 'name' );
    
    	// Add the site description for the home/front page.
    	$site_description = get_bloginfo( 'description', 'display' );
    	if ( $site_description && ( is_home() || is_front_page() ) ) {
    		$title = "$title $sep $site_description";
    	}
    
    	// Add a page number if necessary.
    	if ( $paged >= 2 || $page >= 2 ) {
    		$title = "$title $sep " . sprintf( __( 'Page %s', 'bkninja' ), max( $paged, $page ) );
    	}
    
    	return $title;
    }
}

/**
 * Register menu locations
 *---------------------------------------------------
 */
if ( ! function_exists( 'bk_register_menu' ) ) {
    function bk_register_menu() {
        register_nav_menu('main-menu',__( 'Main Menu' ));
        register_nav_menu('menu-top',__( 'Top Menu' ));
        register_nav_menu('menu-footer',__( 'Footer Menu' )); 
    }
}
add_action( 'init', 'bk_register_menu' );

function bk_category_nav_class( $classes, $item ){
    if( 'category' == $item->object ){
        $classes[] = 'menu-category-' . $item->object_id;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'bk_category_nav_class', 10, 2 );

function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Woocommerce Setup
 */
if ( ! function_exists( 'bk_woocommerce_setup' ) ) {
	function bk_woocommerce_setup() {
		add_theme_support( 'woocommerce' );

		// remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		// remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

		add_filter( 'woocommerce_show_page_title', '__return_false' );
	}
	add_action( 'after_setup_theme', 'bk_woocommerce_setup' );
}
if ( ! function_exists( 'setup_woocommerce_image_dimensions' ) ) {
	function setup_woocommerce_image_dimensions() {
		$catalog = array( // square_medium size
			'width' 	=> '550',	// px
			'height'	=> '550',	// px
			'crop'		=> 1 		// true
		);
	 
		$single = array(
			'width' 	=> '550',	// px
			'height'	=> '550',	// px
			'crop'		=> 1 		// true
		);
	 
		$thumbnail = array(
			'width' 	=> '360',	// px
			'height'	=> '360',	// px
			'crop'		=> 0 		// false
		);
	 
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
	add_action( 'after_switch_theme', 'setup_woocommerce_image_dimensions' );
}
// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
    global $bk_option;
    if(isset($bk_option['bk-shop-sidebar']) && ($bk_option['bk-shop-sidebar'] == 'on')) {
        $args = array(
            'posts_per_page' => 3,
            'columns'        => 3,
            'orderby'        => 'rand',
          );
    }else {
        $args = array(
            'posts_per_page' => 4,
            'columns'        => 4,
            'orderby'        => 'rand',
          );
    }
    woocommerce_related_products($args, false, false); // Display 4 products in rows
}

add_filter( 'single_product_small_thumbnail_size', 'my_single_product_small_thumbnail_size', 25, 1 );
function my_single_product_small_thumbnail_size( $size ) {
    $size = 'full';
    return $size;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'bk_woocommerce_breadcrumbs' );
function bk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}
/**
 * BB Press
 * */
function modify_breadcrumb_args() {
    global $bk_option;
    $args['home_text'] = '<i class="fa fa-home"></i> Home';
    if($bk_option['bk-rtl-sw']) {
        $args['sep'] = '&#92';
    }else {
        $args['sep'] = '&#47';
    }
    
    return $args;
}

add_filter( 'bbp_before_get_breadcrumb_parse_args', 'modify_breadcrumb_args' );


/**
 * ReduxFramework
 */

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/framework/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/framework/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $bk_option ) && file_exists( dirname( __FILE__ ) . '/library/theme-option.php' ) ) {
    require_once( dirname( __FILE__ ) . '/library/theme-option.php' );
}

?>