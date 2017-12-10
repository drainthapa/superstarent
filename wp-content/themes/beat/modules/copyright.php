 <?php 
$footer_information = get_theme_mod('copyright', false);
if($footer_information):
?>
	<p id="copyright" class="pull-left"><?php echo wp_kses_post($footer_information); ?></p>
<?php
endif;