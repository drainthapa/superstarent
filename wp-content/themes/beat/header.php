<!DOCTYPE html>
<html <?php language_attributes(); ?>>              
   <head>
     <meta charset="<?php bloginfo('charset'); ?>" />                   
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
     <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />                       
     <?php wp_head(); ?>
   </head>  
   <body <?php body_class(); ?>>

    <div id="kopa-page-header">

        <div id="kopa-header-top">
            
            <div class="outer clearfix">

                <?php get_template_part('modules/logo'); ?>    

                <div id="kopa-header-top-inner" class="pull-left">

                    <div class="clearfix">

                        <div class="left-col pull-left line-divider clearfix">
                            <?php get_template_part('modules/headlines'); ?>                                                    
                            <!-- kp-headline-wrapper -->

                            <?php get_template_part('modules/socials', 'top'); ?>
                            <!-- social-links -->
                        </div>
                        <!-- left-col -->

                        <?php get_template_part('modules/signup'); ?>
                        <!-- right-col -->
                        
                    </div>
                    <!-- clearfix -->

                    <div class="clearfix">
                        
                        <?php get_template_part('modules/search', 'top'); ?>                        

                        <div class="right-col pull-left">
                        
                        </div>
                        <!-- right-col -->

                    </div>
                    <!-- clearfix -->
                    
                </div>
                <!-- kopa-header-top-inner -->

            </div>
            <!-- outer -->

        </div>
        <!-- kopa-header-top -->

        <?php get_template_part('modules/menu', 'primary'); ?> 

    </div>
    <!-- kopa-page-header -->

    <div id="main-content">

        <?php get_template_part('modules/page-title'); ?>

        <div class="wrapper clearfix">