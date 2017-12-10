<?php
/**
 * The template for displaying all single posts.
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

	<?php
		while ( have_posts() ) : the_post();

		if ( function_exists( 'sharing_display' ) )
			remove_filter( 'the_content', 'sharing_display', 19 );

		if ( function_exists( 'sharing_display' ) )
			remove_filter( 'the_excerpt', 'sharing_display', 19 );
	?>

	<section id="tagline">
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<h4>
			<?php if( has_excerpt() ) {
				echo get_the_excerpt();
			} else {
				echo trim_characters( get_the_content() );
			} ?>
			</h4>
		</div>
	</section>

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<?php
					$images = ta_post_images();
					if ( !empty( $images ) ):
				?>
				<div class="row">
					<!-- photo slider -->
					<div class="col-xs-12">
						<?php if ( function_exists( 'sharing_display' ) ) echo sharing_display(); ?>

						<div class="flexslider event-gallery">
							<ul class="slides">
							<?php foreach ( $images as $image ): ?>
								<li>
									<img class="img-responsive" src="<?php echo wp_get_attachment_image_src( $image->ID, 'full' )[0]; ?>" alt="<?php echo $image->post_title; ?>" />
								</li>
							<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<div class="row event-info">
					<div class="col-sm-4">
						<h3 class="event-details"><?php _e( 'Details', 'ta-music'); ?></h3>
						<dl class="dl-horizontal">
						<?php if ( get_post_meta( $post->ID, '_cmb_event_date', true ) != '' ): ?>
							<dt><?php _e( 'Date :', 'ta-music'); ?></dt><dd><?php echo get_post_meta( $post->ID, '_cmb_event_date', true ); ?></dd>
						<?php endif; ?>
						<?php if ( get_post_meta( $post->ID, '_cmb_event_time', true ) != '' ): ?>
							<dt><?php _e( 'Time :', 'ta-music'); ?></dt><dd><?php echo get_post_meta( $post->ID, '_cmb_event_time', true ); ?></dd>
						<?php endif; ?>
						<?php if ( get_post_meta( $post->ID, '_cmb_event_location', true ) != '' ): ?>
							<dt><?php _e( 'Location :', 'ta-music'); ?></dt><dd><p><?php echo get_post_meta( $post->ID, '_cmb_event_location', true ); ?><p></dd>
						<?php endif; ?>
						<?php if ( get_post_meta( $post->ID, '_cmb_event_address', true ) != '' ): ?>
							<dt><?php _e( 'Address :', 'ta-music'); ?></dt><dd><p><?php echo get_post_meta( $post->ID, '_cmb_event_address', true ); ?><p></dd>
						<?php endif; ?>
						<?php if ( get_post_meta( $post->ID, '_cmb_event_email', true ) != '' ): ?>
							<dt><?php _e( 'Email :', 'ta-music'); ?></dt><dd><a href="mailto:<?php echo get_post_meta( $post->ID, '_cmb_event_email', true ); ?>"><?php echo get_post_meta( $post->ID, '_cmb_event_email', true ); ?></a></dd>
						<?php endif; ?>
						<?php if ( get_post_meta( $post->ID, '_cmb_event_phone', true ) != '' ): ?>
							<dt><?php _e( 'Phone :', 'ta-music'); ?></dt><dd><?php echo get_post_meta( $post->ID, '_cmb_event_phone', true ); ?></dd>
						<?php endif; ?>
						</dl>

						<?php if ( get_post_meta( $post->ID, '_cmb_event_btn_text', true ) != '' && get_post_meta( $post->ID, '_cmb_event_btn_link', true ) != '' ): ?>
						<div class="action-buttons">
							<a href="<?php echo get_post_meta( $post->ID, '_cmb_event_btn_link', true ); ?>"><?php echo get_post_meta( $post->ID, '_cmb_event_btn_text', true ); ?></a>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-sm-8">
						<h3 class="event-desc"><?php _e( 'Description', 'ta-music'); ?></h3>
						<?php
							the_content();
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'ta-music' ),
								'after'  => '</div>',
								)
							);
						?>
					</div>
				</div>

				<!-- event location -->
				<?php if ( get_post_meta( $post->ID, '_cmb_event_google_maps', true ) != '' ): ?>
				<h2><?php _e( 'Event', 'ta-music'); ?> <span><?php _e( 'Location', 'ta-music'); ?></span></h2>
				<div class="row">
					<div class="col-lg-12 map-container">
						<?php echo get_post_meta( $post->ID, '_cmb_event_google_maps', true ); ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- latest events -->
				<h2><?php _e( 'Latest', 'ta-music' ); ?> <span><?php _e( 'Events', 'ta-music' ); ?></span></h2>
				<div class="row">
				<?php
					$the_query = new WP_Query( array( 'post_type' => 'event', 'showposts' => 4, 'post_status' => 'publish', 'has_password' => false, 'post__not_in' => array( get_the_ID() ) ) );
					if ( $the_query->have_posts() ) :
					// the loop
					while ( $the_query->have_posts() ) : $the_query->the_post();
				?>
					<div class="col-sm-6 col-md-3 event">
						<div class="event-image">
							<div class="event-date">
								<span class="day-of-month"><?php echo date( 'd', strtotime( get_post_meta( $post->ID, '_cmb_event_date', true ) ) ); ?></span>
								<span class="day-of-week"><?php echo date( 'D', strtotime( get_post_meta( $post->ID, '_cmb_event_date', true ) ) ); ?></span>
							</div>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?></a>
							<?php endif; ?>
						</div>

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
					endwhile;
					// end of the loop
					wp_reset_postdata();
					endif;
				?>
				</div><!-- .row -->
			</div>
		</section>
	</main><!-- #main -->

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>