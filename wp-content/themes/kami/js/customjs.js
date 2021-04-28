(function($) {
  "use strict";
    $=jQuery;
    jQuery(document).ready(function($){
        if (!($('#page-content-wrap > .bksection:first-child .content .bkmodule:first-child').hasClass('module-maingrid'))
         && !($('#page-content-wrap > .bksection:first-child .content .bkmodule:first-child').hasClass('module-mainslider'))){
            $('#page-content-wrap div:first').css("margin-top","30px");
        }
        $(".price_slider_amount").css("opacity", "1");
        $(window).resize(function(){
            var doc = document.documentElement;
            var pagecontainer = document.getElementById( 'page-inner-wrap' );
            if($(window).width() >= 1000 ){ 
                $('#main-mobile-menu').css('display','none');
                jQuery(pagecontainer).find('.page-cover').css({"opacity":"0.5", "display":"none"});     
                $('html').removeClass('js-nav');
            }else {
                $('#main-mobile-menu').css('display','block');
            }
        });
        $('#mobile-menu > ul > li.menu-item-has-children').prepend('<div class="expand"><i class="fa fa-chevron-down"></i></div>');
        $('#mobile-top-menu > ul > li.menu-item-has-children').prepend('<div class="expand"><i class="fa fa-chevron-down"></i></div>');    
        $('.expand').click(function(){
            $(this).siblings('.sub-menu').toggle(300); 
        });
    // Load More
        $('.loadmore').addClass('active');
        $('.bkmodule').on('click','.loadmore.active',function(){
            var $this = $(this);
            var $bk_fw = "";
            if($(this).hasClass('no-more')){
                return;
            }
            if ($this.closest('.loadmore-wrap').siblings('.content-wrap').hasClass('bk-fw')) {
                var $container = $this.closest('.loadmore-wrap').siblings('.content-wrap').find('ul').first();
                $bk_fw = 'true';
            }else {
                var $container = $this.closest('.loadmore-wrap').siblings('.content-wrap').find('.row').first();
            }
            $this.closest('.loadmore-wrap').siblings('.content-wrap').css('height',$container.height());        
            $('.loadmore').removeClass('active');
            $this.addClass('loading');
            $container.append('<i class="bk-load"></i>');
            
            var module_id = $(this).parent('.loadmore-wrap').attr('id');
            var direction = $(this).attr('class').split(' ')[1];
            var entries_loadmore = parseInt(loadmore['entry'][module_id]);
            var background_color = loadmore['background_color'][module_id];
            var text_color = loadmore['text_color'][module_id];        
            
            if (direction == 'next') {
                if($bk_fw == "true") {
                    loadmore['offset'][module_id] = parseInt(loadmore['offset'][module_id]) + entries_loadmore/2;
                }else {
                    loadmore['offset'][module_id] = parseInt(loadmore['offset'][module_id]) + entries_loadmore;
                }
            }else {
                if($bk_fw == "true") {
                    loadmore['offset'][module_id] = parseInt(loadmore['offset'][module_id]) - entries_loadmore/2;
                }else {
                    loadmore['offset'][module_id] = parseInt(loadmore['offset'][module_id]) - entries_loadmore;
                }
            }
            var loadoffset = loadmore['offset'][module_id];
            var data = {
    			action			    : $(this).attr('class').split(' ')[2],
                post_offset         : loadoffset,
                cat_id              : loadmore['cat'][module_id],
                entries             : entries_loadmore,
                background_color    : background_color,
                text_color          : text_color,
                bk_layout            : loadmore['bk_layout'][module_id],
    		};   
            $.post( ajaxurl, data, function( respond ){
                var respond_length = $(respond).find('.post-element').length;
                if(respond_length < entries_loadmore){
                    $this.addClass('no-more');
                }
                
                if ($bk_fw == "true") {
                    var res = respond.split("<!-- break -->");
                    var content_split =[res[0], res[1], res[2], res[3], res[4]] ;
                    var bk_fw_content = content_split.join(" ");
                    var el = $(bk_fw_content).hide().fadeIn('1500');
                }else {
                    var el = $(respond).hide().fadeIn('1500');
                }
                
                if ((direction == 'next') && ($this.siblings('.previous').hasClass('no-more'))){
                    $this.siblings('.previous').removeClass('no-more');
                }else if((direction == 'previous') && (loadoffset < entries_loadmore) && ($bk_fw != "true")){
                    $this.addClass('no-more');
                }else if((direction == 'previous') && (loadoffset < (entries_loadmore/2)) && ($bk_fw == "true")){
                    $this.addClass('no-more');
                }
                if((direction == 'previous') && ($this.siblings('.next').hasClass('no-more'))){
                    $this.siblings('.next').removeClass('no-more');
                }
                if (respond_length == 0) {
                    $container.find('.bk-load').remove();     
                    $('.loadmore').addClass('active');
                    $this.removeClass('loading');
                    if($bk_fw == "true") {
                        loadmore['offset'][module_id] = parseInt(loadmore['offset'][module_id]) - entries_loadmore/2;
                    }else {
                        loadmore['offset'][module_id] = parseInt(loadmore['offset'][module_id]) - entries_loadmore;
                    }
                    return false;
                }
                $container.empty();
                $container.append(el);
                $container.find('.bk-load').remove();     
                $('.loadmore').addClass('active');
                $this.removeClass('loading');
                $container.imagesLoaded(function(){
                    setTimeout(function() {
                        $this.closest('.loadmore-wrap').siblings('.content-wrap').animate({height:$container.height()}); 
                    },200);
                });
            });
        });
    // End Loadmore
        //Megamenu
        if (megamenu_carousel_el != null) {
            var bk_megamenu_item;
            $.each( megamenu_carousel_el, function( id, maxitems ) {         
                bk_megamenu_item = $('#'+id).find('.bk-sub-post').length;
                if(bk_megamenu_item >= maxitems) {
                    $('#'+id).flexslider({
                        animation: "slide",
                        animationLoop: true,
                        slideshow: false,
                        itemWidth: 10,
                        minItems: maxitems,
                        maxItems: maxitems,
                        controlNav: false,
                        directionNav: true,
                        slideshowSpeed: 3000,
                        prevText: '',
                        nextText: '',
                        move: 1,
                        touch: true,
                        useCSS: true,
                    });
                }else{
                    //console.log(bk_megamenu_item);
                    //console.log(maxitems);
                    $('#'+id).removeClass('flexslider');
                    $('#'+id).addClass('flexslider_destroy');
                }
            });
        }
    /*** Light Box ***/
        $('.img-popup-link').magnificPopup({
    		type: 'image',
    		closeOnContentClick: true,
    		closeBtnInside: false,
    		fixedContentPos: true,		
    		image: {
    			verticalFit: true
    		},
            zoom: {
    			enabled: true,
    			duration: 600, // duration of the effect, in milliseconds
                easing: 'ease', // CSS transition easing function
    			opener: function(element) {
    				return element.find('img');
    			}
    		}
    	});
        $.each( justified_ids, function( index, justified_id ) {
        	$(".justifiedgall_"+justified_id).justifiedGallery({
        		rowHeight: 200,
        		fixedHeight: false,
        		lastRow: 'justify',
        		margins: 4,
        		randomize: false,
                sizeRangeSuffixes: {lt100:"",lt240:"",lt320:"",lt500:"",lt640:"",lt1024:""},
        	});
        });        
        $('.zoom-gallery').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
        		delegate: 'a.zoomer',
        		type: 'image',
        		closeOnContentClick: false,
        		closeBtnInside: false,
        		mainClass: 'mfp-with-zoom mfp-img-mobile',
        		image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        			verticalFit: true,
        			titleSrc: function(item) {
        				return ' <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">'+ item.el.attr('title') + '</a>';
        			}
        		},
        		gallery: {
        			enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
        		},
                zoom: {
        			enabled: true,
        			duration: 600, // duration of the effect, in milliseconds
                    easing: 'ease', // CSS transition easing function
        			opener: function(element) {
        				return element.find('img');
        			}
        		}
        	});	
    	});    
        $('.flexslider').imagesLoaded(function(){
            $('.module-mainslider').find('.carousel-ctrl').attr('style', 'margin-top: -105px !important');
            $(".module-maingrid .flexslider").flexslider({
                animation: "fade",
                controlNav: false,
                directionNav: true,
                slideshowSpeed: 10000,
                smoothHeight: true,
                pauseOnHover: true,
                prevText: '',
                nextText: '',
                after: function(slider) {
                    if (!slider.playing) {
                        slider.play();
                    }
                }
            }); 
            // Main slider
            $.each( main_slider, function( index, id ) {		
                $("#carousel_ctrl_"+id).flexslider({
                    animation: 'slide',
                    controlNav: false,
                    animationLoop: true,
                    slideshow: false,
                    directionNav: true,
                    itemWidth: 10,
                    itemMargin: 0,
                    maxItems: 5,
                    minItems: 1,
                    prevText: '',
                    nextText: '',
                    asNavFor: '#slider_'+id
                });
                
                $('#slider_'+id).flexslider({
                    animation: 'fade',
                    controlNav: false,
                    animationLoop: true,
                    slideshow: true,
                    slideshowSpeed: 8000,
                    animationSpeed: 600,
                    smoothHeight: true,
                    directionNav: true,
                    prevText: '',
                    nextText: '',
                    sync: "#carousel_ctrl_"+id,
                    after: function(slider) {
                        if (!slider.playing) {
                            slider.play();
                        }
                    } 
                });
            });
            $('.widget-slider .flexslider').flexslider({
                animation: "fade",
                controlNav: false,
                directionNav: true,
                slideshowSpeed: 10000,
                smoothHeight: true,
                pauseOnHover: true,
                prevText: '',
                nextText: '',
                after: function(slider) {
                    if (!slider.playing) {
                        slider.play();
                    }
                }
            }); 
            $('.cat-slider.flexslider').flexslider({
                animation: "fade",
                controlNav: false,
                directionNav: true,
                slideshowSpeed: 10000,
                smoothHeight: true,
                pauseOnHover: true,
                prevText: '',
                nextText: '',
                after: function(slider) {
                    if (!slider.playing) {
                        slider.play();
                    }
                }
            }); 
            if($('.product.flexslider ul li').length > 3) {
                $('.product.flexslider').flexslider({
                    animation: "slide",
                    animationLoop: false,
                    itemWidth: 110,
                    minItems: 1,
                    maxItems: 3,
                    prevText: '',
                    nextText: '',
                });
            }else {
                $('.product').removeClass('flexslider');
            }
            $('.woocommerce-page div.product div.thumbnails ul li').css('display', 'block');
        //Gallery Script
            $('#bk-carousel-gallery-thumb').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: false,
                directionNav: true,
                itemWidth: 100,
                itemMargin: 0,
                maxItems: 6,
                prevText: '',
                nextText: '',
                asNavFor: '#bk-gallery-slider',
              })				    
            $('#bk-gallery-slider').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: false,
                sync: '#bk-carousel-gallery-thumb',
                pauseOnHover: true,
                slideshowSpeed: 5000,
                animationSpeed: 600,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            }); 
        });
        //Ticker 
        $.each( ticker, function( id, config ) {    
            if(config == 'Scroll'){
                scroll_ticker_create('#'+id);
            }else if(config == 'Slide'){
                $("#"+id+" ul.ticker").liScroll({travelocity: 0.07});
            }
        });    
        $('.ticker-wrapper').css('opacity','1');
        $('.menu-toggle').toggle(function(){
            $('.open-icon').removeClass('hide');
            $('.close-icon').addClass('hide');
            $('.share-label').addClass('hide');
            $('.top-share').removeClass('hide');
    
        },function(){
            $('.close-icon').removeClass('hide');
            $('.open-icon').addClass('hide');
            $('.share-label').removeClass('hide');
            $('.top-share').addClass('hide');
        });
        
        var bkRate = $('#bk-rate').find('.bk-overlay');
        var bkRateStars = $('#bk-rate').find('.bk-overlay-stars');
        
        if (bkRate.length) {
            
            $(bkRate).on('click', function() {
                $(bkRate).tipper({
                    direction: "bottom"
                });
            });
        }
        // Single Parallax
        var bkParallaxFeatImg = $('.feat-img-parallax');
        if ( bkParallaxFeatImg.length !== 0 ) {
            $(window).scroll(function() {
            var bkBgy_p = -( ($(window).scrollTop()) / 3.5),
                bkBgPos = '50% ' + bkBgy_p + 'px';
            
            bkParallaxFeatImg.css( "background-position", bkBgPos );
            
            });
        }
        
        $(".bk-tipper-bottom").tipper({
            direction: "bottom"
        });
        
        if (fixed_nav == 2) {
            var nav = $('nav.main-nav');
            var d = nav.offset().top;
            $(window).scroll(function () {
                if ($(this).scrollTop() > d) {
                    nav.addClass("fixed");
                    //menu fixed if have admin bar
                    var ad_bar = $('#wpadminbar');
                    if(ad_bar.length != 0) {
                        $('.main-nav').css('margin-top',ad_bar.height());
                    }
                } else {
                    nav.removeClass("fixed");
                    $('.main-nav').css('margin-top','0');
                }
            });
        }
        
        // Back top
    	$(window).scroll(function () {
    		if ($(this).scrollTop() > 500) {
    			$('#back-top').css('bottom','0');
    		} else {
    			$('#back-top').css('bottom','-34px');
    		}
    	});
        
    	// scroll body to top on click
    	$('#back-top').click(function () {
    		$('body,html').animate({
    			scrollTop: 0,
    		}, 1300);
    		return false;
    	});
    
    // Login form bbpress
    
        $('.bbp-login-links > .bbp-register-link').addClass('button');
        $('.bbp-login-links > .bbp-lostpass-link').addClass('button');
        
    });
})(jQuery);