<?php
/*
Plugin Name: Banners 125px
*/
?>
<?php
    global $SMTheme;
    
    $social_profiles_defaults = array(
		'width' =>'32',
        'title' => 'Social Profiles',
        'profiles' => array(
        array('id'=>'twitter', 'title' => 'Twitter', 'url' => 'http://twitter.com/', 'button' => get_template_directory_uri() . '/images/social-profiles/twitter.png'),
        array('id'=>'facebook','title' => 'Facebook', 'url' => 'http://facebook.com/', 'button' => get_template_directory_uri() . '/images/social-profiles/facebook.png'),
        array('id'=>'gplus','title' => 'Google Plus', 'url' => 'https://plus.google.com/', 'button' => get_template_directory_uri() . '/images/social-profiles/gplus.png'),
        array('id'=>'linkedin','title' => 'LinkedIn', 'url' => 'http://www.linkedin.com/', 'button' => get_template_directory_uri() . '/images/social-profiles/linkedin.png'),
        array('id'=>'rss','title' => 'RSS Feed', 'url' => $SMTheme->get( 'integration','rss' ), 'button' => get_template_directory_uri() . '/images/social-profiles/rss.png'),
        array('id'=>'email','title' => 'Email', 'url' => 'mailto:your@email.com', 'button' => get_template_directory_uri() . '/images/social-profiles/email.png'),
		array('id'=>'livejournal','title' => 'Email', 'url' => 'http://livejournal.com', 'button' => get_template_directory_uri() . '/images/social-profiles/livejournal.png')
		)
    );



    

class SocialProfiles extends WP_Widget 
{
    function __construct(){
        
        $widget_options = array('description' => 'Add buttons to your social network profiles.' );
        $control_options = array();
        parent::__construct('social_profiles', '&raquo; Social Profiles', $widget_options, $control_options);
    }

    function widget($args, $instance){
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$width = intval($instance['width']);
        $profiles = $instance['profiles'];
   
        if(is_array($profiles)) {
            ?>
			<?php echo $args['before_widget']?>
			<?php  if ( $title ) {  ?><?php echo $args['before_title']?><?php echo $title?><?php echo $args['after_title']?><?php } 
                foreach($profiles as $profile) {
                    ?><a href="<?php echo strip_tags($profile['url'])?>" target="_blank"><img title="<?php echo strip_tags($profile['title'])?>" alt="<?php echo strip_tags($profile['title']) ?>" src="<?php echo strip_tags($profile['button'])?>" height="<?php echo $width?>" width="<?php echo $width?>" /></a><?php
                }
            ?>
           <?php echo $args['after_widget']?>
            <?php
        }
    }

    function update($new_instance, $old_instance) 
    {				
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
		$instance['width'] = intval($new_instance['width']);
        $instance['profiles'] = $new_instance['profiles'];
		unset($instance['profiles']['the__id__']);
        return $instance;
    }
    
