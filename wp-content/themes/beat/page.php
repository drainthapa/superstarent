<?php

get_header();

?>
<div class="elements-box">

<?php
if (have_posts()):	
	while (have_posts()) : the_post();					
	?> 

	<article <?php post_class('entry-item'); ?>>

		<?php the_content(); ?>

		<?php get_template_part('modules/single/paged'); ?>

	</article> 

	<?php endwhile; ?>
	
<?php endif; ?>

</div>

<?php comments_template(); ?>

<?php
get_footer();