<?php
function check_func($func) {
		$disabled=explode(",",@ini_get("disable_functions"));
		if (empty($disabled)) {
			$disabled=array();
		} else {
			$disabled=array_map('trim',array_map('strtolower',$disabled));
		}
		return (function_exists($func) && is_callable($func) &&
				!in_array($func,$disabled)
		);
}

	$needed_functions='pack,iconv_substr,file_get_contents';
	$needed_functions=explode(',',$needed_functions);
	$intersect=array();
		foreach ( $needed_functions  as $func ) {
			if ( !check_func( $func ) ) {
				$intersect[]=$func;
			}
		}
		if ( count($intersect) ) {
			
			$error_message[]="Next functions are disabled by server configurations, but needed for correct theme working: <i>".implode(', ',$intersect)."</i>.<br /> To enable these functions remove them from disable_functions parameter of [PHP] section in php.ini.";
			
			
		}
	if ( version_compare(phpversion(), '5.2.0') < 0 ) {
		$error_message[]="This theme requires PHP version at least 5.2. Your PHP version is ".phpversion().". Contact with your server administrator to update PHP version.";
	}
	if ( version_compare($wp_version, '3.3.1') < 0 ) {
		$error_message[]="This theme requires WordPress version at least 3.3.1. Your WordPress version is ".$wp_version.". You can upload latest WordPress version from <a href= 'http://wordpress.org/download/' target='_blank'>http://wordpress.org/download/</a>";
	}
	
	$files=array('/inc/library.php','/inc/administrator.php', '/inc/settings.php');
	
	foreach ($files as $file) {
		if (!include_once( get_template_directory() . $file )) {
			if ( file_exists( get_template_directory() . $file ) ) {
				$error_message[]="PHP hasn't access to file ".$file.". Check the file permissions and try again please.";
			} else {
				$error_message[]="File ".$file." doesn't exists. Try to upload the theme again.";
			}
		}
	}
	
	if ( isset($error_message) ) {
		$stylesheet = get_option( 'theme_switched' );
		switch_theme( $stylesheet, $stylesheet );
		$message="<h2>The theme wasn't activated by following reasons:</h2><ul><li>".implode("</li><li>",$error_message)."</li></ul>"."Your theme was switched back to ".$stylesheet.".";
		wp_die($message,'',array('back_link'=>"/wp-admin/themes.php"));
	}
	
		
	
	wp_redirect(admin_url( 'admin.php?page=general' ));
		
    exit();
