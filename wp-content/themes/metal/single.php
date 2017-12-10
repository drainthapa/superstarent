<?php 
	global $SMTheme;
	
	get_header(); 
	
	get_template_part('theloop');
			
	the_tags("<div class='tags'><span>".$SMTheme->_( 'tags' ).":&nbsp;&nbsp;</span>", ", ","</div>");
			
	get_template_part('relatedposts');
			
	comments_template();
			
	get_template_part('navigation');
	
	get_footer();
?>
