<?php

/**
 * The optimize class.
 *
 * @since      	1.2.2
 * @since  		1.5 Moved into /inc
 * @package  	LiteSpeed_Cache
 * @subpackage 	LiteSpeed_Cache/inc
 * @author     	LiteSpeed Technologies <info@litespeedtech.com>
 */

class LiteSpeed_Cache_Optimize
{
	private static $_instance ;

	const DIR_MIN = '/min' ;
	const CSS_ASYNC_LIB = '/min/css_async.js' ;

	private $content ;
	private $http2_headers = array() ;

	private $cfg_http2_css ;
	private $cfg_http2_js ;
	private $cfg_css_minify ;
	private $cfg_css_combine ;
	private $cfg_js_minify ;
	private $cfg_js_combine ;
	private $cfg_html_minify ;
	private $cfg_css_async ;
	private $cfg_js_defer ;
	private $cfg_js_defer_exc = false ;
	private $cfg_qs_rm ;
	private $cfg_exc_jquery ;


	private $html_foot = '' ; // The html info append to <body>
	private $html_head = '' ; // The html info prepend to <body>
	private $css_to_be_removed = array() ;

	private $minify_cache ;
	private $minify_minify ;
	private $minify_env ;
	private $minify_sourceFactory ;
	private $minify_controller ;
	private $minify_options ;

