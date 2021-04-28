    		<?php 
                global $countdownID;
                global $bk_ticker;
                global $justified_ids;
                
                global $ytframe_ID;
                global $ytframe_No;
                global $bk_megamenu_carousel_el;
                global $main_slider;
                
                wp_localize_script( 'customjs', 'countdownID', $countdownID );
                wp_localize_script( 'customjs', 'ticker', $bk_ticker );
                wp_localize_script( 'customjs', 'justified_ids', $justified_ids );
                wp_localize_script( 'customjs', 'megamenu_carousel_el', $bk_megamenu_carousel_el );
                wp_localize_script( 'customjs', 'main_slider', $main_slider );
                
                global $bk_option;
                if (isset($bk_option)):
                    $fixed_nav = $bk_option['bk-fixed-nav-switch'];            
                    wp_localize_script( 'customjs', 'fixed_nav', $fixed_nav );
            
                    $cr_text = $bk_option['cr-text'];
                    $custom_js = $bk_option['bk-js-code'];

                endif;
            ?>
            <script>
                <?php
                    global $ytframe_ID;
                    global $ytframe_No;
                    $ytframeID_arr = json_encode($ytframe_ID);
                    echo "ytframe_ID = ". $ytframeID_arr . ";\n";
                ?>
            </script>
            
            <div class="footer">
                <!-- ticker open -->
                <?php        
                    if (isset($bk_option)){
                        if ($bk_option['bk-footer-ticker'] == 1) {
                            bk_get_ticker('footer');
                        }
                    }
                ?>
                <!-- ticker close -->
                    
                <?php if (is_active_sidebar('footer_sidebar_1') 
                        || is_active_sidebar('footer_sidebar_2')
                        || is_active_sidebar('footer_sidebar_3')) { ?>
                <div class="footer-content clearfix container">
                    <div class="row">
                        <div class="footer-sidebar col-md-4">
                            <?php dynamic_sidebar( 'footer_sidebar_1' ); ?>
                        </div>
                        <div class="footer-sidebar col-md-4">
                            <?php dynamic_sidebar( 'footer_sidebar_2' ); ?>
                        </div>
                        <div class="footer-sidebar col-md-4">
                            <?php dynamic_sidebar( 'footer_sidebar_3' ); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="footer-lower">
                    <div class="footer-inner clearfix">
                        <div class="bk-copyright"><?php echo $cr_text;?></div>
                        <?php if ( has_nav_menu('menu-footer') ) {?> 
                            <?php wp_nav_menu(array('theme_location' => 'menu-footer', 'depth' => '1', 'container_id' => 'footer-menu'));?>  
                        <?php }?>  
                    </div>
                </div>
                <?php 
                    global $customconfig;
                    wp_localize_script( 'customjs', 'customconfig', $customconfig );
                ?>
                
    		</div>
        </div> <!-- Close Page inner Wrap -->

	</div> <!-- Close Page Wrap -->
    <?php        
    if ($custom_js != '') {
        echo ("<script type='text/javascript'>");
        echo ($custom_js);
        echo ("</script>");
    }?>
    <?php wp_footer(); ?>
</body>

</html>
