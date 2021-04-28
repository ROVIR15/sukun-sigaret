
	<div class="news-bg clearfix">
    	<div class="news clearfix">
    		<div class="container">
	      	<p><h1 class="wow zoomIn"><?php pll_e('Program CSR PR. SUKUN'); ?></h1></p>
	      	<p style="margin:0 auto; margin-bottom: 20px; width: 400px; text-align: center;"></p>


			<?php
				// WP_Query arguments
				$args = array(
					'post_type'              => array( 'post' ),
					'post_status'            => array( 'publish' ),
					'posts_per_page'         => '4',
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
					<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('news', array( 'class' => 'img-thumbnail img-responsive wow bounceInUp' ));
						} 
					?>
					<h4><?php the_title( $before = '', $after = '', $echo = true ); ?></h4>
					<p><?php //the_excerpt(); ?></p>
					<a href="<?php the_permalink(); ?>" class="btn btn-primary pull-right"><?php pll_e('Read More ...'); ?></a>
		      	</div>
				<?php
					}
				} else {
					// no posts found
				}

				// Restore original Post Data
				wp_reset_postdata();
			?>
			<!--
	      	<div class="col-md-3">
				<img class="img-thumbnail wow bounceInUp" src="<?php bloginfo('template_url'); ?>/img/news2.jpg" alt="">
				<h4>CENTRAL JAVA “PAJERO OWNERS COMMUNITY” (POC) Goes to East Java 2016 </h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium ut atque, ratione impedit.</p>
				<a href="#" class="btn btn-primary pull-right">Read More...</a>
	      	</div>
	      	<div class="col-md-3">
	      		<img class="img-thumbnail wow bounceInUp" src="<?php bloginfo('template_url'); ?>/img/news3.jpg" alt="">
	      		<h4>Wajah baru dunia balap lumpur jawa tengah Tahun 2017 </h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium ut atque, ratione impedit.</p>
				<a href="#" class="btn btn-primary pull-right">Read More...</a>
	      	</div>
	      	<div class="col-md-3">
	      		<img class="img-thumbnail wow bounceInUp" src="<?php bloginfo('template_url'); ?>/img/news4.jpg" alt="">
	      		<h4>Delapan Tim SMA yang Melaju ke Perempat Final Sukun Youth Cup 2017 </h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium ut atque, ratione impedit.</p>
				<a href="#" class="btn btn-primary pull-right">Read More...</a>
	      	</div>
			-->
	      	<p style="padding: 20px; clear: both; text-align: center;"><a href="" class="btn btn-primary"><?php pll_e('Artikel Lainnya'); ?></a></p>
	    </div>
	    </div>
    </div>  
</div>