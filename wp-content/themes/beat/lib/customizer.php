<?php

add_action('after_setup_theme', array('Beat_Mix_Lite_Customization', 'get_instance'));	

class Beat_Mix_Lite_Customization{

	public function __construct(){
		add_action('customize_register', array($this, 'customize_register'));
	}

	public static function get_instance(){
		new Beat_Mix_Lite_Customization();		
	}

	public function customize_register($wp_customize){
		$wp_customize->get_setting('blogname')->transport        ='refresh';
		$wp_customize->get_setting('blogdescription')->transport ='refresh';


		$options = apply_filters('beat_mix_lite_customization_init_options', array());
		if($options){

			#Add panels
		  if(isset($options['panels']) && !empty($options['panels'])){
		      $panels = $options['panels'];
		      foreach($panels as $panel){
		          $wp_customize->add_panel($panel['id'], $panel);
		      }
		  }

	    #Add sections
	    if(isset($options['sections']) && !empty($options['sections'])){
	        $sections = $options['sections'];
	        foreach($sections as $section){
	            $wp_customize->add_section($section['id'], $section);
	        }
	    }

	    #Add settings & controls
	    if(isset($options['settings']) && !empty($options['settings'])){
        $settings = $options['settings'];
        foreach($settings as $setting){

          #set default sanitize callback
      		if(!isset($setting['sanitize_callback']) || empty($setting['sanitize_callback'])){
            switch ($setting['type']) {
            		case 'image':
                case 'upload':
                    $sanitize_callback = 'esc_url_raw';
                    break;
                case 'color':
                    $sanitize_callback = 'sanitize_hex_color';
                    break;
                case 'textarea':
                    $sanitize_callback = array($this, 'sanitize_textarea');
                    break;
                case 'range':
                case 'text':
                case 'checkbox':
                case 'radio':
                case 'select':
                    $sanitize_callback = 'sanitize_text_field';
                    break;
                default:
                    $sanitize_callback = 'sanitize_text_field';
                    break;
            }
          }else{
          	$sanitize_callback = $setting['sanitize_callback'];
          }
          
          #set default capability
          if(!isset($setting['capability']) || empty($setting['capability'])){
          	$capability = 'edit_theme_options';
          }else{
          	$capability = $setting['capability'];
          }

          #add setting          
          $wp_customize->add_setting($setting['settings'], array(
              "default"           => $setting['default'],
              'sanitize_callback' => $sanitize_callback,
              'capability'        => $capability,
              "transport"         => isset($setting['transport']) ? $setting['transport'] : "refresh",
          ));

          # add control for this setting
          switch ($setting['type']) {
            case 'text':
            case 'textarea':
            case 'checkbox':
            case 'radio':
            case 'select':
            case 'range':
              $wp_customize->add_control(
                $setting['settings'],
                $setting
              );  
              break;
						case 'image':
              unset($setting['type']);
              $wp_customize->add_control(
                  new WP_Customize_Image_Control(
                  $wp_customize,
                  $setting['settings'],
                  $setting));
              break;
            case 'upload':
              unset($setting['type']);
              $wp_customize->add_control(
                  new WP_Customize_Upload_Control (
                  $wp_customize,
                  $setting['settings'],
                  $setting));
              break;
            case 'color':
              unset($setting['type']);
              $wp_customize->add_control(
                  new WP_Customize_Color_Control(
                  $wp_customize,
                  $setting['settings'],
                  $setting));
              break;
            default:
              if(isset($setting['class_name']) && !empty($setting['class_name'])){
                $class_name = $setting['class_name'];
                if(class_exists($class_name)){
                  $obj = new $class_name($wp_customize, $setting['settings'], $setting);
                  $wp_customize->add_control($obj);
                }
              }              

              break;
          }
        }
	    }
		}		
	}

	public function sanitize_textarea($value){
    if($value){
        $value = htmlspecialchars_decode(esc_html($value));
    }
    return $value;
	}
}