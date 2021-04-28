<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<img src="<?php echo get_option('r3_defaultheader'); ?>" alt="">

    <div class="maincontent page">
      <div class="container">
	      <div class="row">
	      	<div class="col-md-8 wow fadeIn entry">
						
	      		<h1><?php the_title(); ?>
				
					<small>
					<?php 
						$subheader = get_post_meta( get_the_ID(), 'sub_header', true );
						if( ! empty( $subheader ) ) {
						  echo $subheader;
						} 
					?>
					</small>
				</h1>
				<?php if ( has_post_thumbnail( $_post->ID ) ) { ?>
					<p><?php echo get_the_post_thumbnail( $page->ID, 'full', array('class' => 'img-responsive')); ?></p>
				<?php } ?>

				<p><?php the_content();?></p>
				
			<?php endwhile; endif; ?>
			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			
			</div>
			<?php get_sidebar(); ?>
		  </div>
	  </div>
    </div>

<?php get_footer(); ?>