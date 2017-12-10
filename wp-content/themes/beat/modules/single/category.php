<?php if(has_category()): ?>
  <div class="tag-box category-box text-center">
      <span><i class="fa fa-book"></i>&nbsp;<?php esc_attr_e('Category:', 'beat-mix-lite'); ?></span>
			<?php the_category(' '); ?>
  </div>
<?php endif;    