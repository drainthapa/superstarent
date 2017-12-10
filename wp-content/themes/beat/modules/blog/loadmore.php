<?php

global $wp, $wp_rewrite;

$url     = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
$current = (intval( get_query_var( 'paged' ) )) ? intval( get_query_var( 'paged' ) ) : 1;

if ( $wp_rewrite->using_permalinks() ) {
	$url = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/', 'paged=' );
} else {
	$url = sprintf( '%s&paged=', $url );
}
?>

<div id="beat_mix_lite_loadmore" class="load-more text-center" data-url="<?php echo esc_url( $url ); ?>" data-paged="<?php echo esc_attr( $current + 1 ); ?>">
	<a class="beat_mix_lite_loadmore_button" href="#"><i class="fa fa-long-arrow-down"></i></a>
	<span class="text-uppercase"><?php esc_attr_e('Load more', 'beat-mix-lite'); ?></span>	
</div>