<?php

if (is_single()) {
    $limit  = '3';
    $taxs = array();

    global $post;    
    $tags = get_the_tags($post->ID);

    if ($tags) {
        $ids = array();
        foreach ($tags as $tag) {
            $ids[] = $tag->term_id;
        }
        $taxs [] = array(
            'taxonomy' => 'post_tag',
            'field' => 'id',
            'terms' => $ids
        );
    }

    if ($taxs) {
        $related_args = array(
            'tax_query' => $taxs,
            'post__not_in' => array($post->ID),
            'posts_per_page' => $limit
        );

        $related_posts = new WP_Query($related_args);
        if ($related_posts->have_posts()):
            ?>            
            <div id="related-post">
                <h3 class="text-center"><?php esc_attr_e('Related articles', 'beat-mix-lite'); ?></h3>
                <div class="row">
                    <?php
                    while ($related_posts->have_posts()):
                        $related_posts->the_post();                            
                        ?>
                        <div class="col-md-4 col-sm-4">

                            <article class="entry-item">
                                
                                <div class="entry-content">
                                    <span class="entry-date"><?php echo esc_attr(get_the_date()); ?></span>
                                    <h4 class="entry-title entry-title-s1">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div>

                                <?php if(has_post_thumbnail()): ?>
                                <div class="entry-thumb">
                                    <a href="<?php the_permalink();?>">
                                        <?php the_post_thumbnail('beat_mix_lite_related', array('class' => 'img-responsive')); ?>
                                    </a>
                                    <div class="mask">
                                        <a href="<?php the_permalink();?>"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <?php endif;?>
                            </article>
                            
                        </div>
                        <?php
                    endwhile;
                    ?>
                </div>
            </div>                    
            <?php
        endif;
        wp_reset_postdata();
    }
}


                


                    