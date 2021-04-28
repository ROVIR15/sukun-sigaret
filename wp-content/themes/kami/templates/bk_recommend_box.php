<?php 
/**
 * Random Posts Recommend Box. Appears in single.php
**/
global $bk_option;
?>

<div class="widget recommend-box">

    <a class="close" href="#" title="Close"><i class="fa fa-arrow-right"></i></a>
    <h3><?php echo esc_attr($bk_option['recommend-box-title']); ?></h3>
    
    <div class="entries">
    <?php
       $arg =  array(
            'post_type' => 'post',
            'post__not_in' => array( $post->ID ),
            'orderby' => 'rand',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 1
        );
        $bk_random_post = new WP_Query($arg);
        
        while ( $bk_random_post->have_posts() ) : $bk_random_post->the_post(); ?>
        
        <article>
            <?php if ( has_post_thumbnail() ) { ?>
        	<figure class="entry-image thumb">
                <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'bk485_300' );?>
                </a>
            </figure>
            <?php }?>
            
            <h4 class="entry-title">
            	<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
                </a>
            </h4>
            
            <div class="entry-summary">
                <?php 
                    $string = get_the_excerpt();
                    echo the_excerpt_limit($string, 25);  
                ?>
            </div>
        </article>
        
    <?php endwhile; ?>
    </div>
    
<?php wp_reset_query(); ?>
</div><!-- .recommend-box -->