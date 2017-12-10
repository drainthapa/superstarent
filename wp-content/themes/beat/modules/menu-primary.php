<?php if (has_nav_menu('primary-nav')): ?>
    <div id="kopa-header-bottom">

        <div class="outer clearfix">

            <nav id="main-nav">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-nav',
                        'container'      => false,                                         
                        'menu_id'        => 'main-menu',
                        'menu_class'     => 'main-menu clearfix')
                    );
                ?>
                <!-- main-menu -->
				
				<i class='fa fa-align-justify'></i>
            
                <div class="mobile-menu-wrapper">
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary-nav',
                            'container'      => false,                                         
                            'menu_id'        => 'mobile-menu',
                            'menu_class'     => 'mobile-menu clearfix')
                        );
                    ?>                            
                </div>
                <!-- mobile-menu-wrapper -->

            </nav>
            <!-- main-nav -->
            
        </div>
        <!-- outer -->
        
    </div>
    <!-- kopa-header-bottom -->
<?php endif;
