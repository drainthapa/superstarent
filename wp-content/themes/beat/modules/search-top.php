<div class="left-col pull-left clearfix">
    <div class="search-box clearfix">
        <form action="<?php echo esc_url(trailingslashit(home_url())); ?>" class="search-form pull-left clearfix" method="get">
            <input type="text" onBlur="if (this.value == '')
                this.value = this.defaultValue;" onFocus="if (this.value == this.defaultValue)
                this.value = '';" value="<?php esc_attr_e('Search', 'beat-mix-lite') ?>" name="s" class="search-text">
            <button type="submit" class="search-submit"><i class="fa fa-search"></i>
            </button>
        </form>
        <!-- search-form -->
    </div>
    <!--search-box-->
</div>
<!-- left-col -->