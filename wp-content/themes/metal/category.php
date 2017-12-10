<?php 
	global $SMTheme;
	
	get_header();
?>

			<h1 class="page-title"><?php printf( $SMTheme->_( 'catarchive' ), single_cat_title( '', false ) ); ?></h1>
				
			<?php get_template_part('theloop'); ?>
			
			<?php get_template_part('navigation'); ?>
        
<?php
	get_footer();
?>