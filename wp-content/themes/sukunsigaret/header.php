<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
		<title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
		} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
		} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
		} elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo wp_specialchars($s);
		} else { wp_title('',true); }?>
		</title>
	<?php wp_head(); ?>
	
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option('r3_favicon'); ?>">	
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/loader.css">
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" charset="utf-8"/>
	
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/animate.css" charset="utf-8"/>
	<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/lightslider.css" />                  
	<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" charset="utf-8"/>

	<style>
		.nusantara {
			background: #ffffff url('<?php echo get_option('r3_gbrokoknusantara'); ?>') top right no-repeat;
		}
	</style>

	<script src="<?php bloginfo('template_directory'); ?>/js/jquery-2.0.2.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/lightslider.js"></script>	
	<script src="<?php bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/wow.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/vendor/modernizr-2.6.2.min.js"></script>

<script type='text/javascript'>//<![CDATA[

function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top) {
        $('#sticky').addClass('stick');
        $('.top-nav').slideUp('fast');
        //$('.nav-logo').addClass('logo-small',1000);
        //$(".navigation").css({ padding: "20px" });
        $('#sticky-anchor').height($('#sticky').outerHeight());
    } else {
        $('#sticky').removeClass('stick');
        $('.top-nav').slideDown('fast');
        //$('.nav-logo').removeClass('logo-small',1000);
        //$(".navigation").css({ padding: "30px" });
        $('#sticky-anchor').height(0);
    }
}

$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

var dir = 1;
var MIN_TOP = 200;
var MAX_TOP = 350;

function autoscroll() {
    var window_top = $(window).scrollTop() + dir;
    if (window_top >= MAX_TOP) {
        window_top = MAX_TOP;
        dir = -1;
    } else if (window_top <= MIN_TOP) {
        window_top = MIN_TOP;
        dir = 1;
    }
    $(window).scrollTop(window_top);
    window.setTimeout(autoscroll, 100);
}

	if ($('#back-to-top').length) {
		var scrollTrigger = 100, // px
		    backToTop = function () {
		        var scrollTop = $(window).scrollTop();
		        if (scrollTop > scrollTrigger) {
		            $('#back-to-top').addClass('show');
		          		} else {
		            $('#back-to-top').removeClass('show');
		            }
		        };
		    backToTop();
		    $(window).on('scroll', function () {
		        backToTop();
		    });
		    $('#back-to-top').on('click', function (e) {
		        e.preventDefault();
		        $('html,body').animate({
		            scrollTop: 0
		    }, 700);
		});
	}
//]]> 

</script>
</head>
<body>
<div id="loader-wrapper">
   <div id="loader"></div>
	<div class="loader-section section-right"></div>
</div>

	<div class="">
		<div class="top-nav darkblue">
		<div class="container">
			<div class="col-md-12 language">
				<?php if ( is_active_sidebar( 'bahasa' ) ) { ?>
					<?php dynamic_sidebar( 'bahasa' ); ?>
				<?php } ?>
			</div>
		</div>

		</div>
	</div>
	
	<div id="sticky-anchor"></div>
	<div id="sticky" class="header blue">
		<div class="container">
		<div class="row">
		
			<div class="col-md-4">
			<div class="logo">			
				<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('title'); ?> - <?php bloginfo('description'); ?>"><img class="img-responsive nav-logo" src="<?php echo get_option('r3_sitelogo'); ?>" alt="<?php bloginfo('description'); ?>" /></a>	
			</div>				
			</div>

		<div class="col-md-8 col-xs-12 navigation">		
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
		  
		  <?php
			wp_nav_menu( array(
				'menu'              => 'primary',
				'theme_location'    => 'primary',
				'depth'             => 3,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'navbar',
				'menu_class'        => 'nav navbar-nav navbar-right',
				'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
				'walker'            => new wp_bootstrap_navwalker())
				);
			?>
				
        </div><!--/.container-fluid -->
      </nav>
      </div>
      </div>
      </div>
      
	</div>
	
	<?php get_template_part('slider'); ?>
	<?php echo do_shortcode( '[sg_popup id=1]' ); ?>