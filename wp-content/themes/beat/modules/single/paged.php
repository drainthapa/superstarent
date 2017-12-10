<?php
wp_link_pages(array(
	'before'         => '<div class="page-links-wrapper text-center"><div class="page-links"> ',
	'after'          => '</div></div>',
	'next_or_number' => 'number',
	'pagelink'       => '<span>%</span>',
	'echo'           => true
));