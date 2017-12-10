<?php
/*
Plugin Name: Tabs Widget
*/
?>
<?php
        
$tabs_defaults = array(
    'effect' => 'fadeIn'
);

$effects = array (
	'noEffect'=>array (
		'title'=>'No effect',
		'action'=>"jQuery(this).addClass('active').siblings().removeClass('active').parents('.widget_tabs').find('.tab_widget').eq(jQuery(this).index()).addClass('active');"
	),
	'fadeIn'=>array (
		'title'=>'Fade in',
		'action'=>"jQuery(this).addClass('active').siblings('.tabscaption').removeClass('active').parents('.widget_tabs').find('.tab_widget').hide().removeClass('active').eq(jQuery(this).index()).fadeIn('slow');"
	),
	'slideDonw'=>array (
		'title'=>'Slide down',
		'action'=>"jQuery(this).addClass('active').siblings('.tabscaption').removeClass('active').parents('.widget_tabs').find('.tab_widget').hide().removeClass('active').eq(jQuery(this).index()).slideDown();"
	)
);



class Tabs extends WP_Widget {
    var $defaults;
    var $effects;
	
    function __construct(){
        global $tabs_defaults,$effects;
        $this->defaults = $tabs_defaults;
		$this->effects = $effects;
	   
        $widget_options = array('description' => 'Allows you to add multiple widgets in tabs. ' );
        $control_options = array( );
		$this->WP_Widget('tabs', '&raquo; Tabs Widget', $widget_options,$control_options);
    }

    function widget($args, $instance){
		global $Page, $SMTheme;
       extract( $args );


	   
        ?> 
		<script>
			jQuery(document).ready(function() {
				jQuery('.widget_tabs').each(function() {
					var tabs=jQuery(this);
					jQuery('.tab_widget', this).each(function() {
						tabs.find('.tabs_captions').append(jQuery(this).find('.tabscaption'));
					});
					tabs.find('.tabscaption').each(function() {
						jQuery(this).html(jQuery(this).text());
					});
					tabs.find('.tab_widget:first').addClass('active');
					tabs.find('.tabscaption:first').addClass('active');
				});
				
				jQuery('.widget_tabs .tabscaption').die();
				jQuery('.widget_tabs .tabscaption').live('click', function() {
					<?php echo $this->effects[$instance['effect']]['action']?>
				});
			});
		</script>
		<?php echo $args['before_widget']?>
        
			<div class='tabs_captions'></div>
			<div class='tabs_contents'>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("tabs_sidebar") )  {
				;
			} ?>
			</div>
			<div style='clear:both'></div>
        <?php echo $args['after_widget']?>
        <?php
    }

    function update($new_instance, $old_instance) 
    {				
        return $new_instance;
    }
    
    function form($instance) {	
        $instance = wp_parse_args( (array) $instance, $this->defaults );
		
        ?>
       <div class="tabs_widget">
		<p><label for="<?php echo $this->get_field_id('effect')?>">Effect:</label><select class="widefat" id="<?php echo $this->get_field_id('effect')?>" name="<?php echo $this->get_field_name('effect')?>">
			<?php
				foreach ($this->effects as $value=>$effect) {
				?><option value='<?php echo $value?>'<?php echo (($instance['effect']==$value)?' selected="selected"':"")?>><?php echo $effect['title']?></option><?php
				}
			?>
		</select></p>
		
		
	   </div>
        <?php
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("Tabs");'));
?>