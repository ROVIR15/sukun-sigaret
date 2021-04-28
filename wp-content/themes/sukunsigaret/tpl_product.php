<?php 
/*
Template Name: Product Page
*/

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>	
	<?php if(!empty($feat_image)) { ?>
		<img src="<?php echo $feat_image; ?>" alt="">
	<?php } ?>

    <div class="maincontent">
      <div class="container">
	      <div class="row">
	      	<div class="col-md-12 wow fadeIn">
			
			<div class="our-products clearfix">

	      		<h1><?php pll_e('Our Products'); ?></h1>
				<?php the_content(); ?>
				<?php
				            // WP_Query arguments
				            $args = array(
				                'post_type'              => array( 'produk' ),
				                'post_status'            => array( 'publish' ),
				                'orderby'                => 'ID',
				                'order'                  => 'ASC'
				            );

				            // The Query
				            $query = new WP_Query( $args );

				            // The Loop
				            if ( $query->have_posts() ) {
				                while ( $query->have_posts() ) {
				                    $query->the_post();
				                    // do something
				                    ?>
				                    <div class="col-md-3">
				                        <div class="view second-effect wow bounceInUp">
				                            <?php 
				                            $image = get_field('gambar_produk');
				                            if( !empty($image) ): ?>
				                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				                            <?php endif; ?>

				                            <div class="mask">
				                                <a href="<?php the_permalink(); ?>" class="info" title="Details">Details</a>
				                            </div>
				                        </div>
				                        <h4><a href="<?php the_permalink(); ?>"><?php the_title( $before = '', $after = '', $echo = true ); ?></a></h4>
				                        <p><?php the_field('keterangan_pendek'); ?></p>
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
			</div>
		  </div>
	  </div>
    </div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>