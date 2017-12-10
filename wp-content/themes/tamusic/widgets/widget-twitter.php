<?php
/**
 * Latest Tweets Widget Class
 *
 * @package TA Music
 */

require_once('twitter-api/twitteroauth.php');

class ta_music_tweets_widget extends WP_Widget {

	private $ta_twitter_oauth = array();

	/*	Widget Setup */
	public function __construct() {
		parent::__construct(
			'', // Base id
			__( 'TA Music: Tweets Widget', 'ta-music' ), // Name
			array(
				'description' => __( 'Displays your Twitter feed.', 'ta-music' )
			)
		);
	}

	/*	Display Widget */
	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );
		
		if ( $title ) { echo $before_title . '<i class="fa fa-twitter"></i>' . $title . $after_title; }

		$result = $this->getTweets( $instance['username'], $instance['count'] );

		echo '<ul class="tweets">';

		if( $result && is_array( $result ) ) {
			foreach( $result as $tweet ) {
				$text = $this->link_replace( $tweet['text'] );
				$text = preg_replace( '/RT/', '<span>RT</span>', $text, 1 );
				echo '<li>';
					echo $text;
					echo ' ';
					echo '<a href="http://twitter.com/' . $instance['username'] . '/status/' . $tweet['id'] . '">' . twitter_time( strtotime( $tweet['timestamp'] ) ) . '</a>';
				echo '</li>';
			}
		} else {
			echo '<li>' . __( 'There was an error grabbing the Twitter feed', 'ta-music' ) . '</li>';
		}
	
		echo '</ul>';
	
		if( !empty( $instance['tweettext'] ) ) {
			echo '<a class="pull-right" href="http://twitter.com/' . $instance['username'] . '">' . $instance['tweettext'] . '</a>';
		}

		echo $after_widget;
	} // end widget

	/*	Update Widget */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove html - important for text inputs
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['tweettext'] = strip_tags( $new_instance['tweettext'] );

		return $instance;
	} // end update

	/*	Widget Settings */
	public function form( $instance ) {
		$instance = wp_parse_args (
			(array) $instance
		);

		//widget defaults
		$defaults = array(
			'title' => 'Latest Tweets',
			'username' => '',
			'count' => '3',
			'tweettext' => 'Follow Us',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$access_token = ta_option( 'twitter_access_token' );
		$access_token_secret = ta_option( 'twitter_access_token_secret' );
		$consumer_key = ta_option( 'twitter_consumer_key' );
		$consumer_key_secret = ta_option( 'twitter_consumer_secret' );

		//if settings are empty
		if( empty( $access_token ) || empty( $access_token_secret ) || empty( $consumer_key ) || empty( $consumer_key_secret ) ) {
			echo '<p><a href="?page=_options&tab=13">' . __( 'Please configure your Twitter API settings first.', 'ta-music' ) . '</a></p>';
		} else { ?>

			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ta-music' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			</p>

			<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Twitter Username:', 'ta-music') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
			</p>

			<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of Tweets:', 'ta-music' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
			</p>

			<p>
			<label for="<?php echo $this->get_field_id( 'tweettext' ); ?>"><?php _e( 'Follow Button Text:', 'ta-music' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tweettext' ); ?>" name="<?php echo $this->get_field_name( 'tweettext' ); ?>" value="<?php echo $instance['tweettext']; ?>" />
			</p>

		<?php
		} //end if

	} // end form
 
	/*	Return Tweets */
	public function getTweets( $username, $count ) {
		$config = array();
		$config['username'] = $username;
		$config['count'] = $count;
		$config['access_token'] = ta_option( 'twitter_access_token' );
		$config['access_token_secret'] = ta_option( 'twitter_access_token_secret' );
		$config['consumer_key'] = ta_option( 'twitter_consumer_key' );
		$config['consumer_key_secret'] = ta_option( 'twitter_consumer_secret' );

		$transname = 'ta_tw_' . $username . '_' . $count;

		$result = get_transient( $transname );
		if( !$result ) {
			$result = $this->oauthRetrieveTweets( $config );

			if( isset( $result['errors'] ) ){
				$result = NULL; 
			} else {
				$result = $this->parseTweets( $result );
				set_transient( $transname, $result, 300 );
			}
		} else {
			if( is_string( $result ) )
				unserialize( $result );
		}

		return $result;
	}

	/*	OAUTH - API 1.1 */
	private function oauthRetrieveTweets( $config ) {
		if( empty( $config['access_token'] ) )
			return array( 'error' => __( 'Not properly configured, check settings', 'ta-music') );		
		if( empty( $config['access_token_secret'] ) )
			return array('error' => __( 'Not properly configured, check settings', 'ta-music') );
		if( empty( $config['consumer_key'] ) )
			return array('error' => __('Not properly configured, check settings', 'ta-music') );		
		if( empty( $config['consumer_key_secret'] ) )
			return array('error' => __( 'Not properly configured, check settings', 'ta-music') );		

		$options = array(
			'trim_user' => true,
			'exclude_replies' => false,
			'include_rts' => true,
			'count' => $config['count'],
			'screen_name' => $config['username']
		);

		$connection = new TwitterOAuth( $config['consumer_key'], $config['consumer_key_secret'], $config['access_token'], $config['access_token_secret']);
		$result = $connection->get( 'statuses/user_timeline', $options );

		return $result;
	}

	/*	Parse / Sanitize */
	public function parseTweets( $results = array() ) {
		$tweets = array();
		foreach( $results as $result ) {
			$timestamp = $result['created_at'];
	
			$tweets[] = array(
				'timestamp' => $timestamp,
				'text' => filter_var($result['text'], FILTER_SANITIZE_STRING),
				'id' => $result['id_str']
			);
		}

		return $tweets;
	}

	/*	Change Text To Link */
	private function tw_change_text_links( $matches ) {
		return '<a href="' . $matches[0] . '" target="_blank">' . $matches[0] . '</a>';
	}

	/*	Username Link */
	private function tw_change_username_link( $matches ) {
		return '<a href="http://twitter.com/' . $matches[0] . '" target="_blank">' . $matches[0] . '</a>';
	}

	/*	Convert Links */
	public function link_replace( $text ) {
		//links
		$string = preg_replace_callback(
			"/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/",
			array( &$this, 'tw_change_text_links' ),
			$text
		);

		//usernames
		$string = preg_replace_callback(
			'/@([A-Za-z0-9_]{1,15})/', 
			array( &$this, 'tw_change_username_link' ), 
			$string
		);

		return $string;
	}

}

?>