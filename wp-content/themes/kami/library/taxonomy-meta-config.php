<?php
/**
 * Registering meta sections for taxonomies
 *
 * All the definitions of meta sections are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value.
 *
 * You also should read the changelog to know what has been changed
 *
 */

// Hook to 'admin_init' to make sure the class is loaded before
// (in case using the class in another plugin)
add_action( 'admin_init', 'bk_taxonomy_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function bk_taxonomy_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Taxonomy_Meta' ) )
		return;
    global $bk_option;
        if ( isset($bk_option) && isset($bk_option['bk-primary-color'])) {
            $primary_color = $bk_option['bk-primary-color'];
        }else {
            $primary_color = '';
        }
	$meta_sections = array();

	// First meta section
	$meta_sections[] = array(
		'title'      => __('BK Category Options','bkninja'),             // section title
		'taxonomies' => array('category', 'post_tag'), // list of taxonomies. Default is array('category', 'post_tag'). Optional
		'id'         => 'bk_cat_opt',                 // ID of each section, will be the option name

		'fields' => array(                             // List of meta fields
			// SELECT
            array(
				'name'    => __('Category title','bkninja'),
				'id'      => 'cat_title',
				'type'    => 'select',
				'options' => array( 'global' => __('Global Setting', 'bkninja'), 
                                    'show'=>__('Show', 'bkninja'), 
                                    'hide'=>__('Hide', 'bkninja'), 
                             ),
                'std' => 'global',
                'desc' => __('Global setting option is set in Theme Option panel','bkninja')
			),
			array(
				'name'    => __('Category layout','bkninja'),
				'id'      => 'cat_layout',
				'type'    => 'select',
				'options' => array(
                                'global' => __('Global Setting', 'bkninja'), 
                                'blog-small'=>__('Blog Small', 'bkninja'), 
                                'large-blog'=>__('Large Blog', 'bkninja'),
                                'windows-2-columns'=>__('Windows 2 columns', 'bkninja'), 
                                'row-2-columns'=>__('Row 2 columns', 'bkninja'),
                                'row-3-columns'=>__('Row 3 columns', 'bkninja'),
                                'windows-3-columns'=>__('Windows 3 columns', 'bkninja'),
                                'windows-2-columns-fullwidth'=>__('Windows 2 columns fullwidth', 'bkninja'),
                                
                            ),
                'std' => 'global',
                'desc' => __('Global setting option is set in Theme Option panel','bkninja')
			),
            array(
				'name'    => __('Category Color','bkninja'),
				'id'      => 'cat_color',
				'type'    => 'color',
                'std' => $primary_color,
                'desc' => __('Category Color setting','bkninja')
			),
            // CHECKBOX
			array(
				'name' => __('Display featured slider','bkninja'),
				'id'   => 'cat_feat',
				'type' => 'checkbox',
			),
            //Background
			array(
				'name' => __('Background','bkninja'),
				'id'   => 'cat_bg_img',
				'type' => 'image',
			),
		),
	);

	foreach ( $meta_sections as $meta_section )
	{
		new RW_Taxonomy_Meta( $meta_section );
	}
}
