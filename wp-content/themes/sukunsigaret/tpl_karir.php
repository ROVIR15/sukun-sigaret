<?php
/*
Template Name: Halaman Karir
*/

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>	
	<?php if(!empty($feat_image)) { ?>
		<img src="<?php echo $feat_image; ?>" class="img-responsive" alt="">
	<?php } else { ?>
		<img src="<?php echo get_option('r3_defaultheader'); ?>" class="img-responsive" alt="">
	<?php } ?>

    <div class="maincontent" style="padding: 30px;">
      <div class="container">
	      <div class="row">
	      	<div class="col-md-8 wow fadeIn">
						
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
				<p><?php the_content();?></p>
				
			<?php endwhile; endif; ?>
			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			
			</div>
			<div class="col-md-4 wow fadeIn">
			<p>			
				<div class="panel-group" id="accordion">
				<?php 
				// WP_Query arguments
					$currentLanguage  = get_bloginfo('language');
					$args = array(
						'post_type' => array( 'karir' ),
                        'post_status'            => array( 'publish' ),
						'tax_query' => array(
						     array (
						        'taxonomy' => 'bahasa',
						        'field' => 'slug',
						        'terms' => $currentLanguage
						     ),
				                ),
					);

					// The Query
					$karir = new WP_Query( $args );

					// The Loop
					if ( $karir->have_posts() ) {
						while ( $karir->have_posts() ) {
							$karir->the_post();
							// do something
							?>

							<div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php the_id();?>">
							        <i class="fa fa-plus"></i> <?php the_title(); ?></a>
							      </h4>
							    </div>
							    <div id="collapse<?php the_id();?>" class="panel-collapse collapse">
							      <div class="panel-body"><?php the_content(); ?></div>
							    </div>
							</div>
					<?php
						}
					} else {
						// no posts found
					}

					// Restore original Post Data
					wp_reset_postdata();
					?>
				</div> 
			</p>
			</div>

		  </div>
	  </div>
    </div>

<?php get_footer(); ?>

