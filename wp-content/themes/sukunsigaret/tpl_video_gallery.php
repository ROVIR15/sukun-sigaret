<?php 
/*
Template Name: Video Gallery
*/

get_header(); ?>

    <div class="maincontent">
      <div class="container wow fadeIn">
	      <div class="row">
	      	<div class="col-md-7 wow fadeIn">
					
	      		<h1><i class="fa fa-youtube-play"></i> <?php the_title(); ?>
				
					<small>
					<?php 
						$subheader = get_post_meta( get_the_ID(), 'sub_header', true );
						if( ! empty( $subheader ) ) {
						  echo $subheader;
						} 
					?>
					</small>
				</h1>
				<p><?php the_content(); ?></p>
				<!-- THE YOUTUBE PLAYER -->
				<div class="vid-container">
					<?php $first = new WP_Query( array( 'post_type' => 'video', 'posts_per_page' => 1, orderby => 'rand' ) ); ?>
					<?php while ( $first->have_posts() ) : $first->the_post(); 
						$ytid_first = get_field('youtube_video_id');
					?>
						<iframe id="vid_frame" src="http://www.youtube.com/embed/<?php echo $ytid_first; ?>?rel=0&showinfo=0&autohide=1" frameborder="0" width="560" height="315"></iframe>
					<?php endwhile; ?>
				</div>

				<!-- THE PLAYLIST -->
				<div class="vid-list-container">
					<div class="vid-list">
					
					<?php
					function yt_title($id) {
						$url = "http://gdata.youtube.com/feeds/api/videos/". $id;
						$doc = new DOMDocument;
						$doc->load($url);
						$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
						return $title;
					}
					
					function getYoutubeDuration($id) {
						$xml = simplexml_load_file('https://gdata.youtube.com/feeds/api/videos/' . $id . '?v=2');
						$result = $xml->xpath('//yt:duration[@seconds]');
						$total_seconds = (int) $result[0]->attributes()->seconds;

						return $total_seconds;
					}
					?>
					
					<?php $loop = new WP_Query( array( 'post_type' => 'video' ) ); ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); 
						$ytid = get_field('youtube_video_id');
					?>
						
						<div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/<?php echo $ytid; ?>?autoplay=1&rel=0&showinfo=0&autohide=1'">
						  <div class="thumb"><img src="http://img.youtube.com/vi/<?php echo $ytid; ?>/0.jpg"></div>
						  <div class="desc"><?php echo yt_title($ytid); ?></div>
						</div>
					
					<?php endwhile; ?>

					</div>
				</div>

				<!-- LEFT AND RIGHT ARROWS -->
				<div class="arrows">
					<div class="arrow-left"><i class="fa fa-chevron-left fa-lg"></i></div>
					<div class="arrow-right"><i class="fa fa-chevron-right fa-lg"></i></div>
				</div>
				
			</div>
			<?php get_sidebar(); ?>
		  </div>
	  </div>
    </div>
	
	<div class="container">
      <div class="row">
			<div class="col-md-12 cta">
				<div class="">
				<?php $ctalink = get_option('r3_ctalink'); ?>
					<a href="<?php echo bloginfo('url').'/'.$ctalink; ?>" title="Book Chris Today!"><img src="<?php bloginfo('template_directory'); ?>/img/cta_front.png" class="img-responsive wow zoomIn" alt="" /></a>
				</div>	       
			</div>
	   </div>
	</div>

<?php get_footer(); ?>