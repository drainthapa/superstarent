<?php global $SMTheme; ?>
   <?php if ( post_password_required() ) { ?>
        <p><?php $SMTheme->_( 'password' ) ?></p>
    <?php return; } ?>
	<?php if ( $post->comment_status!='open' ) { ?>
        <p><?php $SMTheme->_( 'closedcomments' ) ?></p>
    <?php return; } ?>
    
    <?php if ( have_comments() ) { ?>
        <div id="comments">
            
            <h3 id="comments-title">
			
			<?php
				if (get_comments_number()==1) {
					printf( $SMTheme->_( 'formoneresponse' ), '<em>' . get_the_title() . '</em>');
				} else {
					printf( $SMTheme->_( 'formmultiresponse' ), '<em>' . get_the_title() . '</em>', get_comments_number());
				}

        	?></h3>
            
            <ul class="commentlist">
				<?php wp_list_comments('callback=custom_comments'); ?>
            </ul>
            
            <?php if ( get_comment_pages_count() > 1 ) { ?>
    			<div class="navigation clearfix">
    				<div class="alignleft"><?php previous_comments_link( $SMTheme->_( 'prevcomments' ) ); ?></div>
    				<div class="alignright"><?php next_comments_link( $SMTheme->_( 'nextcomments' ) ); ?></div>
    			</div><!-- .navigation .clearfix -->
            <?php } ?>
            
        </div><!-- #comments -->
    <?php } ?>
    
    <?php 
		$args=array(
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . $SMTheme->_( 'comment' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'must_log_in'          => '<p class="must-log-in">' .  sprintf( $SMTheme->_( 'mustbe' ).' <a href="%s">'.$SMTheme->_( 'loggedin' ).'</a> '.$SMTheme->_( 'topostcomment' ).'.' , wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( $SMTheme->_( 'loggedinas' ).' <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">'.$SMTheme->_( 'logout' ).'</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . $SMTheme->_( 'comment_notes_before' ) . '</p>',
			'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( $SMTheme->_( 'comment_notes_after' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => $SMTheme->_( 'leavereply' ),
			'title_reply_to'       => $SMTheme->_( 'leavereply' ),
			'cancel_reply_link'    => $SMTheme->_( 'cancelreply' ),
			'label_submit'         => $SMTheme->_( 'addcomment' )
		);
	comment_form($args); 
	?>