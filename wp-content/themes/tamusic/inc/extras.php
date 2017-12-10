<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package TA Music
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ta_music_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'ta_music_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function ta_music_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'ta-music' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'ta_music_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function ta_music_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'ta_music_render_title' );
endif;

/**
 * Trims a string of words to a specified number of characters.
 */
function trim_characters($text, $length = 130, $append = '&hellip;') {

	$length = (int)$length;
	$text = trim( strip_tags( strip_shortcodes($text) ) );
	$text = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $text);

	if ( strlen($text) > $length ) {
		$text = substr($text, 0, $length + 1);
		$words = preg_split("/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY);
		preg_match("/[\s]|&nbsp;/", $text, $lastchar, 0, $length);
		if ( empty($lastchar) )
			array_pop( $words );

		$text = implode( ' ', $words ) . $append;
	}

	return $text;
}

/**
 * Add numeric pagination.
 */
function ta_pagination( $pages = '', $range = 2 ) {  
     $showitems = ( $range * 2 )+1;

     global $paged;
     if( empty( $paged ) ) $paged = 1;

     if( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if( !$pages ) {
			$pages = 1;
		}
     }  

     if( 1 != $pages ) {
		echo '<ul class="pagination">';
		if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
		if( $paged > 1 && $showitems < $pages ) echo "<li><a href='".get_pagenum_link( $paged - 1 )."'>&lsaquo;</a></li>";

		for ( $i=1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && ( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) ) {
				echo ( $paged == $i ) ? "<li class=\"current\"><a href='".get_pagenum_link($i)."'>".$i."</a></li>" : "<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
			}
		}

		if ( $paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link( $paged + 1 )."'>&rsaquo;</a></li>";  
		if ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) echo "<li><a href='".get_pagenum_link( $pages )."'>&raquo;</a></li>";
		echo "</ul>";
	}
}

/**
 * Get images attached to post.
 */
if ( !function_exists( 'ta_post_images' ) ) {
	function ta_post_images( $args=array() ) {
		global $post;

		$defaults = array(
			'numberposts'		=> -1,
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order',
			'post_mime_type'	=> 'image',
			'post_parent'		=>  $post->ID,
			'post_type'			=> 'attachment',
		);
		$args = wp_parse_args( $args, $defaults );

		return get_posts( $args );
	}
}

/**
 * Retrieves the attachment ID from the file URL.
 */
function get_audio_id( $audio_url ) {
    global $wpdb;

    $dir = wp_upload_dir();
    $path = $audio_url;

    if ( 0 === strpos( $path, $dir['baseurl'] . '/' ) ) {
        $path = substr( $path, strlen( $dir['baseurl'] . '/' ) );
    }

    $sql = $wpdb->prepare(
        "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_attached_file' AND meta_value = %s",
        $path
    );
    $post_id = $wpdb->get_var( $sql );
    if ( ! empty( $post_id ) ) {
        return (int) $post_id;
    }
}

/**
 * Convert Twitter created_at time format to ago format.
 */
function twitter_time( $date ) {

	// Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'year', 'ta-music' ), __( 'years', 'ta-music' ) ),
		array( 60 * 60 * 24 * 30 , __( 'month', 'ta-music' ), __( 'months', 'ta-music' ) ),
		array( 60 * 60 * 24 * 7, __( 'week', 'ta-music' ), __( 'weeks', 'ta-music' ) ),
		array( 60 * 60 * 24 , __( 'day', 'ta-music' ), __( 'days', 'ta-music' ) ),
		array( 60 * 60 , __( 'hour', 'ta-music' ), __( 'hours', 'ta-music' ) ),
		array( 60 , __( 'minute', 'ta-music' ), __( 'minutes', 'ta-music' ) ),
		array( 1, __( 'second', 'ta-music' ), __( 'seconds', 'ta-music' ) )
	);
 
	$current_time = strtotime( ( current_time( 'mysql', $gmt = 1 ) ) );

	// Difference in seconds
	$since = $current_time - $date;
 
	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return __( 'sometime', 'ta-music' );
 
	//The first chunk
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
 
		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}
 
	// Set output var
	$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
 
	if ( !(int)trim( $output ) ){
		$output = '0 ' . __( 'seconds', 'ta-music' );
	}
 
	$output .= __(' ago', 'ta-music');
 
	return $output;
}

