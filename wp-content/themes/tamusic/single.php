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

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row">

					<?php if ( get_post_format() != 'audio' ) { ?>
					<div class="col-sm-8 clearfix">
					<?php } ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							if ( get_post_format() == 'audio' ) {
								get_template_part( 'content-audio' );
							} else {
								get_template_part( 'content-single' );
							}
						?>

						<?php
							if ( get_post_format() == 'audio' ) {
								echo '<div class="col-sm-12 clearfix">';
							}

							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							if ( get_post_format() == 'audio' ) {
								echo '<div>';
							}
						?>

					<?php endwhile; // end of the loop. ?>

					<?php if ( get_post_format() != 'audio' ) { ?>
					</div>
					<?php } ?>

					<?php if ( get_post_format() != 'audio' ) { ?>
					<aside class="sidebar col-sm-4">
						<?php get_sidebar(); ?>
					</aside>
					<?php } ?>

				</div><!-- .row -->
			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>