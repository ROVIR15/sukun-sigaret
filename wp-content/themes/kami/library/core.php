<?php
if ( ! function_exists( 'bk_review_score' ) ) {
    function bk_review_score ($post_id) {
        $ret = '';
        if (strlen(get_post_meta($post_id, 'bk_final_score', true)) > 0) {
            $ret .= '<div class="review-score">';
            $ret .= '<span><i class="fa fa-star-o"></i></span>';
            $ret .= get_post_meta($post_id, 'bk_final_score', true);
            $ret .= '</div>';
        }
        
        
        return $ret;
    }
}
/**
 * Get Ticker
 */
if ( ! function_exists( 'bk_get_ticker' ) ) {
    function bk_get_ticker($location) {
        global $bk_option;
        global $bk_ticker;
        $feat_tag = array();
        $ticker_cat = array();
        
        if (isset($bk_option)){
            if ($location == 'header') {
                $title = $bk_option['bk-ticker-title'];
                if ( $title == '' ) { $title = 'Breaking News';}
                
                $ticker_num = $bk_option['bk-ticker-number'];
                if ( $ticker_num == '' ) { $ticker_num = 5;}
                
                $ticker_ani = $bk_option['bk-ticker-type'];
                if ( $ticker_ani == '' ) { $ticker_ani = 'Slide';}
                
                
                $featured_enable = $bk_option['bk-ticker-featured'];
                if ($featured_enable == 1) {
                    $feat_ops =  $bk_option['bk-ticker-featured-option'];
                    if ($feat_ops == 'Sticky') {
                        $args = array(
                			'post__in'  => get_option( 'sticky_posts' ),
                			'post_status' => 'publish',
                			'ignore_sticky_posts' => 1,
                			'posts_per_page' => $ticker_num,
                        );
                    }else {
                        $feat_tag = $bk_option['ticker-featured-tags'];
                         if (sizeof($feat_tag)) { 
                            $args = array(
                    			'tag__in' => $feat_tag,
                    			'post_status' => 'publish',
                    			'ignore_sticky_posts' => 1,
                    			'posts_per_page' => $ticker_num,
                                );   
                        }
                    }
                }else {
                    if(isset($bk_option['ticker-category'])) {
                        $ticker_cat = $bk_option['ticker-category'];
                    }else {
                        $ticker_cat = '';
                    }
                        if (sizeof($ticker_cat)) {
                        $args = array(
                            'category__in'  => $ticker_cat,
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => $ticker_num,
                        );
                    }
                }
            }else if ($location == 'footer') {
                $title = $bk_option['bk-ticker-footer-title'];
                if ( $title == '' ) { $title = 'Breaking News';}
                
                $ticker_num = $bk_option['bk-ticker-footer-number'];
                if ( $ticker_num == '' ) { $ticker_num = 5;}
                
                $ticker_ani = $bk_option['bk-ticker-footer-type'];
                if ( $ticker_ani == '' ) { $ticker_ani = 'Slide';}
                
                
                $featured_enable = $bk_option['bk-ticker-footer-featured'];
                if ($featured_enable == 1) {
                    $feat_ops =  $bk_option['bk-ticker-footer-featured-option'];
                    if ($feat_ops == 'Sticky') {
                        $args = array(
                			'post__in'  => get_option( 'sticky_posts' ),
                			'post_status' => 'publish',
                			'ignore_sticky_posts' => 1,
                			'posts_per_page' => $ticker_num,
                        );
                    }else {
                        $feat_tag = $bk_option['ticker-footer-featured-tags'];
                         if (sizeof($feat_tag)) { 
                            $args = array(
                    			'tag__in' => $feat_tag,
                    			'post_status' => 'publish',
                    			'ignore_sticky_posts' => 1,
                    			'posts_per_page' => $ticker_num,
                                );   
                        }
                    }
                }else {
                    $ticker_cat = $bk_option['ticker-footer-category'];
                        if (sizeof($ticker_cat)) {
                        $args = array(
                            'category__in'  => $ticker_cat,
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => $ticker_num,
                        );
                    }
                }
            }

            $uid = uniqid('ticker-wrapper-');
            
            $bk_ticker[$uid] = $ticker_ani;
            wp_localize_script( 'customjs', 'ticker', $bk_ticker );
            ?>
             
            <div id="<?php echo $uid;?>" class="ticker-wrapper">
                <div class="bk-container">
                    <h3 class="ticker-header"><?php echo esc_attr($title); ?></h3>
                    <div class="tickercontainer <?php if ($ticker_ani = 'Scroll') {echo "ticker-scroll";}?>">
                        <div class="mask">                                        
                            <ul class="ticker">
                                <?php $ticker_news = new WP_Query($args); while($ticker_news->have_posts()) : $ticker_news->the_post();?>
                                <li>
                                    <div class="thumb">
                                        <?php 
                                            if(has_post_thumbnail( get_the_ID() )) {
                                                echo get_the_post_thumbnail(get_the_ID(), 'bk400_300');
                                            }else {
                                                echo '<img width="400" height="300" src="'.get_template_directory_uri().'/images/bkdefault400_300.jpg">';
                                            }
                                        ?>
                                    </div>
                                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>                        
                    </div>                    
                </div>
            </div><!--ticker-wrapper-->
        <?php
        }
    }
}
/**
 * ************* Post Views *********************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'getPostViews' ) ) {  
    function getPostViews($postID){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
       }
       return $count;
    }
}
if ( ! function_exists( 'setPostViews' ) ) {  
    function setPostViews($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

/**
 * ************* Get unique ID  *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists('bk_uid')){
    function bk_uid(){
        return uniqid();
    }
}

/**
 * ********* Get Post Category ************
 *---------------------------------------------------
 */ 
if ( ! function_exists('bk_get_category_link')){
    function bk_get_category_link($postid){ 
        $html = '';
        $category = get_the_category($postid); 
        if(isset($category[0]) && $category[0]){
            $html.= '<div class="post-cat">
                        <a class="cat-bg-'.$category[0]->term_id.'" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>
                    </div>';  					
        }
        return $html;
    }
}

/**
 * ************* Get youtube ID  *****************
 *---------------------------------------------------
 */ 
  
