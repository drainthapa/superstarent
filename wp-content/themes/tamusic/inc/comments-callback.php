<?php
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @package TA Music
 */

if ( !function_exists( 'ta_music_comment' ) ) {
	function ta_music_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	switch ( $comment -> comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<p><?php _e( 'Pingback:', 'ta-music' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'ta-music' ), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
	<?php
		break;
		default :
		// Proceed with normal comments.
	?>

	<li id="li-comment-<?php comment_ID(); ?>">
		<div class="avatar-img">
			<?php echo get_avatar( $comment, 150 ); ?>
		</div>
   
		<div class="content">
			<h5><?php comment_author_link(); ?> <span><?php echo get_comment_date(); ?> // <?php echo get_comment_time(); ?></span></h5>
			<?php if ( '0' == $comment->comment_approved ) {
				echo '<p>' . __( 'Your comment is awaiting moderation.', 'ta-music' ) . '</p>';
			} ?>

			<?php comment_text(); ?>
			<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'ta-music' ) . '' . '<i class="fa fa-share"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	</li>
	<?php
		break;
		endswitch; // End comment_type check.
	}
}