	/**
	 * Init optimizer
	 *
	 * @since  1.2.2
	 * @access private
	 */
	private function __construct()
	{
		$this->cfg_http2_css = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_CSS_HTTP2 ) ;
		$this->cfg_http2_js = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_JS_HTTP2 ) ;
		$this->cfg_css_minify = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_CSS_MINIFY ) ;
		$this->cfg_css_combine = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_CSS_COMBINE ) ;
		$this->cfg_js_minify = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_JS_MINIFY ) ;
		$this->cfg_js_combine = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_JS_COMBINE ) ;
		$this->cfg_html_minify = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_HTML_MINIFY ) ;
		$this->cfg_css_async = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_CSS_ASYNC ) ;
		$this->cfg_js_defer = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_JS_DEFER ) ;
		$this->cfg_qs_rm = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_QS_RM ) ;
		$this->cfg_exc_jquery = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_EXC_JQUERY ) ;

		$this->_static_request_check() ;

		if ( ! $this->_can_optm() ) {
			return ;
		}

		// To remove emoji from WP
		if ( LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_EMOJI_RM ) ) {
			add_action( 'init', array( $this, 'emoji_rm' ) ) ;
		}

		if ( $this->cfg_qs_rm ) {
			add_filter( 'style_loader_src', array( $this, 'remove_query_strings' ), 999 ) ;
			add_filter( 'script_loader_src', array( $this, 'remove_query_strings' ), 999 ) ;
		}

		// Check if there is any critical css rules setting
		if ( $this->cfg_css_async ) {
			add_action( 'wp_head', array( $this, 'prepend_critical_css' ), 1 ) ;
		}

		/**
		 * Exclude js from deferred setting
		 * @since 1.5
		 */
		if ( $this->cfg_js_defer ) {
			$this->cfg_js_defer_exc = apply_filters( 'litespeed_optm_js_defer_exc', get_option( LiteSpeed_Cache_Config::ITEM_OPTM_JS_DEFER_EXC ) ) ;
			if ( $this->cfg_js_defer_exc ) {
				$this->cfg_js_defer_exc = explode( "\n", $this->cfg_js_defer_exc ) ;
			}
		}

		/**
		 * Add vary filter for Role Excludes
		 * @since  1.6
		 */
		add_filter( 'litespeed_vary', array( $this, 'vary_add_role_exclude' ) ) ;

	}

	/**
	 * Exclude role from optimization filter
	 *
	 * @since  1.6
	 * @access public
	 */
	public function vary_add_role_exclude( $varys )
	{
		if ( ! LiteSpeed_Cache_Config::get_instance()->in_exclude_optimization_roles() ) {
			return $varys ;
		}
		$varys[ 'role_exclude_optm' ] = 1 ;
		return $varys ;
	}

	/**
	 * Remove emoji from WP
	 *
	 * @since  1.4
	 * @access public
	 */
	public function emoji_rm()
	{
		remove_action( 'wp_head' , 'print_emoji_detection_script', 7 ) ;
		remove_action( 'admin_print_scripts' , 'print_emoji_detection_script' ) ;
		remove_filter( 'the_content_feed' , 'wp_staticize_emoji' ) ;
		remove_filter( 'comment_text_rss' , 'wp_staticize_emoji' ) ;
		/**
		 * Added for better result
		 * @since  1.6.2.1
		 */
		remove_action( 'wp_print_styles', 'print_emoji_styles' ) ;
		remove_action( 'admin_print_styles', 'print_emoji_styles' ) ;
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' ) ;
	}

	/**
	 * Output critical css
	 *
	 * @since  1.3
	 * @access public
	 * @return  string The static file content
	 */
	public function prepend_critical_css()
	{

		$rules = get_option( LiteSpeed_Cache_Config::ITEM_OPTM_CSS ) ;
		if ( ! $rules ) {
			return ;
		}

		echo '<style id="litespeed-optm-css-rules">' . $rules . '</style>' ;
	}

	/**
	 * Check if the request is for static file
	 *
	 * @since  1.2.2
	 * @access private
	 * @return  string The static file content
	 */
	private function _static_request_check()
	{
		// This request is for js/css_async.js
		if ( $this->cfg_css_async && strpos( $_SERVER[ 'REQUEST_URI' ], self::CSS_ASYNC_LIB ) !== false ) {
			LiteSpeed_Cache_Log::debug( 'Optimizer start serving static file' ) ;

			LiteSpeed_Cache_Control::set_cacheable() ;
			LiteSpeed_Cache_Control::set_no_vary() ;
			LiteSpeed_Cache_Control::set_custom_ttl( 8640000 ) ;
			LiteSpeed_Cache_Tag::add( LiteSpeed_Cache_Tag::TYPE_MIN . '_CSS_ASYNC' ) ;

			$file = LSWCP_DIR . 'js/css_async.js' ;

			header( 'Content-Length: ' . filesize( $file ) ) ;
			header( 'Content-Type: application/x-javascript; charset=utf-8' ) ;

			echo file_get_contents( $file ) ;
			exit ;
		}

		// If not turn on min files
		if ( ! $this->cfg_css_minify && ! $this->cfg_css_combine && ! $this->cfg_js_minify && ! $this->cfg_js_combine ) {
			return ;
		}

		if ( empty( $_SERVER[ 'REQUEST_URI' ] ) || strpos( $_SERVER[ 'REQUEST_URI' ], self::DIR_MIN . '/' ) === false ) {
			return ;
		}

		// try to match `http://home_url/min/xx.css
		if ( ! preg_match( '#' . self::DIR_MIN . '/(\w+\.(css|js))#U', $_SERVER[ 'REQUEST_URI' ], $match ) ) {
			return ;
		}

		LiteSpeed_Cache_Log::debug( 'Optimizer start minifying file' ) ;

		// Proceed css/js file generation
		define( 'LITESPEED_MIN_FILE', true ) ;

		$result = $this->_minify( $match[ 1 ] ) ;

		if ( ! $result ) {
			LiteSpeed_Cache_Control::set_nocache( 'Empty content from optimizer' ) ;
			exit ;
		}

		foreach ( $result[ 'headers' ] as $key => $val ) {
			if ( in_array( $key, array( 'Content-Length', 'Content-Type' ) ) ) {
				header( $key . ': ' . $val ) ;
			}
		}

		LiteSpeed_Cache_Control::set_cacheable() ;
		LiteSpeed_Cache_Control::set_no_vary() ;
		LiteSpeed_Cache_Control::set_custom_ttl( LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTIMIZE_TTL ) ) ;
		LiteSpeed_Cache_Tag::add( LiteSpeed_Cache_Tag::TYPE_MIN ) ;

		echo $result[ 'content' ] ;
		exit ;
	}

	/**
	 * Remove QS
	 *
	 * @since  1.3
	 * @access public
	 */
	public function remove_query_strings( $src )
	{
		if ( strpos( $src, 'ver=' ) !== false ) {
			$src = preg_replace( '#[&\?]+(ver=([\w\-\.]+))#i', '', $src ) ;
		}
		return $src ;
	}

	/**
	 * Check if can run optimize
	 *
	 * @since  1.3
	 * @access private
	 */
	private function _can_optm()
	{
		if ( is_admin() ) {
			return false ;
		}

		if ( is_feed() ) {
			return false ;
		}

		if ( is_preview() ) {
			return false ;
		}

		if ( LiteSpeed_Cache_Router::is_ajax() ) {
			return false ;
		}

		return true ;
	}

	/**
	 * Run optimize process
	 * NOTE: As this is after cache finalized, can NOT set any cache control anymore
	 *
	 * @since  1.2.2
	 * @access public
	 * @return  string The content that is after optimization
	 */
	public static function finalize( $content )
	{
		if ( defined( 'LITESPEED_MIN_FILE' ) ) {// Must have this to avoid css/js from optimization again ( But can be removed as mini file doesn't have LITESPEED_IS_HTML, keep for efficiency)
			return $content ;
		}

		if ( ! defined( 'LITESPEED_IS_HTML' ) ) {
			LiteSpeed_Cache_Log::debug( 'Optimizer bypass: Not frontend HTML type' ) ;
			return $content ;
		}

		// Check if hit URI excludes
		$excludes = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_EXCLUDES ) ;
		if ( ! empty( $excludes ) ) {
			$result = LiteSpeed_Cache_Utility::str_hit_array( esc_url( $_SERVER[ 'REQUEST_URI' ] ), explode( "\n", $excludes ) ) ;
			if ( $result ) {
				LiteSpeed_Cache_Log::debug( 'Optimizer bypass: hit URI Excludes setting: ' . $result ) ;
				return $content ;
			}
		}

		// Check if is exclude optm roles ( Need to set Vary too )
		if ( $result = LiteSpeed_Cache_Config::get_instance()->in_exclude_optimization_roles() ) {
			LiteSpeed_Cache_Log::debug( 'Optimizer bypass: hit Role Excludes setting: ' . $result ) ;
			return $content ;
		}


		LiteSpeed_Cache_Log::debug( 'Optimizer start' ) ;

		$instance = self::get_instance() ;
		$instance->content = $content ;

		$instance->_optimize() ;
		return $instance->content ;
	}

	/**
	 * Optimize css src
	 *
	 * @since  1.2.2
	 * @access private
	 */
	private function _optimize()
	{
		if ( ! $this->_can_optm() ) {
			LiteSpeed_Cache_Log::debug( 'Optimizer bypass: admin/feed/preview' ) ;
			return ;
		}

		do_action( 'litespeed_optm' ) ;

		// Parse css from content
		$ggfonts_rm = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_OPTM_GGFONTS_RM ) ;
		if ( $this->cfg_css_minify || $this->cfg_css_combine || $this->cfg_http2_css || $ggfonts_rm || $this->cfg_css_async ) {
			// To remove google fonts
			if ( $ggfonts_rm ) {
				$this->css_to_be_removed[] = 'fonts.googleapis.com' ;
			}
			list( $src_list, $html_list ) = $this->_handle_css() ;
		}

		// css optimizer
		if ( $this->cfg_css_minify || $this->cfg_css_combine || $this->cfg_http2_css ) {

			if ( $src_list ) {
				// Analyze local file
				list( $ignored_html, $src_queue_list, $file_size_list ) = $this->_analyse_links( $src_list, $html_list ) ;

				// IF combine
				if ( $this->cfg_css_combine ) {
					$enqueue_first = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_CSS_COMBINED_PRIORITY ) ;

					$urls = $this->_limit_size_build_hash_url( $src_queue_list, $file_size_list ) ;

					$snippet = '' ;
					foreach ( $urls as $url ) {
						$snippet .= "<link data-optimized='2' rel='stylesheet' href='$url' />" ;// use 2 as combined
					}

					// Handle css async load
					if ( $this->cfg_css_async ) {
						// Only ignored html snippet needs async
						list( $noscript, $ignored_html_async ) = $this->_async_css_list( $ignored_html ) ;

						// enqueue combined file first
						if ( $enqueue_first ) {
							$noscript = $snippet . $noscript ;
						}
						else {
							$noscript .= $snippet ;
						}

						$snippet = '' ;
						foreach ( $urls as $url ) {
							$snippet .= "<link rel='preload' data-asynced='1' data-optimized='2' as='style' onload='this.rel=\"stylesheet\"' href='$url' />" ;
						}

						// enqueue combined file first
						if ( $enqueue_first ) {
							$this->html_head .= $snippet . implode( '', $ignored_html_async ) ;
						}
						else {
							$this->html_head .= implode( '', $ignored_html_async ) . $snippet ;
						}

						$this->html_head .= '<noscript>' . $noscript . '</noscript>' ;
					}
					else {
						// enqueue combined file first
						if ( $enqueue_first ) {
							$this->html_head .= $snippet . implode( '', $ignored_html ) ;
						}
						else {
							$this->html_head .= implode( '', $ignored_html ) . $snippet ;
						}
					}

					// Move all css to top
					$this->content = str_replace( $html_list, '', $this->content ) ;

					// Add to HTTP2
					foreach ( $urls as $url ) {
						$this->append_http2( $url ) ;
					}

				}
				// Only minify
				elseif ( $this->cfg_css_minify ) {
					// will handle async css load inside
					$this->_src_queue_handler( $src_queue_list, $html_list ) ;
				}
				// Only HTTP2 push
				else {
					foreach ( $src_queue_list as $val ) {
						$this->append_http2( $val ) ;
					}
				}
			}
		}

		// Handle css lazy load if not handled async loaded yet
		if ( $this->cfg_css_async && ! $this->cfg_css_minify && ! $this->cfg_css_combine ) {
			// async html
			list( $noscript, $html_list_async ) = $this->_async_css_list( $html_list ) ;

			// add noscript
			$this->html_head .= '<noscript>' . $noscript . '</noscript>' ;

			// Replace async css
			$this->content = str_replace( $html_list, $html_list_async, $this->content ) ;

		}

		// Parse js from buffer as needed
		if ( $this->cfg_js_minify || $this->cfg_js_combine || $this->cfg_http2_js || $this->cfg_js_defer ) {
			list( $src_list, $html_list, $head_src_list ) = $this->_parse_js() ;
		}

		// js optimizer
		if ( $this->cfg_js_minify || $this->cfg_js_combine || $this->cfg_http2_js ) {

			if ( $src_list ) {
				list( $ignored_html, $src_queue_list, $file_size_list ) = $this->_analyse_links( $src_list, $html_list, 'js' ) ;

				// IF combine
				if ( $this->cfg_js_combine ) {
					$enqueue_first = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_JS_COMBINED_PRIORITY ) ;

					// separate head/foot js/raw html
					$head_js = array() ;
					$head_ignored_html = array() ;
					$foot_js = array() ;
					$foot_ignored_html = array() ;
					foreach ( $src_queue_list as $k => $src ) {
						if ( in_array( $src, $head_src_list ) ) {
							$head_js[ $k ] = $src ;
						}
						else {
							$foot_js[ $k ] = $src ;
						}
					}
					foreach ( $ignored_html as $src => $html ) {
						if ( in_array( $src, $head_src_list ) ) {
							$head_ignored_html[ $src ] = $html ;
						}
						else {
							$foot_ignored_html[] = $html ;
						}
					}

					$snippet = '' ;
					if ( $head_js ) {
						$urls = $this->_limit_size_build_hash_url( $head_js, $file_size_list, 'js' ) ;
						foreach ( $urls as $url ) {
							$snippet .= "<script data-optimized='1' src='$url' " . ( $this->cfg_js_defer ? 'defer' : '' ) . "></script>" ;

							// Add to HTTP2
							$this->append_http2( $url, 'js' ) ;
						}
					}
					if ( $this->cfg_js_defer ) {
						$head_ignored_html = $this->_js_defer( $head_ignored_html ) ;
					}

					/**
					 * Enqueue combined file first
					 * @since  1.6
					 */
					if ( $enqueue_first ) {
						// Make jQuery to be the first one
						// Suppose jQuery is in header
						foreach ( $head_ignored_html as $src => $html ) {
							if ( $this->_is_jquery( $src ) ) {
								// jQuery should be always the first one
								$this->html_head .= $html ;
								unset( $head_ignored_html[ $src ] ) ;
								break ;
							}
						}
						$this->html_head .= $snippet . implode( '', $head_ignored_html ) ;
					}
					else {
						$this->html_head .= implode( '', $head_ignored_html ) . $snippet ;
					}

					$snippet = '' ;
					if ( $foot_js ) {
						$urls = $this->_limit_size_build_hash_url( $foot_js, $file_size_list, 'js' ) ;
						foreach ( $urls as $url ) {
							$snippet .= "<script data-optimized='1' src='$url' " . ( $this->cfg_js_defer ? 'defer' : '' ) . "></script>" ;

							// Add to HTTP2
							$this->append_http2( $url, 'js' ) ;
						}
					}
					if ( $this->cfg_js_defer ) {
						$foot_ignored_html = $this->_js_defer( $foot_ignored_html ) ;
					}

					// enqueue combined file first
					if ( $enqueue_first ) {
						$this->html_foot .= $snippet . implode( '', $foot_ignored_html ) ;
					}
					else {
						$this->html_foot .= implode( '', $foot_ignored_html ) . $snippet ;
					}

					// Will move all js to top/bottom
					$this->content = str_replace( $html_list, '', $this->content ) ;

				}
				// Only minify
				elseif ( $this->cfg_js_minify ) {
					// Will handle js defer inside
					$this->_src_queue_handler( $src_queue_list, $html_list, 'js' ) ;
				}
				// Only HTTP2 push
				else {
					foreach ( $src_queue_list as $val ) {
						$this->append_http2( $val, 'js' ) ;
					}
				}
			}
		}

		// Handle js defer if not handled defer yet
		if ( $this->cfg_js_defer && ! $this->cfg_js_minify && ! $this->cfg_js_combine ) {
			// defer html
			$html_list2 = $this->_js_defer( $html_list ) ;

			// Replace async js
			$this->content = str_replace( $html_list, $html_list2, $this->content ) ;
		}


		// Append async compatibility lib to head
		if ( $this->cfg_css_async ) {
			$css_async_lib_url = LiteSpeed_Cache_Utility::get_permalink_url( self::CSS_ASYNC_LIB ) ;
			$this->html_head .= "<script src='" . $css_async_lib_url . "' " . ( $this->cfg_js_defer ? 'defer' : '' ) . "></script>" ;// Don't exclude it from defer for now
			$this->append_http2( $css_async_lib_url, 'js' ) ; // async lib will be http/2 pushed always
		}

		// Replace html head part
		$this->html_head = apply_filters( 'litespeed_optm_html_head', $this->html_head ) ;
		if ( $this->html_head ) {
			$this->content = preg_replace( '#<head([^>]*)>#isU', '<head$1>' . $this->html_head , $this->content, 1 ) ;
		}

		// Replace html foot part
		$this->html_foot = apply_filters( 'litespeed_optm_html_foot', $this->html_foot ) ;
		if ( $this->html_foot ) {
			$this->content = str_replace( '</body>', $this->html_foot . '</body>' , $this->content ) ;
		}

		// HTML minify
		if ( $this->cfg_html_minify ) {
			$ori = $this->content ;

			set_error_handler( 'litespeed_exception_handler' ) ;
			try {
				litespeed_load_vendor() ;
				$this->content = Minify_HTML::minify( $this->content ) ;
				$this->content .= '<!-- Page optimized by LiteSpeed Cache on '.date('Y-m-d H:i:s').' -->' ;

			} catch ( ErrorException $e ) {
				LiteSpeed_Cache_Log::debug( 'Error when optimizing HTML: ' . $e->getMessage() ) ;
				error_log( 'LiteSpeed Optimizer optimizing HTML Error: ' . $e->getMessage() ) ;
				// If failed to minify HTML, restore original content
				$this->content = $ori ;
			}
			restore_error_handler() ;

		}

		if ( $this->http2_headers ) {
			@header( 'Link: ' . implode( ',', $this->http2_headers ), false ) ;
		}

	}

	/**
	 * Limit combined filesize when build hash url
	 *
	 * @since  1.3
	 * @access private
	 */
	private function _limit_size_build_hash_url( $src_queue_list, $file_size_list, $file_type = 'css' )
	{
		$total = 0 ;
		$i = 0 ;
		$src_arr = array() ;
		foreach ( $src_queue_list as $k => $v ) {

			empty( $src_arr[ $i ] ) && $src_arr[ $i ] = array() ;

			$src_arr[ $i ][] = $v ;

			$total += $file_size_list[ $k ] ;

			if ( $total > 1000000 ) { // If larger than 1M, separate them
				$total = 0;
				$i ++ ;
			}
		}
		if ( count( $src_arr ) > 1 ) {
			LiteSpeed_Cache_Log::debug( 'Optimizer: separate ' . $file_type . ' to ' . count( $src_arr ) ) ;
		}

		// group build
		$hashed_arr = array() ;
		foreach ( $src_arr as $v ) {
			$hashed_arr[] = $this->_build_hash_url( $v, $file_type ) ;
		}

		return $hashed_arr ;
	}

	/**
	 * Run minify with src queue list
	 *
	 * @since  1.2.2
	 * @access private
	 */
	private function _src_queue_handler( $src_queue_list, $html_list, $file_type = 'css' )
	{
		$noscript = '' ;
		$html_list_ori = $html_list ;

		$tag = $file_type === 'css' ? 'link' : 'script' ;
		foreach ( $src_queue_list as $key => $src ) {
			$url = $this->_build_hash_url( $src, $file_type ) ;
			$snippet = str_replace( $src, $url, $html_list[ $key ] ) ;
			$snippet = str_replace( "<$tag ", "<$tag data-optimized='1' ", $snippet ) ;

			$html_list[ $key ] = $snippet ;

			// Add to HTTP2
			$this->append_http2( $url, $file_type ) ;
		}

		// Handle css async load
		if ( $file_type === 'css' && $this->cfg_css_async ) {
			list( $noscript, $html_list ) = $this->_async_css_list( $html_list ) ;
			$this->html_head .= '<noscript>' . $noscript . '</noscript>' ;
		}

		// Handle js defer
		if ( $file_type === 'js' && $this->cfg_js_defer ) {
			$html_list = $this->_js_defer( $html_list ) ;
		}

		$this->content = str_replace( $html_list_ori, $html_list, $this->content ) ;
	}

	/**
	 * Check that links are internal or external
	 *
	 * @since  1.2.2
	 * @access private
	 * @return array Array(Ignored raw html, src needed to be handled list, filesize for param 2nd )
	 */
	private function _analyse_links( $src_list, $html_list, $file_type = 'css' )
	{
		if ( $file_type == 'css' ) {
			$excludes = apply_filters( 'litespeed_cache_optimize_css_excludes', LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_CSS_EXCLUDES ) ) ;
		}
		else {
			$excludes = apply_filters( 'litespeed_cache_optimize_js_excludes', LiteSpeed_Cache::config( LiteSpeed_Cache_Config::OPID_JS_EXCLUDES ) ) ;
		}
		if ( $excludes ) {
			$excludes = explode( "\n", $excludes ) ;
		}

		$ignored_html = array() ;
		$src_queue_list = array() ;
		$file_size_list = array() ;

		// Analyse links
		foreach ( $src_list as $key => $src ) {
			LiteSpeed_Cache_Log::debug2( 'Optm: ' . $src ) ;

			if ( $excludes ) {
				foreach ( $excludes as $exclude ) {
					if ( stripos( $src, $exclude ) !== false ) {
						$ignored_html[] = $html_list[ $key ] ;
						LiteSpeed_Cache_Log::debug2( 'Optm:    Abort excludes: ' . $exclude ) ;
						continue 2 ;
					}
				}
			}

			// Check if has no-optimize attr
			if ( strpos( $html_list[ $key ], 'data-no-optimize' ) !== false ) {
				$ignored_html[] = $html_list[ $key ] ;
				LiteSpeed_Cache_Log::debug2( 'Optm:    Abort excludes: attr data-no-optimize' ) ;
				continue ;
			}

			// Check if is external URL
			$url_parsed = parse_url( $src ) ;
			if ( ! $file_info = LiteSpeed_Cache_Utility::is_internal_file( $src ) ) {
				$ignored_html[ $src ] = $html_list[ $key ] ;
				LiteSpeed_Cache_Log::debug2( 'Optm:    Abort external/non-exist' ) ;
				continue ;
			}

			/**
			 * Check if exclude jQuery or not
			 * Exclude from minify/combine
			 * @since  1.5
			 */
			if ( $this->cfg_exc_jquery && $this->_is_jquery( $src ) ) {
				$ignored_html[ $src ] = $html_list[ $key ] ;
				LiteSpeed_Cache_Log::debug2( 'Optm:    Abort jQuery by setting' ) ;

				// Add to HTTP2 as its ignored but still internal src
				$this->append_http2( $src, 'js' ) ;

				continue ;
			}

			$src_queue_list[ $key ] = $src ;
			$file_size_list[ $key ] = $file_info[ 1 ] ;
		}

		return array( $ignored_html, $src_queue_list, $file_size_list ) ;
	}

	/**
	 * Run minify process and return final content
	 *
	 * @since  1.2.2
	 * @access private
	 * @return string The final content
	 */
	private function _minify( $filename )
	{
		// Search filename in db for src URLs
		$urls = LiteSpeed_Cache_Data::optm_hash2src( $filename ) ;
		if ( ! $urls || ! is_array( $urls ) ) {
			return false;
		}

		$file_type = substr( $filename, strrpos( $filename, '.' ) + 1 ) ;

		// Parse real file path
		$real_files = array() ;
		foreach ( $urls as $url ) {
			$real_file = LiteSpeed_Cache_Utility::is_internal_file( $url ) ;
			if ( ! $real_file ) {
				continue ;
			}
			$real_files[] = $real_file[ 0 ] ;
		}

		if ( ! $real_files ) {
			return false;
		}

		// Request to minify
		$result = $this->_minify_serve( $real_files, $file_type ) ;

		if ( empty( $result[ 'success' ] ) ) {
			LiteSpeed_Cache_Log::debug( 'Optm:    Lib serve failed ' . $result[ 'statusCode' ] ) ;
			return false ;
		}

		LiteSpeed_Cache_Log::debug( 'Optm:    Generated content' ) ;

		return $result ;
	}

	/**
	 * Generate full URL path with hash for a list of src
	 *
	 * @since  1.2.2
	 * @access private
	 * @return string The final URL
	 */
	private function _build_hash_url( $src, $file_type = 'css' )
	{
		if ( ! $src ) {
			return false ;
		}

		if ( ! is_array( $src ) ) {
			$src = array( $src ) ;
		}
		$src = array_values( $src ) ;

		$hash = md5( serialize( $src ) ) ;

		$short = substr( $hash, -5 ) ;

		$filename = $short ;

		// Need to check conflicts
		// If short hash exists
		if ( $urls = LiteSpeed_Cache_Data::optm_hash2src( $short . '.' . $file_type ) ) {
			// If conflicts
			if ( $urls !== $src ) {
				LiteSpeed_Cache_Data::optm_save_src( $hash . '.' . $file_type, $src ) ;
				$filename = $hash ;
			}
		}
		else {
			// Short hash is safe now
			LiteSpeed_Cache_Data::optm_save_src( $short . '.' . $file_type, $src ) ;
		}

		$file_to_save = self::DIR_MIN . '/' . $filename . '.' . $file_type ;

		return LiteSpeed_Cache_Utility::get_permalink_url( $file_to_save ) ;
	}

	/**
	 * Parse js src
	 *
	 * @since  1.2.2
	 * @access private
	 * @return array  All the src & related raw html list
	 */
	private function _parse_js()
	{
		$src_list = array() ;
		$html_list = array() ;
		$head_src_list = array() ;

		$content = preg_replace( '#<!--.*-->#sU', '', $this->content ) ;
		preg_match_all( '#<script \s*([^>]+)>\s*</script>|</head>#isU', $content, $matches, PREG_SET_ORDER ) ;
		$is_head = true ;
		foreach ( $matches as $match ) {
			if ( $match[ 0 ] === '</head>' ) {
				$is_head = false ;
				continue ;
			}
			$attrs = LiteSpeed_Cache_Utility::parse_attr( $match[ 1 ] ) ;

			if ( ! empty( $attrs[ 'data-optimized' ] ) ) {
				continue ;
			}
			if ( empty( $attrs[ 'src' ] ) ) {
				continue ;
			}

			// to avoid multiple replacement
			if ( in_array( $match[ 0 ], $html_list ) ) {
				continue ;
			}

			$src_list[] = $attrs[ 'src' ] ;
			$html_list[] = $match[ 0 ] ;

			if ( $is_head ) {
				$head_src_list[] = $attrs[ 'src' ] ;
			}
		}

		return array( $src_list, $html_list, $head_src_list ) ;
	}

	/**
	 * Parse css src and remove to-be-removed css
	 *
	 * @since  1.2.2
	 * @access private
	 * @return array  All the src & related raw html list
	 */
	private function _handle_css()
	{
		$this->css_to_be_removed = apply_filters( 'litespeed_optm_css_to_be_removed', $this->css_to_be_removed ) ;

		$src_list = array() ;
		$html_list = array() ;

		// $dom = new PHPHtmlParser\Dom ;
		// $dom->load( $content ) ;return $val;
		// $items = $dom->find( 'link' ) ;

		$content = preg_replace( '#<!--.*-->#sU', '', $this->content ) ;
		preg_match_all( '#<link \s*([^>]+)/?>#isU', $content, $matches, PREG_SET_ORDER ) ;
		foreach ( $matches as $match ) {
			$attrs = LiteSpeed_Cache_Utility::parse_attr( $match[ 1 ] ) ;

			if ( empty( $attrs[ 'rel' ] ) || $attrs[ 'rel' ] !== 'stylesheet' ) {
				continue ;
			}
			if ( ! empty( $attrs[ 'data-optimized' ] ) ) {
				continue ;
			}
			if ( ! empty( $attrs[ 'data-no-optimize' ] ) ) {
				continue ;
			}
			if ( ! empty( $attrs[ 'media' ] ) && strpos( $attrs[ 'media' ], 'print' ) !== false ) {
				continue ;
			}
			if ( empty( $attrs[ 'href' ] ) ) {
				continue ;
			}

			// Check if need to remove this css
			if ( $this->css_to_be_removed && LiteSpeed_Cache_Utility::str_hit_array( $attrs[ 'href' ], $this->css_to_be_removed ) ) {
				LiteSpeed_Cache_Log::debug( 'Optm: rm css snippet ' . $attrs[ 'href' ] ) ;
				// Delete this css snippet from orig html
				$this->content = str_replace( $match[ 0 ], '', $this->content ) ;
				continue ;
			}

			// to avoid multiple replacement
			if ( in_array( $match[ 0 ], $html_list ) ) {
				continue ;
			}

			$src_list[] = $attrs[ 'href' ] ;
			$html_list[] = $match[ 0 ] ;
		}

		return array( $src_list, $html_list ) ;
	}

	/**
	 * Replace css to async loaded css
	 *
	 * @since  1.3
	 * @access private
	 * @param  array $html_list Orignal css array
	 * @return array            array( (string)noscript, (array)css_async_list )
	 */
	private function _async_css_list( $html_list )
	{
		$noscript = '' ;
		foreach ( $html_list as $k => $ori ) {
			if ( strpos( $ori, 'data-asynced' ) !== false ) {
				LiteSpeed_Cache_Log::debug2( 'Optm bypass: attr data-asynced exist' ) ;
				continue ;
			}

			if ( strpos( $ori, 'data-no-async' ) !== false ) {
				LiteSpeed_Cache_Log::debug2( 'Optm bypass: attr api data-no-async' ) ;
				continue ;
			}

			// Append to noscript content
			$noscript .= $ori ;
			// async replacement
			$v = str_replace( 'stylesheet', 'preload', $ori ) ;
			$v = str_replace( '<link', "<link data-asynced='1' as='style' onload='this.rel=\"stylesheet\"' ", $v ) ;
			$html_list[ $k ] = $v ;
		}
		return array( $noscript, $html_list ) ;
	}

	/**
	 * Add defer to js
	 *
	 * @since  1.3
	 * @access private
	 */
	private function _js_defer( $html_list )
	{
		foreach ( $html_list as $k => $v ) {
			if ( strpos( $v, 'async' ) !== false ) {
				continue ;
			}
			if ( strpos( $v, 'defer' ) !== false ) {
				continue ;
			}
			if ( strpos( $v, 'data-deferred' ) !== false ) {
				LiteSpeed_Cache_Log::debug2( 'Optm bypass: attr data-deferred exist' ) ;
				continue ;
			}
			if ( strpos( $v, 'data-no-defer' ) !== false ) {
				LiteSpeed_Cache_Log::debug2( 'Optm bypass: attr api data-no-defer' ) ;
				continue ;
			}

			/**
			 * Parse src for excluding js from setting
			 * @since 1.5
			 */
			if ( $this->cfg_js_defer_exc || $this->cfg_exc_jquery ) {
				// parse js src
				preg_match( '#<script \s*([^>]+)>#isU', $v, $matches ) ;
				if ( empty( $matches[ 1 ] ) ) {
					LiteSpeed_Cache_Log::debug( 'Optm: js defer parse html failed: ' . $v ) ;
					continue ;
				}

				$attrs = LiteSpeed_Cache_Utility::parse_attr( $matches[ 1 ] ) ;

				if ( empty( $attrs[ 'src' ] ) ) {
					LiteSpeed_Cache_Log::debug( 'Optm: js defer parse src failed: ' . $matches[ 1 ] ) ;
					continue ;
				}

				$src = $attrs[ 'src' ] ;
			}

			/**
			 * Exclude js from setting
			 * @since 1.5
			 */
			if ( $this->cfg_js_defer_exc ) {

				if ( LiteSpeed_Cache_Utility::str_hit_array( $src, $this->cfg_js_defer_exc ) ) {
					LiteSpeed_Cache_Log::debug( 'Optm: js defer exclude ' . $src ) ;
					continue ;
				}
			}

			/**
			 * Check if exclude jQuery
			 * @since  1.5
			 */
			if ( $this->cfg_exc_jquery && $this->_is_jquery( $src ) ) {
				LiteSpeed_Cache_Log::debug2( 'Optm:   js defer Abort jQuery by setting' ) ;
				continue ;
			}

			$html_list[ $k ] = str_replace( '></script>', ' defer data-deferred="1"></script>', $v ) ;
		}

		return $html_list ;
	}

	/**
	 * Check if is jq lib
	 *
	 * @since  1.5
	 * @access private
	 */
	private function _is_jquery( $src )
	{
		return stripos( $src, 'jquery.js' ) !== false || stripos( $src, 'jquery.min.js' ) !== false ;
	}

	/**
	 * Append to HTTP2 header
	 *
	 * @since  1.2.2
	 * @access private
	 */
	private function append_http2( $url, $file_type = 'css' )
	{
		if ( ! ( $file_type === 'css' ? $this->cfg_http2_css : $this->cfg_http2_js ) ) {
			return ;
		}

		/**
		 * For CDN enabled ones, bypass http/2 push
		 * @since  1.6.2.1
		 */
		if ( LiteSpeed_Cache_CDN::inc_type( $file_type ) ) {
			return ;
		}

		/**
		 * Keep QS for constance by set 2nd param to true
		 * @since  1.6.2.1
		 */
		$uri = LiteSpeed_Cache_Utility::url2uri( $url, true ) ;

		if ( ! $uri ) {
			return ;
		}

		$this->http2_headers[] = '<' . $uri . '>; rel=preload; as=' . ( $file_type === 'css' ? 'style' : 'script' ) ;
	}

	/**
	 * Run minify serve
	 *
	 * @since  1.2.2
	 * @access private
	 * @param array|string $files The file(s) to minify/combine
	 * @return  string The string after effect
	 */
	private function _minify_serve( $files, $file_type )
	{
		set_error_handler( 'litespeed_exception_handler' ) ;
		try {
			litespeed_load_vendor() ;
			if ( ! isset( $this->minify_cache ) ) {
				$this->minify_cache = new Minify_Cache_File() ;
			}
			if ( ! isset( $this->minify_minify ) ) {
				$this->minify_minify = new Minify( $this->minify_cache ) ;
			}
			if ( ! isset( $this->minify_env ) ) {
				$this->minify_env = new Minify_Env() ;
			}
			if ( ! isset( $this->minify_sourceFactory ) ) {
				$this->minify_sourceFactory = new Minify_Source_Factory( $this->minify_env, array(), $this->minify_cache ) ;
			}
			if ( ! isset( $this->minify_controller ) ) {
				$this->minify_controller = new Minify_Controller_Files( $this->minify_env, $this->minify_sourceFactory ) ;
			}
			if ( ! isset( $this->minify_options ) ) {
				$this->minify_options = array(
					'encodeOutput' => false,
					'quiet' => true,
				) ;
			}

			$this->minify_options[ 'concatOnly' ] =  ! ( $file_type === 'css' ? $this->cfg_css_minify : $this->cfg_js_minify ) ;

			$this->minify_options[ 'files' ] = $files ;

			$content = $this->minify_minify->serve( $this->minify_controller, $this->minify_options ) ;

		} catch ( ErrorException $e ) {
			LiteSpeed_Cache_Log::debug( 'Error when serving from optimizer: ' . $e->getMessage() ) ;
			error_log( 'LiteSpeed Optimizer serving Error: ' . $e->getMessage() ) ;
			return false ;
		}
		restore_error_handler() ;

		return $content ;
	}

	/**
	 * Get the current instance object.
	 *
	 * @since 1.2.2
	 * @access public
	 * @return Current class instance.
	 */
	public static function get_instance()
	{
		if ( ! isset(self::$_instance) ) {
			self::$_instance = new self() ;
		}

		return self::$_instance ;
	}

}



