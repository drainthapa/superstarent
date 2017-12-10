<?php global $SMTheme; ?>

	<?php if ( $SMTheme->layout == 6 ) $style=" style='float:left'"; else $style='';?>
	
	<div class='sidebar right clearfix'<?php echo $style;?>>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Right Sidebar") ) {
			;
		} ?>
	</div><!-- ddd-->