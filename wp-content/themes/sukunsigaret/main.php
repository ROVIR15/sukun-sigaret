	<?php get_template_part('inc/template_part/intro'); ?>
	<?php get_template_part('inc/template_part/product'); ?>
	<div class="row" style="display: none;">
		<div class="col-md-12">
			<img src="<?php bloginfo('template_directory'); ?>/img/product-homepage.jpg" class="img-responsive" alt="">
		</div>
	</div>
    <?php get_template_part('inc/template_part/news'); ?>

    <div class="maincontent" style="display: none;">

      	<div class="container">
	      <div class="row">
	      	<div class="col-md-12 wow fadeIn">
				<?php 
				$homepage_id = get_ID_by_slug(get_option('r3_homepage'));
				$homepage = get_post($homepage_id); 
				$subheader = get_post_meta( $homepage_id, 'sub_header', true );
				?>

	      		<h1 style="display: none;"><?php echo $homepage->post_title; ?>
				<small style="display: none;"><?php echo $subheader; ?></small></h1>
	      		<p class="homepage-content"><?php echo wpautop($homepage->post_content); ?></p>

	      	</div>
	      </div>
	      </div>
      </div>

      <div class="container" style="display: none;">
      <div class="row">
			<div class="col-md-12 cta">
				<div class="">
				<?php $ctalink = get_option('r3_ctalink'); ?>
					<a href="<?php echo bloginfo('url').'/'.$ctalink; ?>" title="!"><img src="" class="img-responsive wow zoomIn" alt="" /></a>
				</div>	      
			</div>
	   </div>

	   </div>
	   
	   <?php //get_template_part('testimonial'); ?>