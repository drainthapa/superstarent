<?php

global $post;
$user_id     = $post->post_author;
$description = get_the_author_meta('description', $user_id);
$email       = get_the_author_meta('user_email', $user_id);
$name        = get_the_author_meta('display_name', $user_id);
$url         = trim(get_the_author_meta('user_url', $user_id));
$link        = ($url) ? $url : get_author_posts_url($user_id);

if (!empty($description)):
?>

<div class="about-author about-author-s2">
    <div class="author-bg"></div>
    <div class="mask"></div>
    <div class="author-avatar pull-left">
        <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($name); ?>">
            <?php echo get_avatar($email, 195); ?>
        </a>
    </div>
    <div class="author-content">
        <h5>
            <?php esc_attr_e('About', 'beat-mix-lite'); ?>
            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($name); ?>">
                <?php echo esc_attr($name); ?>
            </a>
        </h5>

        <p><?php echo esc_textarea($description); ?></p>
    </div>
</div>

<?php
endif;