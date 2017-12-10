<?php
/**
 * @package TA Music
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="post-meta">
			<?php ta_music_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<!-- Post format begin -->
	<?php if( get_post_format() ) {
		get_template_part( 'inc/post-formats' );
	} elseif ( has_post_thumbnail() ) { ?>
		<div class="post-image">
			<a href="<?php echo get_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'full', array( 'class' => "img-responsive" ) ); ?></a>
		</div>
	<?php } ?>
	<!-- Post format end -->

	<div class="post-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ta-music' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

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