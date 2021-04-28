/* -----------------------------------------------------------------------------
 * Page Template Meta-box
 * -------------------------------------------------------------------------- */
;(function( $, window, document, undefined ){
	"use strict";
	
	$( document ).ready( function () {
        $('.textarea-animated').autosize();
        $('#bk_feature_image_position').parents('.rwmb-field').wrap('<div class="feat_img_pos"></div>');
        $('#bk_parallax').parents('.rwmb-field').wrap('<div class="feat_img_parallax"></div>');
        
        var bk_post_fullwidth_checkbox = $('#bk_post_fullwidth_checkbox'),
            feat_img_pos = $('.feat_img_pos'),
            feat_img_parallax = $('.feat_img_parallax');
            
        if (bk_post_fullwidth_checkbox.attr("checked")) {
            feat_img_pos.hide();
            feat_img_parallax.slideDown();
        }else {
            feat_img_pos.show();
            if ($('#bk_feature_image_position').val() == 'content') {
                feat_img_parallax.slideUp();
            }else {
                feat_img_parallax.slideDown();
            }
        }
        
        bk_post_fullwidth_checkbox.click(function(){
            if ($(this).attr("checked")) {
                feat_img_pos.slideUp();
                feat_img_parallax.slideDown();
            }else {
                feat_img_pos.slideDown();
                if ($('#bk_feature_image_position').val() == 'content') {
                    feat_img_parallax.slideUp();
                }else {
                    feat_img_parallax.slideDown();
                }
            }
            
        });
        
        /*
         * show paralax option if Fullwidth enabled
         */
         $('#bk_feature_image_position').change( function() {
            if ($(this).val() == 'content') {
                feat_img_parallax.slideUp();
            }else {
                feat_img_parallax.slideDown();
            }
         }).triggerHandler( 'change' );
		/* -----------------------------------------------------------------------------
		 * Page template
		 * -------------------------------------------------------------------------- */
		$( '#page_template' ).change( function() {
			var template = $( '#page_template' ).val();

			// Page Composer Template
			if ( 'page_builder.php' == template ) {
				
				$.page_builder( 'show' );
				$( '#bk_page_options' ).hide();

			} else {
				$.page_builder( 'hide' );
				$( '#bk_page_options' ).show();
			}
		} ).triggerHandler( 'change' );

		// -----------------------------------------------------------------------------
		// Fitvids - keep video ratio
		// 
//		$( '.postbox .embed-code' ).fitVids( { customSelector: "iframe[src*='maps.google.'], iframe[src*='soundcloud.']" });
        /*
        $(function() {
            $( ".datepicker" ).datepicker();
            $('.timepicker').timepicker({
                minuteStep: 5,
                showInputs: false,
                disableFocus: true
            });
         });
         */
        $(function() {
            if ($('input[name=post_format]:checked', '#post-formats-select').val() == 0) {
                $("#bk_format_options").hide();
            }else {
                var value = $('input[name=post_format]:checked', '#post-formats-select').val(); 
                $("#bk_format_options").show();
                if (value == "gallery"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "block");
                }else if ((value == "video")||(value == "audio")){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                }else if (value == "image"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                }
            }
            $('#post-formats-select input').on('change', function() { 
                var value = $('input[name=post_format]:checked', '#post-formats-select').val(); 
                if (value == 0){
                    $("#bk_format_options").hide();
                }else {
                    $("#bk_format_options").show();
                } 
                if (value == "gallery"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "block");
                }else if ((value == "video")||(value == "audio")){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                }else if (value == "image"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                }
            });
        });
	} );
})( jQuery, window , document );
/* -----------------------------------------------------------------------------
 * UUID
 * https://github.com/eburtsev/jquery-uuid/blob/master/jquery-uuid.js
 * -------------------------------------------------------------------------- */
;(function( $, window, document, undefined ){
	$.uuid = function() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
			return v.toString(16);
		});
	};
})( jQuery, window , document );