/**
 * Display 2 equal columns for Quick Links widget.
 */
class quick_links_nav_walker extends Walker_Nav_Menu {

	var $current_menu = null;
	var $break_point  = null;

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;

        if( !isset( $this->current_menu ) )
			$this->current_menu = wp_get_nav_menu_object( $args->menu );

		if( !isset( $this->break_point ) )
			$this->break_point = ceil( $this->current_menu->count / 2 ) + 1;    

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		if( $this->break_point == $item->menu_order )
			$output .= $indent . '</li></ul><ul class="links col-xs-6 links-col"><li' . $id . $value . $class_names .'>';
		else
			$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
    }
}

/**
 * Posts Page Custom Template.
 */
function posts_page_custom_template( $template ) {
	global $wp_query;

	if( true == ( $posts_per_page_id = get_option( 'page_for_posts' ) ) ) {
		$page_id = $wp_query->get_queried_object_id();
		if( $page_id == $posts_per_page_id ){
			$theme_directory = get_stylesheet_directory() ."/";
			$page_template   = get_post_meta( $page_id, '_wp_page_template', true );
			if( $page_template != 'default' ){
				if( is_child_theme() && !file_exists( $theme_directory . $page_template ) ){
					$theme_directory = get_template_directory();
				}
				return $theme_directory . $page_template;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'posts_page_custom_template' );

/**
 * Customize Tag Cloud Widget font size.
 */
function custom_tag_cloud_widget( $args ) {
	$args['largest'] = 1; //largest tag
	$args['smallest'] = 1; //smallest tag
	$args['unit'] = 'em'; //tag font unit
	$args['format'] = 'list'; //ul with a class of wp-tag-cloud

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );

/**
 * Custom Read More Button
 */
function modify_read_more_link() {

	return '<p><a href="' . get_permalink() . '" class="read-more">' . __( 'Read More', 'ta-music' ) . '</a><i class="fa fa-angle-double-right read-more-icon"></i></p>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/**
 * Add script for Load More button.
 */
function load_more_js_init() {
	global $wp_query;

	// What page are we on? And what is the pages limit?
	$max = $wp_query->max_num_pages;
	$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

	// Add some parameters for the JS.
	wp_localize_script(
		'ta-music-app-js',
		'ta_music',
		array(
			'startPage' => $paged,
			'maxPages' => $max,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'load_more_js_init' );

/**
 * Send Mail.
 */
function ta_contact_send_message() {

	if ( isset( $_POST['ta_cf_nonce'] ) && wp_verify_nonce( $_POST['ta_cf_nonce'], 'ta_cf_html' ) ) {
		$to       =   ta_option( 'contact_email' ); //the address to which the email will be sent
		$name     =   sanitize_text_field( $_POST['username'] );
		$email    =   sanitize_email( $_POST['email'] );
		$subject  =   sanitize_text_field( $_POST['subject'] );
		$message  =   sanitize_text_field( $_POST['message'] );

		/*the $header variable is for the additional headers in the mail function,
		 we are assigning 2 values, first one is FROM and the second one is REPLY-TO.
		 That way when we want to reply the email Gmail(or Yahoo or Hotmail...) will know
		 who are we replying to. */
		$headers  = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$headers .= "Reply-To: $email\r\n";

		// send the email using wp_mail()
		if( wp_mail( $to, $subject, $message, $headers ) ){
			_e( 'Thank you. The Mailman is on his way!', 'ta-music' ); // we are sending this text to the Ajax request telling it that the mail is sent.
		} else {
			_e( "Sorry, don't know what happened. Try later!", 'ta-music' ); // ... or this one to tell it that it wasn't sent.
		}
	}
	die(); // Important
}
add_action( 'wp_ajax_ta_contact_form', 'ta_contact_send_message' );
add_action( 'wp_ajax_nopriv_ta_contact_form', 'ta_contact_send_message' );