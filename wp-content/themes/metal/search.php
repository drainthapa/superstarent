<?php 
	global $SMTheme;
	
	get_header();
	
?>
			<h1 class='page-title'><?php echo sprintf($SMTheme->_('searchresults'),get_search_query()); ?></h1>
			<?php
			
				if (!have_posts()) { ?>
					<div class="entry">
					<p><?php echo $SMTheme->_( 'nothingfound' )?></p>
					</div>
				<?php }
				
				get_template_part('theloop'); 
				
			?>
			
			<?php get_template_part('navigation'); ?>
		
<?php
	get_footer();
?>