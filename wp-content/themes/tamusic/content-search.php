<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package TA Music
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post'); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

		<div class="post-meta">
			<?php ta_music_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="post-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<div class="entry-footer post-meta">
		<?php ta_music_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-## -->