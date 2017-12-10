<?php
/**
 * Post formats template for this theme.
 *
 * @package TA Music
 */
 ?>

<?php $meta = get_post_custom( $post->ID ); ?>

<?php if ( has_post_format( 'audio' ) ) : // Audio ?>

	<div class="post-image">
	<?php if ( isset( $meta['_cmb_album_embed'][0] ) && !empty( $meta['_cmb_album_embed'][0] ) ) { ?>
		<?php echo $meta['_cmb_album_embed'][0]; ?>
	<?php } elseif ( has_post_thumbnail() ) { ?>
		<a href="<?php echo get_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'full', array( 'class' => "img-responsive" ) ); ?></a>
	<?php } ?>
	</div>

<?php endif; ?>

<?php if ( has_post_format( 'gallery' ) ): // Gallery ?>

	<div class="post-image">
		<?php
			$images = ta_post_images();
			if ( !empty( $images ) ):
		?>

		<div class="flexslider post-gallery">
			<ul class="slides">
			<?php
				foreach ( $images as $image ):
				$imageurl = wp_get_attachment_image_src( $image->ID, 'full' );
			?>
				<li>
					<img class="img-responsive" src="<?php echo $imageurl[0]; ?>" alt="<?php echo $image->post_title; ?>" />
				</li>
			<?php endforeach; ?>
			</ul>
		</div>

		<?php endif; ?>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'video' ) ): // Video ?>

	<div class="post-image">
	<?php if ( isset( $meta['_cmb_video_code'][0] ) && !empty( $meta['_cmb_video_code'][0] ) ) : ?>
		<?php echo $meta['_cmb_video_code'][0]; ?>
	<?php endif; ?>
	</div>

<?php endif; ?>