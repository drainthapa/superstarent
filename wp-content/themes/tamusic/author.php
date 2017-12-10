<?php
/**
 * The template for displaying artist page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package TA Music
 */

get_header(); ?>

	<!-- breadcrumbs -->
	<section id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
		<div class="container">
		<?php ta_breadcrumbs(); ?>
		</div>
	</section><!-- #breadcrumbs -->

	<section id="tagline">
		<div class="container">
			<h1><?php echo get_the_author_meta( 'display_name' ); ?></h1>
			<h4><?php echo get_the_author_meta( 'description' ); ?></h4>
		</div>
	</section><!-- #tagline -->

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row artist-info">
					<!-- artist info -->
					<div class="col-sm-4 col-md-3">
						<div class="latest-content">
							<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_avatar', true ) != '' ) { ?>
								<div class="latest-content-image">
									<img src="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_avatar', true ); ?>" class="img-responsive" alt="<?php echo get_the_author_meta( 'display_name' ); ?>" />
								</div>
							<?php } ?>

							<div class="latest-content-info">
								<div class="meta">
									<div class="icon">
										<i class="fa fa-user"></i>
									</div>
									<h4><?php echo get_the_author_meta( 'display_name' ); ?></h4>
									<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_artist_skill', true ) != '' ) { ?>
									<p><?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_artist_skill', true ); ?></p>
									<?php } ?>
								</div>
							</div><!-- .latest-content-info -->
						</div><!-- .latest-content -->

						<ul class="share clearfix">
						<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_twitter_url', true ) != '' ) { ?>
							<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_twitter_url', true ); ?>"><i class="fa fa-lg fa-twitter"></i></a></li>
						<?php } ?>
						<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_facebook_url', true ) != '' ) { ?>
							<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_facebook_url', true ); ?>"><i class="fa fa-lg fa-facebook"></i></a></li>
						<?php } ?>
						<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_google_plus_url', true ) != '' ) { ?>
							<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_google_plus_url', true ); ?>"><i class="fa fa-lg fa-google-plus"></i></a></li>
						<?php } ?>
						<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_youtube_url', true ) != '' ) { ?>
							<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_youtube_url', true ); ?>"><i class="fa fa-lg fa-youtube"></i></a></li>
						<?php } ?>
						<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_soundcloud_url', true ) != '' ) { ?>
							<li><a href="<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_soundcloud_url', true ); ?>"><i class="fa fa-lg fa-soundcloud"></i></a></li>
						<?php } ?>
						</ul><!-- .share -->
					</div>

					<div class="col-sm-8 col-md-9">
					<?php if ( get_user_meta( get_the_author_meta( 'ID' ), '_cmb_artist_biography', true ) != '' ) { ?>
						<?php echo get_user_meta( get_the_author_meta( 'ID' ), '_cmb_artist_biography', true ); ?>
					<?php } ?>

					<?php
						$args = array(
							'author'          => get_the_author_meta( 'ID' ),
							'post_type'       => 'post',
							'posts_per_page'  => -1,
							'post_status'     => 'publish',
							'has_password'    => false,
							'tax_query'       => array(
								array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => array( 'post-format-audio' ),
								),
							),
						);

						$the_query = new WP_Query( $args );
						
						if ( $the_query->have_posts() ) {
					?>

						<!-- tracks -->
						<div id="songs">
						<?php
							$num = 0;
							$num_temp= 0;
							while ( $the_query->have_posts() ) : $the_query->the_post();
								if ( get_post_meta( $post->ID, '_cmb_album_tracks', true ) ) {
									$num_temp = count( get_post_meta( $post->ID, '_cmb_album_tracks', true ) );
								}
								$num = $num + $num_temp;
							endwhile;

							if ( $num == 1 ) {
								echo '<h4>' . __( 'Playlist', 'ta-music' ) . '<span>' . $num . ' '.  __( 'Track In Total', 'ta-music' ) . '</span></h4>';
							} elseif ( $num > 1 ) {
								echo '<h4>' . __( 'Playlist', 'ta-music' ) . '<span>' . $num . ' '.  __( 'Tracks In Total', 'ta-music' ) . '</span></h4>';
							}
						?>

						<?php if ( $num >= 1 ) { ?>
							<ul class="songs">
								<?php
									$i = 0;
									while ( $the_query->have_posts() ) : $the_query->the_post();

									$tracks = get_post_meta( $post->ID, '_cmb_album_tracks', true );
									if ( !empty($tracks) ) :
										foreach ( $tracks as $track ) :
										$i++;
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
										endforeach;
									endif;
									endwhile;
									// end of the loop
									wp_reset_postdata();
								?>
							</ul><!-- .songs -->
						<?php } ?>
						</div><!-- #songs -->
						<?php } ?>
					</div>
				</div>

				<!-- featured artists -->
				<h2><?php _e( 'Featured', 'ta-music' ); ?> <span><?php _e( 'Artists', 'ta-music' ); ?></span></h2>
				<div class="row">
				<?php
					$args = array(
						'role'    => 'author',
						'number'  => 4,
						'exclude' => array( get_the_author_meta( 'ID' ) ),
						'orderby' => 'post_count',
						'order'   => 'DESC',
					);
					// The Query
					$artists_query = new WP_User_Query( $args );
					$artists = $artists_query->get_results();

					// User Loop
					foreach ( $artists as $artist ) {
				?>
					<div class="col-sm-6 col-md-3">
						<div class="latest-content">
							<a href="<?php echo get_author_posts_url( $artist->ID ); ?>">
							<?php if ( get_user_meta( $artist->ID, '_cmb_avatar', true ) != '' ) { ?>
								<div class="latest-content-image">
									<img src="<?php echo get_user_meta( $artist->ID, '_cmb_avatar', true ); ?>" class="img-responsive" alt="<?php echo $artist->display_name; ?>" />
								</div>
							<?php } ?>

								<div class="latest-content-info">
									<div class="meta">
										<div class="icon">
											<i class="fa fa-user"></i>
										</div>
										<h4><?php echo $artist->display_name; ?></h4>
										<?php if ( get_user_meta( $artist->ID, '_cmb_artist_skill', true ) != '' ) { ?>
										<p><?php echo get_user_meta( $artist->ID, '_cmb_artist_skill', true ); ?></p>
										<?php } ?>
									</div>
								</div><!-- .latest-content-info -->
							</a>
						</div><!-- .latest-content -->
					</div>
				<?php } ?>
				</div><!-- .row -->
			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>