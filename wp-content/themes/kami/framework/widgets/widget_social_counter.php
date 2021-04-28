<?php
/**
 * Plugin Name: BKninja: Social Counter Widget
 * Plugin URI: http://bkninja.com
 * Description: Displays social counters.
 * Version: 1.0
 * Author: BKninja
 * Author URI: http://bkninja.com
 *
 */
 
/**
 * Include required files
 */
require_once dirname(__FILE__) . '/lib/twitteroauth.php';

 /**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init','bk_register_social_counters_widget');

function bk_register_social_counters_widget() {
	register_widget('bk_social_counter');
	}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_social_counter extends WP_Widget {
    private $connection;

	private $consumer_key;
	private $consumer_secret;
	private $access_token;
	private $access_token_secret;	
	/**
	 * Widget setup.
	 */
	function bk_social_counter() {
		
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget-social-counter','description' => __('Displays social counters', 'bkninja'));
		
		/* Create the widget. */
		$this->WP_Widget('bk_social_counter',__('BKninja: Widget Social Counters', 'bkninja'),$widget_ops);

	}
	
	/**
	 * display the widget on the screen.
	 */	
	function widget( $args, $instance ) {
		extract( $args );
		//user settings	
        $title = apply_filters('widget_title', $instance['title'] );
		$bk_youtube_username = esc_attr($instance['bk_youtube_username']);
		$bk_dribbble_username = esc_attr($instance['bk_dribbble_username']);
        $bk_rss_url = esc_url($instance['bk_rss_url']);
		$bk_facebook_username = esc_attr($instance['bk_facebook_username']);
		$bk_twitter_id = esc_attr($instance['bk_twitter_id']);
        
        $bk_soundcloud_user = esc_attr($instance['bk_soundcloud_user']);
        $bk_soundcloud_api = esc_attr($instance['bk_soundcloud_api']);
        $bk_instagram_api = esc_attr($instance['bk_instagram_api']);

		$this->consumer_key = isset( $instance['bk_consumer_key'] ) ? $instance['bk_consumer_key'] : '';
		$this->consumer_secret = isset( $instance['bk_consumer_secret'] ) ? $instance['bk_consumer_secret'] : '';
		$this->access_token = isset( $instance['bk_access_token'] ) ? $instance['bk_access_token'] : '';
		$this->access_token_secret = isset( $instance['bk_access_secret'] ) ? $instance['bk_access_secret'] : '';	
		

		echo $before_widget;
		if ( $title )
			echo $before_title . esc_attr($title) . $after_title;

		//twitter
		if (isset($bk_twitter_id)&&(strlen($bk_twitter_id) != 0)){
			$interval = 600;				
			$follower_count = 0;
			
			if(time() > get_option('bk_twitter_cache_time')) {
				

      		    if ($this->pre_validate_keys() === true) {
        			$this->connection = new TwitterOAuth( $this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret );
        		} else {
        			echo '<p>Twitter Widget not configured</p>';
        		}
                $this->connection->get('account/verify_credentials');
			
				if ($this->connection->http_code == 200 ) {
				    $userInfo = $this->connection->get('users/show',array('screen_name' => $bk_twitter_id));
					$follower_count = $userInfo->followers_count;
					if ($follower_count > 0 ) {
						update_option('bk_twitter_cache_time', time() + $interval);
						update_option('bk_twitter_followers', $follower_count);
					}
				}			
			}	 
		}
		//Soundcloud
		if ((isset($bk_soundcloud_user)&&(strlen($bk_soundcloud_user) != 0)) && (isset($bk_soundcloud_api)&&(strlen($bk_soundcloud_api) != 0))){
		  	$interval = 600;
			$soundcloud_count = 0;
            $soundcloud_url = '';
            if(time() > get_option('bk_soundcloud_cache_time')) {
                $url = 'http://api.soundcloud.com/users/'.$bk_soundcloud_user.'.json?consumer_key='.$bk_soundcloud_api;
                $api = wp_remote_get( $url ) ;
                $request = json_decode(wp_remote_retrieve_body ($api), true);
                $soundcloud_count = $request['followers_count']; 
                $soundcloud_url =  $request['permalink_url']; 
                if ($soundcloud_count >= 0 ) {
					update_option('bk_soundcloud_cache_time', time() + $interval);
					update_option('bk_soundcloud_followers', $soundcloud_count);
					update_option('bk_soundcloud_link', $soundcloud_url);
				}
            }        
        }
        //Instagram
		if (isset($bk_instagram_api)&&(strlen($bk_instagram_api) != 0)){
		  	$interval = 600;
			$instagram_count = 0;
            $instagram_username = '';
            if(time() > get_option('bk_instagram_cache_time')) {
                $instagram_userid = explode(".", $bk_instagram_api);
                $url = 'https://api.instagram.com/v1/users/'.$instagram_userid[0].'/?access_token='.$bk_instagram_api;
                $api = wp_remote_get( $url ) ;
                $request = json_decode(wp_remote_retrieve_body ($api), true);
                $instagram_count = $request['data']['counts']['followed_by'];   
                $instagram_username =  $request['data']['username'];
                $instagram_url = 'http://instagram.com/'.$instagram_username;
                if ($instagram_count >= 0 ) {
					update_option('bk_instagram_cache_time', time() + $interval);
					update_option('bk_instagram_followers', $instagram_count);
					update_option('bk_instagram_link', $instagram_url);
				}
            }            
        }
		//facebook
		if (isset($bk_facebook_username)&&(strlen($bk_facebook_username) != 0)){
			$interval = 600;
			$fb_likes = 0;
			
			if(time() > get_option('bk_facebook_cache_time')) {
				
				$api = wp_remote_get('http://graph.facebook.com/' . $bk_facebook_username);
				
				if (!is_wp_error($api)) {
					
					$json = json_decode($api['body']);
					$fb_likes = $json->likes;
					
					if ($fb_likes > 0 ) {
						update_option('bk_facebook_cache_time', time() + $interval);
						update_option('bk_facebook_followers', $fb_likes);
						update_option('bk_facebook_link', $json->link);
					}
				
				}				
				
			}
		}
		
		//dribbble
		if (isset($bk_dribbble_username)&&(strlen($bk_dribbble_username) != 0)){
			$interval = 600;
			$followers_count = 0;
			if(time() > get_option('bk_dribbble_cache_time')) {
				
				$api = wp_remote_get('http://api.dribbble.com/' . $bk_dribbble_username);
				
				if (!is_wp_error($api)) {
					$json = json_decode($api['body']);
					$followers_count = $json->followers_count;
					
					if ($followers_count > 0 ) {
						update_option('bk_dribbble_cache_time', time() + $interval);
						update_option('bk_dribbble_followers', $followers_count );
					}
				}
			}
		}
        
        if(isset($bk_youtube_username)&&(strlen($bk_youtube_username) != 0)){
            $interval = 600;
            $data = file_get_contents('http://gdata.youtube.com/feeds/api/users/'.$bk_youtube_username);
            if(time() > get_option('bk_youtube_cache_time')) {                
                if($data != null){
                    $xml = new SimpleXMLElement($data);
                    $stats_data = (array)$xml->children('yt', true)->statistics->attributes();
                    $stats_data = $stats_data['@attributes'];
                    $subscriberCount = $stats_data['subscriberCount'];
                }
                if ($subscriberCount > 0 ){
                    update_option('bk_youtube_cache_time', time() + $interval);
                    update_option('bk_youtube_subscribers', $subscriberCount );
                }
            }
                      
        }
		?>
		<div class="wrap">
			<ul>
											
				<?php if (isset($bk_twitter_id)&&(strlen($bk_twitter_id) != 0)){ ?>
					<li class="twitter clear-fix">
                        <a target="_blank" href="http://twitter.com/<?php echo esc_attr($bk_twitter_id); ?>">
    						<div class="icon"><i class="fa fa-twitter"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_twitter_followers'); ?></div>
    							<div class="text"><?php _e('Followers', 'bkninja');?></div>
    						</div>
                        </a>
					</li> <!-- /twitter -->
				<?php } ?>
				
				<?php if (isset($bk_facebook_username) && (strlen($bk_facebook_username) != 0)){ ?>
					<li class="facebook clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_facebook_link'); ?>">
    						<div class="icon"><i class="fa fa-facebook"></i></div>
    						<div class="data">				
    							<div class="counter"><?php echo get_option('bk_facebook_followers'); ?></div>
    							<div class="text"><?php _e('Likes', 'bkninja');?></div>				
    						</div>
                        </a>
					</li><!-- /facebook -->
				<?php } ?>
                
				<?php if (isset($bk_dribbble_username)&&(strlen($bk_dribbble_username) != 0)){ ?>
					<li class="dribbble clear-fix">
                        <a target="_blank" href="http://dribbble.com/<?php echo esc_attr($bk_dribbble_username); ?>">
    						<div class="icon"><i class="fa fa-dribbble"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_dribbble_followers'); ?></div>
    							<div class="text"><?php _e('Followers', 'bkninja'); ?></div>		
    						</div>
                        </a>				
					</li>
				<?php } ?>
				
				<?php if (isset($bk_youtube_username)&&(strlen($bk_youtube_username) != 0)){ ?>
					<li class="youtube clear-fix">
                        <a target="_blank" href="http://www.youtube.com/user/<?php echo esc_attr($bk_youtube_username) ;?>">
    						<div class="icon"><i class="fa fa-youtube"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_youtube_subscribers'); ?></div>
    							<div class="text"><?php _e('Subscribers', 'bkninja'); ?></div>		
    						</div>
                        </a>				
					</li>
				<?php } ?>
                 <?php if ((isset($bk_soundcloud_user)&&(strlen($bk_soundcloud_user) != 0)) && (isset($bk_soundcloud_api)&&(strlen($bk_soundcloud_api) != 0))){ ?>
					<li class="soundcloud clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_soundcloud_link'); ?>">
    						<div class="icon"><i class="fa fa-soundcloud"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_soundcloud_followers'); ?></div>
    							<div class="text"><?php _e('Followers', 'bkninja'); ?></div>	
    						</div>	
                        </a>			
					</li>
				<?php } ?>
                <?php if (isset($bk_instagram_api)&&(strlen($bk_instagram_api) != 0)){ ?>
					<li class="instagram clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_instagram_link'); ?>">
    						<div class="icon"><i class="fa fa-instagram"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_instagram_followers'); ?></div>
    							<div class="text"><?php _e('Followers', 'bkninja'); ?></div>	
    						</div>	
                        </a>			
					</li>
				<?php } ?>
                <?php if (isset($bk_rss_url)&&(strlen($bk_rss_url) != 0)){ ?>
					<li class="rss clear-fix">
                        <a target="_blank" href="<?php echo esc_url($bk_rss_url); ?>">
    						<div class="icon"><i class="fa fa-rss"></i></div>
    						<div class="data">
    							<div class="subscribe"><?php _e('Subscribe', 'bkninja'); ?></div>
    							<div class="text"><?php _e('RSS Feeds', 'bkninja'); ?></div>		
    						</div>	
                        </a>			
					</li>
				<?php } ?>
				
			</ul>
				
		</div><!-- /wrap -->			
		<?php 
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['bk_youtube_username'] = $new_instance['bk_youtube_username'];
		$instance['bk_dribbble_username'] = $new_instance['bk_dribbble_username'];
		$instance['bk_facebook_username'] = $new_instance['bk_facebook_username'];
        $instance['bk_rss_url'] = $new_instance['bk_rss_url'];
        $instance['bk_soundcloud_user'] = $new_instance['bk_soundcloud_user'];
        $instance['bk_soundcloud_api'] = $new_instance['bk_soundcloud_api'];
        $instance['bk_instagram_api'] = $new_instance['bk_instagram_api'];
        $instance['bk_twitter_id'] = $new_instance['bk_twitter_id'];
		$instance['bk_consumer_key'] = $new_instance['bk_consumer_key'];	
		$instance['bk_consumer_secret'] = $new_instance['bk_consumer_secret'];	
		$instance['bk_access_token'] = $new_instance['bk_access_token'];	
		$instance['bk_access_secret'] = $new_instance['bk_access_secret'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
        	'title' => '',		
			'bk_youtube_username' => '',
			'bk_dribbble_username' => '',
			'bk_twitter_id' => '',
			'bk_facebook_username' => '',
            'bk_rss_url' => '',
            'bk_soundcloud_user' => '',
            'bk_soundcloud_api' => 'fc20fec35eb62030a9051ff68e6e6614',
            'bk_instagram_api' => '',
			'bk_consumer_key' => 'V6kDOs8evsngxd886KrL8QBuB',	
			'bk_consumer_secret' => '7J6qrANBChZTZWn5pYlaN8fokOcUHhInx9aS4N8QN13vQhflZj',	
			'bk_access_token' => '2351267310-BLNj5jSVws3vQU0Ws4JsFCG4Obxkd7gsfKC5keL',	
			'bk_access_secret' => '0cBsn2b0rwCWREKsaR0S76Z8zgqfXJYG7W2eHQvzP3bjb'
 		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<!-- Title: Text Input -->     
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e('Title:', 'bkninja');?></strong></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
                
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_facebook_username' ); ?>"><strong><?php _e('Facebook Username:', 'bkninja');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_facebook_username' ); ?>" name="<?php echo $this->get_field_name( 'bk_facebook_username' ); ?>" value="<?php echo esc_attr($instance['bk_facebook_username']); ?>" class="widefat" />
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'bk_dribbble_username' ); ?>"><strong><?php _e('Dribbble Username', 'bkninja');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_dribbble_username' ); ?>" name="<?php echo $this->get_field_name( 'bk_dribbble_username' ); ?>" value="<?php echo esc_attr($instance['bk_dribbble_username']); ?>" class="widefat" />
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_youtube_username' ); ?>"><strong><?php _e('Youtube username', 'bkninja');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_youtube_username' ); ?>" name="<?php echo $this->get_field_name( 'bk_youtube_username' ); ?>" value="<?php echo esc_attr($instance['bk_youtube_username']); ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_soundcloud_user' ); ?>"><strong><?php _e('SoundCloud Username','bkninja');?></strong> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_soundcloud_user' ); ?>" name="<?php echo $this->get_field_name( 'bk_soundcloud_user' ); ?>" value="<?php echo esc_attr($instance['bk_soundcloud_user']); ?>"/>
			
			<label for="<?php echo $this->get_field_id( 'bk_soundcloud_api' ); ?>">Soundcloud API Key : </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_soundcloud_api' ); ?>" name="<?php echo $this->get_field_name( 'bk_soundcloud_api' ); ?>" value="<?php echo esc_attr($instance['bk_soundcloud_api']); ?>" />
		</p>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_instagram_api' ); ?>"><strong>Instagram Access Token Key :</strong> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_instagram_api' ); ?>" name="<?php echo $this->get_field_name( 'bk_instagram_api' ); ?>" value="<?php echo esc_attr($instance['bk_instagram_api']); ?>" />
            <i>Get Instagram Access Token <a target="_blank" href="http://jelled.com/instagram/access-token">here</a></i>
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_rss_url' ); ?>"><strong><?php _e('RSS URL', 'bkninja');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_rss_url' ); ?>" name="<?php echo $this->get_field_name( 'bk_rss_url' ); ?>" value="<?php echo esc_url($instance['bk_rss_url']); ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_twitter_id' ); ?>"><strong><?php _e('Twitter Name', 'bkninja');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'bk_twitter_id' ); ?>" value="<?php echo esc_attr($instance['bk_twitter_id']); ?>" class="widefat" />
        </p>

		<p>
			<label for="<?php echo $this->get_field_id( 'bk_consumer_key' ); ?>"><strong><?php _e('Consumer key', 'bkninja') ?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'bk_consumer_key' ); ?>" value="<?php echo esc_attr($instance['bk_consumer_key']); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_consumer_secret' ); ?>"><strong><?php _e('Consumer secret', 'bkninja') ?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'bk_consumer_secret' ); ?>" value="<?php echo esc_attr($instance['bk_consumer_secret']); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_access_token' ); ?>"><strong><?php _e('Access token', 'bkninja');?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_access_token' ); ?>" name="<?php echo $this->get_field_name( 'bk_access_token' ); ?>" value="<?php echo esc_attr($instance['bk_access_token']); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_access_secret' ); ?>"><strong><?php _e('Access token secret', 'bkninja');?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_access_secret' ); ?>" name="<?php echo $this->get_field_name( 'bk_access_secret' ); ?>" value="<?php echo esc_attr($instance['bk_access_secret']); ?>" />			
		</p>


	<?php 
	}
    	function pre_validate_keys() {
    	if ( ! $this->consumer_key        ) return false;
    	if ( ! $this->consumer_secret     ) return false;
    	if ( ! $this->access_token        ) return false;
    	if ( ! $this->access_token_secret ) return false;
    
    	return true;
	}
} //end class