<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category TA Music
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_ta_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_ta_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	/**
	 * Initiate the metabox.
	 */
	$meta_boxes['event_metabox'] = array(
		'id'         => 'event_metabox',
		'title'      => __( 'Event Metabox', 'ta-music' ),
		'pages'      => array( 'event' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Event Date', 'ta-music' ),
				'desc' => __( 'Choose a date for the event.', 'ta-music' ),
				'id'   => $prefix . 'event_date',
				'type' => 'text_date',
			),

			array(
				'name' => __( 'Event Time', 'ta-music' ),
				'desc' => __( 'Choose a time for the event.', 'ta-music' ),
				'id'   => $prefix . 'event_time',
				'type' => 'text_time',
			),

			array(
				'name' => __( 'Event Location', 'ta-music' ),
				'desc' => __( 'Enter event location information.', 'ta-music' ),
				'id'   => $prefix . 'event_location',
				'type' => 'text_medium',
			),

			array(
				'name' => __( 'Event Address', 'ta-music' ),
				'desc' => __( 'Enter event address information.', 'ta-music' ),
				'id'   => $prefix . 'event_address',
				'type' => 'text',
			),

			array(
				'name' => __( 'Event Email', 'ta-music' ),
				'desc' => __( 'Enter event email information.', 'ta-music' ),
				'id'   => $prefix . 'event_email',
				'type' => 'text_email',
			),

			array(
				'name' => __( 'Event Phone', 'ta-music' ),
				'desc' => __( 'Enter event phone information.', 'ta-music' ),
				'id'   => $prefix . 'event_phone',
				'type' => 'text_medium',
			),

			array(
				'name' => __( 'Button Text', 'ta-music' ),
				'desc' => __( 'You can create a "Buy Tickets" button for the event.', 'ta-music' ),
				'id'   => $prefix . 'event_btn_text',
				'type' => 'text_medium',
			),

			array(
				'name' => __( 'Button Link', 'ta-music' ),
				'desc' => __( 'Enter the link information for the button.', 'ta-music' ),
				'id'   => $prefix . 'event_btn_link',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'Event Location Google Maps', 'ta-music' ),
				'desc' => __( 'Please refer to <a href="http://themeart.co/document/ta-magazine-theme-documentation/#google-map-settings" target="_blank">theme documentation</a> for how to Embed a Google Map with iFrame.', 'ta-music' ),
				'id'   => $prefix . 'event_google_maps',
				'type' => 'textarea_code',
			),
		),
	);

	$meta_boxes['post_metabox'] = array(
		'id'         => 'post_metabox',
		'title'      => __( 'Post Metabox', 'ta-music' ),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Location for Your Post', 'ta-music' ),
				'desc' => __( 'You can add location information for video or gallery post.', 'ta-music' ),
				'id'   => $prefix . 'post_location',
				'type' => 'text_medium',
			),
		),
	);

	$meta_boxes['video_metabox'] = array(
		'id'         => 'video_metabox',
		'title'      => __( 'Video Post Metabox', 'ta-music' ),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Embed Video Code', 'ta-music' ),
				'desc' => __( 'Paste video embed code here.', 'ta-music' ),
				'id'   => $prefix . 'video_code',
				'type' => 'textarea_code',
			),
		),
	);

	$meta_boxes['album_post_metabox'] = array(
		'id'         => 'album_post_metabox',
		'title'      => __( 'Album Post Metabox', 'ta-music' ),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Release Date', 'ta-music' ),
				'desc' => __( 'Choose release date for the album.', 'ta-music' ),
				'id'   => $prefix . 'album_date',
				'type' => 'text_date',
			),

			array(
				'id'          => $prefix . 'buy_link',
				'type'        => 'group',
				'description' => __( 'Add buy links for the album.', 'ta-music' ),
				'options'     => array(
					'group_title'   => __( 'Link {#}', 'ta-music' ),
					'add_button'    => __( 'Add Another Link', 'ta-music' ),
					'remove_button' => __( 'Remove Link', 'ta-music' ),
					'sortable'      => true,
				),

				'fields'      => array(
					array(
						'name' => 'Button Title',
						'id'   => 'btn_title',
						'type' => 'text',
					),
					array(
						'name' => 'Link URL',
						'id'   => 'btn_url',
						'type' => 'text_url',
					),
				),
			),

			array(
				'id'          => $prefix . 'album_tracks',
				'type'        => 'group',
				'description' => __( 'Upload your tracks for the album.', 'ta-music' ),
				'options'     => array(
					'group_title'   => __( 'Track {#}', 'ta-music' ),
					'add_button'    => __( 'Add Another Track', 'ta-music' ),
					'remove_button' => __( 'Remove Track', 'ta-music' ),
					'sortable'      => true,
				),

				'fields'      => array(
					array(
						'name' => 'Upload Track',
						'id'   => 'track_url',
						'type' => 'file',
					),
					array(
						'name' => 'Download Link',
						'id'   => 'track_download',
						'type' => 'checkbox',
					),
					array(
						'name' => 'Buy Link',
						'id'   => 'track_buy',
						'type' => 'text',
					),
				),
			),

			array(
				'name' => __( 'Embed Album Playlist', 'ta-music' ),
				'desc' => __( 'If you want to embedded playlist from other music sites such as SoundCloud, just copy the code and paste it here.', 'ta-music' ),
				'id'   => $prefix . 'album_embed',
				'type' => 'textarea_code',
			),
		),
	);

	$meta_boxes['user_edit'] = array(
		'id'         => 'user_edit',
		'title'      => __( 'User Profile Metabox', 'ta-music' ),
		'pages'      => array( 'user' ),
		'show_names' => true,
		'cmb_styles' => false,
		'fields'     => array(
			array(
				'name'    => __( 'Avatar', 'ta-music' ),
				'desc'    => __( 'Upload your Avatar.', 'ta-music' ),
				'id'      => $prefix . 'avatar',
				'type'    => 'file',
				'save_id' => true,
			),

			array(
				'name' => __( 'Twitter URL', 'ta-music' ),
				'desc' => __( 'Enter your Twitter URL.', 'ta-music' ),
				'id'   => $prefix . 'twitter_url',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'Facebook URL', 'ta-music' ),
				'desc' => __( 'Enter your Facebook URL.', 'ta-music' ),
				'id'   => $prefix . 'facebook_url',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'Google+ URL', 'ta-music' ),
				'desc' => __( 'Enter your Google+ URL.', 'ta-music' ),
				'id'   => $prefix . 'google_plus_url',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'YouTube URL', 'ta-music' ),
				'desc' => __( 'Enter your YouTube URL.', 'ta-music' ),
				'id'   => $prefix . 'youtube_url',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'Vimeo URL', 'ta-music' ),
				'desc' => __( 'Enter your Vimeo URL.', 'ta-music' ),
				'id'   => $prefix . 'vimeo_url',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'SoundCloud URL', 'ta-music' ),
				'desc' => __( 'Enter your SoundCloud URL.', 'ta-music' ),
				'id'   => $prefix . 'soundcloud_url',
				'type' => 'text_url',
			),

			array(
				'name' => __( 'Artist Skills', 'ta-music' ),
				'desc' => __( 'Separate skills with comma.', 'ta-music' ),
				'id'   => $prefix . 'artist_skill',
				'type' => 'text',
			),

			array(
				'name' => __( 'Artist Biography', 'ta-music' ),
				'desc' => __( 'Enter your full biography.', 'ta-music' ),
				'id'   => $prefix . 'artist_biography',
				'type' => 'wysiwyg',
			),
		)
	);

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}