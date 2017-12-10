<?php
/**
 * The template for displaying gallery post archive page.
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
			<h1><?php if ( ta_option( 'galleries_listing_title' ) != '' ) { echo ta_option( 'galleries_listing_title' ); } ?></h1>
			<h4><?php if ( ta_option( 'galleries_listing_tagline' ) != '' ) { echo ta_option( 'galleries_listing_tagline' ); } ?></h4>
		</div>
	</section>

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1 galleries-desc">
						<p><?php if ( ta_option( 'galleries_listing_desc' ) != '' ) { echo ta_option( 'galleries_listing_desc' ); } ?></p>
					</div>
				</div>

				<?php
					$all_tags_arr = array();
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							$post_tags = get_the_tags();
							if ( $post_tags ) {
								foreach( $post_tags as $tag ) {
									$all_tags_arr[] = $tag -> name;
								}
							}
						endwhile;
					endif; 

					$terms = array_unique( $all_tags_arr );
					$count = count( $terms );

					if ( $count > 0 && ta_option( 'galleries_filter_switch') == '1' ) {
						echo '<ul class="isotope-filters gallery-filter">';
						echo '<li class="current"><a href="#" data-filter="*">'. __( 'All Galleries', 'ta-music' ) .'</a></li>';
							foreach ( $terms as $term ) {
								$term_name = strtolower( $term );
								$term_name = str_replace( ' ', '_', $term_name );

								echo '<li><i class="fa fa-ellipsis-v"></i><a href="#" data-filter=".'.$term_name.'">'.$term.'</a></li>';
							}
						echo '</ul>';
					}
				?>

				<div class="row galleries">
					<?php if ( have_posts() ) : ?>
					<!-- galleries -->
					<?php
						while ( have_posts() ) : the_post();

						$terms = get_the_terms( $post->ID, 'post_tag' );

						if ( $terms && ! is_wp_error( $terms ) ) :
							$tags = array();

							foreach ( $terms as $term ) {
								$tags[] = $term->name;
							}

							$tags = str_replace( ' ', '_', $tags );
							$tax = join( " ", $tags );

						else :
							$tax = '';
						endif;
					?>
					<div class="col-sm-6 col-md-3 gallery <?php echo strtolower( $tax ); ?>">
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
					</div><!-- .gallery -->

					<?php
						endwhile;

						else :
							get_template_part( 'content', 'none' );
						endif;
					?>

				</div><!-- .galleries -->

				<?php ta_pagination(); ?>

			</div><!-- #container -->
		</section>
	</main><!-- #main -->

<?php get_footer(); ?>