function parse_youtube($link){
 
    $regexstr = '~
        # Match Youtube link and embed code
        (?:                             # Group to match embed codes
            (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
            |(?:                        # Group to match if older embed
                (?:<object .*>)?      # Match opening Object tag
                (?:<param .*</param>)*  # Match all param tags
                (?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
            )?                          # End older embed code group
        )?                              # End embed code groups
        (?:                             # Group youtube url
            https?:\/\/                 # Either http or https
            (?:[\w]+\.)*                # Optional subdomains
            (?:                         # Group host alternatives.
            youtu\.be/                  # Either youtu.be,
            | youtube\.com              # or youtube.com
            | youtube-nocookie\.com     # or youtube-nocookie.com
            )                           # End Host Group
            (?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
            ([\w\-]{11})                # $1: VIDEO_ID is numeric
            [^\s]*                      # Not a space
        )                               # End group
        "?                              # Match end quote if part of src
        (?:[^>]*>)?                       # Match any extra stuff up to close brace
        (?:                             # Group to match last embed code
            </iframe>                 # Match the end of the iframe
            |</embed></object>          # or Match the end of the older embed
        )?                              # End Group of last bit of embed code
        ~ix';

    preg_match($regexstr, $link, $matches);

    return $matches[1];

}

/**
 * ************* Get vimeo ID *****************
 *---------------------------------------------------
 */  

function parse_vimeo($link){
 
    $regexstr = '~
        # Match Vimeo link and embed code
        (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
        (?:                         # Group vimeo url
            https?:\/\/             # Either http or https
            (?:[\w]+\.)*            # Optional subdomains
            vimeo\.com              # Match vimeo.com
            (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
            \/                      # Slash before Id
            ([0-9]+)                # $1: VIDEO_ID is numeric
            [^\s]*                  # Not a space
        )                           # End group
        "?                          # Match end quote if part of src
        (?:[^>]*></iframe>)?        # Match the end of the iframe
        (?:<p>.*</p>)?              # Match any title information stuff
        ~ix';

    preg_match($regexstr, $link, $matches);

    return $matches[1];
}
function parse_dailymotion($link){
    preg_match('#<object[^>]+>.+?http://www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s', $link, $matches);

        // Dailymotion url
        if(!isset($matches[1])) {
            preg_match('#http://www.dailymotion.com/video/([A-Za-z0-9]+)#s', $link, $matches);
        }

        // Dailymotion iframe
        if(!isset($matches[1])) {
            preg_match('#http://www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $link, $matches);
        }
    return $matches[1];
}

/**
 * ************* The custom excerpt *****************
 *---------------------------------------------------
 */  
function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

function the_excerpt_limit($string, $word_limit){
    $strout = string_limit_words($string,$word_limit);
    if (strlen($strout) < strlen($string))
        $strout .=" ...";
    return $strout;
}
/**
 * Ajax callback for attaching media to field
 *
 * @return void
 */
add_action( 'wp_ajax_blog_small', 'bk_ajax_blog_small' );
add_action('wp_ajax_nopriv_blog_small', 'bk_ajax_blog_small');
if ( ! function_exists( 'bk_ajax_blog_small' ) ) {
    function bk_ajax_blog_small() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
        
    	$args = array(
            'cat' => $cat_id,
            'posts_per_page' => $entries,
            'offset' => $post_offset,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $the_query = new WP_Query( $args );
        echo (bk_get_blog_small_content($the_query));
        die();
    }
}
add_action( 'wp_ajax_blog_small_leftsec', 'bk_ajax_blog_small_leftsec' );
add_action('wp_ajax_nopriv_blog_small_leftsec', 'bk_ajax_blog_small_leftsec');
if ( ! function_exists( 'bk_ajax_blog_small_leftsec' ) ) {
    function bk_ajax_blog_small_leftsec() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
        
    	$args = array(
            'cat' => $cat_id,
            'posts_per_page' => $entries,
            'offset' => $post_offset,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $the_query = new WP_Query( $args );
        echo (bk_get_blog_small_leftsec_content($the_query));
        die();
    }
}
/**
 * Ajax callback for large blog module
 *
 * @return void
 */
add_action( 'wp_ajax_large_blog', 'bk_ajax_large_blog' );
add_action('wp_ajax_nopriv_large_blog', 'bk_ajax_large_blog');
if ( ! function_exists( 'bk_ajax_large_blog' ) ) {
    function bk_ajax_large_blog() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
        
    	$args = array(
            'cat' => $cat_id,
            'posts_per_page' => $entries,
            'offset' => $post_offset,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $the_query = new WP_Query( $args );
        echo (bk_get_large_blog_content($the_query));
        die();
    }
}
/**
 * Ajax callback for windows module
 *
 * @return void
 */
add_action( 'wp_ajax_windows', 'bk_ajax_windows' );
add_action('wp_ajax_nopriv_windows', 'bk_ajax_windows');
function bk_ajax_windows(){
    $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
    $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
    $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
    $bk_layout = isset( $_POST['bk_layout'] ) ? $_POST['bk_layout'] : 0;
    $args = array(
        'cat' => $cat_id,
        'posts_per_page' => $entries,
        'offset' => $post_offset,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
        );
    $the_query = new WP_Query( $args );
    echo (bk_get_windows_content($the_query, $bk_layout));
    die();
}

/**
 * Ajax callback for 1l & 2m_side module
 *
 * @return void
 */
add_action( 'wp_ajax_1l_2m_side', 'bk_ajax_1l_2m_side' );
add_action('wp_ajax_nopriv_1l_2m_side', 'bk_ajax_1l_2m_side');
function bk_ajax_1l_2m_side(){
    $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
    $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
    $args = array(
        'cat' => $cat_id,
        'posts_per_page' => 3,
        'offset' => $post_offset,
        'orderby' => 'date',
        'post_status' => 'publish',
        'order' => 'DESC'
        );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
        echo (bk_get_1l_2m_side_content($the_query));
    endif;
    die();
}
/**
 * Ajax callback for row module
 *
 * @return void
 */
add_action( 'wp_ajax_m_row', 'bk_ajax_m_row' );
add_action('wp_ajax_nopriv_m_row', 'bk_ajax_m_row');
function bk_ajax_m_row(){
    $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
    $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
    $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
    $bk_layout = isset( $_POST['bk_layout'] ) ? $_POST['bk_layout'] : 0;                
    $args = array(
        'cat' => $cat_id,
        'posts_per_page' => $entries,
        'offset' => $post_offset,
        'orderby' => 'date',
        'post_status' => 'publish',
        'order' => 'DESC'
        );
    $the_query = new WP_Query( $args );
    echo (bk_get_row_content($the_query, $bk_layout));
    die();
}

/**
 * Ajax callback for 1l&list side module
 *
 * @return void
 */
add_action( 'wp_ajax_1l_list_side', 'bk_ajax_1l_list_side' );
add_action('wp_ajax_nopriv_1l_list_side', 'bk_ajax_1l_list_side');
function bk_ajax_1l_list_side(){
    $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
    $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
    $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
    $args = array(
        'cat' => $cat_id,
        'posts_per_page' => $entries,
        'offset' => $post_offset,
        'orderby' => 'date',
        'post_status' => 'publish',
        'order' => 'DESC'
        );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
        echo (bk_get_1l_list_side_content($the_query));
    endif; 
    die();
}

/**
 * Ajax callback for ajax grid module
 *
 * @return void
 */
add_action( 'wp_ajax_ajax_grid', 'bk_ajax_ajax_grid' );
add_action('wp_ajax_nopriv_ajax_grid', 'bk_ajax_ajax_grid');
function bk_ajax_ajax_grid(){
    $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
    $cat_id = isset( $_POST['cat_id'] ) ? $_POST['cat_id'] : 0;
    $args = array(
        'cat' => $cat_id,
        'posts_per_page' => 10,
        'offset' => $post_offset,
        'orderby' => 'date',
        'post_status' => 'publish',
        'order' => 'DESC',
        );
    $the_query = new WP_Query( $args );
    echo (bk_get_ajax_grid_content($the_query));
    die();
}
/**
 * ************* Related Post *****************
 *---------------------------------------------------
 */     

if ( ! function_exists( 'bk_related_posts' ) ) {        
    function bk_related_posts($bk_number_related) {
        global $post;
        $bk_post_id = $post->ID;
        if (is_attachment() && ($post->post_parent)) { $bk_post_id = $post->post_parent; };
        $i = 1;
        $bk_related_posts = array();
        $bk_relate_tags = array();
        $bk_relate_categories = array();
        $excludeid = array();
        $bk_number_related_remain = 0;
        array_push($excludeid, $bk_post_id);

        $bk_tags = wp_get_post_tags($bk_post_id);   
        $tag_length = sizeof($bk_tags);                               
        $bk_tag_check = $bk_all_cats = NULL;
 
 // Get tag post
        if ($tag_length > 0){
            foreach ( $bk_tags as $bk_tag ) { $bk_tag_check .= $bk_tag->slug . ','; }             
                $bk_related_args = array(   'numberposts' => $bk_number_related, 
                                            'tag' => $bk_tag_check, 
                                            'post__not_in' => $excludeid,
                                            'post_status' => 'publish',
                                            'orderby' => 'rand'  );
            $bk_relate_tags_posts = get_posts( $bk_related_args );
            $bk_number_related_remain = $bk_number_related - sizeof($bk_relate_tags_posts);
            if(sizeof($bk_relate_tags_posts) > 0){
                foreach ( $bk_relate_tags_posts as $bk_relate_tags_post ) {
                    array_push($excludeid, $bk_relate_tags_post->ID);
                    array_push($bk_related_posts, $bk_relate_tags_post);
                }
            }
        }
 // Get categories post
        $bk_categories = get_the_category($bk_post_id);  
        $category_length = sizeof($bk_categories);       
        if ($category_length > 0){       
            foreach ( $bk_categories as $bk_category ) { $bk_all_cats .= $bk_category->term_id  . ','; }
                $bk_related_args = array(  'numberposts' => $bk_number_related_remain, 
                                        'category' => $bk_all_cats, 
                                        'post__not_in' => $excludeid, 
                                        'post_status' => 'publish', 
                                        'orderby' => 'rand'  );
            $bk_relate_categories = get_posts( $bk_related_args );

            if(sizeof($bk_relate_categories) > 0){
                foreach ( $bk_relate_categories as $bk_relate_category ) {
                    array_push($bk_related_posts, $bk_relate_category);
                }
            }
        }
        if ( $bk_related_posts != NULL ) {?>
            
            <div class="bk-related-posts">
                <ul class="related-posts row clearfix">
                <?php                                                        
                foreach ( $bk_related_posts as $key => $post ) { //setup global post
                    if($key > ($bk_number_related - 1))
                        break;                                   
                    setup_postdata($post);?>
                    <li class="item content-in <?php if($bk_number_related == 3) {echo 'col-md-4';}else {echo 'col-md-6';}?>">
                        <?php get_template_part( 'templates/bk_windows' );?>
                    </li>
                    <?php }?> 
                </ul>
            </div>
        <?php wp_reset_postdata();    
        }    
    }
}
/**
 * ************* Comments  *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_comments') ) {
    function bk_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="comment-article  media">
                <header class="comment-author clear-fix">
                    <div class="comment-avatar">
                        <!-- custom gravatar call -->
                        <?php echo get_avatar( get_comment_author_email(), 60 ); ?>  
                    </div>
                        <?php printf('<span class="comment-author-name">%s</span>', get_comment_author_link()) ?>
    					          <span class="comment-time" datetime="<?php comment_time('c'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" class="comment-timestamp"><?php comment_time(__('j F, Y \a\t H:i', 'bkninja')); ?> </a></span>
                        <span class="comment-links">
                            <?php
                                edit_comment_link(__('Edit', 'bkninja'),'  ','');
                                comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
                            ?>
                        </span>
                    </header><!-- .comment-meta -->
                
                <div class="comment-text">
                    				
    				<?php if ($comment->comment_approved == '0') : ?>
    				<div class="alert info">
    					<p><?php _e('Your comment is awaiting moderation.', 'bkninja') ?></p>
    				</div>
    				<?php endif; ?>
    				<section class="comment-content">
    					<?php comment_text() ?>
    				</section>
                </div>
			</article>
		<!-- </li> is added by WordPress automatically -->
		<?php
    }
}
/**
* ************* Author Page.*****************
*---------------------------------------------------
*/ 
if ( ! function_exists( 'bk_contact_data' ) ) {  
    function bk_contact_data($contactmethods) {
    
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['publicemail'] = 'Public Email';
        $contactmethods['author'] = 'Author URL';
        $contactmethods['twitter'] = 'Twitter Username';
        $contactmethods['facebook'] = 'Facebook URL';
        $contactmethods['youtube'] = 'Youtube Username';
        $contactmethods['googleplus'] = 'Google+ (Entire URL)';
         
        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'bk_contact_data');

/**
* ************* Author box *****************
*---------------------------------------------------
*/
if ( ! function_exists( 'bk_author_details' ) ) {  
    function bk_author_details($bk_author_id, $bk_desc = true) {
        
        $bk_author_email = get_the_author_meta('publicemail', $bk_author_id);
        $bk_author_url = get_the_author_meta('author', $bk_author_id);
        $bk_author_name = get_the_author_meta('display_name', $bk_author_id);
        $bk_author_tw = get_the_author_meta('twitter', $bk_author_id);
        $bk_author_go = get_the_author_meta('googleplus', $bk_author_id);
        $bk_author_fb = get_the_author_meta('facebook', $bk_author_id);
        $bk_author_yo = get_the_author_meta('youtube', $bk_author_id);
        $bk_author_www = get_the_author_meta('url', $bk_author_id);
        $bk_author_desc = get_the_author_meta('description', $bk_author_id);
        $bk_author_posts = count_user_posts( $bk_author_id ); 
    
        $bk_author_output = NULL;
        $bk_author_output .= '<div class="bk-author-box clearfix"><div class="bk-author-avatar"><a href="'.get_author_posts_url($bk_author_id).'">'. get_avatar($bk_author_id, '75').'</a></div><div class="author-info"><h3><a href="'.get_author_posts_url($bk_author_id).'">'.$bk_author_name.'</a></h3>';
                            
        if (($bk_author_desc != NULL) && ($bk_desc == true)) { $bk_author_output .= '<p class="bk-author-bio">'. $bk_author_desc .'</p>'; }                    
        if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_tw != NULL) || ($bk_author_go != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {$bk_author_output .= '<div class="bk-author-page-contact">';}
        if ($bk_author_email != NULL) { $bk_author_output .= '<a class="bk-tipper-bottom" data-title="Email" href="mailto:'. $bk_author_email.'"><i class="fa fa-envelope " title="'.__('Email', 'bkninja').'"></i></a>'; } 
        if ($bk_author_www != NULL) { $bk_author_output .= ' <a class="bk-tipper-bottom" data-title="'.$bk_author_name.'" href="'. $bk_author_url .'" target="_blank"><i class="fa fa-user " title="'.__('Author URL', 'bkninja').'"></i></a> '; }
        if ($bk_author_www != NULL) { $bk_author_output .= ' <a class="bk-tipper-bottom" data-title="Website" href="'. $bk_author_www .'" target="_blank"><i class="fa fa-globe " title="'.__('Website', 'bkninja').'"></i></a> '; } 
        if ($bk_author_tw != NULL) { $bk_author_output .= ' <a class="bk-tipper-bottom" data-title="Twitter" href="//www.twitter.com/'. $bk_author_tw.'" target="_blank" ><i class="fa fa-twitter " title="Twitter"></i></a>'; } 
        if ($bk_author_go != NULL) { $bk_author_output .= ' <a class="bk-tipper-bottom" data-title="Google Plus" href="'. $bk_author_go .'" rel="publisher" target="_blank"><i title="Google+" class="fa fa-google-plus " ></i></a>'; }
        if ($bk_author_fb != NULL) { $bk_author_output .= ' <a class="bk-tipper-bottom" data-title="Facebook" href="'.$bk_author_fb. '" target="_blank" ><i class="fa fa-facebook " title="Facebook"></i></a>'; }
        if ($bk_author_yo != NULL) { $bk_author_output .= ' <a class="bk-tipper-bottom" data-title="Youtube" href="http://www.youtube.com/user/'.$bk_author_yo. '" target="_blank" ><i class="fa fa-youtube " title="Youtube"></i></a>'; }
        if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_go != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {$bk_author_output .= '</div>';}                          
        
        $bk_author_output .= '</div></div> <!-- close author-infor-->';
             
        return $bk_author_output;
    }
}
/**
 * ************* Social Share Box *****************
 *---------------------------------------------------
 */  

if ( ! function_exists( 'bk_share_box' ) ) {        
    function bk_share_box($social_share, $post_id) {
        $titleget = get_the_title($post_id);
        ?>
        <ul class="social-share">
            <?php if ($social_share['fb']): ?>
                <li><a class="bk-share bk_facebook_share bk-tipper-bottom" data-title="Facebook" onClick="window.open('http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink($post_id));?>','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink($post_id));?>"><i class="fa fa-facebook " title="Facebook"></i></a></li>
            <?php endif; ?>
            <?php if ($social_share['tw']): ?>
                <li><a class="bk-share bk_twitter_share bk-tipper-bottom" data-title="Twitter" onClick="window.open('http://twitter.com/share?url=<?php echo urlencode(get_permalink($post_id));?>&amp;text=<?php echo str_replace(" ", "%20", esc_attr($titleget)); ?>','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://twitter.com/share?url=<?php echo urlencode(get_permalink($post_id));?>&amp;text=<?php echo str_replace(" ", "%20", esc_attr($titleget)); ?>"><i class="fa fa-twitter " title="Twitter"></i></a></li>
            <?php endif; ?>
            <?php if ($social_share['gp']): ?>
                <li><a class="bk-share bk_google_share bk-tipper-bottom" data-title="Google" onClick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($post_id));?>','Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink($post_id));?>"><i class="fa fa-google-plus " title="Google Plus"></i></a></li>
            <?php endif; ?>
            <?php if ($social_share['pi']): ?>
                <li><a class="bk-share bk_pinterest_share bk-tipper-bottom" data-title="Pinterest" href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'><i class="fa fa-pinterest " title="Pinterest"></i></a></li>
            <?php endif; ?>
            <?php if ($social_share['tbl']): 
                $str = urlencode(get_permalink($post_id));
                $str = preg_replace('#^https?://#', '', $str);
            ?>
                <li><a class="bk-share bk_tumblr_share bk-tipper-bottom" data-title="Tumblr" onClick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($post_id));?>&amp;name=<?php echo str_replace(" ", "%20", esc_attr($titleget)); ?>','Tumblr','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://www.tumblr.com/share/link?url=<?php echo esc_url($str); ?>&amp;name=<?php echo str_replace(" ", "%20", esc_attr($titleget)); ?>"><i class="fa fa-tumblr " title="Tumblr"></i></a></li>
            <?php endif; ?>
            <?php if ($social_share['li']): ?>
                <li><a class="bk-share bk_linkedin_share bk-tipper-bottom" data-title="Linkedin" onClick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($post_id));?>','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($post_id));?>"><i class="fa fa-linkedin " title="Linkedin"></i></a></li>
            <?php endif; ?>                        
        </ul>
     <?php   
    }
}
/**
 * wp_get_attachment
 * -------------------------------------------------
 */
if ( ! function_exists( 'wp_get_attachment' ) ) {
    function wp_get_attachment( $attachment_id ) {
    
        $attachment = get_post( $attachment_id );
        return array(
        	'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        	'caption' => $attachment->post_excerpt,
        	'description' => $attachment->post_content,
        	'href' => get_permalink( $attachment->ID ),
        	'src' => $attachment->guid,
        	'title' => $attachment->post_title
        );
    }
}
/**
 * ************* Display Post format *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_post_format_display' ) ) { 
    function bk_post_format_display($postID, $feature_image_position) { 
        global $bk_option;
        $bk_title_position = get_post_meta($postID,'bk_post_title_position',true);
        $single_img = $bk_option['bk-single-featimg'];
        $page_fw = get_post_meta($postID,'bk_post_fullwidth_checkbox',true);
        $feature_image_parallax = get_post_meta($postID,'bk_parallax',true);
        if(function_exists('has_post_format') && ( get_post_format( $postID ) == 'video')){
            $bk_url = get_post_meta($postID, 'bk_media_embed_code_post', true);
            $bk_parse_url = parse_url($bk_url);?>
            <div class="video-wrap <?php if (($page_fw == '1') || ($feature_image_position == 'fullwidth')){echo 'col-md-12';} if($bk_title_position == 'below') {echo ' bk-embed-below';}?>">
            <?php
            if (($bk_parse_url['host'] == 'www.youtube.com')||($bk_parse_url['host'] == 'youtube.com')) { 
                $yt_id = parse_youtube($bk_url);?>            
                <div class='bk-embed-video'>
                    <iframe width="1050" height="591" src="http://www.youtube.com/embed/<?php echo $yt_id;?>" allowFullScreen ></iframe>
                </div>
            <?php
            }
            else if (($bk_parse_url['host'] == 'www.vimeo.com')||($bk_parse_url['host'] == 'vimeo.com')) {
                $bk_vimeo_id = parse_vimeo($bk_url);?>
                <div class='bk-embed-video'>                
                    <iframe src="//player.vimeo.com/video/<?php echo $bk_vimeo_id;?>?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff"></iframe>
                </div>
            <?php                                    
            }
            else {
                _e('The theme does not support this video type, please try with youtube or vimeo video', 'bkninja');
            }?> 
            </div>
            
           <?php  
        }
        else if(function_exists('has_post_format') && (has_post_format('audio'))) {
            $bk_url = get_post_meta($postID, 'bk_media_embed_code_post', true);
            $bk_parse_url = parse_url($bk_url);
            if (($bk_parse_url['host'] == 'www.soundcloud.com')||($bk_parse_url['host'] == 'soundcloud.com')) { ?>
                <div class='bk-embed-audio <?php if (($page_fw == '1') || ($feature_image_position == 'fullwidth')){echo 'col-md-12';} if($bk_title_position == 'below') {echo ' bk-embed-below';}?>'>
                    <?php echo wp_oembed_get( $bk_url );?>
                </div>
            <?php
            }
            else {
                _e('The theme does not support this audio type, please try with soundcloud', 'bkninja');
            } 
        }
        else if( function_exists('has_post_format') && has_post_format( 'gallery') ) {
            $gallery_images = rwmb_meta( 'bk_gallery_content', $args = array('type' => 'image'), $postID );?>
            <?php 
                $array_length = count($gallery_images); 
                if ($array_length == 0) {
                    return null;
                }
            ?>
            <div class="gallery-wrap <?php if (($page_fw == '1') || ($feature_image_position == 'fullwidth')){echo 'col-md-12';} if($bk_title_position == 'below') {echo ' bk-gallery-below';}?>">
                <div id="bk-gallery-slider" class="flexslider">
                    <ul class="slides">
                        <?php 
                        	foreach ( $gallery_images as $image ){
                                $thumb_url = wp_get_attachment_image_src($image['ID'], true);
                                $attachment_data =  wp_get_attachment( $image['ID'] );
                        ?>
                            <li>
                                <?php echo "<a class='img-popup-link cursor-zoom' href='{$image['full_url']}' title='{$image['title']}'><img src='{$thumb_url[0]}' alt='{$image['alt']}' /></a>"; ?>
                                <?php if (strlen($attachment_data['caption']) > 0) {?>
                                    <div class="caption"><?php echo ($attachment_data['caption']);?></div>
                                <?php }?>
                            </li>
                        <?php } ?>       								    
                    </ul>
        		</div>
        		<div id="bk-carousel-gallery-thumb" class="flexslider">
                    <ul class="slides">
                        <?php 
                        	foreach ( $gallery_images as $image ){
                                $thumb_url = wp_get_attachment_image_src($image['ID'], 'bk400_300', true);
                        ?>
                            <li>
                                <?php echo "<a href='{$image['full_url']}' title='{$image['title']}'><img src='{$thumb_url[0]}' alt='{$image['alt']}' /></a>"; ?>
                            </li>
                        <?php } ?>       								    
                    </ul>
        		</div>
            </div>
            <?php
        }
        else if( function_exists('has_post_format') && has_post_format( 'image') ) {?>
            <div class="thumb-wrap <?php if((($page_fw == '1') || ($feature_image_position == 'fullwidth'))){if ($bk_title_position == 'below') {echo 'bk-fw-b';}else {echo 'bk-fw-a';}}?> <?php if ($feature_image_position == 'fullwidth'){echo 'col-md-12';}?>">
                    <?php 
                    $attachment_id = get_post_meta($postID, 'bk_image_upload', true );
                    $bkThumbUrl = wp_get_attachment_image_src($attachment_id, 'full', true);
                    if ((($page_fw == '1') || ($feature_image_position == 'fullwidth')) && ($feature_image_parallax == 'enable')){
                        if ( has_post_thumbnail() ) {
                            echo '<div class="thumb thumb-parallax">';
                            echo '<div class="feat-img-parallax" data-type="background" style="background-image: url('.$bkThumbUrl[0].')"></div></div><!-- End Thumb parallax -->';
                        }
                    }else {
                        echo '<div class="thumb">';
                        echo "<img src='{$bkThumbUrl[0]}' alt='Image' />";
                        echo '</div>';
                    }?>
            </div>        
        <?php }
        else { ?>
            <?php if (($single_img) && (has_post_thumbnail())){?>
            <div class="thumb-wrap <?php if(!has_post_format() && (($page_fw == '1') || ($feature_image_position == 'fullwidth'))){if ($bk_title_position == 'below') {echo 'bk-fw-b';}else {echo 'bk-fw-a';}}?> <?php if ($feature_image_position == 'fullwidth'){echo 'col-md-12';}?>">
                
                    <?php if ((($page_fw == '1') || ($feature_image_position == 'fullwidth')) && ($feature_image_parallax == 'enable')){
                        if ( has_post_thumbnail() ) {
                            echo '<div class="thumb thumb-parallax">';
                            $bkThumbId = get_post_thumbnail_id( $postID );
                            $bkThumbUrl = wp_get_attachment_image_src( $bkThumbId, 'full', true );
                            echo '<div class="feat-img-parallax" data-type="background" style="background-image: url('.$bkThumbUrl[0].')"></div></div><!-- End Thumb parallax -->';
                        }
                    }else {
                        echo '<div class="thumb">';
                        echo get_the_post_thumbnail($postID, 'bk1000_600');
                        echo '</div>';
                    }?>
            </div>
            <?php }?>
        <?php
        }
    }
}
/**
* ************* Display post review box ********
*---------------------------------------------------
*/
if ( ! function_exists( 'bk_post_review_boxes' ) ) {  
     function bk_post_review_boxes($bk_post_id){
        global $bk_option;
            if (isset($bk_option)){
                $primary_color = $bk_option['bk-primary-color'];
            }
        $bk_custom_fields = get_post_custom();
        $bk_review_checkbox = get_post_meta($bk_post_id, 'bk_review_checkbox', true );
        $bk_user_rating = get_post_meta($bk_post_id, 'bk_user_rating', true );

        if ( $bk_review_checkbox == '1' ) {
             $bk_review_checkbox = 'on'; 
        } else {
             $bk_review_checkbox = 'off';
        }
        if ($bk_review_checkbox == 'on') {
            $bk_summary = get_post_meta($bk_post_id, 'bk_summary', true );                
            $bk_final_score = get_post_meta($bk_post_id, 'bk_final_score', true );        
            
            if ( isset ( $bk_custom_fields['bk_ct1'][0] ) ) { $bk_rating_1_title = $bk_custom_fields['bk_ct1'][0]; }
            if ( isset ( $bk_custom_fields['bk_cs1'][0] ) ) { $bk_rating_1_score = $bk_custom_fields['bk_cs1'][0]; }
            if ( isset ( $bk_custom_fields['bk_ct2'][0] ) ) { $bk_rating_2_title = $bk_custom_fields['bk_ct2'][0]; }
            if ( isset ( $bk_custom_fields['bk_cs2'][0] ) ) { $bk_rating_2_score = $bk_custom_fields['bk_cs2'][0]; }
            if ( isset ( $bk_custom_fields['bk_ct3'][0] ) ) { $bk_rating_3_title = $bk_custom_fields['bk_ct3'][0]; }
            if ( isset ( $bk_custom_fields['bk_cs3'][0] ) ) { $bk_rating_3_score = $bk_custom_fields['bk_cs3'][0]; }
            if ( isset ( $bk_custom_fields['bk_ct4'][0] ) ) { $bk_rating_4_title = $bk_custom_fields['bk_ct4'][0]; }
            if ( isset ( $bk_custom_fields['bk_cs4'][0] ) ) { $bk_rating_4_score = $bk_custom_fields['bk_cs4'][0]; }
            if ( isset ( $bk_custom_fields['bk_ct5'][0] ) ) { $bk_rating_5_title = $bk_custom_fields['bk_ct5'][0]; }
            if ( isset ( $bk_custom_fields['bk_cs5'][0] ) ) { $bk_rating_5_score = $bk_custom_fields['bk_cs5'][0]; }
            if ( isset ( $bk_custom_fields['bk_ct6'][0] ) ) { $bk_rating_6_title = $bk_custom_fields['bk_ct6'][0]; }
            if ( isset ( $bk_custom_fields['bk_cs6'][0] ) ) { $bk_rating_6_score = $bk_custom_fields['bk_cs6'][0]; }
            
            $bk_review_final_score = floatval($bk_final_score);
            
            $bk_ratings = array();  
            
            $bk_best_rating = '10';
            for( $i = 1; $i < 7; $i++ ) {
                 if ( isset(${"bk_rating_".$i."_score"}) ) { $bk_ratings[] =  ${"bk_rating_".$i."_score"};}
            }
            $bk_review_ret = '<div class="bk-review-box clear-fix"><div class="bk-detail-rating clear-fix">'; 
            for( $j = 1; $j < 7; $j++ ) {
                
                 $k = ($j - 1);
            
                 if ((isset(${"bk_rating_".$j."_title"})) && (isset(${"bk_rating_".$j."_score"})) ) {                       
                        $bk_review_ret .= '<span class="bk-criteria">'. ${"bk_rating_".$j."_title"}.'</span><span class="bk-criteria-score">'. $bk_ratings[$k].'</span>';                                     
                        $bk_review_ret .= '<div class="bk-bar clearfix"><span class="bk-overlay"><span class="bk-zero-trigger" style="width:'. ( ${"bk_rating_".$j."_score"}*10).'%"></span></span></div>';
                 }
            }
            $bk_review_ret .= '</div>';
            if ( $bk_summary != NULL ) { $bk_review_ret .= '<div class="bk-summary"><div id="bk-conclusion">'.$bk_summary.'</div></div>'; }                                    
                       
            $bk_review_ret .= '<div class="bk-score-box" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><meta itemprop="worstRating" content="1"><meta itemprop="bestRating" content="'. $bk_best_rating .'"><span class="score" itemprop="ratingValue">'.$bk_review_final_score.'</span></div></div><!-- /bk-review-box -->';
            
            if($bk_user_rating) {
                $bk_number_rates = get_post_meta($bk_post_id, "bk_rates", true);
                $bk_user_score = get_post_meta($bk_post_id, "bk_user_score_output", true); 
                if ($bk_number_rates == NULL) {$bk_number_rates = 0;}
                if ($bk_user_score == NULL) {$bk_user_score = 0;}
                $bk_average_score = '<div class="bk-criteria-score bk-average-score">'.  floatval($bk_user_score) .'</div>'; 
                if(isset($_COOKIE["bk_user_rating"])) { $bk_current_rates = $_COOKIE["bk_user_rating"]; } else { $bk_current_rates = NULL; }
                if(isset($_COOKIE["bk_score_rating"])) { $bk_current_score = $_COOKIE["bk_score_rating"]; } else { $bk_current_score = NULL; }
    
                if ( preg_match('/\b' .$bk_post_id . '\b/', $bk_current_rates) ) {
                     $bk_class = " bk-rated"; 
                     $bk_tip_class = ' bk-tipper-bottom'; 
                     $bk_tip_title = ' data-title="'. __('You have rated '.$bk_current_score.' points for this post', 'bkninja') .'"'; 
                } else {
                     $bk_class = $bk_tip_title = $bk_tip_class = NULL; 
                }
    
                if ( $bk_number_rates == '1' ) {
                    $bk_rate_str = __("Rate", "bkninja");
                }  else {
                    $bk_rate_str = __("Rates", "bkninja");
                }             
                $bk_review_ret .= '<div class="bk-bar bk-user-rating clearfix"><div id="bk-rate" class="bg '. $bk_class .'"><span class="bk-criteria">'. __("Reader Rating", "bkninja"). ': (<span>'. $bk_number_rates .'</span> '. $bk_rate_str .')</span>';
                
                $bk_review_ret .= $bk_average_score. '<span class="bk-overlay'. $bk_tip_class .'"'. $bk_tip_title .'><span style="width:'. $bk_user_score*10 .'%"></span></span></div></div>';
    
                 if ( function_exists('wp_nonce_field') ) { $bk_review_ret .= wp_nonce_field('rating_nonce', 'rating_nonce', true, false); } 
            }
            
            return $bk_review_ret;
        }
    }
}
/**
 * Get Post format Icon
 */
if ( ! function_exists( 'bk_get_post_icon' ) ) {
    function bk_get_post_icon($post_id) {
        $ret = '';
        if(function_exists('has_post_format') && (get_post_format( $post_id ) == 'image')) {
            $ret = '<i class="post-icon fa fa-camera-retro"></i>';
        }else if(function_exists('has_post_format') && ( get_post_format( $post_id ) == 'video')) {
            $ret = '<i class="post-icon fa fa-video-camera"></i> ';
        }else if(function_exists('has_post_format') && (get_post_format( $post_id ) == 'audio')) {
            $ret = '<i class="post-icon fa fa-volume-up"></i>';
        }else if(function_exists('has_post_format') && (get_post_format( $post_id ) == 'gallery')) {
            $ret = '<i class="post-icon fa fa-picture-o"></i>';
        }else {
            $ret = null;
        }
        return $ret;
    }   
}

if ( ! function_exists( 'bk_wpgallery_boxes' ) ) {  
     function bk_wpgallery_boxes($bk_post_id, $attachment_ids){
        global $justified_ids;
        $uid = rand();
        $justified_ids[]=$uid;
        wp_localize_script( 'customjs', 'justified_ids', $justified_ids );
        $ret = '';
        
        $ret .= '<div class="zoom-gallery justifiedgall_'.$uid.' justified-gallery" style="margin: 0px 0px 1.5em;">
					<div class="spinner"><span></span><span></span><span></span></div>';
						if ($attachment_ids) :					
						foreach ($attachment_ids as $id) :
							$attachment_url = wp_get_attachment_image_src( $id, 'full' );
                            $attachment = get_post($id);
							$caption = apply_filters('the_title', $attachment->post_excerpt);
					
					   $ret .= '<a class="zoomer" title="'.apply_filters('the_title', $attachment->post_excerpt).'" data-source="'.$attachment_url[0].'" href="'.$attachment_url[0].'">'.wp_get_attachment_image($attachment->ID, 'full').'</a>';

						endforeach;
						endif;
			$ret .= '</div>';
            return $ret;
     }
}

/*** Module Content ***/
/**
 * ************* ajax Grid Content *****************
 *---------------------------------------------------
 */ 
 if ( ! function_exists( 'bk_get_ajax_grid_content') ) {
    function bk_get_ajax_grid_content($the_query){ ?> 
        <?php while ( $the_query->have_posts() ): $the_query->the_post();?>	
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'bk684_452');?>
            <li>
                <div class="grid-background" style="background-image:url(<?php echo $thumb['0'];?>);background-size:cover;background-position:50% 50%;background-repeat:no-repeat;"></div>
                <div class="post-content post-element">
                    <h2 class="title">
                        <a href="<?php the_permalink();?>">
                    		<?php 
                    			$title = get_the_title();
                    			echo esc_attr($title);
                    		?>
                        </a>
                    </h2>
                    <div class="excerpt">
                        <?php 
                            $string = get_the_excerpt();
                            echo the_excerpt_limit($string, 20); 
                        ?>
                    </div>
                    <div class="meta-bottom">
                        <div class="meta-author">
                            <span class="avatar">
                                <i class="fa fa-user"></i>
                            </span>
                            <?php the_author_posts_link();?>           
                        </div>
                        <div class="post-date">
                            <span><i class="fa fa-clock-o"></i></span>
                            <?php echo get_the_date('M j, Y'); ?>
                        </div>
                        <?php if ( comments_open() ) : ?>
                    		<div class="meta-comment">
                    			<span><i class="fa fa-comments-o"></i></span>
                    			<?php comments_popup_link( __('0', 'bkninja'), __('1', 'bkninja'), __('%', 'bkninja')); ?>
                    		</div>		
                        <?php endif; ?> 
                    </div>
                </div>
            </li>
            <!-- break -->
        <?php endwhile;?>
    <?php
    }
}
 
/**
 * ************* Windows Content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_windows_content') ) {
    function bk_get_windows_content($the_query, $bk_layout){ ?> 
       <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li class="<?php if($bk_layout == 'three_cols'){echo 'col-md-4 col-sm-6';}else {echo 'col-sm-6';}?>">
                <div class="content-in post-element <?php echo $bk_layout;?>">
                    <?php get_template_part( 'templates/bk_windows' );?>
                 </div>
            </li>
        <?php endwhile;?>
    <?php
    }
}
/**
 * ************* 1l & 2 side m Content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_1l_2m_side_content') ) {
    function bk_get_1l_2m_side_content($the_query){ ?>
        <div class="col-sm-8 main-post">
           <?php foreach( range( 1, 1 ) as $i ):?>
                <?php $the_query->the_post(); ?>
                    <div class="content-out post-element co-type2">
                        <?php get_template_part( 'templates/post_485x300_type2' );?>
                    </div>
            <?php endforeach;?>
        </div>
        <?php if ($the_query->post_count > 1) {?>
            <div class="subpost col-sm-4">
                <ul class="subpost-list">
                    <?php foreach( range( 1, ($the_query->post_count - 1) ) as $i ):?>
                    <?php $the_query->the_post(); ?>
                        <li class="item content-out co-type1 post-element clearfix">
                            <?php get_template_part( 'templates/post_230x140_type4' );?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php }?>
    <?php
    }
}
/**
 * ************* Row Content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_row_content') ) {
    function bk_get_row_content($the_query, $bk_layout){ ?>
        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li class="<?php if($bk_layout == 'three_cols'){echo 'col-md-4 col-sm-6';}else {echo 'col-sm-6';}?>">
				<div class="item content-out co-type1 post-element">
                    <?php get_template_part( 'templates/post_485x300_row' );?>
                </div>
            </li>
        <?php endwhile;?>
    <?php
    }
}
/**
 * ************* Blog small Content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_blog_small_content') ) {
    function bk_get_blog_small_content($the_query){ ?>
        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li class="col-md-12">
                <div class="item content-out co-type3 post-element clearfix">
                    <?php get_template_part( 'templates/bk_blog_small' );?>
                </div>
            </li>
        <?php endwhile;?>
    <?php
    }
}
/**
 * ************* Blog small leftsec Content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_blog_small_leftsec_content') ) {
    function bk_get_blog_small_leftsec_content($the_query){ ?>
        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li class="col-md-12">
                <div class="item content-out co-type3 post-element clearfix">
                    <?php get_template_part( 'templates/bk_blog_small_leftsec' );?>
                </div>
            </li>
        <?php endwhile;?>
    <?php
    }
}
/**
 * ************* Large Blog Content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_large_blog_content') ) {
    function bk_get_large_blog_content($the_query){ ?>
        <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li class="col-md-12">
                <div class="item content-out co-type1 post-element clearfix">
                    <?php get_template_part( 'templates/large_blog' );?>
                </div>
            </li>
        <?php endwhile;?>
    <?php
    }
}
/**
 * *************  bk_get_1l_list_side_content *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_1l_list_side_content') ) {
    function bk_get_1l_list_side_content($the_query){ ?>
        <div class="col-sm-7 main-post">
           <?php foreach( range( 1, 1 ) as $i ):?>
                <?php $the_query->the_post(); ?>
                <?php $category = get_the_category(get_the_ID());?>
                    <div class="content-out post-element co-type1">
                        <div class="thumb <?php if (is_array($category)) { if(isset($category[0])) {echo "thumb-bg-".$category[0]->term_id;}}?>">
                            <?php 
                                if(has_post_thumbnail( get_the_ID() )) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'bk485_300');
                                }else {
                                    echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                                }
                                echo bk_get_post_icon(get_the_ID());
                            ?>
                        </div>
                        <div class="meta-top">
                            <?php echo bk_get_category_link(get_the_ID());?>
                            <?php echo bk_review_score(get_the_ID());?>
                        </div>
                        <h4 class="title">
                            <a href="<?php the_permalink();?>">
                        		<?php 
                        			$title = get_the_title();
                        			echo esc_attr($title);
                                    //echo the_excerpt_limit($title, 15);
                        		?>
                            </a>
                        </h4>
                        <div class="excerpt">
                        <?php 
                            $string = get_the_excerpt();
                            echo the_excerpt_limit($string, 30); 
                        ?>
                        </div>
                        <div class="meta-bottom">
                            <div class="post-date">
                                <span><i class="fa fa-clock-o"></i></span>
                              <?php echo get_the_date('M j, Y'); ?>
                            </div>
                        </div>
                    </div>
            <?php endforeach;?>
        </div>
        <?php if ($the_query->post_count > 1) {?>
            <div class="subpost col-sm-5">
                <ul class="subpost-list">
                    <?php foreach( range( 1, ($the_query->post_count - 1) ) as $i ):?>
                    <?php $the_query->the_post(); ?>
                        <li class="item content-out post-element clearfix">
                            <h4 class="title">
                                <a href="<?php the_permalink();?>">
                            		<?php 
                            			$title = get_the_title();
                            		    echo esc_attr($title);
                            		?>
                                </a>
                            </h4>
                            <div class="excerpt">
                            <?php 
                                $string = get_the_excerpt();
                                echo the_excerpt_limit($string, 9); 
                            ?>
                            </div>
                            <div class="meta-bottom">
                                <div class="meta-author">
                                    <span class="avatar">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <?php the_author_posts_link();?>           
                                </div>
                                <div class="post-date">
                                    <span><i class="fa fa-clock-o"></i></span>
                                    <?php echo get_the_date('M j, Y'); ?>
                                </div>
                                <?php if ( comments_open() ) : ?>
                                	<div class="meta-comment">
                                		<span><i class="fa fa-comments-o"></i></span>
                                		<?php comments_popup_link( __('0', 'bkninja'), __('1', 'bkninja'), __('%', 'bkninja')); ?>
                                	</div>		
                                <?php endif; ?> 
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php }?>
    <?php
    }
}
/**
 * *************  bk_get_block_one a half *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_block_one') ) {
    function bk_get_block_one($the_query){ ?>
        <div class="main-post">
           <?php foreach( range( 1, 1 ) as $i ):?>
                <?php $the_query->the_post(); ?>
                <?php $category = get_the_category(get_the_ID());?>
                <div class="content-out co-type1 post-element">
                    <?php get_template_part( 'templates/post_485x300_row' );?>
                </div>
            <?php endforeach;?>
        </div>
        <?php if ($the_query->post_count > 1) {?>
            <div class="subpost">
                <ul class="list post-list row">
                    <?php foreach( range( 1, ($the_query->post_count - 1) ) as $i ):?>
                    <?php $the_query->the_post(); ?>
                        <li class="item content-out co-type3 col-md-12 clearfix">
                            <?php get_template_part( 'templates/post_widget_style1' );?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php }?>
    <?php
    }
}
/**
 * ************* Pagination *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_paginate') ) {
    function bk_paginate(){  
        global $wp_query, $wp_rewrite, $bk_option; 
        if ( $wp_query->max_num_pages > 1 ) : ?>
        <div id="pagination" class="clear-fix">
        	<?php
        		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
                if($bk_option['bk-rtl-sw']) {
                    $pagination = array(
            			'base' => @add_query_arg( 'paged','%#%' ),
            			'format' => '',
            			'total' => $wp_query->max_num_pages,
            			'current' => $current,
            			'prev_text' => __( '&rightarrow;', 'bkninja' ),
            			'next_text' => __( '&leftarrow;', 'bkninja' ),
            			'type' => 'plain'
            		); 
                }else {
            		$pagination = array(
            			'base' => @add_query_arg( 'paged','%#%' ),
            			'format' => '',
            			'total' => $wp_query->max_num_pages,
            			'current' => $current,
            			'prev_text' => __( '&leftarrow;', 'bkninja' ),
            			'next_text' => __( '&rightarrow;', 'bkninja' ),
            			'type' => 'plain'
            		);
                }
        		
        		if( $wp_rewrite->using_permalinks() )
        			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
        
        		if( !empty( $wp_query->query_vars['s'] ) )
        			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
        
        		echo paginate_links( $pagination );

        	?>
        </div>
<?php
    endif;
    }
}


/**
 * ************* bk_get_module_title *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_get_module_title') ) {
    function bk_get_module_title($page_id, $module_prefix){  
        global $bk_option;
        if ( isset($bk_option)):
            $primary_color = $bk_option['bk-primary-color'];
            $category_color_settings = $bk_option['bk-category-color-select'];
        endif;    
        $title = esc_attr(get_post_meta( $page_id, $module_prefix.'_title', true ));
        $sub_title = esc_attr(get_post_meta( $page_id, $module_prefix.'_sub_title', true )); 
        $cat_opt = get_option('bk_cat_opt');
        $category = get_post_meta( $page_id, $module_prefix.'_category', true );
        if(strlen($title)!=0) {?>
            <div class="module-title title-cat-<?php echo $category;?>">
				<h3 class="main-title"><span><?php echo esc_attr($title); ?></span></h3> 
                <?php if(strlen($sub_title)!=0) {?>
                <h4 class="sub-title"><?php echo esc_attr($sub_title); ?></h4>
                <?php }?>
			</div>
        <?php }
    }
}

/* Convert hexdec color string to rgb(a) string */

function hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default; 

	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}