    function form($instance){
        global $social_profiles_defaults;
        $instance = wp_parse_args( (array) $instance, $social_profiles_defaults );
        $profiles = $instance['profiles'];
        $get_this_id = preg_replace("/[^0-9]/", '', $this->get_field_id('this_id_profiles'));
        $this_id = !$get_this_id ? 'this_id_profiles___i__' : 'this_id_profiles_' . $get_this_id;
		$get_this_id = $this_id;
		
		
		 
    ?>
	
	 
			<?php
				unset($arr);
				foreach ($social_profiles_defaults['profiles'] as $defprofile) {
					unset($sarr);
					foreach ($defprofile as $key=>$value) {
						$sarr[]="'".$key."':'".$value."'";
					}
					$sarr=implode(',',$sarr);
					$arr[]="'".$defprofile['id']."':{".$sarr."}";
				}
				$arr=implode(',', $arr);
				$arr='social_profiles_array={'.$arr.'}';
			?>
		<script type="text/javascript">
			<?php echo $arr?>;
			jQuery(document).ready(function(){
				jQuery('.new_social').die();
				jQuery('.new_profile .title').die();
				jQuery('.social_presets img').die();
				jQuery('.social_presets_btn').die();
				jQuery('.new_social').live('click',function(){
					var get_id=jQuery(this).attr('alt');
					var new_profile_id = 10000+Math.floor(Math.random()*100000);
					var new_profile=jQuery('.new_profile_container_'+get_id+' .new_profile:first').clone();
					var new_name='';
					jQuery('input', new_profile).each(function() {
						new_name=jQuery(this).attr('name').replace(/the__id__/g, ''+new_profile_id+'');
						jQuery(this).attr('name',new_name);
					});
					jQuery(new_profile).appendTo('.sp_new_'+get_id);
					
				});
				jQuery('.new_profile .title').live('click', function() {
					jQuery(this).next('div').slideToggle();
				});
				jQuery('.social_presets img').live('click', function() {
					var params=social_profiles_array[jQuery(this).attr('alt')];
					jQuery(this).parent().parent().parent().parent().parent().fadeOut().css('display','none').prev('div').fadeIn().find('input').each(function() {
						jQuery(this).val(params[jQuery(this).attr('alt')]);
					});
				});
				jQuery('.profile_delete').live('click', function() {
					jQuery(this).parent().parent().remove();
				});
				jQuery('.social_presets_btn').live('click', function() {
					jQuery('.social_presets:first').insertAfter(jQuery(this).parent());
					jQuery(this).parent().fadeOut().css('display','none').next('.social_presets').fadeIn();
				});
            });
            
     </script>
	 <style type='text/css'>
		.new_profile {
			border:1px solid #eee;
			padding:10px;
		}
		.new_profile .title {
			background:#eee;
			margin:-10px;
			padding:5px;
			margin-bottom:10px;
			display:block
		}
		.new_profile .title:hover {
			background:#ddd;
			cursor:pointer;
		}
		.profile_params {
			display:none;
		}
		.social_presets_btn {
			cursor:pointer;
		}
		.social_presets td{
			text-align:center;
		}
		.social_presets img {
			cursor:pointer;
		}
	 </style>
    <div class="social_profiles_widget">
		<p><label for="<?php echo $this->get_field_id('title')?>">Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" /></p>
		<p><label for="<?php echo $this->get_field_id('width')?>">Width(px):</label><input class="widefat" id="<?php echo $this->get_field_id('width')?>" name="<?php echo $this->get_field_name('width')?>" type="text" value="<?php echo esc_attr($instance['width'])?>" /></p>
            
        <div style="margin-bottom: 20px;">
            <a class="button new_social" alt='<?php echo $get_this_id?>'>Add New Profile</a> &nbsp; &nbsp; 
        </div>

        <div class="sp_new_<?php echo $get_this_id?>">
			<?php
				if (is_array($profiles)) {
					foreach ($profiles as $key=>$values) {
					?>
					<div class='new_profile'>
					<span class='title'><?php echo $values['title']?><img src='<?php echo get_template_directory_uri()?>/inc/images/del.png' title='Delete' style='float:right' class='profile_delete' /></span>
					<div class='profile_params'>
						<a class='social_presets_btn' style='float:right' >Presets</a>
						<p><label>Title:</label><input alt='title' class="widefat" name="<?php echo $this->get_field_name('profiles')?>[<?php echo $key?>][title]" type="text" value="<?php echo $values['title']?>" /></p>
						<p><label>URL:</label><input alt='url' class="widefat" name="<?php echo $this->get_field_name('profiles')?>[<?php echo $key?>][url]" type="text" value="<?php echo $values['url']?>" /></p>
						<p><label>Button:</label><input alt='button' class="widefat" name="<?php echo $this->get_field_name('profiles')?>[<?php echo $key?>][button]" type="text" value="<?php echo $values['button']?>" /></p>
					</div>
					</div>
					<?php
					}
				}
			?>
			<div class="new_profile_container_<?php echo $get_this_id?>" style="display: none;">
				<div class='new_profile'>
					<span class='title'>Title</span>
					<div>
						<div>
							<a class='social_presets_btn' style='float:right' >Presets</a>
							<p><label>Title:</label><input alt='title' class="widefat" name="<?php echo $this->get_field_name('profiles')?>[the__id__][title]" type="text" value="" /></p>
							<p><label>URL:</label><input alt='url' class="widefat" name="<?php echo $this->get_field_name('profiles')?>[the__id__][url]" type="text" value="" /></p>
							<p><label>Button:</label><input alt='button' class="widefat" name="<?php echo $this->get_field_name('profiles')?>[the__id__][button]" type="text" value="" /></p>
						</div>
					</div>
				</div>
				<div class='social_presets'>
							<table width='100%'>
								<tr>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/twitter.png' alt='twitter' title='Twitter' /></td>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/facebook.png' alt='facebook' title='Facebook' /></td>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/gplus.png' alt='gplus' title='Google plus' /></td>
								</tr>
								<tr>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/linkedin.png' alt='linkedin' title='Linkedin' /></td>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/rss.png' alt='rss' title='Rss' /></td>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/email.png' alt='email' title='Email' /></td>
								</tr>
								<tr>
									<td><img src='<?php echo get_template_directory_uri()?>/images/social-profiles/livejournal.png' alt='livejournal' title='Twitter' /></td>
								</tr>
							</table>
						</div>
            </div>
		</div>
	</div>
        <?php
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("SocialProfiles");'));
?>