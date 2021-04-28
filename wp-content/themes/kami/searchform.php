<form method="get" id="searchform" action="<?php echo get_home_url(); ?>">
    <div class="searchform-wrap">
        <input type="text" name="s" id="s" value="<?php _e( 'Search', 'bkninja' ); ?>" onfocus='if (this.value == "<?php _e( 'Search', 'bkninja' ); ?>") { this.value = ""; }' onblur='if (this.value == "") { this.value = "<?php _e( 'Search', 'bkninja' ); ?>"; }'/>
    <div class="search-icon">
        <i class="fa fa-search"></i>
    </div>
    </div>
</form>