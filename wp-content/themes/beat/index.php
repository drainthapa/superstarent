<?php

get_header();

$blog_layout = get_theme_mod('blog-layout', 'one-col');
if($blog_layout){
	get_template_part('modules/blog/blog', $blog_layout);
}

get_footer();