<?php global $SMTheme; ?>
<?php if (!$SMTheme->get( 'layout', 'dpagination' )) { ?>
<div class='pagination classic'>
			<?php
global $wp_query;
$big = 999999999; 
			echo paginate_links( array(
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?>
</div>

<?php } else { 
	$currentpage=max( 1, get_query_var('paged') );
	if ($wp_query->max_num_pages > $currentpage) {
?>	
<div class='pagination'>
	<a class="nextpage" alt='<?php echo ($currentpage+1) ?>' href='<?php echo get_pagenum_link($currentpage+1) ?>'><?php echo $SMTheme->_( 'nextpage' ); ?></a>
</div>
<?php } }?>