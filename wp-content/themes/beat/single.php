<?php

get_header();

?>
<div <?php post_class(array('entry-box', 'standard-post')); ?>>

	<?php
	if (have_posts()):	
		while (have_posts()) : the_post();	
			$user_id    = $post->post_author;				
			$user_email = get_the_author_meta('user_email', $user_id);
			$user_url   = trim(get_the_author_meta('user_url', $user_id));
			$user_link  = ($user_url) ? $user_url : get_author_posts_url($user_id);
		?> 	
    <h2 class="entry-title"><?php the_title(); ?></h2>

    <div class="entry-thumb">
        <?php the_post_thumbnail('beat_mix_lite_single'); ?>
    </div>

    <div class="entry-content-wrap">

        <div class="left-col">            
            <div class="about-author">
                <div class="author-avatar">
                	<a href="<?php echo esc_url($user_link); ?>">
                		<?php echo get_avatar($user_email, 80); ?>
                	</a>
                </div>
                <div class="author-content">
                    <h5><?php esc_attr_e('By', 'beat-mix-lite'); ?> <?php the_author_link(); ?></h5>                                                
                </div>
            </div>
        </div>

        <div class="entry-content clearfix">
					<?php the_content(); ?>            
        </div>
        <!-- entry-content -->
        
    </div>
    <!-- entry-content-wrap -->
       
    <?php get_template_part('modules/single/paged'); ?>

    <?php get_template_part('modules/single/category'); ?>

    <?php get_template_part('modules/single/tag'); ?>

    <?php get_template_part('modules/single/posts', 'adjacent'); ?>

		<?php 
		endwhile;		
	endif; ?>

</div>

<?php get_template_part('modules/single/author'); ?>

<?php get_template_part('modules/single/posts', 'related'); ?>

<?php comments_template(); ?>

<?php
get_footer();