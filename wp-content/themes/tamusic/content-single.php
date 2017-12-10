<?php
/**
 * @package TA Music
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

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
			<?php the_post_thumbnail( 'full', array( 'class' => "img-responsive" ) ); ?>
		</div>
	<?php } ?>
	<!-- Post format end -->

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

<div class="author-info">
	<div class="avatar-img">
	<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_avatar', true ) != '' ) { ?>
		<img src="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_avatar', true ); ?>" class="img-responsive" alt="<?php echo get_the_author_meta( 'display_name' ); ?>" />
	<?php } elseif ( function_exists( 'get_avatar' ) ) {
		echo get_avatar( get_the_author_meta( 'ID' ), 150 );
	} ?>
	</div><!-- .avatar -->

	<div class="bio">
		<h5><?php echo get_the_author_meta( 'display_name' ); ?> <span><?php echo ucfirst( get_the_author_meta( 'roles' )[0] ); ?></span></h5>
		<p><?php echo get_the_author_meta( 'description' ); ?></p>
		<ul class="social">
		<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_twitter_url', true ) != '' ) { ?>
			<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_twitter_url', true ); ?>"><i class="fa fa-twitter"></i></a></li>
		<?php } ?>
		<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_facebook_url', true ) != '' ) { ?>
			<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_facebook_url', true ); ?>"><i class="fa fa-facebook"></i></a></li>
		<?php } ?>
		<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_google_plus_url', true ) != '' ) { ?>
			<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_google_plus_url', true ); ?>"><i class="fa fa-google-plus"></i></a></li>
		<?php } ?>
		<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_youtube_url', true ) != '' ) { ?>
			<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_youtube_url', true ); ?>"><i class="fa fa-youtube"></i></a></li>
		<?php } ?>
		<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_soundcloud_url', true ) != '' ) { ?>
			<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_soundcloud_url', true ); ?>"><i class="fa fa-soundcloud"></i></a></li>
		<?php } ?>
		</ul><!-- .social -->
	</div><!-- .bio -->
</div><!-- .author-info -->