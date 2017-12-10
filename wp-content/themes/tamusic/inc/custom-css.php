<?php
/**
 * Adds custom CSS to the wp_head() hook.
 *
 * @package WordPress
 * @subpackage TA Music
 */

if ( !function_exists( 'ta_custom_css' ) ) {

	add_action( 'wp_head', 'ta_custom_css' );
	function ta_custom_css() {

			$custom_css = '';

			if( ta_option( 'slider_bg', false, 'url' ) != '' ) {
				$slider_bg_url = ta_option( 'slider_bg', false, 'url' );
				$custom_css .= 'body:before, body:after { background: url('.$slider_bg_url.') repeat-x; }';
			}

			if( ta_option( 'custom_css' ) != '' ) {
				$custom_css .= ta_option( 'custom_css' );
			}

			//Trim white space for faster page loading
			$custom_css_trimmed =  preg_replace( '/\s+/', ' ', $custom_css );

			//Echo CSS
			$css_output = "<!-- Custom CSS -->\n<style type=\"text/css\">\n" . $custom_css_trimmed . "\n</style>";

			if( !empty( $custom_css ) ) {
				echo $css_output;
			}
	}

}