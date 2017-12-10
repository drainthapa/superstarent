<?php
if ( has_nav_menu( 'footer-nav' ) ) {
	wp_nav_menu(array(
		'theme_location' => 'footer-nav',
		'container'      => 'nav',
		'container_id'   => 'footer-nav',
		'container_class' => 'pull-right',
		'menu_id'        => 'footer-menu',
		'menu_class'     => 'footer-menu clearfix',
		)
	);
}
