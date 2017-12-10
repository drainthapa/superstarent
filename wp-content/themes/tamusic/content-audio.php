<?php
/**
 * @package TA Music
 */
?>

<div class="album-banner">
<?php if ( has_post_thumbnail() ) : ?>
	<div class="banner-image">
		<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
	</div>
<?php endif; ?>

	<div class="col-sm-9 album-title">
		<h1><?php the_title(); ?></h1>
		<p><?php _e( 'Artist: ', 'ta-music' ); ?><?php the_author_posts_link(); ?></p>
		<p><?php _e( 'Release Date: ', 'ta-music' ); ?><?php echo get_post_meta( $post->ID, '_cmb_album_date', true ); ?></p>
	</div><!-- .album-title -->
	<div class="col-sm-3 album-btns">
	<?php if ( get_post_meta( $post->ID, '_cmb_buy_link', true ) ) { ?>
		<h5><?php _e( 'This album is now available on', 'ta-music' ); ?></h5>
		<ul class="btns">
		<?php
			$links = get_post_meta( $post->ID, '_cmb_buy_link', true );
			foreach ( $links as $link ) :
		?>
			<li><a href="<?php if ( !empty( $link['btn_url'] ) ) { echo $link['btn_url']; } ?>"><?php if ( !empty( $link['btn_title'] ) ) { echo $link['btn_title']; } ?></a></li>
		<?php endforeach; ?>
	<?php } ?>
	</div><!-- .album-btns -->
</div><!-- #album-banner -->

<div class="album-info">
	<div class="col-xs-12 col-md-9 col-md-offset-1">
		<h3><?php _e( 'Album Description', 'ta-music'); ?></h3>
		<?php
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ta-music' ),
				'after'  => '</div>',
				)
			);
		?>
		
		<!-- tracks -->
		<div id="songs">
		<?php if ( get_post_meta( $post->ID, '_cmb_album_embed', true ) != '' ) { ?>
			<?php echo '<h4>' . __( 'Album Tracks', 'ta-music') . '</h4>'; ?>
		<?php } else if ( get_post_meta( $post->ID, '_cmb_album_tracks', true ) ) { ?>
			<?php
				$num = count( get_post_meta( $post->ID, '_cmb_album_tracks', true ) );
				if ( $num == 1 ) {
					echo '<h4>' . __( 'Album Tracks', 'ta-music' ) . '<span>' . $num . ' '.  __( 'Tracks In Total', 'ta-music' ) . '</span></h4>';
				} else {
					echo '<h4>' . __( 'Album Tracks', 'ta-music' ) . '<span>' . $num . ' '.  __( 'Tracks In Total', 'ta-music' ) . '</span></h4>';
				}
			?>
		<?php } ?>

			<!-- embed album playlist -->
			<?php if ( get_post_meta( $post->ID, '_cmb_album_embed', true ) != '' ) {
				echo get_post_meta( $post->ID, '_cmb_album_embed', true );
			} ?>

			<ul class="songs">
				<?php
					$tracks = get_post_meta( $post->ID, '_cmb_album_tracks', true );
					if ( !empty($tracks) ) {
						$i = 1;
						foreach ( $tracks as $track ) {
				?>
				<li>
					<div class="track-nr"><?php echo $i; ?></div>
					<div class="track-meta">
					<?php
						if ( !empty( $track['track_url'] ) ) {
							$audio_id = get_audio_id( $track['track_url'] );
							$audio_title = get_the_title( $audio_id );
							$audio_desc = get_post_field( 'post_content', $audio_id );
						}
					?>
						<?php if ( $audio_title != '' ) { echo '<h5>' . $audio_title . '</h5>'; } ?>
						<p><?php if ( $audio_desc != '' ) { echo $audio_desc; } ?></p>
					</div>

					<audio src="<?php if ( !empty( $track['track_url'] ) ) { echo $track['track_url']; } ?>" preload="auto"></audio>

					<?php if ( ( isset ( $track['track_download'] ) && $track['track_download'] == true ) || !empty( $track['track_buy'] ) ) { ?>
					<ul class="track-btns">
						<?php if ( isset ( $track['track_download'] ) && $track['track_download'] == true ) { ?>
						<li><a href="<?php if ( !empty( $track['track_url'] ) ) { echo $track['track_url']; } ?>" class="download-track"><?php _e( 'Download Track', 'ta-music' ); ?></a></li>
						<?php } ?>
						<?php if ( !empty( $track['track_buy'] ) ) { ?>
						<li><a href="<?php echo $track['track_buy']; ?>" class="buy-track"><?php _e( 'Buy Track', 'ta-music' ); ?></a></li>
						<?php } ?>
					</ul>
					<?php } ?>
				</li>
				<?php
						$i++;
						}
					}
				?>
			</ul><!-- .songs -->
		</div><!-- #songs -->
	</div>
</div><!-- .album-info -->

<!-- latest albums -->
<div class="col-sm-12 clearfix">
	<h2><?php _e( 'Latest', 'ta-music' ); ?> <span><?php _e( 'Albums', 'ta-music' ); ?></span></h2>
	<?php
		$args = array(
			'post_type'    => 'post',
			'showposts'    => 4,
			'post_status'  => 'publish',
			'has_password' => false,
			'post__not_in' => array( get_the_ID() ),
			'tax_query'    => array(
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-audio' ),
				),
			),
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		// the loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<div class="col-sm-6 col-md-3 album">
		<div class="latest-content">
			<a href="<?php echo get_permalink(); ?>">
				<div class="latest-content-image">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
					} ?>
				</div>

				<div class="latest-content-info">
					<div class="meta">
						<div class="icon">
							<i class="fa fa-headphones"></i>
						</div>
						<h4><?php the_title(); ?></h4>
						<p><?php echo strip_tags( get_the_tag_list( '', ', ', '' ) ); ?></p>
					</div>
				</div><!-- .latest-content-info -->
			</a>
		</div><!-- .latest-content -->
	</div><!-- .album -->

	<?php
		endwhile;
		// end of the loop
		wp_reset_postdata();
		endif;
	?>
</div>