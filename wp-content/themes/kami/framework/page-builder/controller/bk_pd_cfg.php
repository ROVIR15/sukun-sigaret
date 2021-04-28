<?php
/* 
 * Sections Configuration
 */
if ( ! function_exists( 'bk_init_sections' ) ) {
	function bk_init_sections() {
		$sections = array(
            'fullwidth'=>__('FullWidth Section','bkninja'), 'has-rsb' => __('Content Section', 'bkninja'), 'has-innersb'=>__('Content Section with Small Sidebar','bkninja')
		);
		wp_localize_script( 'bk-page-builder-js', 'bk_sections', $sections );
        $modules = array(
            'mainslider' => array(
				'title' => __( 'BK Slider (Feature Module)', 'bkninja' ),
				'options' => array(
                    'number' => array(
						'title' => __( 'Number of posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
                    'feature' => array(
						'title' => __('Display featured posts', 'bkninja'),
                        'description' => __( 'Yes: Display featured posts', 'bkninja' ),
						'field' => 'select',
						'default' => 'yes',
						'options' => array(
							'yes' => __( 'Yes', 'bkninja' ),
							'no' => __( 'No', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'grid' => array(
				'title' => __( 'BK Grid (Feature Module)', 'bkninja' ),
				'options' => array(
                    'number' => array(
						'title' => __('Number of posts (Required at least 6 posts)','bkninja'),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 6,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
                    'feature' => array(
						'title' => __('Display featured posts', 'bkninja' ),
                        'description' => __( 'Yes: Display featured posts', 'bkninja' ),
						'field' => 'select',
						'default' => 'yes',
						'options' => array(
							'yes' => __( 'Yes', 'bkninja' ),
							'no' => __( 'No', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja'),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'grid_w_ajax' => array(
				'title' => __( 'BK Ajax Grid', 'bkninja' ),
				'options' => array(
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja'),
						'description' => __( 'Choose a post category to be shown up (Need at least 5 posts to work properly)', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),
            'row' => array(
				'title' => __( 'BK Row', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Rows', 'bkninja' ),
						'description' => __( 'Enter the number of post rows', 'bkninja' ),
						'field' => 'number',
						'default' => 1
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),
            'row_wbg' => array(
				'title' => __( 'BK Row With Background (Feature Module)', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
                    'text_color' => array(
						'title' => __('Text Color', 'bkninja' ),
						'description' => __( 'Choose Text Color', 'bkninja' ),
						'field' => 'color',
						'default' => '',
					),
                    'background_color' => array(
						'title' => __('Background Color', 'bkninja' ),
						'description' => __( 'Choose Background Color', 'bkninja' ),
						'field' => 'color',
						'default' => '',
					),
                    'feature' => array(
						'title' => __('Display featured posts', 'bkninja' ),
                        'description' => __( 'Yes: Display featured posts', 'bkninja' ),
						'field' => 'select',
						'default' => 'yes',
						'options' => array(
							'yes' => __( 'Yes', 'bkninja' ),
							'no' => __( 'No', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'windows' => array(
				'title' => __( 'BK Windows', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of rows', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 2,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
                    'columns' => array(
						'title' => __('Choose layout', 'bkninja' ),
						'field' => 'select',
						'default' => 'left',
						'options' => array(
							'two_cols' => __( '2 Columns', 'bkninja' ),
							'three_cols' => __( '3 Columns', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
                    ),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),  
            'small_pieces' => array(
				'title' => __( 'BK Small Pieces', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number of posts', 'bkninja' ),
						'field' => 'number',
						'default' => 12
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'custom_html' => array(
				'title' => __( 'BK Custom HTML (New)', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'custom_html' => array(
						'title' => __('HTML Code', 'bkninja' ),
						'description' => __( 'Put your custom HTML code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'ads' => array(
				'title' => __( 'BK Single Ad', 'bkninja' ),
				'options' => array(
                    'image_url' => array(
						'title' => __('Image Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url' => array(
						'title' => __('Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'two_col_ads' => array(
				'title' => __( 'BK Two Col Ads', 'bkninja' ),
				'options' => array(
                    'image_url1' => array(
						'title' => __('Image Url - (First Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url1' => array(
						'title' => __('Url - (First Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'image_url2' => array(
						'title' => __('Image Url - (Last Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url2' => array(
						'title' => __('Url - (Last Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'three_col_ads' => array(
				'title' => __( 'BK Three Col Ads', 'bkninja' ),
				'options' => array(
                    'image_url1' => array(
						'title' => __('Image Url - (First Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url1' => array(
						'title' => __('Url - (First Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'image_url2' => array(
						'title' => __('Image Url - (Middle Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url2' => array(
						'title' => __('Url - (Middle Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'image_url3' => array(
						'title' => __('Image Url - (Last Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url3' => array(
						'title' => __('Url - (Last Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'adsense' => array(
				'title' => __( 'BK Adsense', 'bkninja' ),
				'options' => array(
                    'adsense_code' => array(
						'title' => __('Adsense Code','bkninja' ),
						'description' => __( 'Put your adsense code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
            ),
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_fullwidth_modules', $modules );
        $modules = array(
			'1l_2m_side' => array(
				'title' => __( 'BK 1l and 2m side', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'main_post_position' => array(
						'title' => __('Main Post Position','bkninja' ),
						'field' => 'select',
						'default' => 'left',
						'options' => array(
							'left' => __( 'Left', 'bkninja' ),
							'right' => __( 'Right', 'bkninja' ),
						),
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),  
            
            'blog_small' => array(
				'title' => __( 'BK Blog Small', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
            ),
            'large_blog' => array(
				'title' => __( 'BK Large Blog', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
            ),
            '1l_list_side' => array(
				'title' => __( 'BK 1l and list Side', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),  
            'row_2cols' => array(
				'title' => __( 'BK Row', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Rows','bkninja' ),
						'description' => __( 'Enter the number of post rows', 'bkninja' ),
						'field' => 'number',
						'default' => 1
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			), 
            'windows' => array(
				'title' => __( 'BK Windows', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of rows','bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 2,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
                    ),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),  
            'block_one' => array(
				'title' => __( 'BK Block One (New)', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'offset_1' => array(
						'title' => __('Offset (Column 1)', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order_1' => array(
						'title' => __('Order (Column 1)', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category_1' => array(
						'title' => __('Category (Column 1)', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
                    ),
                    'offset_2' => array(
						'title' => __('Offset (Column 2)', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order_2' => array(
						'title' => __('Order (Column 2)', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category_2' => array(
						'title' => __('Category (Column 2)', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
                    ),
				),
			),
            'block_two' => array(
				'title' => __( 'BK Block Two (New)', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
                    ),
				),
			),  
            'custom_html' => array(
				'title' => __( 'BK Custom HTML (New)', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'custom_html' => array(
						'title' => __('HTML Code', 'bkninja' ),
						'description' => __( 'Put your custom HTML code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'two_col_ads' => array(
				'title' => __( 'BK Two Col Ads', 'bkninja' ),
				'options' => array(
                    'image_url1' => array(
						'title' => __('Image Url - (First Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url1' => array(
						'title' => __('Url - (First Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'image_url2' => array(
						'title' => __('Image Url - (Last Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url2' => array(
						'title' => __('Url - (Last Column)','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),            
            'ads' => array(
				'title' => __( 'BK Ads', 'bkninja' ),
				'options' => array(
                    'image_url' => array(
						'title' => __('Image Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url' => array(
						'title' => __('Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'adsense' => array(
				'title' => __( 'BK Adsense', 'bkninja' ),
				'options' => array(
                    'adsense_code' => array(
						'title' => __('Adsense Code','bkninja' ),
						'description' => __( 'Put your adsense code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
            ),
                     
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_has_rsb_modules', $modules );
        $modules = array(
            'row_2cols' => array(
				'title' => __( 'BK Row', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Rows','bkninja' ),
						'description' => __( 'Enter the number of post rows', 'bkninja' ),
						'field' => 'number',
						'default' => 1
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			), 
            'windows' => array(
				'title' => __( 'BK Windows', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of rows','bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 2,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
                    ),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
			),  
            'blog_small' => array(
				'title' => __( 'BK Blog Small', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
            ),
            'large_blog' => array(
				'title' => __( 'BK Large Blog', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
                    'ajax_load' => array(
						'title' => __('Ajax Load', 'bkninja' ),
                        'description' => __( 'Enable/Disable Ajax Load for this module', 'bkninja' ),
						'field' => 'select',
						'default' => 'disable',
						'options' => array(
							'enable' => __( 'Enable', 'bkninja' ),
							'disable' => __( 'Disable', 'bkninja' ),
						),
					),
				),
            ),
            'custom_html' => array(
				'title' => __( 'BK Custom HTML (New)', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => __('Sub Title', 'bkninja' ),
						'description' => __( 'The module subtitle', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'custom_html' => array(
						'title' => __('HTML Code', 'bkninja' ),
						'description' => __( 'Put your custom HTML code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'ads' => array(
				'title' => __( 'BK Ads', 'bkninja' ),
				'options' => array(
                    'image_url' => array(
						'title' => __('Image Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url' => array(
						'title' => __('Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'adsense' => array(
				'title' => __( 'BK Adsense', 'bkninja' ),
				'options' => array(
                    'adsense_code' => array(
						'title' => __('Adsense Code','bkninja' ),
						'description' => __( 'Put your adsense code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
            ),
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_has_innersb_left_modules', $modules );
        $modules = array(
            'most_commented' => array(
				'title' => __( 'BK Most Commented', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'latest' => array(
				'title' => __( 'BK Latest', 'bkninja' ),
				'options' => array(
                    'title' => array(
						'title' => __('Title', 'bkninja' ),
						'description' => __( 'The Module title', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'number' => array(
						'title' => __('Number of Posts', 'bkninja' ),
						'description' => __( 'Enter the number', 'bkninja' ),
						'field' => 'number',
						'default' => 5,
					),  
                    'offset' => array(
						'title' => __('Offset', 'bkninja' ),
						'description' => __( 'Enter the offset number', 'bkninja' ),
						'field' => 'number',
						'default' => 0
					),      
                    'order' => array(
						'title' => __('Order', 'bkninja' ),
                        'description' => __( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'bkninja' ),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => __( 'Latest', 'bkninja' ),
							'rand' => __( 'Random', 'bkninja' ),
						),
					),      
					'category' => array(
						'title' => __('Category', 'bkninja' ),
						'description' => __( 'Choose a post category to be shown up', 'bkninja' ),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),            
            'ads' => array(
				'title' => __( 'BK Ads', 'bkninja' ),
				'options' => array(
                    'image_url' => array(
						'title' => __('Image Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					),
                    'url' => array(
						'title' => __('Url','bkninja' ),
						'description' => __( '', 'bkninja' ),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'adsense' => array(
				'title' => __( 'BK Adsense', 'bkninja' ),
				'options' => array(
                    'adsense_code' => array(
						'title' => __('Adsense Code','bkninja' ),
						'description' => __( 'Put your adsense code here', 'bkninja' ),
						'field' => 'textarea',
						'default' => '',
					),
				),
            ),
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_has_innersb_right_modules', $modules );
	}
}