<?php
/**
 * @package TA Music
 */
?>

<div class="col-sm-6 col-md-4 col-lg-3 grid-item">
	<article id="post-<?php the_ID(); ?>" class="recent-post grid-post">
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
			<header class="entry-header">
				<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

				<div class="post-meta">
					<span class="date"><i class="fa fa-calendar"></i><?php echo get_the_date( 'M j, Y' ); ?></span>
					<?php
						if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
							echo '<span class="comments"><i class="fa fa-comments"></i>';
							comments_popup_link( __( 'No Comment', 'ta-music' ), __( '1 Comment', 'ta-music' ), __( '% Comments', 'ta-music' ) );
							echo '</span>';
						}
					?>
				</div>
			</header><!-- .entry-header -->

			<?php if( has_excerpt() ) {
				the_excerpt();
			} else {
				echo '<p>' . trim_characters( get_the_content() ) . '</p>';
			} ?>

			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e( 'Read More', 'ta-music' ); ?> <i class="fa fa-angle-double-right read-more-icon"></i></a>
			<?php $category = get_the_category(); ?>
			<div class="post-meta">
				<span class="tags"><i class="fa fa-tag"></i><a href="<?php echo get_category_link( $category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a></span>
			</div>
		</div><!-- .post-content -->
	</article><!-- #grid-post -->
</div><!-- .grid-item -->