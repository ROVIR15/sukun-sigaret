<?php
    /*
    Plugin Name: Style Switcher
    Plugin URI: http://bk-ninja.com
    Description: Plugin is used for demo theme
    Author: BKNinja
    Version: 1.0
    Author URI: http://bk-ninja.com
    */
?>
<?php
add_action('wp_footer','style_sw',20);
if ( ! function_exists( 'style_sw' ) ) {
    function style_sw() {?>
        <style type='text/css' media="all">
            .color-small-box {
            width: 22px;
            height: 22px;
            display: inline-block;
            border: 2px solid #eee;
            cursor: pointer;
        }
        .color-small-box.selected {
            border: 2px solid #444;
        }
        .style-selector {
            background-color: white;
            border: 1px solid #ccc;
            border-left: none;
            position: fixed;
            top: 110px;
            padding-bottom: 25px;
            width: 250px;
            z-index: 1000;
            border-bottom-right-radius: 3px;
            -webkit-box-shadow: 0 2px 10px 2px rgba(0,0,0,0.11);
            -moz-box-shadow: 0 2px 10px 2px rgba(0,0,0,0.11);
            box-shadow: 0 2px 10px 2px rgba(0,0,0,0.11);
            transition: all 0.5s;
        }
        .switch.button {
            position: absolute;
            top: -1px;
            right: -60px;
            width: 60px;
            display: block;
            z-index: 10000;
            text-align: center;
            cursor: pointer;
            background-color: #eee;
            box-shadow: 2px 2px 0px rgba(0,0,0,0.05);
            border: 1px solid #ccc;
            border-right: 3px solid #ccc;
            font-size: 30px;
        }
        </style>
        <div class="style-selector" style="left: 0px;">
            <div class="switch-container">
                <div class="switch button" status="open"><i class="fa fa-cog"></i></div>
            </div>
            <div class="style-selector-container">
                <h5 class="style-selector-main-title">STYLE SWITCHER</h5>
                <h6 class="style-selector-box-title">Site Layout</h6>
                <div class="field-container">
                    <select name="" id="site_layout">
                    <option value="full-medium">Full-Page (970px Wide)</option>
                    <option value="full-large">Full-Page (1200px Wide)</option>
                    <option value="boxed" selected="selected">Boxed</option>
                </select>
                </div>
                <h6 class="style-selector-box-title">Logo Position</h6>
                <div class="field-container">
                    <select name="" id="logo_position">
                    <option value="left-logo" selected="selected">Left Logo</option>
                    <option value="center-logo">Center Logo
                    </option></select>
                </div>
                <h6 class="style-selector-box-title">Primary Color</h6>
                <div class="field-container primary-color-option">
                    <div class="color-small-box selected" data-color="#F1284E" style="background: #F1284E;"></div>
                    <div class="color-small-box" data-color="#3FACD6" style="background: #3FACD6;"></div>
                    <div class="color-small-box" data-color="#f57f27" style="background: #f57f27;"></div>
                    <div class="color-small-box" data-color="#ee4272" style="background: #ee4272;"></div>
                    <div class="color-small-box" data-color="#5f3577" style="background: #5f3577;"></div>
                    <div class="color-small-box" data-color="#12959f" style="background: #12959f;"></div>
                    <div class="color-small-box" data-color="#afbb26" style="background: #afbb26;"></div>
                    <div class="color-small-box" data-color="#c5aa03" style="background: #c5aa03;"></div>
                </div>
                <h6 class="style-selector-box-title">Top-bar Color</h6>
                <div class="field-container top-bar-color-option">
                    <div class="color-small-box selected" data-color="#333333" style="background: #333333;"></div>
                    <div class="color-small-box" data-color="#b3b3b2" style="background: #b3b3b2;"></div>
                    <div class="color-small-box" data-color="#287fac" style="background: #287fac;"></div>
                    <div class="color-small-box" data-color="#d15719" style="background: #d15719;"></div>
                    <div class="color-small-box" data-color="#c82a4d" style="background: #c82a4d;"></div>
                    <div class="color-small-box" data-color="#3f2251" style="background: #3f2251;"></div>
                    <div class="color-small-box" data-color="#0b6a73" style="background: #0b6a73;"></div>
                    <div class="color-small-box" data-color="#97B866" style="background: #97B866;"></div>
                    <div class="color-small-box" data-color="#997d02" style="background: #997d02;"></div>
                </div>
                <h6 class="style-selector-box-title">Menu Color</h6>
                <div class="field-container menu-color-option">
                    <div class="color-small-box selected" data-color="#333333" style="background: #333333;"></div>
                    <div class="color-small-box" data-color="#b3b3b2" style="background: #b3b3b2;"></div>
                    <div class="color-small-box" data-color="#3FACD6" style="background: #3FACD6;"></div>
                    <div class="color-small-box" data-color="#f57f27" style="background: #f57f27;"></div>
                    <div class="color-small-box" data-color="#ee4272" style="background: #ee4272;"></div>
                    <div class="color-small-box" data-color="#5f3577" style="background: #5f3577;"></div>
                    <div class="color-small-box" data-color="#12959f" style="background: #12959f;"></div>
                    <div class="color-small-box" data-color="#97B866" style="background: #97B866;"></div>
                    <div class="color-small-box" data-color="#c5aa03" style="background: #c5aa03;"></div>
                </div>
                </a>
            </div>
        
        </div>
        <script type="text/javascript">
            ( function ( $ ) {
                $( function() {
                    var $switch = $( '.style-selector .switch' );
                    
                    var toggle_switcher = function( status ) {
    					if ( status == 'open' ) {
    						// open
    						$( '.style-selector' ).css( 'left', '0' );
    						$switch.attr( 'status', 'open' );
    					} else {
    						// close
    						$( '.style-selector' ).css( 'left', '-250px' );
    						$switch.attr( 'status', 'closed' );
    					}
    				}
                    $switch.click( function () {
    					if ( $switch.attr( 'status' ) == 'closed' ) {
    						toggle_switcher( 'open' );
    					} else {
    						toggle_switcher( 'closed' );
    					}
    				} );
                
                    $( '.color-small-box' ).click( function() {
                        if ( $( this ).hasClass( 'selected' ) ) return;
                        
                        $( this ).siblings().removeClass( 'selected' );
                        $( this ).toggleClass( 'selected' );
                    } );
            		$( '.primary-color-option .color-small-box' ).click( function() {
            			var value = $( this ).data('color');
            			var template = $( '#primary-color-option-template' ).val();
            			template = template.replace(/##VAL##/g, value);
            			$( '#primary-color-option' ).text( template );
            		} );
            	} );
            } )( jQuery );
        </script>

        <textarea id="primary-color-option-template" style="display:none;">		
            ::selection {color: #FFF; background: ##VAL##;}
            ::-webkit-selection {color: #FFF; background: ##VAL##;}
                
            .main-nav #main-menu .menu > li:hover, .bk-mega-menu .bk-sub-posts .feature-post .menu-post-item .post-title:after, .bk-mega-menu .bk-sub-posts .latest-post .menu-post-item .post-author, 
            .bk-mega-menu .bk-sub-menu > li:hover, #main-menu .menu .bk-dropdown-menu ul li:hover, .bk-grid .post-title h3:after, .single-post-one-col .large-thumbnail-post .post-meta .post-author,
            .single-post-two-col .post-title h3:after, .module-post .large-thumbnail-post .post-categories, .bk-module .post-thumb-wrap .info, .widget-slider .flexslider .flex-viewport .slides li .post-title h3:after, 
            .photostack a.info, .photostack figcaption h1:after, .photostack nav span.current
            {background-color: ##VAL##;}
            
            .post-title a:hover
            {color: ##VAL##;}
            
            #flickr li a:hover img 
            {border-color:##VAL##;}
        </textarea>
        <style id="primary-color-option"></style>
    <?php }?>
<?php }?>