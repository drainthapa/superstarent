<?php
$social_links = beat_mix_lite_get_socials();
if($social_links):
?>
	<ul class="social-links pull-right clearfix">
		<?php
		foreach($social_links as $social_slug => $social):
			$url = get_theme_mod($social_slug, false);
			if($url):
			?>
	  		<li>
	  			<a href="<?php echo esc_url($url); ?>" class="<?php echo esc_attr($social[1]); ?>"></a>
	  		</li>
	  	<?php
	  	endif;
	  endforeach;
	  ?>  
	</ul>
<?php
endif;