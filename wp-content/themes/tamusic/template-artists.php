<?php
/**
 * Template Name: Artists Page
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
			<h1><?php if ( ta_option( 'artists_listing_title' ) != '' ) { echo ta_option( 'artists_listing_title' ); } ?></h1>
			<h4><?php if ( ta_option( 'artists_listing_tagline' ) != '' ) { echo ta_option( 'artists_listing_tagline' ); } ?></h4>
		</div>
	</section>

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1 albums-desc">
						<p><?php if ( ta_option( 'artists_listing_desc' ) != '' ) { echo ta_option( 'artists_listing_desc' ); } ?></p>
					</div>
				</div>

				<?php
					$args = array(
						'role'    => 'author',
						'orderby' => 'display_name'
					);
					// The Query
					$artists_query = new WP_User_Query( $args );
					$artists = $artists_query->get_results();
				?>

				<?php
					$artist_tags = array();
					foreach ( $artists as $artist ) {
						$artist_tags_temp = explode( ", ", get_user_meta( $artist->ID, '_cmb_artist_skill', true ) );
						$artist_tags = array_merge ( $artist_tags, $artist_tags_temp );
					}
					
					$terms = array_unique( $artist_tags );
					$count = count( $terms );

					if ( $count > 0 && ta_option( 'artists_filter_switch') == '1' ) {
						echo '<ul class="isotope-filters artist-filter">';
						echo '<li class="current"><a href="#" data-filter="*">' . __( 'All Albums', 'ta-music' ) . '</a></li>';
							foreach ( $terms as $term ) {
								$term_name = strtolower( $term );
								$term_name = str_replace( ' ', '_', $term_name );

								if ( $term != '' ) {
									echo '<li><i class="fa fa-ellipsis-v"></i><a href="#" data-filter=".' . $term_name.'">' . $term . '</a></li>';
								}
							}
						echo '</ul>';
					}
				?>

				<div class="row artists">
				<!-- artists -->
				<?php
					foreach ( $artists as $artist ) {

					$terms = explode( ", ", get_user_meta( $artist->ID, '_cmb_artist_skill', true ) );

					if ( $terms && ! is_wp_error( $terms ) ) :

						$tags = str_replace( ' ', '_', $terms );
						$tax = join( " ", $tags );

					else :
						$tax = '';
					endif;
				?>

					<div class="col-sm-6 col-md-3 artist <?php echo strtolower( $tax ); ?>">
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
					</div><!-- .artist -->
				<?php } ?>
				</div><!-- .artists -->
			</div><!-- #container -->
		</section>
	</main><!-- #main -->

<?php get_footer(); ?>