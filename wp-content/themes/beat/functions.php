<?php
/*
LIBRARY
----------
Load the required library for theme.
----------*/
require_once 'lib/customizer.php';

/*
INIT
----------
init action hook & filter hook for "after_setup_theme"
----------*/
add_action('after_setup_theme', 'beat_mix_lite_after_setup_theme');


function beat_mix_lite_after_setup_theme() {

    load_theme_textdomain('beat-mix-lite', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5');
    add_theme_support('loop-pagination');
    add_theme_support('automatic-feed-links');

    beat_mix_lite_register_new_image_sizes();

    global $content_width;
    if (!isset($content_width))
        $content_width = 870;

    register_nav_menus(array(
        'primary-nav'   => esc_attr__('Primary Menu', 'beat-mix-lite'),
        'secondary-nav' => esc_attr__('Secondary Menu', 'beat-mix-lite'),
        'footer-nav'    => esc_attr__('Footer Menu', 'beat-mix-lite'),
    ));

    add_filter('beat_mix_lite_customization_init_options', 'beat_mix_lite_init_options');
    add_action('widgets_init', 'beat_mix_lite_register_sidebar');

    if (!is_admin()){
        add_action('wp_enqueue_scripts', 'beat_mix_lite_enqueue_scripts');
        add_filter('body_class', 'beat_mix_lite_body_class');
        add_filter('excerpt_more', '__return_false');
    }
}


function beat_mix_lite_register_new_image_sizes(){
    add_image_size('beat_mix_lite_blog_once_col', 1050, 579, true); 
    add_image_size('beat_mix_lite_blog_masonry', 271, null, false);
    add_image_size('beat_mix_lite_single', 1050, 470, true);
}

function beat_mix_lite_enqueue_scripts(){
    global $post, $wp_styles, $is_IE;
    $dir = get_template_directory_uri();

    /*
     * --------------------------------------------------
     * STYLESHEET
     * --------------------------------------------------
     */
    
    wp_enqueue_style('beat_mix_lite-fonts', beat_mix_lite_fonts_url(), array(), null );
    wp_enqueue_style('bootstrap', "{$dir}/css/bootstrap.css", array(), NULL);
    wp_enqueue_style('font-awesome', "{$dir}/css/font-awesome.css", array(), NULL);
    wp_enqueue_style('navgoco', "{$dir}/css/jquery.navgoco.css", array(), NULL);
    wp_enqueue_style('superfish', "{$dir}/css/superfish.css", array(), NULL);
    wp_enqueue_style('owl-carousel', "{$dir}/css/owl.carousel.css", array(), NULL);
    wp_enqueue_style('owl-theme', "{$dir}/css/owl.theme.css", array(), NULL);    
    wp_enqueue_style('beat_mix_lite-style', get_stylesheet_uri(), array(), NULL);
    wp_enqueue_style('beat_mix_lite-responsive', "{$dir}/css/responsive.css", array(), NULL);

    $header_background = get_theme_mod('header-background', false);
    if($header_background){
        $custom_style = sprintf(".page-header-bg {background: url('%s') repeat fixed 0 top;}", $header_background);
        wp_add_inline_style('beat_mix_lite-style', $custom_style);
    }

    /*
     * --------------------------------------------------
     * JAVASCRIPT
     * --------------------------------------------------
     */
    if (is_singular())
        wp_enqueue_script('comment-reply');

    wp_enqueue_script('jquery');
    wp_enqueue_script('masonry');
    wp_enqueue_script('modernizr', "{$dir}/js/modernizr.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('bootstrap', "{$dir}/js/bootstrap.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('fitvids', "{$dir}/js/fitvids.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('imagesloaded', "{$dir}/js/imagesloaded.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('caroufredsel', "{$dir}/js/jquery.caroufredsel.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('matchheight', "{$dir}/js/jquery.matchheight.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('navgoco', "{$dir}/js/jquery.navgoco.js", array('jquery'), NULL, TRUE);    
    wp_enqueue_script('owl-carousel', "{$dir}/js/owl.carousel.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('superfish', "{$dir}/js/superfish.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('visible', "{$dir}/js/visible.js", array('jquery'), NULL, TRUE);
    wp_enqueue_script('beat_mix_lite-custom', "{$dir}/js/custom.js", array('jquery'), NULL, TRUE);
    wp_localize_script('beat_mix_lite-custom', 'beat_mix_lite_vars', array());
}

function beat_mix_lite_body_class($classes){
    array_push($classes, 'kopa-sub-page');

    if(is_archive() || is_home()){
        array_push($classes, 'categories-1');
    }elseif(is_singular()){
        array_push($classes, 'kopa-single-page', 'kopa-subpage');        
    }

	return $classes;
}

function beat_mix_lite_fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    /*
     * Translators: If there are characters in your language that are not supported
     * by Source Sans Pro, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Source Sans Pro', 'beat-mix-lite' ) ) {
        $fonts[] = 'Source Sans Pro:400,200,300,600,700,400italic,300italic';
    }

    /*
     * Translators: If there are characters in your language that are not supported
     * by Lato, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Lato', 'beat-mix-lite' ) ) {
        $fonts[] = 'Lato:400,700,300';
    }

    /*
     * Translators: To add an additional character subset specific to your language,
     * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
     */
    $subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'beat-mix-lite' );

    if ( 'cyrillic' == $subset ) {
        $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' == $subset ) {
        $subsets .= ',greek,greek-ext';
    } elseif ( 'devanagari' == $subset ) {
        $subsets .= ',devanagari';
    } elseif ( 'vietnamese' == $subset ) {
        $subsets .= ',vietnamese';
    }

    if ( $fonts ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts ) ),
            'subset' => urlencode( $subsets ),
        ), 'https://fonts.googleapis.com/css' );
    }

    return $fonts_url;
}