if ( ! function_exists( 'bk_wpgallery_boxes' ) ) {  
     function bk_wpgallery_boxes($bk_post_id, $attachment_ids){
        global $justified_ids;
        $uid = rand();
        $justified_ids[]=$uid;
        wp_localize_script( 'customjs', 'justified_ids', $justified_ids );
        $ret = '';
        
        $ret .= '<div class="zoom-gallery justifiedgall_'.$uid.' justified-gallery" style="margin: 0px 0px 1.5em;">';
						if ($attachment_ids) :					
						foreach ($attachment_ids as $id) :
							$attachment_url = wp_get_attachment_image_src( $id, 'full' );
                            $attachment = get_post($id);
							$caption = apply_filters('the_title', $attachment->post_excerpt);
					
					   $ret .= '<a class="zoomer" title="'.apply_filters('the_title', $attachment->post_excerpt).'" data-source="'.$attachment_url[0].'" href="'.$attachment_url[0].'">'.wp_get_attachment_image($attachment->ID, 'full').'</a>';

						endforeach;
						endif;
			$ret .= '</div>';
            return $ret;
     }
}

if ( ! function_exists( 'bk_single_content') ) {
    function bk_single_content($postID){
        $the_content = apply_filters( 'the_content', get_the_content($postID) );
        $the_content = str_replace( ']]>', ']]&gt;', $the_content );

        $post_content_str = get_the_content($postID);
        $gallery_flag = 0;
        $i = 0;
        $ids = null;
        for ($i=0; $i < 10; $i++) {
            preg_match('/<style(.+(\n))+.*?<\/div>/', $the_content, $match);
                
            preg_match('/\[gallery.*ids=.(.*).\]/', $post_content_str, $ids);             
            
            if ($ids != null) {
                $the_content = str_replace($match[0], $ids[0] ,$the_content);          
                   
                $attachment_ids = explode(",", $ids[1]);
                $post_content_str = str_replace($ids[0], bk_wpgallery_boxes ($postID, $attachment_ids),$post_content_str);
                $the_content = str_replace($ids[0], bk_wpgallery_boxes ($postID, $attachment_ids),$the_content);
                $gallery_flag = 1;
            }
        }
        if($gallery_flag == 1) {
            echo ($the_content);
        }else {
            echo the_content($postID);
        }
    }
}

