<div class="widget kopa-masonry-list-1-widget">
	<div class="masonry-list-wrapper">
		<ul id="beat_mix_lite_loadmore_placeholder" class="clearfix">
			<?php
			while (have_posts()) : 
				the_post();
				

				?>
				<li class="masonry-item">

					<article <?php post_class(array('entry-item', 'entry-item')); ?>>
						<?php if(is_sticky()): ?>
					  	<span class="sticky-post"><i class="fa"></i></span>
					  <?php endif;?>

					  <div class="entry-content">
					      <header>
					      	<span class="entry-date"><?php echo esc_attr(get_the_date()); ?></span>
					      </header>

					      <h3 class="entry-title">
					      	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					      </h3>

					      <?php the_excerpt(); ?>					      
					  </div>

					  <?php if(has_post_thumbnail()): ?>
						  <div class="entry-thumb">
					      <a href="<?php the_permalink(); ?>">
					      	<?php the_post_thumbnail('beat_mix_lite_blog_masonry', array('class' => 'img-responsive')); ?>
					      </a>
					      <div class="mask"><a href="#"><i class="fa fa-plus"></i></a></div>
						  </div>
						<?php endif;?>
					</article>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>

	<?php 
	if(is_home() || is_category() || is_tag()){
	 	get_template_part('modules/blog/loadmore');
	}else{
		get_template_part('modules/blog/pagination');
	}
	?>

</div>