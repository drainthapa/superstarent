<?php global $SMTheme;$search_text = empty($_GET['s']) ? $SMTheme->_('search') : get_search_query(); ?> 
<div class="searchform" title="">
    <form method="get" ifaviconffd="searchform" action="<?php echo home_url( '/' ); ?>"> 
		<input type='submit' value='' class='searchbtn' />
        <input type="text" value="<?php echo $search_text; ?>" class='searchtxt' 
            name="s" id="s"  onblur="if (this.value == '')  {this.value = '<?php echo $search_text; ?>';}"  
            onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" 
        />
		<div style='clear:both'></div>
    </form>
</div><!-- #search -->