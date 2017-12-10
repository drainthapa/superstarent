<?php
/**
 * The template for displaying event archive page.
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
			<h1><?php if ( ta_option( 'events_listing_title' ) != '' ) { echo ta_option( 'events_listing_title' ); } ?></h1>
			<h4><?php if ( ta_option( 'events_listing_tagline' ) != '' ) { echo ta_option( 'events_listing_tagline' ); } ?></h4>
		</div>
	</section><!-- #tagline -->

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row">
					<!-- events -->
					<div class="col-md-9">
						<h2>
							<?php _e( 'Upcoming', 'ta-music' ); ?> <span><?php _e( 'Events', 'ta-music' ); ?></span>
							<span class="view">
								<span><?php _e( 'View', 'ta-music' ); ?></span> 
								<?php
									if ( ta_option( 'default_events_style') == '1' ) {
										$event_list = 'current';
										$event_grid = 'inactive';
										$style = 'list';
									} else {
										$event_list = 'inactive';
										$event_grid = 'current';
										$style = 'grid';
									}
								?>
								<a href="#grid" class="<?php echo $event_grid; ?>"><i class="fa fa-lg fa-th"></i></a>
								<a href="#list" class="<?php echo $event_list; ?>"><i class="fa fa-lg fa-list"></i></a>
							</span>
						</h2>

						<?php if ( have_posts() ) : ?>
						<div id="upcoming-events" class="<?php echo $style; ?>-style">
							<?php
								$i = 0;
								$num = $wp_query->post_count;
								while ( have_posts() ) : the_post();
								if( $i % 3 == 0 ) { echo '<div class="row">'; }
							?>
								<div class="col-md-4 event">
									<div class="event-image">
										<div class="event-date">
											<span class="day-of-month"><?php echo date( 'd', strtotime( get_post_meta( $post->ID, '_cmb_event_date', true ) ) ); ?></span>
											<span class="day-of-week"><?php echo date( 'D', strtotime( get_post_meta( $post->ID, '_cmb_event_date', true ) ) ); ?></span>
										</div><!-- .event-date -->
										<?php if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?></a>
										<?php endif; ?>
									</div><!-- .event-image -->

									<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>

									<div class="event-location">
									<?php if ( get_post_meta( $post->ID, '_cmb_event_location', true ) != '' ) { ?>
										<span class="location"><i class="fa fa-map-marker"></i><?php echo get_post_meta( $post->ID, '_cmb_event_location', true ); ?></span>
									<?php } ?>
									<?php if ( get_post_meta( $post->ID, '_cmb_event_time', true ) != '' ) { ?>
										<span class="time"><i class="fa fa-clock-o"></i><?php echo get_post_meta( $post->ID, '_cmb_event_time', true ); ?></span>
									</div>
									<?php } ?>

									<?php if( has_excerpt() ) {
										the_excerpt();
									} else {
										echo '<p>' . trim_characters( get_the_content() ) . '</p>';
									} ?>
									<a href="<?php echo get_permalink(); ?>" class="learn-more"><?php _e( 'Learn More', 'ta-music' ); ?></a>
								</div><!-- .event -->
							<?php
								$i++;
								if( $i % 3 == 0 || ( $i == $num && $num % 3 !== 0 ) ) { echo '</div><!-- .row -->'; }
								endwhile;
							?>
						</div><!-- #upcoming-events -->

						<?php ta_pagination(); ?>

						<?php else : ?>
							<?php get_template_part( 'content', 'none' ); ?>
						<?php endif; ?>
					</div>

					<!-- sidebar -->
					<div class="col-md-3">
						<h2><?php _e( 'Latest', 'ta-music' ); ?> <span><?php _e( 'Videos', 'ta-music' ); ?></span></h2>
						<?php
							$args = array(
								'post_type'    => 'post',
								'showposts'    => 1,
								'post_status'  => 'publish',
								'has_password' => false,
								'tax_query'    => array(
									array(
										'taxonomy' => 'post_format',
										'field'    => 'slug',
										'terms'    => array( 'post-format-video' ),
									),
								),
							);
							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) : $the_query->the_post();
						?>
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
											<i class="fa fa-video-camera"></i>
										</div>
										<h4><?php the_title(); ?></h4>
										<?php if ( get_post_meta( $post->ID, '_cmb_post_location', true ) != '' ) { ?>
											<p><?php echo '@' . get_post_meta( $post->ID, '_cmb_post_location', true ); ?></p>
										<?php } else { ?>
											<p><?php echo get_the_date(); ?></p>
										<?php } ?>
									</div>
								</div><!-- .latest-content-info -->
							</a>
						</div><!-- .latest-content -->
						<?php
							wp_reset_postdata();
							endif;
						?>

						<h2><?php _e( 'Latest', 'ta-music' ); ?> <span><?php _e( 'Albums', 'ta-music' ); ?></span></h2>
						<?php
							$args = array(
								'post_type'    => 'post',
								'showposts'    => 1,
								'post_status'  => 'publish',
								'has_password' => false,
								'tax_query'    => array(
									array(
										'taxonomy' => 'post_format',
										'field'    => 'slug',
										'terms'    => array( 'post-format-audio' ),
									),
								),
							);
							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) : $the_query->the_post();
						?>
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
						<?php
							wp_reset_postdata();
							endif;
						?>

						<h2><?php _e( 'Latest', 'ta-music' ); ?> <span><?php _e( 'Gallery', 'ta-music' ); ?></span></h2>
						<?php
							$args = array(
								'post_type'    => 'post',
								'showposts'    => 1,
								'post_status'  => 'publish',
								'has_password' => false,
								'tax_query'    => array(
									array(
										'taxonomy' => 'post_format',
										'field'    => 'slug',
										'terms'    => array( 'post-format-gallery' ),
									),
								),
							);
							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) : $the_query->the_post();
						?>
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
											<i class="fa fa-camera"></i>
										</div>
										<h4><?php the_title(); ?></h4>
										<?php if ( get_post_meta( $post->ID, '_cmb_post_location', true ) != '' ) { ?>
											<p><?php echo '@' . get_post_meta( $post->ID, '_cmb_post_location', true ); ?></p>
										<?php } else { ?>
											<p><?php echo get_the_date(); ?></p>
										<?php } ?>
									</div>
								</div><!-- .latest-content-info -->
							</a>
						</div><!-- .latest-content -->
						<?php
							wp_reset_postdata();
							endif;
						?>
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- end main content area -->

<?php get_footer(); ?>