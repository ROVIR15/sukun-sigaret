	   <div class="row bg-testimonial">
	   	<div class="col-md-1"></div>
			<div class="col-md-10 testimonial">
				<h1 class="wow zoomIn"><?php echo get_option('r3_testimonial_title'); ?></h1>
				<ul id="testimonial">
				
					<?php $loop = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 5, orderby => 'rand' ) ); ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); 
						$name = get_post_meta( get_the_ID(), 'name', true );
						$company = get_post_meta( get_the_ID(), 'company_name', true );
						$image = get_field('image');
					?>
						<li>
							<?php the_content(); ?>
							
							<?php if( !empty($image) ): ?>
								<img src="<?php echo $image['url']; ?>" class="img-circle img-testimonial" alt="<?php echo $image['alt']; ?>" />
							<?php endif; ?>
							
							<span><span class="name"><?php echo $name; ?></span> 
							<?php echo $company; ?></span>

						</li>
					<?php endwhile; ?>
		    	</ul>					
			</div>	 
			<div class="col-md-1"></div>  
	   </div>