add_action('wp_footer', 'bk_user_rating');

// User Rating System
if ( ! function_exists( 'bk_user_rating' ) ) {
    function bk_user_rating() {
        if (is_single()) {
            global $wp_query;
            global $bk_option;
            $post = $wp_query->post;
            $bk_review_checkbox = get_post_meta( $post->ID, 'bk_review_checkbox', true );
            if ($bk_review_checkbox == 1) {
                $rtl = $bk_option['bk-rtl-sw'];
                $user_rating_script = "";            
                $user_rating_script.= " <script type='text/javascript'>
                var bkExistingOverlay=0, bkWidthDivider = 1, old_val=0, new_val=1;
                old_val = jQuery('#bk-rate').find('.bk-overlay').width();
                jQuery(window).resize(function(){
                    x = jQuery('#bk-rate').find('.bk-overlay').find('span').width();
                    y = jQuery('#bk-rate').find('.bk-overlay').width();
                    new_val = y;
                    //console.log(x);
                    //console.log(y);
                    //console.log(new_val);
                    //console.log(old_val);
                    if (new_val != old_val) {
                        bkExistingOverlay = ((x/old_val)*y).toFixed(0)+'px';
                        old_val = new_val;
                    }
                    bkWidthDivider = jQuery('#bk-rate').width() / 100;
                    //console.log(bkExistingOverlay);
                    jQuery('#bk-rate').find('.bk-overlay').find('span').css( {'width': bkExistingOverlay} );
                });
                (function ($) {'use strict';
                    var bkRate = $('#bk-rate'), 
                        bkCriteriaAverage = $('.bk-criteria-score.bk-average-score'),
                        bkRateCriteria = bkRate.find('.bk-criteria'),
                        bkRateOverlay = bkRate.find('.bk-overlay');
                            
                        var bkExistingOverlaySpan = bkRateOverlay.find('span'),
                            bkNotRated = bkRate.not('.bk-rated').find('.bk-overlay');
                            
                        bkExistingOverlay = bkExistingOverlaySpan.css('width');
                        bkExistingOverlaySpan.addClass('bk-zero-trigger');
                        
                    var bkExistingScore =  $(bkCriteriaAverage).text(),
                        bkExistingRateLine = $(bkRateCriteria).html(),
                        bkRateAmount  = $(bkRate).find('.bk-criteria span').text();
                        bkWidthDivider = ($(bkRate).width() / 100);
                        
                    if ( typeof bkExistingRateLine !== 'undefined' ) {
                        var bkExistingRatedLine = bkExistingRateLine.substr(0, bkExistingRateLine.length-1) + ')'; 
                    }
                    var bk_newRateAmount = parseInt(bkRateAmount) + 1;
                    if ( (bkRateAmount) === '0' ) {
                        var bkRatedLineChanged = '". __('Reader Rating', 'bkninja') .": (' + (bk_newRateAmount) + ' ". __('Rate', 'bkninja') .")';
                    } else {
                        var bkRatedLineChanged = '". __('Reader Rating', 'bkninja') .": (' + (bk_newRateAmount) + ' ". __('Rates', 'bkninja') .")';      
                    }
    
                    if (bkRate.hasClass('bk-rated')) {
                        bkRate.find('.bk-criteria').html(bkExistingRatedLine); 
                    }
    
                    bkNotRated.on('mousemove click mouseleave mouseenter', function(e) {
                        var bkParentOffset = $(this).parent().offset();  
                        ";
                        if($bk_option['bk-rtl-sw']) {
                            $user_rating_script.= "
                            var bkBaseX =  100 - (Math.ceil((e.pageX - bkParentOffset.left) / bkWidthDivider));";
                        }else {
                            $user_rating_script.= "
                            var bkBaseX = Math.ceil((e.pageX - bkParentOffset.left) / bkWidthDivider);";
                        }
                        $user_rating_script.= "
                        var bkFinalX = (bkBaseX / 10).toFixed(1);
                        bkCriteriaAverage.text(bkFinalX);
                        
                        bkExistingOverlaySpan.css( 'width', (bkBaseX +'%') );
     
                        if ( e.type == 'mouseleave' ) {
                            bkExistingOverlaySpan.animate( {'width': bkExistingOverlay}, 300); 
                            bkCriteriaAverage.text(bkExistingScore); 
                        }
                        
                        if ( e.type == 'click' ) {
                                var bkFinalX = bkFinalX;
                                console.log(bkRatedLineChanged);
                                bkRateCriteria.fadeOut(550, function () {  $(this).fadeIn(550).html(bkRatedLineChanged);  });
                                var bkParentOffset = $(this).parent().offset(),
                                    nonce = $('input#rating_nonce').val(),
                                    bk_data_rates = { 
                                            action  : 'bk_rate_counter', 
                                            nonce   : nonce, 
                                            postid  : '". $post->ID ."' 
                                    },
                                    bk_data_score = { 
                                            action: 'bk_add_user_score', 
                                            nonce: nonce, 
                                            bkCurrentRates: bkRateAmount, 
                                            bkNewScore: bkFinalX, 
                                            postid: '". $post->ID ."' 
                                    };
                                
                                bkRateOverlay.off('mousemove click mouseleave mouseenter'); 
                                        
                                $.post('". admin_url('admin-ajax.php'). "', bk_data_rates, function(bk_rates) {
                                    if ( bk_rates !== '-1' ) {
                                        
                                        var bk_checker = cookie.get('bk_user_rating'); 
                                       
                                        if (!bk_checker) {
                                            var bk_rating_c = '" . $post->ID . "';
                                        } else {
                                            var bk_rating_c = bk_checker + '," . $post->ID . "';
                                        }
                                       cookie.set('bk_user_rating', bk_rating_c, { expires: 1, }); 
                                    } 
                                });
                                        
                                $.post('". admin_url('admin-ajax.php') ."', bk_data_score, function(bk_score) {
                                        var res = bk_score.split(' ');
                                        if ( ( res[0] !== '-1' ) && ( res[0] !=='null' ) ) {
                                            
                                                var bkScoreOverlay = (res[0]*10);
                                                var latestScore = res[1];
                                                var bkScore_display = (parseFloat(res[0])).toFixed(1);
                                                var overlay_w = jQuery('#bk-rate').find('.bk-overlay').width();
                                                
                                                var bkScoreOverlay_px = (bkScoreOverlay*overlay_w)/100;
                                                
                                                old_val = overlay_w;
                                                
                                                bkCriteriaAverage.html( bkScore_display ); 
                                               
                                                bkExistingOverlaySpan.css( 'width', bkScoreOverlay_px +'px' );
                                                bkRate.addClass('bk-rated');
                                                bkRateOverlay.addClass('bk-tipper-bottom').attr('data-title', '". __('You have rated ', 'bkninja') . "' + latestScore + ' points for this post');
                                                bkRate.off('click');
                                        } 
                                });
                                cookie.set('bk_score_rating', bkFinalX, { expires: 1, }); 
                                
                                return false;
                       }
                    });
                })(jQuery);
                </script>";
                echo ($user_rating_script);
            }
        }
    }
}
if ( ! function_exists( 'bk_rate_counter' ) ) {
    function bk_rate_counter() {
        if ( ! wp_verify_nonce($_POST['nonce'], 'rating_nonce') ) { return; }
    
        $bk_post_id = $_POST['postid'];   
        $bk_current_rates = get_post_meta($bk_post_id, "bk_rates", true); 
        
        if ($bk_current_rates == NULL) {
             $bk_current_rates = 0; 
        }
        
        $bk_current_rates = intval($bk_current_rates);       
        $bk_new_rates = $bk_current_rates + 1;
        
        update_post_meta($bk_post_id, 'bk_rates', $bk_new_rates);
            
        die(0);
    }
}
add_action('wp_ajax_bk_rate_counter', 'bk_rate_counter');
add_action('wp_ajax_nopriv_bk_rate_counter', 'bk_rate_counter');
add_action('wp_ajax_bk_rate_counter', 'bk_rate_counter');
add_action('wp_ajax_nopriv_bk_rate_counter', 'bk_rate_counter');

