<?php
/**
 * The template for displaying archive pages.
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
			<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php the_archive_description( '<h4>', '</h4>' ); ?>
		</div>
	</section><!-- #tagline -->

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
			<?php
				if ( ta_option( 'default_blog_style' ) == '1' ) {
					echo '<div class="row grid-blog">';
				} else {
					echo '<div class="row">';
				}
			?>
					

					<!-- blog area -->
					<?php if ( ta_option( 'default_blog_style' ) !== '1' ) { ?>
					<div class="col-sm-8">
					<?php } ?>

					<?php
						if ( have_posts() ) :
							/* Start the Loop */
							while ( have_posts() ) : the_post();
								if ( ta_option( 'default_blog_style' ) == 1 ) :
									get_template_part( 'content', 'grid' );
								else :
									get_template_part( 'content' );
								endif;
							endwhile;

						if ( ta_option( 'default_blog_style' ) == '1' ) {
							ta_posts_navigation();
						} else {
							ta_pagination();
						}

						else :
							get_template_part( 'content', 'none' );
						endif;
					?>

					<?php if ( ta_option( 'default_blog_style' ) !== '1' ) { ?>
					</div>
					<?php } ?>

					<?php if ( ta_option( 'default_blog_style' ) !== '1' ) { ?>
					<!-- sidebar -->
					<aside class="sidebar col-sm-4">
						<?php get_sidebar(); ?>
					</aside>
					<?php } ?>

				</div><!-- .row -->

				<?php if ( ta_option( 'default_blog_style' ) == '1' ) { ?>
					<a href="#" id="load-more-enable" class="load-more"><?php _e( 'Load More' ,'ta-music' ); ?></a><a href="#" id="load-more-disable" class="load-more hide"><?php _e( 'No More Posts', 'ta-music' ); ?></a>
				<?php } ?>

			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>