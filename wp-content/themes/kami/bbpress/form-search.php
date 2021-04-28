<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" id="bbp-search-form" class="searchform" action="<?php bbp_search_url(); ?>">
	<div class="search-wrap">
		<label class="screen-reader-text hidden" for="bbp_search"><?php _e( 'Search for:', 'bbpress' ); ?></label>
		<input type="hidden" name="action" value="bbp-search-request" />
		<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php _e( 'Forum Search', 'bkninja'); ?>" onfocus='if (this.value == "<?php _e( 'Forum Search', 'bkninja' ); ?>") { this.value = ""; }' onblur='if (this.value == "") { this.value = "<?php _e( 'Forum Search', 'bkninja' ); ?>"; }' name="bbp_search" id="bbp_search" />
		<!-- <input tabindex="<?php bbp_tab_index(); ?>" class="search-button" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Forum Search', 'bbpress' ); ?>" /> -->
		<div class="search-icon">
            <i class="fa fa-search"></i>
        </div>
		
	</div>
</form>