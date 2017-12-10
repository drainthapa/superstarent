<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package TA Music
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php // You can start editing here -- including this comment! ?>

<?php if ( have_comments() ) : ?>
<div id="comments">
	<h3>
		<?php
			printf( _nx( '<i class="fa fa-lg fa-comments"></i>1 Comment', '<i class="fa fa-lg fa-comments"></i>%1$s Comments', get_comments_number(), 'ta-music' ),
				number_format_i18n( get_comments_number() ) );
		?>
	</h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav id="comment-nav-above" class="navigation comment-navigation clearfix" role="navigation">
		<h2 class="sr-only"><?php _e( 'Comment navigation', 'ta-music' ); ?></h2>
		<ul class="next-prev clearfix">

			<li class="prev-post"><?php previous_comments_link( __( '&larr; Older Comments', 'ta-music' ) ); ?></li>
			<li class="next-post pull-right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ta-music' ) ); ?></li>

		</ul><!-- .nav-links -->
	</nav><!-- #comment-nav-above -->
	<?php endif; // check for comment navigation ?>

	<ul class="comments">
		<?php
			wp_list_comments( array(
				'style'      => 'ul',
				'short_ping' => true,
				'callback'   => 'ta_music_comment'
			) );
		?>
	</ul><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav id="comment-nav-below" class="navigation comment-navigation clearfix" role="navigation">
		<h2 class="sr-only"><?php _e( 'Comment navigation', 'ta-music' ); ?></h2>
		<div class="nav-links">

			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'ta-music' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'ta-music' ) ); ?></div>

		</div><!-- .nav-links -->
	</nav><!-- #comment-nav-below -->
	<?php endif; // check for comment navigation ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( !comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'ta-music' ); ?></p>
	<?php endif; ?>

</div><!-- #comments -->
<?php endif; // have_comments() ?>

<div id="leave-comment">
	<!-- Comment form begin -->
	<?php 
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " required" : '' );

	$comments_args = array(
		// change the title of send button
		'label_submit' => __( 'Submit Comment', 'ta-music' ),
		// change the title of the reply section
		'title_reply' => __( 'Leave a <span>Comment</span>', 'ta-music' ),
		// remove "Text or HTML to be displayed after the set of comment fields"
		'comment_notes_after' => '',
		// redefine your own textarea (the comment body)
		'comment_field' => '<label for="message">' . __( 'Message', 'ta-music' ) . '</label><textarea name="comment" id="message" aria-required="true"></textarea>',

		'fields' => apply_filters( 'comment_form_default_fields', array(
			'author' =>
			  '<label for="name">' . __( 'Your Name', 'ta-music' ) . '</label> ' .
			  '<input type="text" name="author" id="name" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' />',

			'email' =>
			  '<label for="email">' . __( 'Your E-Mail', 'ta-music' ) . '</label> ' .
			  '<input type="email" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . ' />',

			'url' =>
			  '<label for="url">' .
			  __( 'Website', 'ta_music ') . '</label>' .
			  '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />',
			)
		),
	);

	ob_start();
	comment_form( $comments_args );
	$form = ob_get_clean();
	$form = str_replace( '<h3', '<h2', $form );
	$form = str_replace( '</h3>', '</h2>', $form );
	$form = str_replace( 'class="submit"','class="submitcomment"', $form );
	$form = str_replace( 'id="submit"','id="submitcomment"', $form );
	echo $form;
	?>
	<!-- Comment form end -->
</div>