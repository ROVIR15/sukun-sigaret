	<?php 
	/*
	Template Name: Homepage Elementor
	*/

	get_header(); ?>
    <div class="maincontent">

      	<div class="container">
	      <div class="row">
	      	<div class="col-md-12">
				<?php 
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post(); 
							the_content( $more_link_text = null, $strip_teaser = false );
						} // end while
					} // end if
				?>
	      	</div>
	      </div>
	      </div>
      </div>
      <?php get_template_part('inc/template_part/news'); ?>
	   <?php get_footer(); ?>