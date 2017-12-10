<?php
$prev_post = get_previous_post();
$next_post = get_next_post();

if ($prev_post || $next_post):
    ?>
    <footer class="entry-box-footer clearfix">
        <?php if ($prev_post): ?>
            <div class="prev-article pull-left clearfix">
                <a href="<?php echo esc_url(get_the_permalink($prev_post)); ?>" class="prev-icon fa fa-chevron-left"></a>
                <a href="<?php echo esc_url(get_the_permalink($prev_post)); ?>" class="prev-post"><?php esc_attr_e('Previous', 'beat-mix-lite'); ?></a>
                <h4><a href="<?php echo esc_url(get_the_permalink($prev_post)); ?>"><?php echo esc_attr(get_the_title($prev_post)); ?></a></h4>                
            </div>        
        <?php endif; ?>

        <?php if ($next_post): ?>
        <div class="next-article pull-left clearfix">
            <a href="<?php echo esc_url(get_the_permalink($prev_post)); ?>" class="next-icon fa fa-chevron-right"></a>
            <a href="<?php echo esc_url(get_the_permalink($prev_post)); ?>" class="next-post"><?php esc_attr_e('Next', 'beat-mix-lite'); ?></a>
            <h4><a href="<?php echo esc_url(get_the_permalink($next_post)); ?>"><?php echo esc_attr(get_the_title($next_post)); ?></a></h4>
        </div>
        <?php endif; ?>            
    </footer>
    <?php
endif;