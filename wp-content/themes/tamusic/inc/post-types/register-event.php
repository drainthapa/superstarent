<?php
/**
 * WP Custom Post Type Class
 *
 * @package TA Music
 */

	$event = new CPT(
		array(
			'post_type_name' => 'event',
			'singular'       => __( 'Event', 'ta-music' ),
			'plural'         => __( 'Events', 'ta-music' ),
			'slug'           => 'event'
		),

		array(
			'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon' => 'dashicons-calendar'
		)
	);