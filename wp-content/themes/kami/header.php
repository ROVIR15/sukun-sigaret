<?php global $bk_option;
    $favicon = array(); $logo = array();
    if (isset($bk_option)){
        if ((isset($bk_option['bk-favicon'])) && (($bk_option['bk-favicon']) != NULL)){ 
            $favicon = $bk_option['bk-favicon'];
        };   
        if ((isset($bk_option['bk-logo'])) && (($bk_option['bk-logo']) != NULL)){ 
            $logo = $bk_option['bk-logo'];
        };
        $header_banner = $bk_option['bk-header-banner-switch'];
        $ga_script = $bk_option['bk-banner-script'];
        $backtop = $bk_option['bk-backtop-switch'];
        if ($header_banner){ 
            $imgurl = $bk_option['bk-header-banner']['imgurl'];
            $linkurl = $bk_option['bk-header-banner']['linkurl'];
        };
        $site_layout = $bk_option['bk-site-layout'];
    }
    $schema_org = '';
    if (is_single()) {
    	$schema_org .= ' itemscope itemtype="http://schema.org/Article"';
    } else {
    	$schema_org .= ' itemscope itemtype="http://schema.org/WebPage"';
    }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php if (($favicon != null) && (array_key_exists('url',$favicon))) {
        if ($favicon['url'] != '') {
        echo '<link rel="shortcut icon" href="'.  $favicon['url']  .'"/>';
        }
     }?>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    
	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>

	<?php wp_head(); ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-58671032-1', 'auto');
      ga('send', 'pageview');
    
    </script>
<p hidden><a href="https://luckypatcherapkk.org/lucky-patcher-no-root/">lucky patcher no root</a>
<br>
if you want do download paid apps for free try <a href="https://blackmartdownload.org/">blackmart apk latest version</a></p>
</head>

