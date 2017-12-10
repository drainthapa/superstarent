<?php
$logo = get_theme_mod('logo', false);
if($logo):
?>
	<div id="logo-image" class="pull-left">
	    <a href="<?php echo esc_attr(home_url('/')); ?>">    	
	    	<img src="<?php echo esc_url($logo); ?>" alt="">
	    </a>
	</div>
<?php else: ?>
	<div id="logo-image" class="logo-text pull-left">
		<a href="<?php echo esc_url(home_url('/')); ?>">
		  <?php if(is_front_page() || is_home()): ?>
		      <h1 id="site-title"><?php echo esc_attr(get_bloginfo('name'));?></h1>
		  <?php else: ?>
		      <p id="site-title"><?php echo esc_attr(get_bloginfo('name'));?></p>
		  <?php endif;?>
		</a>	    
	</div>
<?php
endif;	