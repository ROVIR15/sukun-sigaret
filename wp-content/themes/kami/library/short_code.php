<?php
add_action( 'init', 'wptuts_buttons' );
function wptuts_buttons() {
    add_filter( "mce_external_plugins", "wptuts_add_buttons" );
    add_filter( 'mce_buttons', 'wptuts_register_buttons' );
}
function wptuts_add_buttons( $plugin_array ) {
    $plugin_array['wptuts'] = get_template_directory_uri() . '/js/short_code.js';
    return $plugin_array;
}
function wptuts_register_buttons( $buttons ) {
    array_push( $buttons, 'youtube_embed', 'vimeo_embed', 'buttonsc', 'half_cols', 'one_third_cols', 'two_third_cols' );
    return $buttons;
}
function register_youtube_embed_shortcode($atts) {
    $atts = shortcode_atts (
        array (
            'src'       => '',
        ), $atts );
        $yt_id = parse_youtube($atts['src']);
        
        return '
        <div class="video-wrap-sc">
            <div class="bk-embed-video">
                <iframe width="1050" height="591" src="http://www.youtube.com/embed/'.$yt_id.'" allowFullScreen ></iframe>
            </div>
        </div>';

}
add_shortcode('youtube_embed', 'register_youtube_embed_shortcode');

function register_vimeo_embed_shortcode($atts) {
    $atts = shortcode_atts (
        array (
            'src'       => '',
        ), $atts );
        $vimeo_id = parse_vimeo($atts['src']);
        
        return '
        <div class="video-wrap-sc">
            <div class="bk-embed-video">                
                    <iframe src="http://player.vimeo.com/video/'.$vimeo_id.'?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff"></iframe>
                </div>
        </div>';    
}
add_shortcode('vimeo_embed', 'register_vimeo_embed_shortcode');

function register_colfirsthalf_shortcode($atts, $content = null) {
    return "
        <div class='column halfsc first-col'>             
            ".do_shortcode( $content )."
        </div>";
}
add_shortcode('first_half', 'register_colfirsthalf_shortcode');

function register_collasthalf_shortcode($atts, $content = null) {
    return '
        <div class="column halfsc last-col">             
            '.do_shortcode( $content ).'
        </div><div class="clearfix"></div>';
}
add_shortcode('last_half', 'register_collasthalf_shortcode');

function register_colfirstthird_shortcode($atts, $content = null) {
    return '
        <div class="column thirdsc one-third">             
            '.do_shortcode( $content ).'
        </div>';    
}
add_shortcode('first_third', 'register_colfirstthird_shortcode');

function register_colsecondthird_shortcode($atts, $content = null) {
    return '
        <div class="column thirdsc second-third">             
            '.do_shortcode( $content ).'
        </div>';    
}
add_shortcode('second_third', 'register_colsecondthird_shortcode');

function register_collastthird_shortcode($atts, $content = null) {
    return '
        <div class="column thirdsc last-third">             
            '.do_shortcode( $content ).'
        </div><div class="clearfix"></div>';    
}
add_shortcode('last_third', 'register_collastthird_shortcode');

function register_coltwothird_shortcode($atts, $content = null) {
        return '
        <div class="column thirdsc two-third">             
            '.do_shortcode( $content ).'
        </div>';    
}
add_shortcode('two_third', 'register_coltwothird_shortcode');

function register_button_shortcode($atts) {
    $atts = shortcode_atts (
        array (
            'href'       => '',
            'name'       => '',
            'target'       => '_blank',
        ), $atts );

        return '
        <div class="buttonsc" style="background-color: #F1284E;">             
            <a href="'. $atts['href'] .'" target="'. $atts['target'] .' ">'. $atts['name'] .'</a>
        </div>';
}
add_shortcode('button', 'register_button_shortcode');