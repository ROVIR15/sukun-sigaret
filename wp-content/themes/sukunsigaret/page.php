<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>	
	<?php if(!empty($feat_image)) { ?>
		<img src="<?php echo $feat_image; ?>" class="img-responsive" alt="">
	<?php } ?>

    <div class="maincontent page">
      <div class="container">
	      <div class="row">
	      	<div class="col-md-12 wow fadeIn post">
				
	      		<div style="width: 50%; text-align: center; margin: 0 auto;">
	      		<h1 style="color: #000 !important; text-align: center;"><?php the_title(); ?></h1>
				
					<small>
					<?php 
						$subheader = get_post_meta( get_the_ID(), 'sub_header', true );
						if( ! empty( $subheader ) ) {
						  echo $subheader;
						} 
					?>
					</small>
				</h1>
				</div>

				<p><?php the_content();?></p>
				
			<?php endwhile; endif; ?>
			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			
			</div>
			<?php //get_sidebar(); ?>
		  </div>
	  </div>
    </div>

<?php get_footer(); ?>