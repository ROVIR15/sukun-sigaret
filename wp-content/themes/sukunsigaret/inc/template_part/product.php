<div class="container">
    <div class="our-products orange clearfix">
        <h1 class="section-title"><?php pll_e('Our Products'); ?></h1>

        <?php
            // WP_Query arguments
            $args = array(
                'post_type'              => array( 'produk' ),
                'post_status'            => array( 'publish' ),
                'posts_per_page'         => '4',
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
                    <div class="col-md-4">
                        <div class="view second-effect wow bounceInUp">
                            <?php 
                            $image = get_field('gambar_produk');
                            if( !empty($image) ): ?>
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $image['url']; ?>" class="img-responsive" alt="<?php echo $image['alt']; ?>" /></a>
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


        <p style="padding: 20px; clear: both; display: none;"><a href="" class="btn btn-danger"><?php pll_e('View All Products'); ?></a></p>
    </div>
</div>