function beat_mix_lite_init_options($options){
    $options['sections'][] = array(
        'id'    => 'beat_mix_lite_opt_header',
        'title' => esc_attr__('Header', 'beat-mix-lite'));

    $options['sections'][] = array(
        'id'    => 'beat_mix_lite_opt_footer',
        'title' => esc_attr__('Footer', 'beat-mix-lite'));

    $options['sections'][] = array(
        'id'    => 'beat_mix_lite_opt_socials',
        'title' => esc_attr__('Social links', 'beat-mix-lite'));
    
    $options['sections'][] = array(
        'id'    => 'beat_mix_lite_opt_blog',
        'title' => esc_attr__('Blog posts', 'beat-mix-lite'));

    $options['settings'][] = array(
        'settings'  => 'is_show_signup_links',
        'label'     => esc_attr__('Is show signup links (header)', 'beat-mix-lite'),
        'default'   => 1,
        'type'      => 'checkbox',        
        'section'   => 'beat_mix_lite_opt_header',
        'transport' => 'refresh');

    $options['settings'][] = array(
        'settings'  => 'is_show_headlines',
        'label'     => esc_attr__('Is show headlines', 'beat-mix-lite'),
        'default'   => 1,
        'type'      => 'checkbox',        
        'section'   => 'beat_mix_lite_opt_header',
        'transport' => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'logo',
        'label'       => esc_attr__('Logo', 'beat-mix-lite'),
        'description' => esc_attr__('Upload your logo image.', 'beat-mix-lite'),
        'default'     => '',
        'type'        => 'image',
        'section'     => 'beat_mix_lite_opt_header',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'header-background',
        'label'       => esc_attr__('Header background', 'beat-mix-lite'),
        'description' => esc_attr__('Upload your header background image.', 'beat-mix-lite'),
        'default'     => '',
        'type'        => 'image',
        'section'     => 'beat_mix_lite_opt_header',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'copyright',
        'label'       => esc_attr__('Copyright', 'beat-mix-lite'),
        'description' => esc_attr__('Your copyright information on footer.', 'beat-mix-lite'),
        'default'     => '',
        'type'        => 'textarea',
        'section'     => 'beat_mix_lite_opt_footer',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings' => 'blog-layout',
        'label'    => esc_attr__('Blog layout', 'beat-mix-lite'),
        'default'  => 'one-col',
        'type'     => 'select',
        'choices'  => array(
            'one-col' => esc_attr__('One col', 'beat-mix-lite'),
            'masonry' => esc_attr__('Masonry', 'beat-mix-lite')
        ),
        'section'     => 'beat_mix_lite_opt_blog',
        'transport'   => 'refresh');

    $social_links = beat_mix_lite_get_socials();
    foreach($social_links as $social_slug => $social){
        $options['settings'][] = array(
            'settings'    => $social_slug,
            'label'       => $social[0],            
            'default'     => '',
            'type'        => 'text',
            'section'     => 'beat_mix_lite_opt_socials',
            'transport'   => 'refresh');
    }

    return $options;
}

function beat_mix_lite_register_sidebar(){

    $args = array(
        'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title widget-title-s1">',
        'after_title'   => '</h2>');

    $sidebars = array(
        array(
            'name' => esc_attr__('Footer 1st', 'beat-mix-lite'),
            'id'   => 'footer-1-sidebar'),
        array(
            'name' => esc_attr__('Footer 2nd', 'beat-mix-lite'),
            'id'   => 'footer-2-sidebar'),
        array(
            'name' => esc_attr__('Footer 3rd', 'beat-mix-lite'),
            'id'   => 'footer-3-sidebar')      
    );

    foreach($sidebars as $sidebar){
        $sidebar = array_merge($sidebar, $args);
        register_sidebar($sidebar);
    }
}

function beat_mix_lite_get_socials(){
    return apply_filters('beat_mix_lite_get_socials', array(
        'facebook'    => array(__('Facebook', 'beat-mix-lite'), 'fa fa-facebook'),
        'twitter'     => array(__('Twitter', 'beat-mix-lite'), 'fa fa-twitter'),
        'pinterest'   => array(__('Pinterest', 'beat-mix-lite'), 'fa fa-pinterest'),
        'google-plus' => array(__('Google plus', 'beat-mix-lite'), 'fa fa-google-plus'),
        'youtube'     => array(__('Youtube', 'beat-mix-lite'), 'fa fa-youtube'),
        'vimeo'       => array(__('Vimeo', 'beat-mix-lite'), 'fa fa-vimeo'),
        'flickr'      => array(__('Flickr', 'beat-mix-lite'), 'fa fa-flickr'),
        'instagram'   => array(__('Instagram', 'beat-mix-lite'), 'fa fa-instagram'),
    ));
}





