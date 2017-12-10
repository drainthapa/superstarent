<?php 
	global $SMTheme;
	
	get_header(); 
?>
			<h1 class="page-title"><?php echo $SMTheme->_( 'errortext' ); ?></h1>
			<?php echo $SMTheme->_( 'errorsolution' ); ?>
<?php
	get_footer();
?>