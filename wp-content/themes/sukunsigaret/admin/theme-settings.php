<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){

//Theme Shortname
$shortname = "r3";


//Populate the options array
global $tt_options;
$tt_options = get_option('of_options');


//Access the WordPress Pages via an Array
$tt_pages = array();
$tt_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($tt_pages_obj as $tt_page) {
$tt_pages[$tt_page->ID] = $tt_page->post_name; }
$tt_pages_tmp = array_unshift($tt_pages, "Select a page:"); 


//Access the WordPress Categories via an Array
$tt_categories = array();  
$tt_categories_obj = get_categories('hide_empty=0');
foreach ($tt_categories_obj as $tt_cat) {
$tt_categories[$tt_cat->cat_ID] = $tt_cat->cat_name;}
$categories_tmp = array_unshift($tt_categories, "Select a category:");


//Sample Array for demo purposes
$sample_array = array("1","2","3","4","5");


//Sample Advanced Array - The actual value differs from what the user sees
$sample_advanced_array = array("image" => "The Image","post" => "The Post"); 


//Folder Paths for "type" => "images"
$sampleurl =  get_template_directory_uri() . '/admin/images/sample-layouts/';


/*-----------------------------------------------------------------------------------*/
/* Create The Custom Site Options Panel
/*-----------------------------------------------------------------------------------*/
$options = array(); // do not delete this line - sky will fall

$options[] = array( "name" => __('General Settings','framework_localize'),
			"type" => "heading");
			

$options[] = array( "name" => __('Website Logo','framework_localize'),
			"desc" => __('Upload a custom logo for your Website. File size : 327px × 118px','framework_localize'),
			"id" => $shortname."_sitelogo",
			"std" => get_bloginfo('template_directory') . "/img/logo.jpg",
			"type" => "upload");
			
			
$options[] = array( "name" => __('Favicon','framework_localize'),
			"desc" => __('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="http://www.favicon.cc/">www.favicon.cc</a>)</em>','framework_localize'),
			"id" => $shortname."_favicon",
			"std" => "",
			"type" => "upload");
			
									   
$options[] = array( "name" => __('Tracking Code','framework_localize'),
			"desc" => __('Paste Google Analytics (or other) tracking code here.','framework_localize'),
			"id" => $shortname."_google_analytics",
			"std" => "",
			"type" => "textarea");
			
$options[] = array( "name" => __('Homepage Settings','framework_localize'),
			"type" => "heading");
			
$options[] = array( "name" => __('Newsletter Title','framework_localize'),
			"desc" => __('Newsletter Opt-in title.','framework_localize'),
			"id" => $shortname."_newsletter_title",
			"std" => "Sign up for latest update via email",
			"type" => "text");

$options[] = array( "name" => __('Testimonial Title','framework_localize'),
			"desc" => __('Testimonial Section header title.','framework_localize'),
			"id" => $shortname."_testimonial_title",
			"std" => "What people are saying about Chris",
			"type" => "text");

$options[] = array( "name" => __('Home Page','framework_localize'),
			"desc" => __('Homepage.','framework_localize'),
			"id" => $shortname."_homepage",
			"std" => "",
			"type" => "select",
			"options" => $tt_pages);

$options[] = array( "name" => __('Gambar Rokok Nusantara','framework_localize'),
			"desc" => __('Upload Gambar untuk Rokok Nusantara','framework_localize'),
			"id" => $shortname."_gbrokoknusantara",
			"std" => get_bloginfo('template_directory') . "/img/bg-filler-nusantara.jpg",
			"type" => "upload");
			
$options[] = array( "name" => __('CTA Link','framework_localize'),
			"desc" => __('Call to action link.','framework_localize'),
			"id" => $shortname."_ctalink",
			"std" => "",
			"type" => "select",
			"options" => $tt_pages);
			
$options[] = array( "name" => __('Youtube Video ID','framework_localize'),
			"desc" => __('Youtube Video ID.','framework_localize'),
			"id" => $shortname."_youtube",
			"std" => "",
			"type" => "text");
			
$options[] = array( "name" => __('Social Media','framework_localize'),
			"type" => "heading");
			
$options[] = array( "name" => __('<i class=fa fa-facebook></i> Facebook','framework_localize'),
			"desc" => __('Facebook URL.','framework_localize'),
			"id" => $shortname."_fb",
			"std" => "https://www.facebook.com",
			"type" => "text");
			
$options[] = array( "name" => __('Twitter','framework_localize'),
			"desc" => __('Twitter Account.','framework_localize'),
			"id" => $shortname."_twitter",
			"std" => "https://twitter.com/",
			"type" => "text");
			
$options[] = array( "name" => __('Youtube Channel','framework_localize'),
			"desc" => __('Youtube Channel URL.','framework_localize'),
			"id" => $shortname."_youtube_ch",
			"std" => "https://www.youtube.com/user/",
			"type" => "text");

$options[] = array( "name" => __('Instagram','framework_localize'),
			"desc" => __('Instagram URL.','framework_localize'),
			"id" => $shortname."_instagram",
			"std" => "https://www.instagram.com/",
			"type" => "text");

$options[] = array( "name" => __('Pinterest','framework_localize'),
			"desc" => __('Pinterest URL.','framework_localize'),
			"id" => $shortname."_pinterest",
			"std" => "https://www.pinterest.com/",
			"type" => "text");

$options[] = array( "name" => __('Google Plus','framework_localize'),
			"desc" => __('Google Plus URL.','framework_localize'),
			"id" => $shortname."_googleplus",
			"std" => "https://plus.google.com/",
			"type" => "text");

$options[] = array( "name" => __('LinkedIn','framework_localize'),
			"desc" => __('LinkedIn URL.','framework_localize'),
			"id" => $shortname."_linkedin",
			"std" => "https://www.linkedin.com/",
			"type" => "text");

update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>