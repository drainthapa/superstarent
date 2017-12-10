<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=3.4.1"></script>  
<script type="text/javascript" src="/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script>
	jQuery('.input').live('click', function() {
		var shortcode_value = 's';
		var shortcode='<div class="highlight '+jQuery(this).attr('alt')+'"><div class="inner"><p><?php echo ($_GET['txt'])?$_GET['txt']:'Text'?></p></div></div>';
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
	.input {
		display:block;
		width:64px;
		height:64px;
		cursor:pointer;
	}
	.input.red {
		background:url(<?php echo $_GET['url'];?>/../images/smt/highlight-red.png) left top no-repeat;
	}
	.input.green {
		background:url(<?php echo $_GET['url'];?>/../images/smt/highlight-green.png) left top no-repeat;
	}
	.input.yellow {
		background:url(<?php echo $_GET['url'];?>/../images/smt/highlight-yellow.png) left top no-repeat;
	}
	.input.blue {
		background:url(<?php echo $_GET['url'];?>/../images/smt/highlight-blue.png) left top no-repeat;
	}
</style>
<table><tr>
<td><span class='input red' alt='red'></span></td>
<td><span class='input green' alt='green'></span></td>
<td><span class='input yellow' alt='yellow'></span></td>
<td><span class='input blue' alt='blue'></span></td>
</tr></table>