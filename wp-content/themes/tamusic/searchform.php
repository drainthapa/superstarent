<?php
/**
 * Search Form Template
 *
 * @package TA Music
 */
?>

<form name="search-form" class="search-form" method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" value="" name="s" class="search-term" placeholder="<?php esc_attr_e( 'Search entire blog here...', 'ta-meghna' ); ?>" />
	<input type="submit" value="" class="search-submit" />
</form>