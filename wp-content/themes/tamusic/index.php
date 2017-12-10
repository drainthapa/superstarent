<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row">

					<!-- blog area -->
					<div class="col-sm-8 blog-list">
					<?php if ( have_posts() ) : ?>

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						?>

						<?php endwhile; ?>

						<?php ta_pagination(); ?>

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>
					</div>

					<!-- sidebar -->
					<aside class="sidebar col-sm-4">
						<?php get_sidebar(); ?>
					</aside>

				</div><!-- .row -->
			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>