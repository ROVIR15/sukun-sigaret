<?php get_header(); ?>
<div class="page-wrap container">
    <div class="row">
        <div id="page-content" class="col-sm-12">
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

                <?php
                    if (function_exists("bk_paginate")) {
                        bk_paginate();
                    }
                ?>  

			<?php else : ?>

				<h2><?php _e('Not Found', 'bkninja') ?></h2>

			<?php endif; ?>
		</div>
    </div>
</div>
		
<?php get_footer(); ?>