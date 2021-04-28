<?php 
/*
Template Name: Kontak
*/

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="maincontent">
      <div class="">
	      <div class="row">
	      	<div class="col-md-12 wow fadeIn">
				<p><?php the_content();?></p>
				
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

			</div>
		  </div>
	  </div>
    </div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>