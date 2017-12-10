<?php
/**
 * The template for displaying the contact page.
 *
 * @package TA Music
 *
 * Template Name: Contact Page
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
			<h1><?php the_title(); ?></h1>
			<?php if ( ta_option( 'contact_tagline' ) != '' ) { echo '<h4>' . ta_option( 'contact_tagline' ) . '</h4>'; } ?>
		</div>
	</section><!-- #tagline -->

	<!-- main content area -->
	<main id="main" class="site-main" role="main">
		<section id="content">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 clearfix">

						<div class="col-xs-10 col-xs-offset-1 contact-desc center">
							<?php
								while ( have_posts() ) : the_post();
									the_content();
								endwhile;
							?>
						</div><!-- .post-content -->

						<div class="row">
							<div class="col-sm-6">
								<h2><?php _e( 'Send us a message', 'ta-music' ); ?></h2>
								<form action="" method="post" name="contact-form" id="contact-form">
									<label for="name"><?php _e( 'Your Name', 'ta-music' ); ?> <span>*</span></label>
									<input type="text" name="username" id="name" value="<?php if( isset( $_POST['username'] ) ) { echo esc_attr( $_POST['username'] ); } ?>" required />
									<label for="email"><?php _e( 'Your E-Mail', 'ta-music' ); ?> <span>*</span></label>
									<input type="email" name="email" id="email" value="<?php if( isset( $_POST['email'] ) ) { echo esc_attr( $_POST['email'] ); } ?>" required />
									<label for="email"><?php _e( 'Subject', 'ta-music' ); ?></label>
									<input type="text" name="subject" id="subject" value="<?php if( isset( $_POST['subject'] ) ) { echo esc_attr( $_POST['subject'] ); } ?>" />
									<label for="message"><?php _e( 'Your Message', 'ta-music' ); ?></label>
									<textarea name="message" id="message"><?php if( isset( $_POST['message'] ) ) { echo esc_attr( $_POST['message'] ); } ?></textarea>
									<div class="row">
										<div class="col-sm-6">
											<input type="hidden" name="action" value="ta_contact_form">
											<?php wp_nonce_field( 'ta_cf_html', 'ta_cf_nonce' ); ?>
											<input type="submit" name="sendmessage" id="sendmessage" value="<?php _e( 'Send Message', 'ta-music' ); ?>" />
										</div>
										<div class="col-sm-6 dynamic"></div>
									</div>
								</form>
							</div>

							<div class="col-sm-6">
								<h2><?php _e( 'Address & Contact Details', 'ta-music' ); ?></h2>
								<?php if ( ta_option( 'contact_address' ) != '' ) { ?>
								<div class="contact-details">
									<div class="icon">
										<i class="fa fa-4x fa-map-marker"></i>
									</div>
									<p>
										<?php echo ta_option( 'contact_address' ); ?>
									</p>
								</div>
								<?php } ?>

								<?php if ( ta_option( 'contact_phone' ) != '' ) { ?>
								<div class="contact-details">
									<div class="icon">
										<i class="fa fa-4x fa-phone-square"></i>
									</div>
									<p>
										<?php echo ta_option( 'contact_phone' ); ?>
									</p>
								</div>
								<?php } ?>

								<?php if ( ta_option( 'contact_email' ) != '' && ta_option( 'disable_contact_email' ) == "1" ) { ?>
								<div class="contact-details">
									<div class="icon">
										<i class="fa fa-4x fa-envelope"></i>
									</div>
									<p>
										<a href="mailto:<?php echo ta_option( 'contact_email' ); ?>"><?php echo ta_option( 'contact_email' ); ?></a>
									</p>
								</div>
								<?php } ?>
							</div>
						</div><!-- .row -->

						<?php if ( ta_option( 'map_code' ) != '' ) { ?>
						<div id="contact-map-container">
							<div class="map-container">
								<?php echo ta_option( 'map_code' ); ?>
							</div>
						</div><!-- #contact-map-container -->
						<?php } ?>

						<div class="entry-footer post-meta">
							<?php ta_music_entry_footer(); ?>
						</div><!-- .entry-footer -->

					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</section><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>