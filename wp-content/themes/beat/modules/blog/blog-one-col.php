<div class="widget kopa-blog-classic-widget">
	<ul>
		<?php
		while (have_posts()) : 
			the_post();
			?>
	      <li>
	          <article <?php post_class(array('entry-item', 'entry-item')); ?>>
	              <?php if(is_sticky()): ?>
		              <span class="sticky-post">
		              	<i class="fa"></i>
		              </span>
		            <?php endif;?>

		            <?php if(has_post_thumbnail() && !is_search()): ?>
	              <div class="entry-thumb">
	                  <a href="<?php the_permalink(); ?>">
	                  	<?php the_post_thumbnail('beat_mix_lite_blog_once_col', array('class' => 'img-responsive')); ?>
	                  </a>
	                  <div class="mask"><a href="<?php the_permalink(); ?>"><i class="fa fa-plus"></i></a></div>
	              </div>
	            	<?php endif;?>

	              <div class="entry-content">
	                  <header>
	                      <span class="entry-date"><?php echo esc_attr(get_the_date()); ?></span>
	                      <span class="entry-meta"> / </span>
	                      <span class="entry-author">
	                      	<span><?php esc_attr_e('by', 'beat-mix-lite'); ?></span>
	                      	<?php the_author_link(); ?>
	                      </span>
	                  </header>

	                  <h3 class="entry-title">
	                  	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                  </h3>
	                  
	                  <div class="entry-excerpt">
	                      <?php 
	                      the_excerpt();
	                      ?>
	                  </div>
	                  
	                  <footer>
	                      <a href="<?php the_permalink(); ?>" class="more-link">
	                          <span class="pull-left"><?php esc_attr_e('Continue reading', 'beat-mix-lite'); ?></span>
	                          <i class="fa fa-long-arrow-right pull-left"></i>
	                      </a>
	                  </footer>
	              </div>

	          </article>
	      </li>

			<?php
		endwhile;
		?>
	</ul>

	<?php get_template_part('modules/blog/pagination'); ?>
</div>