if ( ! function_exists( 'bk_add_user_score' ) ) {
    function bk_add_user_score() {
        
        if ( ! wp_verify_nonce($_POST['nonce'], 'rating_nonce')) { return; }

        $bk_post_id = $_POST['postid'];
        $bk_latest_score = floatval($_POST['bkNewScore']);
        $bk_current_rates = floatval($_POST['bkCurrentRates']);   
        
        $current_score = get_post_meta($bk_post_id, "bk_user_score_output", true);    

        if ($bk_current_rates == NULL) {
            $bk_current_rates = 0; 
        }

        if ($bk_current_rates == 0) {
            $bk_new_score =  $bk_latest_score ;
        }
        
        if ($bk_current_rates == 1) {
            $bk_new_score = round(floatval(( $current_score + $bk_latest_score  ) / 2),1);
        }
        if ($bk_current_rates > 1) {
            $current_score_total = ($current_score * $bk_current_rates );
            $bk_new_score = round(floatval(($current_score_total + $bk_latest_score) / ($bk_current_rates + 1)),1) ;
        }

        update_post_meta($bk_post_id, 'bk_user_score_output', $bk_new_score);
        $score_return = array();
        $score_return['bk_new_score'] = $bk_new_score;
        $score_return['bk_latest_score'] = $bk_latest_score;                        
        echo implode(" ",$score_return);
        die(0);
    }
}
add_action('wp_ajax_bk_add_user_score', 'bk_add_user_score');
add_action('wp_ajax_nopriv_bk_add_user_score', 'bk_add_user_score');




