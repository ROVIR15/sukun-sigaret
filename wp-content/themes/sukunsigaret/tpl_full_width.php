<?php 
/*
Template Name: Full Width
*/

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>	
	<?php if(!empty($feat_image)) { ?>
		<img src="<?php echo $feat_image; ?>" alt="">
	<?php } ?>

    <div class="maincontent">
      <div class="">
	      <div class="row">
	      	<div class="col-md-12 wow fadeIn">
			

	      		<h1><?php //the_title(); ?>
				
					<small>
					<?php 
						$subheader = get_post_meta( get_the_ID(), 'sub_header', true );
						if( ! empty( $subheader ) ) {
						  echo $subheader;
						} 
					?>
					</small>
				</h1>
				<p><?php the_content();?></p>
				
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

			</div>
		  </div>
	  </div>
    </div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>