<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Beat_Mix
 * @subpackage Beat_Mix_Lite
 * @since Beat_Mix_Lite 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {return;}
?>

<div id="comments">
    <?php
	if ( have_comments() ) :
		?>     
        <h3 class="text-center">
            <?php echo esc_attr( sprintf( _n( '%d Comment', '%d Comments', get_comments_number(), 'beat-mix-lite' ), get_comments_number() ) ); ?>
        </h3> 
        
        <ol class="comments-list clearfix">
            <?php
			wp_list_comments(array(
				'style'      => 'ol',
				'short_ping' => true,
				'callback'   => 'beat_mix_lite_list_comments',
				'type'       => 'all',
			));
			?>
        </ol>        

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>           
            <div class="pagination kopa-comment-pagination">  
                <?php
				paginate_comments_links(array(
					'prev_text' => esc_attr__( '<span>&laquo;</span> Previous', 'beat-mix-lite' ),
					'next_text' => esc_attr__( 'Next <span>&raquo;</span>', 'beat-mix-lite' ),
				));
				?>
            </div>
        <?php endif; ?>
        <?php if ( ! comments_open() && get_comments_number() ) : ?>
            <blockquote><?php esc_attr_e( 'Comments are closed.', 'beat-mix-lite' ); ?></blockquote>
        <?php endif; ?>    
        <?php
	endif;
	?>
</div>

<?php beat_mix_lite_comment_form(); ?>

<?php
/**
 * This function is override the default comment form of Wordpress
 * @param array $args
 * @param int   $post_id
 */