if ( ! function_exists( 'bk_single_title_display' ) ) {
    function bk_single_title_display($bk_title_align, $feature_image_position, $review) {
        $page_fw = get_post_meta(get_the_ID(),'bk_post_fullwidth_checkbox',true);
        ?>
        <h3 class="main-title <?php echo $bk_title_align;?>  <?php if (($page_fw == '1') || ($feature_image_position == 'fullwidth')){echo 'col-md-12';}?>" <?php if ( $review == '1' ) { echo 'itemprop="itemReviewed"'; } else { echo 'itemprop="headline"'; }?>>
            <?php the_title(); ?>
        </h3>
        
        <div class="meta-bottom <?php echo $bk_title_align;?> <?php if (($page_fw == '1') || ($feature_image_position == 'fullwidth')){echo 'col-md-12';}?>">
            <div class="post-date">
                <span><?php _e('Post on', 'bkninja');?>: </span>
                <?php echo get_the_date('M j, Y'); ?>
            </div>   
            <div class="meta-author">
                <span class="avatar">
                    <i class="fa fa-user"></i>
                </span>
                <?php $author_display_name = get_the_author_meta( 'display_name' );
                global $post;
                        $bk_author_id = $post->post_author;
                printf('<span class="author" itemprop="author" >%s</span>', '<a rel="author" href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" title="'.sprintf(__('Posts by %s','bkninja'), $author_display_name).'">'.$author_display_name.'</a>') ?>          
            </div>  
            <?php if ( comments_open() ) : ?>
        		<div class="meta-comment">
        			<span><i class="fa fa-comments-o"></i></span>
        			<?php comments_popup_link( __('0', 'bkninja'), __('1', 'bkninja'), __('%', 'bkninja')); ?>
        		</div>		
            <?php endif; ?>             
        </div> 
    
    <?php }
}
if ( ! function_exists( 'bk_display_single_top' ) ) {
    function bk_display_single_top($postID, $social_share) {?>
        <div id="single-top">
            <div id="share-menu-btn">
                <div class="menu-toggle">
                    <span class="close-icon"><i class="fa fa-plus"></i></span>
                    <span class="open-icon hide"><i class="fa fa-minus"></i></span>
                </div>
                <span class="share-label"><?php _e('share', 'bkninja');?></span>
                <div class="top-share hide">
                <?php bk_share_box($social_share, $postID);?>
                </div>
            </div>
            <div class="tag-top">
                <?php 
                $category = bk_get_category_link($postID);
                if ($category): ?>
                    <div class="category">
                        <?php echo $category;?>
                    </div>
                <?php endif; ?>
                <?php echo bk_review_score(get_the_ID());?>
            </div>
        </div>
    <?php
    }
}

