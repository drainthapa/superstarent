<?php
global $post, $wp_query;
$current_class     = 'current-page';
$prefix            = '  /  ';
$breadcrumb_before = '<div class="breadcrumb clearfix"> ';
$breadcrumb_after  = '</div>';
$breadcrumb_home   = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . home_url() . '" itemprop="url"><span itemprop="title">' . esc_attr__( 'Home', 'beat-mix-lite' ) . '</span></a></span>';
$breadcrumb        = $breadcrumb_home;
$page_title        = '';

if ( is_archive() ) {
	if ( is_tag() ) {
		$term       = get_term( get_queried_object_id(), 'post_tag' );
		$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, $term->name );
		$page_title = $term->name;
	} else if ( is_category() ) {
		$terms_link = explode( $prefix, substr( get_category_parents( get_queried_object_id(), true, $prefix ), 0, (strlen( $prefix ) * -1) ) );
		$n = count( $terms_link );
		if ( $n > 1 ) {
			for ( $i = 0; $i < ($n - 1); $i++ ) {
				$breadcrumb .= $prefix . $terms_link[ $i ];
			}
		}
		$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_category_by_ID( get_queried_object_id() ) );

		$term       = get_term( get_queried_object_id(), 'category' );
		$page_title = $term->name;
	} else if ( is_year() || is_month() || is_day() ) {

		$m = get_query_var( 'm' );
		$date = array( 'y' => null, 'm' => null, 'd' => null );
		if ( strlen( $m ) >= 4 ) {
			$date['y'] = substr( $m, 0, 4 ); }
		if ( strlen( $m ) >= 6 ) {
			$date['m'] = substr( $m, 4, 2 ); }
		if ( strlen( $m ) >= 8 ) {
			$date['d'] = substr( $m, 6, 2 ); }
		if ( $date['y'] ) {
			if ( is_year() ) {
				$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, $date['y'] ); }
		} else {
			$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_year_link( $date['y'] ), $date['y'] ); }
		if ( $date['m'] ) {
			if ( is_month() ) {
				$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, date( 'F', mktime( 0, 0, 0, $date['m'] ) ) ); }
		} else {
					$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_month_link( $date['y'], $date['m'] ), date( 'F', mktime( 0, 0, 0, $date['m'] ) ) ); }
		if ( $date['d'] ) {
			if ( is_day() ) {
				$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, $date['d'] ); }
		} else {
							$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_day_link( $date['y'], $date['m'], $date['d'] ), $date['d'] ); }
	} else if ( is_author() ) {
		$author_id = get_queried_object_id();
		$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, sprintf( __( 'Posts created by %1$s', 'beat-mix-lite' ), get_the_author_meta( 'display_name', $author_id ) ) );
		$page_title = get_the_author_meta( 'display_name', $author_id );
	}
} else if ( is_search() ) {
	$s = get_search_query();
	$c = $wp_query->found_posts;
	$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, sprintf( __( 'Searched for "%s" return %s results', 'beat-mix-lite' ), $s, $c ) );
	$page_title = esc_attr__( 'Search', 'beat-mix-lite' );
} else if ( is_singular() ) {
	if ( is_page() ) {
		if ( is_front_page() ) {
			$breadcrumb = get_bloginfo( 'description' );
			$page_title = get_bloginfo( 'name' );
			;
		} else {
			$post_ancestors = get_post_ancestors( $post );
			if ( $post_ancestors ) {
				$post_ancestors = array_reverse( $post_ancestors );
				foreach ( $post_ancestors as $crumb ) {
					$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_permalink( $crumb ), esc_html( get_the_title( $crumb ) ) ); }
			}
			$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url" href="%2$s"><span itemprop="title">%3$s</span></a></span>', $current_class, get_permalink( get_queried_object_id() ), esc_html( get_the_title( get_queried_object_id() ) ) );
			$page_title = get_the_title( get_queried_object_id() );
		}
	} else if ( is_single() ) {
		$categories = get_the_category( get_queried_object_id() );
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', get_term_link( $category, 'category' ), $category->name );
			}
		}
		$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url" href="%2$s"><span itemprop="title">%3$s</span></a></span>', $current_class, get_permalink( get_queried_object_id() ), esc_html( get_the_title( get_queried_object_id() ) ) );
		$page_title = get_the_title( get_queried_object_id() );
	}
} else if ( is_404() ) {
	$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, esc_attr__( 'Page not found', 'beat-mix-lite' ) );
	$page_title = esc_attr__( '404', 'beat-mix-lite' );
} else {
	$breadcrumb .= $prefix . sprintf( '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, esc_attr__( 'Latest News', 'beat-mix-lite' ) );
	$page_title = esc_attr__( 'Home', 'beat-mix-lite' );
}

echo empty( $page_title ) ? '' : sprintf( '<h1 class="page-title">%s</h1>', wp_kses_post( $page_title ) );
echo wp_kses_post( $breadcrumb_before );
$data = apply_filters( 'beat_mix_lite_get_breadcrumb', $breadcrumb, $current_class, $prefix );

$allowed_html                  = wp_kses_allowed_html();
$allowed_html['ul']['class']   = true;
$allowed_html['li']['class']   = true;
$allowed_html['span']['class'] = true;
$allowed_html['i']['class']    = true;
$allowed_html['a']['class']    = true;

echo wp_kses( $data, $allowed_html );

echo wp_kses_post( $breadcrumb_after );
