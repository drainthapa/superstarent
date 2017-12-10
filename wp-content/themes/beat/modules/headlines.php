<?php

$is_show_headlines = (int)get_theme_mod('is_show_headlines', 1);

if($is_show_headlines):
    $args = array(
        'post_type'           => array('post'),
        'posts_per_page'      => (int)apply_filters('beat_mix_lite_get_headlines_number_of_post', 10),
        'post_status'         => array('publish'),
        'ignore_sticky_posts' => true
    );
    $resuls_set = new WP_Query($args);

    if ($resuls_set->have_posts()):
        ?>
            <div class="kp-headline-wrapper pull-left clearfix">
                <div class="kp-headline clearfix">                        
                    <dl class="ticker-1 clearfix">
                        <?php while ($resuls_set->have_posts()): $resuls_set->the_post(); ?>
                            <dt></dt>
                            <dd>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </dd>
                        <?php endwhile; ?>
                    </dl>
                    <!--ticker-1-->
                </div>
                <!--kp-headline-->
            </div>
        <?php
    endif;
endif;

