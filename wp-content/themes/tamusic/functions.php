<?php
/**
 * TA Music functions and definitions
 *
 * @package TA Music
 */

/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on TA Music, use a find and replace
 * to change 'ta-music' to the name of your theme in all the template files
 */
load_theme_textdomain( 'ta-music', get_template_directory() . '/languages' );

 /**
 * Include the Redux theme options Framework.
 */
if ( !class_exists( 'ReduxFramework' ) ) {
	require_once( get_template_directory() . '/redux/framework.php' );
}

/**
 * Register all the theme options.
 */
require_once( get_template_directory() . '/inc/redux-config.php' );

/**
 * Theme options functions.
 */
require_once( get_template_directory() . '/inc/ta-option.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 750; /* pixels */
}

if ( ! function_exists( 'ta_music_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ta_music_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ta-music' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'audio', 'video',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ta_music_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ta_music_setup
add_action( 'after_setup_theme', 'ta_music_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ta_music_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'ta-music' ),
		'id'            => 'sidebar-1',
		'description'   => 'Main sidebar that appears on the right.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

		register_sidebar( array(
		'name'          => __( 'Footer 1', 'ta-music' ),
		'id'            => 'footer-1',
		'description'   => __( 'Appears on the left of the footer section of the site.', 'ta-music' ),
		'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'ta-music' ),
		'id'            => 'footer-2',
		'description'   => __( 'Appears in the middle of the footer section of the site.', 'ta-music' ),
		'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'ta-music' ),
		'id'            => 'footer-3',
		'description'   => __( 'Appears in the middle of the footer section of the site.', 'ta-music' ),
		'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'ta-music' ),
		'id'            => 'footer-4',
		'description'   => __( 'Appears on the right of the footer section of the site.', 'ta-music' ),
		'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_widget( 'ta_music_tweets_widget' );
	register_widget( 'ta_music_mailchimp_widget' );
	register_widget( 'ta_music_quick_links_widget' );
	register_widget( 'ta_post_tabs_widget' );
}
add_action( 'widgets_init', 'ta_music_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ta_music_scripts() {
	wp_enqueue_style( 'ta-music-bootstrap-style', get_template_directory_uri() . '/layouts/bootstrap.min.css', array(), '3.3.4', 'all' );

	wp_enqueue_style( 'ta-music-font-awesome-style', get_template_directory_uri() . '/layouts/font-awesome.min.css', array(), '4.3.0', 'all' );

	wp_enqueue_style( 'ta-music-google-font', 'https://fonts.googleapis.com/css?family=Dosis:400,500,600,700', array(), '', 'all' );

	wp_enqueue_style( 'ta-music-color-style', get_template_directory_uri() . '/layouts/'. ta_option( 'css_style', 'red.css' ), array(), '', 'all' );

	wp_enqueue_style( 'ta-music-isotope-style', get_template_directory_uri() . '/layouts/isotope.css', array(), '', 'all' );

	wp_enqueue_style( 'ta-music-audio-player-style', get_template_directory_uri() . '/layouts/audio-player.css', array(), '', 'all' );

	wp_enqueue_style( 'ta-music-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ta-music-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.4', true );

	wp_enqueue_script( 'ta-music-flexslider-js', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array( 'jquery' ), '2.2.0', true );

	wp_enqueue_script( 'ta-music-isotope-js', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '1.5.26', true );

	wp_enqueue_script( 'ta-music-imagesloaded-js', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '3.1.8', true );

	wp_enqueue_script( 'ta-music-infinitescroll-js', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array( 'jquery' ), '2.1.0', true );

	wp_enqueue_script( 'ta-music-manual-trigger-js', get_template_directory_uri() . '/js/manual-trigger.js', array( 'jquery' ), '2.0b2.110617', true );

	wp_enqueue_script( 'ta-music-audio-js', get_template_directory_uri() . '/js/audio.js', array(), '', true );

	wp_enqueue_script( 'ta-music-app-js', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), '', true );

	wp_localize_script( 'ta-music-app-js', 'cf', array( 'url' => admin_url( 'admin-ajax.php' ) ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ta_music_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Register Custom Navigation Walker.
 */
require_once get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Custom Post Types.
 */
require_once get_template_directory() . '/inc/post-types/CPT.php';

/**
 * Portfolio Custom Post Type.
 */
require_once get_template_directory() . '/inc/post-types/register-event.php';

/**
 * Comments Callback.
 */
require_once get_template_directory() . '/inc/comments-callback.php';

/**
 * Add Custom Meta Boxes.
 */
require_once get_template_directory() . '/inc/custom-meta-boxes/CMB.php';

/**
 * Add Breadcrumbs.
 */
require_once get_template_directory() . '/inc/breadcrumb.php';

/**
 * Add Custom CSS.
 */
require_once get_template_directory() . '/inc/custom-css.php';

/**
 * Add Theme Widgets.
 */
require_once ( get_template_directory() . '/widgets/widget-twitter.php' );
require_once ( get_template_directory() . '/widgets/widget-mailchimp.php' );
require_once ( get_template_directory() . '/widgets/widget-quick-links.php' );
require_once ( get_template_directory() . '/widgets/widget-post-tabs.php' );