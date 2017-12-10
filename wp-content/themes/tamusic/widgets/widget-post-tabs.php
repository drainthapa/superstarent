<?php
/**
 * Post Tabs Widget Class
 *
 * @package TA Music
 */

class ta_post_tabs_widget extends WP_Widget {
	/* Constructor method */
	function __construct() {
		$widget_ops = array( 'description' => __( 'Display popular posts, recent posts and comments in tabbed format.', 'ta-music' ) );
		parent::__construct( '', __( 'TA Music: Post Tabs Widget', 'ta-music' ), $widget_ops );
	}

	/* Render this widget in the sidebar */
	function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$number = $instance['number'];
		echo $before_widget;
?>

		<!-- tab nav -->
		<ul class="tabs">
			<li class="active"><a href="#popular" data-toggle="tab"><?php _e( 'Popular', 'ta-music' ) ?></a></li>
			<li><a href="#recent" data-toggle="tab"><?php _e( 'Recent', 'ta-music' ) ?></a></li>
			<li><a href="#recent-comments" data-toggle="tab"><?php _e( 'Comments', 'ta-music' ) ?></a></li>
		</ul>
		<!-- /tab nav -->

		<div class="tab-content">
			<div class="tab-pane fade in active" id="popular">
			<?php
				// get popular posts by comment count.
				$popular_posts = new WP_Query( array( 'showposts' => $number, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'has_password' => false, 'orderby' => 'comment_count', 'order'=> 'DESC', ) );
				while( $popular_posts->have_posts() ): $popular_posts->the_post(); ?>

				<article class="row recent-post">
					<div class="col-md-4 post-image">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
						</a>
					<?php endif; ?>
					</div>

				<div class="col-md-8 post-content">
					<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<div class="post-meta">
					<?php
						if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
							echo '<span class="comments"><i class="fa fa-comments"></i>';
							comments_popup_link( __( 'No Comment', 'ta_music' ), __( '1 Comment', 'ta_music' ), __( '% Comments', 'ta_music' ) );
							echo '</span>';
						}
					?>
					<?php
						$byline = sprintf(
							'<i class="fa fa-user"></i>%s',
							'<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
						);
						echo '<span class="author"> ' . $byline . '</span>';
					?>
					</div>
					<a href="<?php the_permalink(); ?>" class="read-more"><?php _e( 'Read More', 'ta-music' ); ?></a><i class="fa fa-angle-double-right read-more-icon"></i>
				</div>

				</article>
				<?php endwhile;
			?>
			</div>
			<?php wp_reset_query(); ?>

			<div class="tab-pane fade" id="recent">
			<?php
				// get recent posts.
				$recent_posts = new WP_Query( array( 'showposts' => $number, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'has_password' => false ) );
				while( $recent_posts->have_posts() ): $recent_posts->the_post(); ?>

				<article class="row recent-post">
					<div class="col-md-4 post-image">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
						</a>
					<?php endif; ?>
					</div>

				<div class="col-md-8 post-content">
					<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<div class="post-meta">
					<span class="date"><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></span>
					<?php
						$byline = sprintf(
							'<i class="fa fa-user"></i>%s',
							'<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
						);
						echo '<span class="author"> ' . $byline . '</span>';
					?>
					</div>
					<a href="<?php the_permalink(); ?>" class="read-more"><?php _e( 'Read More', 'ta-music' ); ?></a><i class="fa fa-angle-double-right read-more-icon"></i>
				</div>

				</article>
				<?php endwhile;
			?>
			</div>
			<?php wp_reset_query(); ?>

			<div class="tab-pane fade" id="recent-comments">
				<?php $recent_comments = get_comments( array ( 'number' => $number, 'status' => 'approve' ) ); ?>
				<?php foreach( $recent_comments as $comment ) : ?>

				<div class="row recent-post">
					<div class="col-md-4 post-image">
					<?php if ( has_post_thumbnail( $comment->comment_post_ID ) ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php echo get_the_post_thumbnail( $comment->comment_post_ID, 'full', array( 'class' => 'img-responsive' ) ); ?>
						</a>
					<?php endif; ?>
					</div>

					<div class="col-md-8 post-content">
						<?php
							if ( $comment->comment_author ) {
								echo $comment->comment_author;
							} else {
								_e( 'Anonymous','ta-music' );
							}
							echo ' ' . __( 'on','ta-music' );
						?>
						<a href="<?php echo get_permalink( $comment->comment_post_ID ) ?>" rel="bookmark" title="<?php echo get_the_title( $comment->comment_post_ID ); ?>">
							<?php echo get_the_title( $comment->comment_post_ID ); ?>
						</a>
						<p>
							<i class="fa fa-quote-left"></i>
							<?php echo wp_trim_words( $comment->comment_content, 15 ) ;?>
							<i class="fa fa-quote-right"></i>
						</p>
					</div>
				</div>

				<?php endforeach; ?>
			</div>
		</div>

		<?php echo $after_widget;
	}

	/* Output user options */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'number' => 5 );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show', 'ta-music' ) ?>:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="1" />
		</p>

	<?php }
	
	/* Update the widget settings */
	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}

}// end ta_post_tabs_widget

?>