<div class="right-col line-divider pull-left">
	<?php if (!is_user_logged_in()): ?>
		<a class="signin-button" href="<?php echo esc_url(wp_login_url(home_url('/'))); ?>"><?php esc_attr_e('Sign in', 'beat-mix-lite'); ?></a>
		<a class="reg-button" href="<?php echo esc_url(wp_registration_url()); ?>"><?php esc_attr_e('Register', 'beat-mix-lite'); ?></a>
	<?php else:?>
		<a class="signin-button" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_attr_e('Log out', 'beat-mix-lite'); ?></a>
	<?php endif;?>
</div>