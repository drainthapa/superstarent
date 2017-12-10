<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package TA Music
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php $fav = ta_option( 'custom_favicon', false, 'url' ); ?>
<?php if ( $fav !== '' ) : ?>
<link rel="icon" type="image/png" href="<?php echo ta_option( 'custom_favicon', false, 'url' ); ?>" />
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="sr-only" href="#content"><?php _e( 'Skip to content', 'ta-music' ); ?></a>

	<?php if ( ta_option( 'disable_top_bar' ) == '1' ) { ?>
	<!-- TOP-BAR -->
	<div id="top-bar">
		<div class="container">
		<?php if ( ta_option( 'disable_tagline' ) == '1' ) { ?>
			<div id="site-description"><?php bloginfo( 'description' ); ?></div>
		<?php } ?>

			<ul id="top-links">
			<?php if ( ta_option( 'disable_login_register' ) == '1' ) { ?>
				<li class="login"><a href="<?php echo wp_login_url( get_permalink() ); ?>"><i class="fa fa-lock"></i><span><?php _e( 'Login', 'ta-music' ); ?></span></a></li>
				<li class="register"><a href="<?php echo wp_registration_url(); ?>"><i class="fa fa-user"></i><span><?php _e( 'Register', 'ta-music' ); ?></span></a></li>
			<?php } ?>

			<?php if ( ta_option( 'disable_social' ) == '1' ) {
				if ( ta_option( 'facebook_link' ) != '' ) { ?>
					<li class="facebook"><a href="<?php echo ta_option( 'facebook_link' ); ?>"></a></li>
				<?php }
				if ( ta_option( 'facebook_link' ) != '' ) { ?>
					<li class="twitter"><a href="<?php echo ta_option( 'twitter_link' ); ?>"></a></li>
				<?php }
				if ( ta_option( 'google_plus_link' ) != '' ) { ?>
					<li class="google-plus"><a href="<?php echo ta_option( 'google_plus_link' ); ?>"></a></li>
				<?php }
				if ( ta_option( 'youtube_link' ) != '' ) { ?>
					<li class="youtube"><a href="<?php echo ta_option( 'youtube_link' ); ?>"></a></li>
				<?php }
			} ?>

			<?php if ( ta_option( 'disable_search' ) == '1' ) { ?>
				<li class="search">
					<form id="search-form" method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="text" value="" name="s" id="top-search" />
					</form>
					<a href="#"></a>
				</li>
			<?php } ?>
			</ul><!-- #top-links -->
		</div><!-- .container -->
	</div><!-- #top-bar -->
	<?php } ?>

	<header id="navigation" class="navbar navbar-default" role="banner">
		<div class="container">
			<div class="navbar-header">
				<?php if ( has_nav_menu( 'primary' ) ) { ?>
				<!-- Responsive nav button -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only"><?php _e( 'Toggle navigation', 'ta-music' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- End responsive nav button -->
				<?php } ?>

				<!-- Logo -->
				<?php $logo = ta_option( 'custom_logo', false, 'url' ); ?>

				<?php if( $logo !== '' ) { ?>
					<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="homepage"><img src="<?php echo $logo ?>" alt="<?php bloginfo( 'name' ) ?>" /></a>
				<?php } else { ?>
					<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="homepage"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ) ?>" /></a>
				<?php } ?>
				<!-- End logo -->
			</div><!-- .navbar-header -->

			<?php if ( has_nav_menu( 'primary' ) ) { ?>
			<!-- Main nav -->
			<nav class="collapse navbar-collapse" id="main-nav" role="Navigation">
				<?php
					$args = array(
						'theme_location' => 'primary',
						'depth'          => 2,
						'container'      => false,
						'menu_id'        => 'nav',
						'menu_class'     => 'nav navbar-nav navbar-right',
						'walker'         => new wp_bootstrap_navwalker()
					);

					wp_nav_menu( $args );
				?>
			</nav>
			<!-- End main nav -->
			<?php } ?>
		</div>
	</header><!-- #navigation -->