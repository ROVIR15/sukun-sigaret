<?php get_header(); ?>

<div class="row" style="display:none; clear: both; padding-top: 30px; background: url('<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(); ?>'); background-attachment: fixed; background-repeat: no-repeat; min-height: 200px; margin-top: 50px; background-position: top center">
</div>

<?php if (function_exists('z_taxonomy_image_url')) echo '<img src="'.z_taxonomy_image_url().'" alt="" class="img-responsive" />'; ?>

    <div class="maincontent page">
      <div class="container">
	      <div class="row">
	      	<div class="col-md-9 wow fadeIn">
			
				<p style="display: none;">
					<h1 style="display: none;" class="archive-title"><?php pll_e('Category Archives: '); ?><?php single_cat_title( $prefix = '', $display = true ) ?></h1>
				</p>

				<?php if( have_posts() ): ?>

		        <?php while( have_posts() ): the_post(); ?>		      	
			
				<div class="row">
					<div class="col-md-4">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('category-img', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']); ?>
						</a>
					</div>
					<div class="col-md-8">
						<?php
							$categories = get_the_category();
		 
							if ( ! empty( $categories ) ) {
							    //echo esc_html( $categories[0]->name );   
							}
						?>
						<?php echo get_the_category_list(); ?>
						<h2 style="margin-top: 20px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		                <span class="meta"><i class="fa fa-calendar"></i> <?php the_time('j F, Y'); ?></span>
						<?php the_excerpt(__('Continue reading »','example')); ?>
						<a href="<?php the_permalink(); ?>" class="btn btn-primary pull-right"><?php pll_e('Selengkapnya'); ?></a>
					</div>
				</div>



				
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

				<hr style="background-color: #cccccc; height: 1px; border: 0;">

				<?php endwhile; ?>

					<?php else: ?>

						<div id="post-404" class="noposts">

						    <p><?php _e('None found.','example'); ?></p>

					    </div><!-- /#post-404 -->

					<?php endif; wp_reset_query(); ?>
					<?php wp_pagenavi(); ?>

			</div>
			<?php get_sidebar(); ?>
		  </div>
	  </div>
    </div>

<?php get_footer(); ?>