if ( ! function_exists( 'bk_title_and_feature_image_display' ) ) {
    function bk_title_and_feature_image_display($postID, $social_share, $bk_title_position, $bk_title_align, $feature_image_position) {
        $bk_review_checkbox = get_post_meta($postID,'bk_review_checkbox',true);
        $page_fw = get_post_meta($postID,'bk_post_fullwidth_checkbox',true);
        if ((($page_fw == '1') || ($feature_image_position == 'fullwidth')) && ($bk_title_position != 'below')){echo "<div class='col-md-12'>";}?>
         <?php if (($bk_title_position != 'below') || (($bk_title_position == 'below') && ($feature_image_position != 'fullwidth'))) {?>
            <?php bk_display_single_top($postID, $social_share);?>
        <?php }?>
        <?php if ((($page_fw == '1') || ($feature_image_position == 'fullwidth')) && ($bk_title_position != 'below')){echo "</div>";}?>
        <?php if ($bk_title_position != 'below') {?>
                <?php bk_single_title_display($bk_title_align, $feature_image_position, $bk_review_checkbox);?>
        <?php }?>
        <?php bk_post_format_display($postID, $feature_image_position);    
    }
}

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		echo '<meta property="og:image" content=""/>';
	}
	else{
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
	}
	echo "
";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

// Gets instagram data
function fetchData($url){
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_TIMEOUT, 20);
     $result = curl_exec($ch);
     curl_close($ch); 
     return $result;
}





















