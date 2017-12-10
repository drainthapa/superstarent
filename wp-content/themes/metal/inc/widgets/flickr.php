<?php
/*
Plugin Name: Flickr Box
*/
?>
<?php
$flickr_defaults = array(
			'title' => 'Flickr',
			'userid' => '80789124@N02',
			'width' => '55'
		);
	


class Flickr extends WP_Widget { 
	function __construct(){
        $widget_options = array('description' => 'Flickr widget.' );
        $control_options = array( 'width' => 440);
		$this->WP_Widget('flickr', '&raquo; Flickr Box', $widget_options, $control_options);
    }
	
	

     function widget($args, $instance){
        global $wpdb;
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$userid = $instance['userid'];
		$width = $instance['width'];
		
		
        ?>
       <?php echo $args['before_widget']?>
        <?php  if ( $title ) {  ?><?php echo $args['before_title']?><?php echo $title?><?php echo $args['after_title']?><?php }  
		$url="http://api.flickr.com/services/feeds/photos_public.gne?id=".$userid."&format=csv";
		$s=file_get_contents($url);
		$s=stripslashes($s);
		$s=explode("\n", $s);
		unset($s[0]);
		$photos=array();
		foreach( $s as $string ) {
			if ($string!='')
			$photos[]=explode(', ', $string);
		}
		echo "<div style='overflow:hidden'>";
		foreach ($photos as $photo) {
			$src=preg_replace('/(.*)(staticflickr\.com\/)([^\"]*)(.*)/', '$3', $photo[2]);
			echo "<a rel='nofollow' style='height:".$width."px;width:".$width."px;' href=".$photo[1]." target='_blank'><img src='http://farm3.staticflickr.com/".$src."' alt=".$photo[0]." title=".$photo[0]." /></a>\r\n";
		}
		?>
		</div>
          <?php echo $args['after_widget']?>
     <?php
    }


    function update($new_instance, $old_instance){
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
		$instance['userid'] = strip_tags($new_instance['userid']);
		$instance['width'] = strip_tags($new_instance['width']);
	   
        return $instance;
    }
    
    function form($instance){
		global $flickr_defaults;
        $instance=wp_parse_args( (array)$instance, $flickr_defaults);
        ?>
        
            <div class="tt-widget">
                <table width="100%">
                    <tr>
                        <td class="tt-widget-label" width="30%"><label for="<?php echo $this->get_field_id('title')?>">Title:</label></td>
                        <td class="tt-widget-content" width="70%"><input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" /></td>
                    </tr>
					 <tr>
                        <td class="tt-widget-label" width="30%"><label for="<?php echo $this->get_field_id('userid')?>">User ID:</label></td>
                        <td class="tt-widget-content" width="70%"><input class="widefat" id="<?php echo $this->get_field_id('userid')?>" name="<?php echo $this->get_field_name('userid')?>" type="text" value="<?php echo esc_attr($instance['userid'])?>" /></td>
                    </tr>
					 <tr>
                        <td class="tt-widget-label" width="30%"><label for="<?php echo $this->get_field_id('width')?>">Image width (px):</label></td>
                        <td class="tt-widget-content" width="70%"><input class="widefat" id="<?php echo $this->get_field_id('width')?>" name="<?php echo $this->get_field_name('width')?>" type="text" value="<?php echo esc_attr($instance['width'])?>" /></td>
                    </tr>
                    
                  
                    
                </table>
            </div>
            
        <?php 
    }
} 

add_action('widgets_init', create_function('', 'return register_widget("Flickr");'));
?>