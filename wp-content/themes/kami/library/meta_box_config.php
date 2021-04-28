<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'bk_';

global $meta_boxes;

$meta_boxes = array();

// Post Layout Options
$meta_boxes[] = array(
    'id' => "{$prefix}post_fullwidth",
    'title' => __( 'BK Post Option', 'bkninja' ),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'low',

    'fields' => array(
        array(
            'name' => __( 'Make this post full-width (Without sidebar)', 'bkninja' ),
            'id' => "{$prefix}post_fullwidth_checkbox",
            'type' => 'checkbox',
            'std'  => 0,
        ),
        array(
			'id' => "{$prefix}feature_image_position",
            'name' => __( 'Feature Image position', 'bkninja' ),
			'desc' => __('Setup feature image display in fullwidth section or content section', 'bkninja'),
            'type' => 'select', 
			'options'  => array(
                            'content' => __( 'Content', 'bkninja' ),
        					'fullwidth' => __( 'Fullwidth', 'bkninja' ),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'content',
		),
        array(
			'id' => "{$prefix}parallax",
            'name' => __( 'Parallax Enable', 'bkninja' ),
			'desc' => __('Enable/Disable Parallax feature', 'bkninja'),
            'type' => 'select', 
			'options'  => array(
                            'disable' => __( 'Disable', 'bkninja' ),
        					'enable' => __( 'Enable', 'bkninja' ),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'disable',
		),
        array(
			'id'=>"{$prefix}post_title_align",
            'name' => __( 'Title align center or left on single post', 'bkninja' ),
			'desc' => __( 'Title align center or left on Single Page', 'bkninja'),
            'type' => 'select', 
			'options'  => array(
        					'left' => __( 'Left', 'bkninja' ),
        					'center' => __( 'Center', 'bkninja' ),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'left',
		),
        array(
			'id' => "{$prefix}post_title_position",
            'name' => __( 'Post title position', 'bkninja' ),
			'desc' => __('Setup post title display at above or below feature image', 'bkninja'),
            'type' => 'select', 
			'options'  => array(
        					'above' => __( 'Above', 'bkninja' ),
        					'below' => __( 'Below', 'bkninja' ),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'above',
		),
    )
);
// 2nd meta box
$meta_boxes[] = array(
    'id' => "{$prefix}format_options",
    'title' => __( 'BK Post Format Options', 'bkninja' ),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',
	'fields' => array(        
        //Video
        array(
            'name' => __( 'Format Options: Video, Audio', 'bkninja' ),
            'desc' => __('Support Youtube, Vimeo, SoundCloud, DailyMotion, ... iframe embed code', 'bkninja'),
            'id' => "{$prefix}media_embed_code_post",
            'type' => 'textarea',
            'placeholder' => __('Link ...', 'bkninja'),
            'std' => ''
        ),
		// PLUPLOAD IMAGE UPLOAD (WP 3.3+)
		array(
			'name'             => __( 'Format Options: Image', 'bkninja' ),
            'desc'             => __('Image Upload', 'bkninja'),
			'id'               => "{$prefix}image_upload",
			'type'             => 'plupload_image',
			'max_file_uploads' => 1,
		),
        //Gallery
        array(
            'name' => __( 'Format Options: Gallery', 'bkninja' ),
            'desc' => __('Gallery Images', 'bkninja'),
            'id' => "{$prefix}gallery_content",
            'type' => 'image_advanced',
            'std' => ''
        )
    )
);
// Post Review Options
$meta_boxes[] = array(
    'id' => "{$prefix}review",
    'title' => __( 'BK Review System', 'bkninja' ),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',

    'fields' => array(
        // Enable Review
        array(
            'name' => __( 'Include Review Box', 'bkninja' ),
            'id' => "{$prefix}review_checkbox",
            'type' => 'checkbox',
            'desc' => __( 'Enable Review On This Post', 'bkninja' ),
            'std'  => 0,
        ),
        // Criteria 1 Text & Score
        array(
            'name'  => __( 'Criteria 1 Title', 'bkninja' ),
            'id'    => "{$prefix}ct1",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'Criteria 1 Score', 'bkninja' ),
            'id' => "{$prefix}cs1",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10,
                'step'  => .1,
            ),
        ),
        // Criteria 2 Text & Score
        array(
            'name'  => __( 'Criteria 2 Title', 'bkninja' ),
            'id'    => "{$prefix}ct2",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'Criteria 2 Score', 'bkninja' ),
            'id' => "{$prefix}cs2",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10,
                'step'  => .1,
            ),
        ),    
        // Criteria 3 Text & Score
        array(
            'name'  => __( 'Criteria 3 Title', 'bkninja' ),
            'id'    => "{$prefix}ct3",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'Criteria 3 Score', 'bkninja' ),
            'id' => "{$prefix}cs3",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10,
                'step'  => .1,
            ),
        ),
        // Criteria 4 Text & Score
        array(
            'name'  => __( 'Criteria 4 Title', 'bkninja' ),
            'id'    => "{$prefix}ct4",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'Criteria 4 Score', 'bkninja' ),
            'id' => "{$prefix}cs4",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10,
                'step'  => .1,
            ),
        ),
        // Criteria 5 Text & Score
        array(
            'name'  => __( 'Criteria 5 Title', 'bkninja' ),
            'id'    => "{$prefix}ct5",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'Criteria 5 Score', 'bkninja' ),
            'id' => "{$prefix}cs5",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10,
                'step'  => .1,
            ),
        ),    
        // Criteria 6 Text & Score
        array(
            'name'  => __( 'Criteria 6 Title', 'bkninja' ),
            'id'    => "{$prefix}ct6",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'Criteria 6 Score', 'bkninja' ),
            'id' => "{$prefix}cs6",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10,
                'step'  => .1,
            ),
        ),
        // Summary
        array(
            'name' => __( 'Summary', 'bkninja' ),
            'id'   => "{$prefix}summary",
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 4,
        ),
        
        // Final average
        array(
            'name'  => __('Final Average Score','bkninja'),
            'id'    => "{$prefix}final_score",
            'type'  => 'text',
        ),
        array(
            'name' => __( 'User Rating', 'bkninja' ),
            'id' => "{$prefix}user_rating",
            'type' => 'checkbox',
            'desc' => __( 'Enable User Rating On This Post', 'bkninja' ),
            'std'  => 0,
        ),
        array(
			'id' => "{$prefix}review_box_position",
            'name' => __( 'Review Box Position', 'bkninja' ),
			'desc' => __('Setup review post position [left-content, right-content, above-content, below-content]', 'bkninja'),
            'type' => 'select', 
			'options'  => array(
        					'left' => __( 'Left', 'bkninja' ),
        					'right' => __( 'Right', 'bkninja' ),
                            'above' => __( 'Above', 'bkninja' ),
                            'below' => __( 'Below', 'bkninja' ),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'left',
		),

    )
);
/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
if ( ! function_exists( 'bk_register_meta_boxes' ) ) {
    function bk_register_meta_boxes() {
    	// Make sure there's no errors when the plugin is deactivated or during upgrade
    	if ( !class_exists( 'RW_Meta_Box' ) )
    		return;
    
    	global $meta_boxes;
    	foreach ( $meta_boxes as $meta_box )
    	{
    		new RW_Meta_Box( $meta_box );
    	}
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'bk_register_meta_boxes' );