function beat_mix_lite_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID(); }

	$commenter      = wp_get_current_commenter();
	$user           = wp_get_current_user();
	$user_identity  = $user->exists() ? $user->display_name : '';
	$args           = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml'; }
	$req            = get_option( 'require_name_email' );
	$aria_req       = ( $req ? " aria-required='true'" : '' );
	$html5          = 'html5' === $args['format'];
	$fields         = array();

	$fields['author'] = '<div class="row">';
	$fields['author'] .= '<div class="col-md-4 col-sm-4 col-xs-4">';
	$fields['author'] .= '<p class="input-block">';
	$fields['author'] .= sprintf( '<input type="text" value="%1$s" id="comment_name" name="author" size="30" onblur="if(this.value==\'\')this.value=\'%1$s\';" onfocus="if(this.value==\'%1$s\')this.value=\'\';" %2$s>', esc_attr__( 'Name *', 'beat-mix-lite' ), $aria_req );
	$fields['author'] .= '</p>';
	$fields['author'] .= '</div>';

	$fields['email']  = '<div class="col-md-4 col-sm-4 col-xs-4">';
	$fields['email']  .= '<p class="input-block">';
	$fields['email']  .= sprintf( '<input type="text" value="%1$s" id="comment_email" name="email" size="30"  onblur="if(this.value==\'\')this.value=\'%1$s\';" onfocus="if(this.value==\'%1$s\')this.value=\'\';" %2$s>',  esc_attr__( 'Email *', 'beat-mix-lite' ), $aria_req );
	$fields['email']  .= '</p>';
	$fields['email']  .= '</div>';

	$fields['url']    = '<div class="col-md-4 col-sm-4 col-xs-4">';
	$fields['url']    .= '<p class="input-block">';
	$fields['url']    .= sprintf( '<input type="text" value="%1$s" id="comment_url" name="url" size="30"  onblur="if(this.value==\'\')this.value=\'%1$s\';" onfocus="if(this.value==\'%1$s\')this.value=\'\';" %2$s>', esc_attr__( 'Website', 'beat-mix-lite' ), $aria_req );
	$fields['url']    .= '</p>';
	$fields['url']    .= '</div>';
	$fields['url']    .= '</div>';

	$comment_field    = sprintf('<div class="row"><div class="col-md-12"> <p class="textarea-block"><textarea name="comment" 
        id="comment_message" 
        style="overflow: auto; resize: vertical;" 
        rows="6" 
        placeholder="%s" %s></textarea></p>
        </div>
        </div>',
		esc_attr__( 'Your comment (*)', 'beat-mix-lite' ),
	$aria_req);

	$fields = apply_filters( 'comment_form_default_fields', $fields );

	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => $comment_field,
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'beat-mix-lite' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'beat-mix-lite' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'id_form'              => 'comments-form',
		'id_submit'            => 'submit-comment',
		'title_reply'          => esc_attr__( 'Leave a Reply', 'beat-mix-lite' ),
		'title_reply_to'       => esc_attr__( 'Leave a Reply to %s', 'beat-mix-lite' ),
		'cancel_reply_link'    => esc_attr__( '(cancel)', 'beat-mix-lite' ),
		'label_submit'         => esc_attr__( 'Post Comment', 'beat-mix-lite' ),
		'format'               => 'xhtml',
	);
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
	?>
    <?php if ( comments_open( $post_id ) ) : ?>
        <?php
		do_action( 'comment_form_before' );
		?>
        <div id="respond">        
            <h3 class="text-center">
                <?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?>                
            </h3>

            <?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
                <?php echo wp_kses_post( $args['must_log_in'] ); ?>
                <?php
				do_action( 'comment_form_must_log_in_after' );
				?>
            <?php else : ?> 

                <form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form clearfix" <?php echo $html5 ? ' novalidate' : ''; ?>>
                    <p class="comment-notes"><?php echo wp_kses_post( $args['comment_notes_before'] ); ?></p>
                   
                    <?php
					do_action( 'comment_form_top' );
					?>
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php
						echo wp_kses_post( apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ) );
						do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
						?>                        
                    <?php else : ?>                        
                        <?php
						do_action( 'comment_form_before_fields' );
						?>

							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4">
									<p class="input-block">
										<input type="text" value="<?php echo esc_attr__( 'Name *', 'beat-mix-lite' ); ?>" id="comment_name" name="author" size="30" onblur="if(this.value==\'\')this.value=\'%1$s\';" onfocus="if(this.value==\'%1$s\')this.value=\'\';">
									</p>
								</div>

								<div class="col-md-4 col-sm-4 col-xs-4">
									<p class="input-block">
										<input type="text" value="<?php echo esc_attr__( 'Email *', 'beat-mix-lite' ); ?>" id="comment_email" name="email" size="30"  onblur="if(this.value==\'\')this.value=\'%1$s\';" onfocus="if(this.value==\'%1$s\')this.value=\'\';">
									</p>
								</div>

								<div class="col-md-4 col-sm-4 col-xs-4">
									<p class="input-block">
										<input type="text" value="<?php echo esc_attr__( 'Website', 'beat-mix-lite' ); ?>" id="comment_url" name="url" size="30"  onblur="if(this.value==\'\')this.value=\'%1$s\';" onfocus="if(this.value==\'%1$s\')this.value=\'\';">
									</p>
								</div>
							</div>

						<?php
						do_action( 'comment_form_after_fields' );
						?>
                    <?php endif; ?>

                    <?php
					echo wp_kses_post( apply_filters( 'comment_form_field_comment', $args['comment_field'] ) );
					echo wp_kses_post( $args['comment_notes_after'] );
					?>                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <p class="comment-button clearfix">
                                <input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
                                <?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?>                        
                                <?php comment_id_fields( $post_id ); ?>                                                    
                            </p>
                        </div>
                    </div>
                    <?php
					do_action( 'comment_form', $post_id );
					?>
                </form>

            <?php endif; ?>
        </div><!-- #respond -->
        <?php
		do_action( 'comment_form_after' );
	else :
		do_action( 'comment_form_comments_closed' );
	endif;
}

function beat_mix_lite_list_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
    <li <?php comment_class( 'clearfix' ); ?> id="comment-<?php comment_ID(); ?>">

        <article class="comment-wrap clearfix"> 
            
            <div class="comment-avatar">
                <?php echo get_avatar( $comment->comment_author_email, 85 ); ?>
            </div>

            <div class="comment-body clearfix">
                <header class="clearfix">                                
                    <div class="pull-left">
                        <h6><?php comment_author_link(); ?></h6>
                    </div>                                                                

                    <span class="comment-reply-link pull-right">
                        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => '<i class="fa fa-mail-reply"></i><span>'. esc_attr__( 'Reply', 'beat-mix-lite' ) .'</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>                        
                    </span>

                    <div class="clear"></div>
                </header>
                <div class="comment-content">
                    <?php comment_text( true ); ?>
                </div>                                
                <footer class="text-right text-uppercase">
                    <span class="entry-date"><?php comment_time( get_option( 'date_format' ) . ' - ' . get_option( 'time_format' ) ); ?></span>                    
                    <?php edit_comment_link( __( '<span>&nbsp;/&nbsp;</span> Edit', 'beat-mix-lite' ), ' ', '' ); ?>                    
                </footer>
            </div><!--comment-body -->            
     
        </article>
<?php
}