<body <?php body_class(); echo $schema_org; ?>>
	
	<div id="page-wrap" <?php if($site_layout == 1){echo "class='wide'";}else {echo "class='boxed'";}?>>
        <div id="main-mobile-menu">
            <div class="block">
                <div id="mobile-inner-header">
                    <a class="mobile-menu-close" href="#" title="Close"><i class="fa fa-long-arrow-left"></i></a> 
                </div>
                <?php if (( has_nav_menu( 'menu-top' )) && ($bk_option['bk-header-top-switch'] != 0)){?>
                    <div class="top-menu">
                        <h3 class="menu-location-title">
                            <?php _e('Top Menu', 'bkninja');?>
                        </h3>
                        <?php
                        wp_nav_menu( array( 
                            'theme_location' => 'menu-top',
                            'depth' => '3',
                            'container_id' => 'mobile-top-menu' ) );
                        ?>                 
                    </div>
                <?php }?>
                <div class="main-menu">
                    <h3 class="menu-location-title">
                        <?php _e('Main Menu', 'bkninja');?>
                    </h3>
                    <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'main-menu',
                        'depth' => '3',
                        'container_id' => 'mobile-menu' ) );
                    ?>
                </div>
            </div>
        </div>            
        <div id="page-inner-wrap">
            <div class="page-cover mobile-menu-close"></div>
            <div class="header-wrap">
                <div class="top-bar">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                            <!-- ticker open -->
                            <?php        
                                if (isset($bk_option)){
                                    if ($bk_option['bk-header-ticker'] == 1) {
                                        bk_get_ticker('header');
                                    }
                                }
                            ?>
                            <!-- ticker close -->
                			<?php if ( has_nav_menu('menu-top') ) {?> 
                                <nav class="top-nav clearfix">
                                    <?php wp_nav_menu(array('theme_location' => 'menu-top','container_id' => 'top-menu'));?>        
                                </nav><!--top-nav-->
                            <?php }?>
                                
                            </div>
                        </div>
                    </div>
                </div><!--top-bar-->
    
                <div class="header container">
        			<div class="header-inner">
            			<!-- logo open -->
                            <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                    if ($logo['url'] != '') {
                                ?>
                			<div class="logo">
                                <h1>
                                    <a href="<?php echo get_home_url();?>">
                                        <img src="<?php echo esc_url($logo['url']);?>" alt="logo"/>
                                    </a>
                                </h1>
                			</div>
                			<!-- logo close -->
                            <?php } else {?> 
                            <div class="logo logo-text">
                                <h1>
                                    <a href="<?php echo get_home_url();?>">
                                        <?php echo bloginfo( 'name' );?>
                                    </a>
                                </h1>
                			</div>
                            <?php }
                            } else {?> 
                            <div class="logo logo-text">
                                <h1>
                                    <a href="<?php echo get_home_url();?>">
                                        <?php echo bloginfo( 'name' );?>
                                    </a>
                                </h1>
                			</div>
                            <?php } ?>
                            <?php if ( $header_banner ) : ?>
                                <!-- header-banner open -->                             
                    			<div class="header-banner">
                                <?php
                                    if (($ga_script != '') && ($ga_script != 'Put your google adsense code here')){
                                        echo ($ga_script);
                                    } else { ?>
                                        <a class="ads-banner-link" target="_blank" href="<?php echo esc_attr( $linkurl ); ?>">
                        				    <img class="ads-banner" src="<?php echo esc_attr( $imgurl ); ?>" alt="Header Banner"/>
                                        </a>
                                    <?php }
                                ?> 
                    			</div>                            
                    			<!-- header-banner close -->
                            <?php endif; ?>
                    </div>
                </div>   
    		</div>
            <!-- nav open -->
    		<nav class="main-nav">
                <div class="main-nav-container container clearfix">
                    
                    <div class="mobile-menu-wrap">
                        <a class="mobile-nav-btn" id="nav-open-btn"><i class="fa fa-bars"></i></a>  
                    </div>
                    
                    <?php if ( has_nav_menu( 'main-menu' ) ) { 
                        wp_nav_menu( array( 
                            'theme_location' => 'main-menu',
                            'container_id' => 'main-menu',
                            'walker' => new BK_Walker,
                            'depth' => '3' ) );}?>
    
                </div><!-- main-nav-inner -->            
    		</nav>
    		<!-- nav close -->
            <div class="header-below">
                <div class="container">   
                    <div class="header-below-wrap">         
                        <div id="main-search">
            		          <?php get_search_form(); ?>        
                        </div><!--main-search-->		
                        <?php if ( isset($bk_option ['bk-social-header-switch']) && ($bk_option ['bk-social-header-switch'] == 1) ){ ?>
        				<div class="header-social">
            					<ul class="clearfix">
            						<?php if ($bk_option['bk-social-header']['fb']){ ?>
            							<li class="fb"><a class="bk-tipper-bottom" data-title="Facebook" href="<?php echo esc_url($bk_option['bk-social-header']['fb']); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['twitter']){ ?>
            							<li class="twitter"><a class="bk-tipper-bottom" data-title="Twitter" href="<?php echo esc_url($bk_option['bk-social-header']['twitter']); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['gplus']){ ?>
            							<li class="gplus"><a class="bk-tipper-bottom" data-title="Google Plus" href="<?php echo esc_url($bk_option['bk-social-header']['gplus']); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['linkedin']){ ?>
            							<li class="linkedin"><a class="bk-tipper-bottom" data-title="Linkedin" href="<?php echo esc_url($bk_option['bk-social-header']['linkedin']); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['pinterest']){ ?>
            							<li class="pinterest"><a class="bk-tipper-bottom" data-title="Pinterest" href="<?php echo esc_url($bk_option['bk-social-header']['pinterest']); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['instagram']){ ?>
            							<li class="instagram"><a class="bk-tipper-bottom" data-title="Instagram" href="<?php echo esc_url($bk_option['bk-social-header']['instagram']); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['dribbble']){ ?>
            							<li class="dribbble"><a class="bk-tipper-bottom" data-title="Dribbble" href="<?php echo esc_url($bk_option['bk-social-header']['dribbble']); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
            						<?php } ?>
            						
            						<?php if ($bk_option['bk-social-header']['youtube']){ ?>
            							<li class="youtube"><a class="bk-tipper-bottom" data-title="Youtube" href="<?php echo esc_url($bk_option['bk-social-header']['youtube']); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
            						<?php } ?>      							
            						                                    
                                    <?php if ($bk_option['bk-social-header']['vimeo']){ ?>
            							<li class="vimeo"><a class="bk-tipper-bottom" data-title="Vimeo" href="<?php echo esc_url($bk_option['bk-social-header']['vimeo']); ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
            						<?php } ?>
                                    
                                    <?php if ($bk_option['bk-social-header']['vk']){ ?>
            							<li class="vk"><a class="bk-tipper-bottom" data-title="VKontakte" href="<?php echo esc_url($bk_option['bk-social-header']['vk']); ?>" target="_blank"><i class="fa fa-vk"></i></a></li>
            						<?php } ?>
                                    
                                    <?php if ($bk_option['bk-social-header']['rss']){ ?>
            							<li class="rss"><a class="bk-tipper-bottom" data-title="Rss" href="<?php echo esc_url($bk_option['bk-social-header']['rss']); ?>" target="_blank"><i class="fa fa-rss"></i></a></li>
            						<?php } ?>
            						
            					</ul>
        				</div>
                        <?php }?>
                    </div>
                </div>
                <!-- backtop open -->
        		<?php if ($backtop) { ?>
                    <div id="back-top"><i class="fa fa-long-arrow-up"></i></div>
                <?php } ?>
        		<!-- backtop close -->
            </div>
        
        
        
        
        
        
        