<?php
/**
 * The template for displaying 404 pages (not found).
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
			<h1><?php if ( ta_option( '404_title' ) != '' ) { echo ta_option( '404_title' ); } ?></h1>
			<h4><?php if ( ta_option( '404_tagline' ) != '' ) { echo ta_option( '404_tagline' ); } ?></h4>
		</div>
	</section><!-- #tagline -->

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="error-404">
					<h1>404</h1>
					<h2><?php if ( ta_option( '404_notice_title' ) != '' ) { echo ta_option( '404_notice_title' ); } ?></h2>
					<p><?php if ( ta_option( '404_notice_info' ) != '' ) { echo ta_option( '404_notice_info' ); } ?></p>
				</div><!-- .error-404 -->
			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>
