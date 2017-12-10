<?php
/*
Plugin Name: Banners
*/
?>
<?php


$banners_defaults = array(
    'randomize' => '',
	'count' => '3',
	'title' => '',
    'banners' => array(
        '<a href="#"><img src="' . get_template_directory_uri()  . '/images/smt/banner260.gif" alt="" title="" /></a>',
        '<a href="#"><img src="' . get_template_directory_uri()  . '/images/smt/banner125.gif" alt="" title="" /></a>',
		'<a href="#"><img src="' . get_template_directory_uri()  . '/images/smt/banner125.gif" alt="" title="" /></a>'
    )
);


class Banners extends WP_Widget {
    function __construct() {
        $widget_options = array('description' => 'Add banners.' );
        $control_options = array( 'width' => 260);
		$this->WP_Widget('banners', '&raquo; Banners', $widget_options,$control_options);
    }

    function widget($args, $instance){
        
        $banners = $instance['banners'];
        $result = '';
         if(is_array($banners)) {
            echo $args['before_widget'];
			if ( isset($title)&&$title!='' ) {  echo $args['before_title'].$title.$args['after_title']; } 
			if($instance['title']!='')
				$result.="<h3>".$instance['title']."</h3>";
            if($instance['randomize'])
                shuffle($banners);
            $i=$instance['count'];
            foreach($banners as $banner) {
				if ($i==0) break;
				$i--;
                if($banner) {
                    $result .= "<span class='bnr_span'>".stripslashes($banner)."</span>";
                }
            }
			echo $result;
            echo $args['after_widget'];
        }
    }

    function update($new_instance, $old_instance){
    	$instance = $old_instance;
        $instance['randomize'] = strip_tags($new_instance['randomize']);
        $instance['banners'] = $new_instance['banners'];
		$instance['count'] = (int)$new_instance['count'];
		$instance['title'] = strip_tags($new_instance['title']);
		unset($instance['banners']['the__id__']);
        return $instance;
    }
    
    function form($instance){
		global $banners_defaults;
		$instance = wp_parse_args( (array) $instance, $banners_defaults );
        $get_banners = $instance['banners'];
		$get_this_id = preg_replace("/[^0-9]/", '', $this->get_field_id('this_id_banners'));
        $get_this_id = !$get_this_id ? 'this_id_banners___i__' : 'this_id_banners_' . $get_this_id;
        ?>
        
        <script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.new_banner').die();
				jQuery('.new_banner2').die();
				jQuery('.delete_banner').die();
				jQuery('.preview_banner').die();
				jQuery('.new_banner').live('click',function(){
					var get_id=jQuery(this).attr('alt');
					var new_banner_id = 10000+Math.floor(Math.random()*100000);
					var new_banner=jQuery('.banners_new_'+get_id+' .new_banner_container div:first').clone();
					var new_name='';
					jQuery('textarea', new_banner).each(function() {
						new_name=jQuery(this).attr('name').replace(/the__id__/g, '');
						jQuery(this).attr('name',new_name);
					});
					jQuery(new_banner).appendTo('.banners_'+get_id);
					
					
				});
				jQuery('.delete_banner').live('click',function(){
					if (confirm('The selected banner will be deleted! Do you really want to continue?')) { 
						jQuery(this).parents('.tt-clearfix').remove();
					}
				});
				
				jQuery('.preview_banner').live('click', function() {
					if (jQuery(this).text()=='Preview') {
						var txtarea=jQuery(this).parents('.tt-clearfix').find('textarea');
						var el=jQuery(txtarea).fadeOut().css('display','none').next('div').fadeIn();
						jQuery(el).empty();
						var bannersource = jQuery(txtarea).val();
						jQuery(el).append(''+bannersource+'');
						jQuery(this).text('Edit');
					} else {
						var txtarea=jQuery(this).parents('.tt-clearfix').find('textarea');
						jQuery(txtarea).next('div').fadeOut().css('display','none');
						jQuery(txtarea).fadeIn();
						jQuery(this).text('Preview');
					}
				});
            });
            
        </script>

        <div style="margin-bottom: 20px;">
			Title:<input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" /><br /><br />
			Number of banners displayed:<input class="widefat" type="text" name="<?php echo $this->get_field_name('count') ?>" value="<?php echo $instance['count']; ?>" size='2' /> <br /><br />
            Randomize banners order <input type="checkbox" name="<?php echo $this->get_field_name('randomize') ?>" <?php checked('true', $instance['randomize']); ?> value="true" /> <br /><br />
			<a class="button new_banner" alt='<?php echo $get_this_id?>'>Add New Banner</a>
        </div>
		<div class="banners_<?php echo $get_this_id?>">
        <?php
            if(is_array($get_banners)) {
                foreach($get_banners as $banner_id=>$banner_source) {
                    ?>
                    <div class="tt-clearfix" style="padding: 0 0 20px 0; border-bottom: 1px solid #ddd; margin-bottom: 20px;">
						<div>
                            <textarea class="tt-textarea" style="height: 162px; width:100%;" id="source_<?php echo $this->get_field_id($banner_id)?>" name="<?php echo $this->get_field_name('banners')?>[]"><?php echo stripslashes($banner_source); ?></textarea>
							 <div style="display:none;width: 100%; height: 162px; border: 1px solid #eee; margin-bottom: 10px; text-align:center;line-height:162px;vertical-align:middle" id="preview_<?php echo $this->get_field_id($banner_id)?>">&nbsp;</div>
                        </div>
                        <div style='margin-top:10px;'>
                            <div><a class="button preview_banner" alt="<?php echo $this->get_field_id($banner_id)?>">Preview</a> <a class="button tt-button-red delete_banner" alt="<?php echo $this->get_field_id($banner_id)?>">Delete</a></div>
                        </div>
                    </div>
                    <?php
                }
            }
        
        ?>
		</div>
            <div class="banners_new_<?php echo $get_this_id?>">
                <div class="new_banner_container" style="display: none;">
                    <div class="tt-clearfix" style="padding: 0 0 20px 0; border-bottom: 1px solid #ddd; margin-bottom: 20px;">
						<div>
                            <textarea class="tt-textarea" style="height: 162px; width:100%;" id="source_the__id__" name="<?php echo $this->get_field_name('banners'); ?>[the__id__]"></textarea>
							 <div style="display:none;width: 100%; height: 162px; border: 1px solid #eee; margin-bottom: 10px; text-align:center;line-height:162px;vertical-align:middle" id="preview_the__id__">&nbsp;</div>
                        </div>
                        <div style='margin-top:10px;'>
                            <div><a class="button preview_banner">Preview</a> <a class="button tt-button-red delete_banner">Delete</a></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("Banners");'));
?>