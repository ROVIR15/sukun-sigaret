<?php
global $meta_boxes;
if ( ! isset( $meta_boxes ) ) {
	$meta_boxes = array();
}

add_action( 'after_setup_theme', 'bk_setup_meta_boxes' );
function bk_setup_meta_boxes() {
	add_action( 'admin_init', 'bk_register_meta_boxes' );
}

/* -----------------------------------------------------------------------------
 * Register meta boxes
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_register_meta_boxes' ) ) {
	function bk_register_meta_boxes() {
		global $meta_boxes;

		$page_sidebars = bk_get_registered_sidebars();

		/* -----------------------------------------------------------------------------
		 * Post Options
		 * -------------------------------------------------------------------------- */
		$meta_boxes[] = array(
			'id' => 'bk_page_options',
			'title' => __( 'Post Options', 'bkninja' ),
			'pages' => array( 'post' ),
			'fields' => array(
				array(
					'name' => __( 'Make this post featured', 'bkninja' ),
					'id' => 'bk_post_featured',
					'type' => 'checkbox',
				),
				array(
					'name' => __( 'Post Layout', 'bkninja' ),
					'id' => 'bk_post_layout',
					'desc' => __( 'Choose the post layout.' , 'bkninja' ),
					'type' => 'select',
					'std' => 'right',
					'options' => array(
						'right' => __( 'Right Sidebar', 'bkninja' ),
						'fullwidth' => __( 'Full Width', 'bkninja' ),
					),
				),
			)
		);

		/* -----------------------------------------------------------------------------
		 * Page Options
		 * -------------------------------------------------------------------------- */
		$meta_boxes[] = array(
			'id' => 'bk_page_options',
			'title' => __( 'Page Options', 'bkninja' ),
			'pages' => array( 'page' ),
			'fields' => array(
				array(
					'name' => __( 'Page Subtitle', 'bkninja' ),
					'id' => 'bk_page_subtitle',
					'type' => 'text',
				),
				array(
					'name' => __( 'Sidebar Position', 'bkninja' ),
					'id' => 'bk_page_sidebar_position',
					'desc' => __( 'Choose the sidebar position.' , 'bkninja' ),
					'type' => 'select',
					'std' => 'right',
					'options' => array(
						'hidden' => __( 'Hidden', 'bkninja' ),
						'left' => __( 'Left Sidebar', 'bkninja' ),
						'right' => __( 'Right Sidebar', 'bkninja' ),
					),
				),
				array(
					'name' => __( 'Sidebar', 'bkninja' ),
					'id' => 'bk_page_sidebar',
					'desc' => __( 'You can edit the Default Page Sidebar at Theme Options page (General &gt; Default Sidebar For Pages).' , 'bkninja' ),
					'type' => 'select',
					'options' => $page_sidebars,
				),
			)
		);

		/* -----------------------------------------------------------------------------
		 * Review Meta Box
		 * -------------------------------------------------------------------------- */
		$meta_boxes[] = array(
			'id' => 'bk_review',
			'title' => __( 'Review Options', 'bkninja' ),
			'pages' => array( 'post' ),
			'fields' => array(
				array(
					'name' => __( 'Enable Review', 'bkninja' ),
					'id' => 'bk_enable_review',
					'type' => 'checkbox',
				),
				array(
					'name' => __( 'Review Summary', 'bkninja' ),
					'id' => 'bk_review_summary',
					'class' => 'field-review-summary',
					'type' => 'textarea',
				),
				array(
					'name' => __( 'Review Score', 'bkninja' ),
					'id' => 'bk_review_scores',
					'class' => 'field-review-score',
					'type' => 'review_score',
				),
			)
		);

		/* -----------------------------------------------------------------------------
		 * Post Formats
		 * -------------------------------------------------------------------------- */
		$meta_boxes[] = array(
			'id' => 'bk_post_format_gallery',
			'title' => __( 'Gallery Post Options', 'bkninja' ),
			'pages' => array( 'post' ),
			'fields' => array(
				array(
					'name' => __( 'Gallery Images', 'bkninja' ),
					'id' => 'bk_post_format_gallery_images',
					'type' => 'image_advanced',
				),
			)
		);

		$meta_boxes[] = array(
			'id' => 'bk_post_format_audio',
			'title' => __( 'Audio Post Options', 'bkninja' ),
			'pages' => array( 'post' ),
			'fields' => array(
				array(
					'name' => __( 'Sound Cloud Audio Source', 'bkninja' ),
					'id' => 'bk_post_format_audio_oembed',
					'type' => 'oembed',
					'desc' => 'Paste page URL from SoundCloud',
				),
			)
		);

		$meta_boxes[] = array(
			'id' => 'bk_post_format_video',
			'title' => __( 'Video Post Options', 'bkninja' ),
			'pages' => array( 'post' ),
			'fields' => array(
				array(
					'name' => __( 'Video Source', 'bkninja' ),
					'id' => 'bk_post_format_video_oembed',
					'type' => 'oembed',
					'desc' => 'Paste page URL from YouTube, Vimeo.',
				),
			)
		);

		// Make sure there's no errors when the plugin is deactivated or during upgrade
		if ( class_exists( 'RW_Meta_Box' ) ) {
			foreach ( $meta_boxes as $meta_box ) {
				new RW_Meta_Box( $meta_box );
			}
		}
	}
}

if ( ! function_exists( 'bk_get_registered_sidebars' ) ) {
	function bk_get_registered_sidebars() {
		$page_sidebars = array();
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$page_sidebars[ $sidebar['id'] ] = $sidebar['name'];
		}

		return $page_sidebars;
	}
}