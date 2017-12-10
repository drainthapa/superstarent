<?php
$social_links = beat_mix_lite_get_socials();
if($social_links):
	?>
	<div class="footer-social-box">
		<div class="wrapper">
			<ul class="socials-link clearfix">
				<?php
				foreach($social_links as $social_slug => $social):
					$url = get_theme_mod($social_slug, false);
					if($url):
					?>
						<li>
							<a class="clearfix" href="<?php echo esc_url($url); ?>">
								<i class="<?php echo esc_attr($social[1]); ?> pull-left"></i>
								<span class="pull-left"><?php echo esc_attr($social[0]); ?></span>
							</a>
						</li>				
					<?php
			  	endif;
			  endforeach;
			  ?>  						
			</ul>
			<!-- socials-link -->
		</div>
		<!-- wrapper -->
	</div>
	<?php
endif;