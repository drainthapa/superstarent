<?php
/**
 * MailChimp Newsletter Class
 *
 * @package TA Music
 */
 
class ta_music_mailchimp_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'description' => __( 'Add MailChimp Newsletter widget.', 'ta-music' ) );
		parent::__construct( '', __( 'TA Music: MailChimp Newsletter Widget', 'ta-music' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title']) ? __( 'Newsletter', 'ta-music' ) : $instance['title'], $instance, $this->id_base );
		$url = apply_filters( 'widget_url', empty($instance['url']) ? '' : $instance['url'], $instance, $this->id_base );
		$uid = apply_filters( 'widget_uid', empty($instance['uid']) ? '' : $instance['uid'], $instance, $this->id_base );
		$lid = apply_filters( 'widget_lid', empty($instance['lid']) ? '' : $instance['lid'], $instance, $this->id_base );
		$des = apply_filters( 'widget_des', empty($instance['des']) ? '' : $instance['des'], $instance, $this->id_base );
		echo $before_widget;
		echo $before_title;
		echo '<i class="fa fa-envelope"></i>' . $title;
		echo $after_title;
		?>

		<!-- Begin MailChimp Signup Form -->
		<p><?php echo $des; ?></p>
		<form action="<?php echo $url; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="subscribe-form" target="_blank" novalidate>
			<input type="email" value="" name="EMAIL" class="email" placeholder="<?php _e( 'Your email address', 'ta-music' ) ?>" required>
			<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			<div class="mailchimp">
				<input type="text" name="b_<?php echo $uid; ?>_<?php echo $lid; ?>" tabindex="-1" value="">
			</div>
			<input type="submit" value="<?php _e( 'Submit', 'ta-music' ) ?>" name="subscribe" class="submit">
		</form>
		<!--End mc_embed_signup-->

		<?php echo $after_widget;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array('title' => '', 'url' => '', 'uid' => '', 'lid' => '', 'des' => '') );
		$title = strip_tags( $instance['title'] );
		$url = strip_tags( $instance['url'] );
		$uid = strip_tags( $instance['uid'] );
		$lid = strip_tags( $instance['lid'] );
		$des = strip_tags( $instance['des'] );
	?>
		<p><?php _e( 'Please visit <a href="http://kb.mailchimp.com/lists/signup-forms/host-your-own-signup-forms" target="_blank">MailChimp Knowledge Base</a> to get your Signup Form URL, User ID and List ID.', 'ta-music' ); ?></p>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ta-music' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><?php _e( 'Signup Form URL Structure:', 'ta-music' ); ?><br />http://listname.usx.list-manage.com/subscribe?u=userID&id=listID</p>
		<p><label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Signup Form URL:', 'ta-music' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'uid' ); ?>"><?php _e( 'User ID:', 'ta-music' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'uid' ); ?>" name="<?php echo $this->get_field_name( 'uid' ); ?>" type="text" value="<?php echo esc_attr($uid); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'lid' ); ?>"><?php _e( 'List ID:', 'ta-music' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'lid' ); ?>" name="<?php echo $this->get_field_name( 'lid' ); ?>" type="text" value="<?php echo esc_attr( $lid ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'des' ); ?>"><?php _e( 'Description:', 'ta-music' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'des' ); ?>" name="<?php echo $this->get_field_name( 'des' ); ?>" type="text" value="<?php echo esc_attr( $des ); ?>" /></label></p>
	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'url' => '', 'uid' => '', 'lid' => '', 'dec' => '' ) );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['uid'] = strip_tags( $new_instance['uid'] );
		$instance['lid'] = strip_tags( $new_instance['lid'] );
		$instance['des'] = strip_tags( $new_instance['des'] );

		return $instance;
	}

}