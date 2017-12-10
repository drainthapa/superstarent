<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package TA Music
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="post-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ta-music' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .post-content -->

	<div class="entry-footer post-meta">
		<?php ta_music_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post -->
