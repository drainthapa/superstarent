<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=3.4.1"></script>  
<script type="text/javascript" src="/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script>
	jQuery('.cols').live('click', function() {
		var shortcode_value = 's';
		var shortcode='';
		switch(jQuery(this).attr('alt')) {
			case '2':
				shortcode='<div class="cols"><div class="two">Column #1</div><div class="two">Column #2</div></div>';
				break;
			case '3':
				shortcode='<div class="cols"><div class="three">Column #1</div><div class="three">Column #2</div><div class="three">Column #3</div></div>';
				break;
			case 'propleft':
				shortcode='<div class="cols"><div class="prop">Column #1</div><div class="propfirst">Column #2</div></div>';
				break;
			case 'propright':
				shortcode='<div class="cols"><div class="propfirst">Column #1</div><div class="prop">Column #2</div></div>';
				break;
		}
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, shortcode ) ;
	    tinyMCEPopup.close();
	});
</script>
<style>
	table {
		width:100%;
	}
	table td{
		text-align:center;
	}
	table tr {
		height:40px;
	}
	.cols {
		width:113px;
		height:101px;
		cursor:pointer;
		display:block;
	}
	.cols2 {
		background:url(<?php echo $_GET['url'];?>/../inc/images/cols2.png) left top no-repeat;
	}
	.cols3 {
		background:url(<?php echo $_GET['url'];?>/../inc/images/cols3.png) left top no-repeat;
	}
	.cols4 {
		background:url(<?php echo $_GET['url'];?>/../inc/images/cols4.png) left top no-repeat;
	}
	.colsprop {
		background:url(<?php echo $_GET['url'];?>/../inc/images/colsprop.png) left top no-repeat;
	}
</style>
<table><tr>
<td><span class='cols cols2' alt='2'></span></td>
<td><span class='cols cols3' alt='3'></span></td>
<td><span class='cols cols4' alt='propleft'></span></td>
<td><span class='cols colsprop' alt='propright'></span></td>
</tr></table>