<?php

/**
 * bbPress Forum Template 
 */

get_header();

?>
<div class="page-wrap container">
    <div class="row">
        <div id="page-content" class="<?php if (isset($bk_option['bk-forum-sidebar']) && ($bk_option['bk-forum-sidebar'] == 'on')){ echo 'col-md-8 col-sm-12 three-cols';}else { echo 'col-sm-12 four-cols'; }?>">
			<?php if (have_posts()) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( is_page() && ! is_front_page() || ( function_exists( 'bp_current_component' ) && bp_current_component() )  ) : ?>
                    <div class="page-title">
					   <h3 itemprop="name"><span><?php the_title(); ?></span></h3>
                    </div>
					<?php endif; ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
						<div class="post-content"><?php the_content(); ?></div>
					</article>
					
				<?php endwhile; ?>

			<?php else : ?>

				<h2><?php _e('Not Found', 'bkninja') ?></h2>

			<?php endif; ?>
		</div>
        <?php
            if (isset($bk_option['bk-forum-sidebar']) && ($bk_option['bk-forum-sidebar'] == 'on')) {?>
                <aside id="forum-sidebar" class="sidebar col-md-4 col-sm-12">
        			<?php get_sidebar(); ?>
        		</aside>
        <?php }?>                
    </div>
</div>
		
<?php get_footer(); ?>