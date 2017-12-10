<?php

get_header();

?>

<section class="error-404 row clearfix">
	<div class="col-md-6 col-sm-6 col-xs-12 left-col">
		<p><?php esc_html_e('404','beat-mix-lite'); ?></p>
	</div><!--col-md-6-->
	<div class="col-md-6 col-sm-6 col-xs-12 right-col">
		<h1><?php esc_html_e('Page not found...','beat-mix-lite'); ?></h1>
		<p><?php esc_html_e("We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it we'll try to fix it. In the meantime, try one of this options:",'beat-mix-lite'); ?></p>
		<ul class="arrow-list">
			<li><a href="javascript: history.go(-1);"><?php esc_html_e( 'Go back to previous page', 'beat-mix-lite' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Go to homepage', 'beat-mix-lite' ); ?></a></li>
		</ul>
	</div><!--col-md-6-->
</section><!--error-404-->

<?php
get_footer();

