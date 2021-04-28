	   <a href="#" id="back-to-top" title="Back to top"><i class="fa fa-angle-up"></i></a>
	   <div class="">
		   <div class="row">
		   	<div class="col-md-12 footer">		   
			   	<div class="container">
					<div class="col-md-4 col-xs-12">
						<h2><?php pll_e('Contact Us'); ?></h2>
						<!-- img class="" src="<?php echo get_option('r3_sitelogo'); ?>" alt="<?php bloginfo('description'); ?>" / -->
						<h3 style="margin: 15px 0;">PR. Sukun Kudus</h3>
						<p>
							Jl. Raya PR Sukun No. 1-2<br />
							Gondosari, Gebog, Kabupaten Kudus, <br />
							Jawa Tengah 59354, Indonesia
						</p>
					</div>
					<div class="col-md-4 col-xs-12">
						<h2><?php pll_e('Quick Links'); ?></h2>
							<ul class="quicklinks">
								<li><a href="">Home</a></li>
								<li><a href="">Our Brands</a></li>
								<li><a href="">CSR</a></li>
								<li><a href="">Image Gallery</a></li>
								<li><a href="">Info Career</a></li>
								<li><a href="">Contact Us</a></li>
							</ul>
					</div>
					<div class="col-md-4 col-xs-12">
						<h2><?php pll_e('Get Updates'); ?></h2>
						<p><?php pll_e('Get Latest Update on our CSR, Events Schedule, Products'); ?></p>
						<br /><br /><p><a href="https://my.sendinblue.com/users/subscribe/js_id/2g8gx/id/1" class="btn btn-primary"><?php pll_e('Subscribe Now'); ?></a></p>
							<?php //echo do_shortcode('[sibwp_form id=3]'); ?>
					</div>
				</div>	   
			</div>
		   </div>
	   </div>

	   <div class="lightblue">
		   <div class="row">
		   	<div class="col-md-12 footnote">		   
		   	<div class="container">
		   		<div class="col-md-7 col-xs-12">
			   		<div class="copyright wow fadeInUp"><?php pll_e('Copyright'); ?> &copy; <?php echo date('Y'); ?> - <a href="<?php bloginfo('url'); ?>"><?php bloginfo('title'); ?></a> -  disclaimer</div>
		   		</div>
		   		<div class="col-md-5 col-xs-12">
					<ul class="socmed wow fadeInUp">
						<li><?php pll_e('Follow Us on'); ?> : </li>
						<li>
							<a href="<?php echo get_option('r3_fb'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo get_option('r3_twitter'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li style="display: none;">
							<a href="<?php echo get_option('r3_youtube_ch'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo get_option('r3_instagram'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo get_option('r3_pinterest'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-pinterest fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo get_option('r3_linkedin'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo get_option('r3_googleplus'); ?>">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
					</ul>
					</div>
				</div>	   
				</div>
		   </div>
	   </div>

<script type="text/javascript">
jQuery(document).ready(function() {
	new WOW().init();
	setTimeout(function(){
		jQuery('body').addClass('loaded');
	}, 3000);
	
	jQuery('#lightSlider').lightSlider({
	    gallery: false,
	    item: 1,
	    auto:true,
	    pause: 5000,
	    loop: true,
	    slideMargin: 0,
	    thumbItem: 2,
		 responsive : [
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                  }
            }
        ]
	});
	jQuery('#testimonial').lightSlider({
	    gallery: false,
	    item: 1,
	    auto:true,
	    pause: 5000,
	    loop: true,
	    slideMargin: 0,
		adaptiveHeight: true,
	    controls: false
	});
		    
	jQuery(".arrow-right").bind("click", function (event) {
		event.preventDefault();
			jQuery(".vid-list-container").stop().animate({
				scrollLeft: "+=336"
		    }, 750);
	});
	
	jQuery(".arrow-left").bind("click", function (event) {
		event.preventDefault();
			jQuery(".vid-list-container").stop().animate({
				scrollLeft: "-=336"
			}, 750);
	});
});
</script>
<?php wp_footer(); ?>
<?php echo get_option('r3_google_analytics'); ?>
</body>
</html>