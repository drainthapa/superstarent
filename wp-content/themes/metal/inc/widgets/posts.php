<?php

global $theme;

$posts_defaults = array(
    'title' => 'Recent Posts',
    'posts_number' => '5',
    'order_by' => 'none',
	'display_content' => 'true',
    'display_title' => 'true',
	'display_date' => 'true',
    'display_featured_image' => 'true',
    'excerpt_length' => '120',
    'filter' => 'recent',
    'filter_cats' => '',
    'filter_tags' => ''
);

        


class Posts extends WP_Widget 
{
    function __construct() 
    {
        $widget_options = array('description' => 'Advanced widget for displaying the recent posts or posts from the selected categories or tags.');
        $control_options = array( 'width' => 400);
		$this->WP_Widget('posts', '&raquo; Posts with Images', $widget_options, $control_options);
    }

    function widget($args, $instance){
	global $post;
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        
    ?>
	
        <?php echo $args['before_widget']?>
        <?php  if ( $title ) {  ?><?php echo $args['before_title']?><?php echo $title?><?php echo $args['after_title']?><?php }  ?>
            <ul>
        	<?php
                switch ($instance['order_by']) {
                    case 'none' : $order_query = ''; break;
                    case 'id_asc' : $order_query = '&orderby=ID&order=ASC'; break;
                    case 'id_desc' : $order_query = '&orderby=ID&order=DESC'; break;
                    case 'date_asc' : $order_query = '&orderby=date&order=ASC'; break;
                    case 'date_desc' : $order_query = '&orderby=date&order=DESC'; break;
                    case 'title_asc' : $order_query = '&orderby=title&order=ASC'; break;
                    case 'title_desc' : $order_query = '&orderby=title&order=DESC'; break;
                    default : $order_query = '&orderby=' . $instance['order_by'];
                    
                }
                switch ($instance['filter']) {
                    case 'cats' : $filter_query = '&cat=' . trim($instance['filter_cats']) ; break;
                    case 'category' : $filter_query = '&cat=' . trim($instance['selected_category']) ; break;
                    case 'tags' : $filter_query = '&tag=' . trim($instance['filter_tags']) ; break;
                    default : $filter_query = '';
                }
	
                $posts=get_posts('posts_per_page=' . $instance['posts_number'] . $filter_query . $order_query);
				
                if ( count($posts) >0  ):
				foreach($posts as $p) {?>
                    <li>
						<?php if ( ($instance['display_date']) ) { 
							$date=explode(':',get_the_time('F:j', $p->ID));
							$day=$date[1];
							$month=$date[0];
							$class=' class="withdate"';
						?>
						<span class='date'><span class='day'><?php echo $day; ?></span><br /><?php echo $month; ?></span>
						<?php } else $class='';?>
                        <?php if ($instance['display_featured_image'] && has_post_thumbnail($p->ID) ) { ?><?php echo get_the_post_thumbnail($p->ID,array(56,56), array()); ?> <?php } ?>
                        <?php if ( $instance['display_title'] ) { ?> <a href="<?php echo get_permalink($p->ID); ?>" rel="bookmark" title="<?php echo $p->post_title; ?>"><?php echo $p->post_title?></a><?php } ?>
						<?php if ( $instance['display_content'] ) { ?> 
							<?php echo "<p".$class.">".strip_tags(smtheme_excerpt('maxchar='.$instance['excerpt_length'], $p->ID),'<strong><b><i><p><abbr><acronim><cite><q><strike>')."</p>"; ?>
						<?php } ?>
                    </li>
                <?php
                }
                endif;
                
            ?>
            </ul>
         <?php echo $args['after_widget']?>
        <?php
    }

    function update($new_instance, $old_instance){
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
        $instance['posts_number'] = strip_tags($new_instance['posts_number']);
        $instance['order_by'] = strip_tags($new_instance['order_by']);
		$instance['display_content'] = strip_tags($new_instance['display_content']);
        $instance['display_title'] = strip_tags($new_instance['display_title']);
		$instance['display_date'] = strip_tags($new_instance['display_date']);
        $instance['display_featured_image'] = strip_tags($new_instance['display_featured_image']);
        $instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
        $instance['filter'] = strip_tags($new_instance['filter']);
        $instance['filter_cats'] = strip_tags($new_instance['filter_cats']);
        $instance['selected_category'] = strip_tags($new_instance['selected_category']);
        $instance['filter_tags'] = strip_tags($new_instance['filter_tags']);
        return $instance;
    }
    
    function form($instance) 
    {	
        global $posts_defaults;
		$instance = wp_parse_args( (array) $instance, $posts_defaults );
        
        ?>
        
        <div class="tt-widget">
            <table width="100%">
                <tr>
                    <td class="tt-widget-label" width="25%"><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label></td>
                    <td class="tt-widget-content" width="75%"><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></td>
                </tr>
                
                <tr>
                    <td class="tt-widget-label"><label for="<?php echo $this->get_field_id('posts_number'); ?>">Number Of Posts:</label></td>
                    <td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('posts_number'); ?>" name="<?php echo $this->get_field_name('posts_number'); ?>" type="text" value="<?php echo esc_attr($instance['posts_number']); ?>" /></td>
                </tr>
				<tr>
					<td class="tt-widget-label"><label for="<?php echo $this->get_field_id('excerpt_length'); ?>">The Excerpt Length:</label></td>
                    <td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo esc_attr($instance['excerpt_length']); ?>" /></td>
				</tr>
                
                <tr>
                    <td class="tt-widget-label"><label for="<?php echo $this->get_field_id('order_by'); ?>">Order Posts By:</label></td>
                    <td class="tt-widget-content">
                        <select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
                            <option value="none" <?php selected('none', $instance['order_by']); ?> >None (Default)</option>
                            <option value="id_asc" <?php selected('id_asc', $instance['order_by']); ?> >ID ( Ascending ) </option>
                            <option value="id_desc" <?php selected('id_desc', $instance['order_by']); ?> >ID ( Descending ) </option>
                            <option value="date_asc"  <?php selected('date_asc', $instance['order_by']); ?>>Date ( Ascending ) </option>
                            <option value="date_desc"  <?php selected('date_desc', $instance['order_by']); ?>>Date ( Descending ) </option>
                            <option value="title_asc" <?php selected('title_asc', $instance['order_by']); ?>>Title ( Ascending ) </option>
                            <option value="title_desc" <?php selected('title_desc', $instance['order_by']); ?>>Title ( Descending  ) </option>
                            <option value="rand" <?php selected('rand', $instance['order_by']); ?>>Random</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="tt-widget-label">Display Elements:</td>
                    <td class="tt-widget-content">
                        <input type="checkbox" name="<?php echo $this->get_field_name('display_title'); ?>"  <?php checked('true', $instance['display_title']); ?> value="true" />  Post Title
						<br /><input type="checkbox" name="<?php echo $this->get_field_name('display_content'); ?>"  <?php checked('true', $instance['display_content']); ?> value="true" /> Content
                        <br /><input type="checkbox" name="<?php echo $this->get_field_name('display_featured_image'); ?>"  <?php checked('true', $instance['display_featured_image']); ?> value="true" /> Thumbnail
						<br /><input type="checkbox" name="<?php echo $this->get_field_name('display_date'); ?>"  <?php checked('true', $instance['display_date']); ?> value="true" /> Date
                    </td>
                </tr>
                
               
            
                <tr>
                    <td class="tt-widget-label">Filter:</td>
                    <td class="tt-widget-content" style="padding-top: 5px;">
                        <input type="radio" name="<?php echo $this->get_field_name('filter'); ?>" <?php checked('recent', $instance['filter']); ?> value="recent" /> Show Recent Posts <br /><br />
                       
                        <input type="radio" name="<?php echo $this->get_field_name('filter'); ?>" <?php checked('category', $instance['filter']); ?> value="category" /> Show Posts from a sinle category:<br />
                        <select name="<?php echo $this->get_field_name('selected_category'); ?>">
                        <?php
                            $categories = get_categories('hide_empty=0');
                            foreach ($categories as $category) {
                                $category_selected = $this->get_field_name('selected_category') == $category->cat_ID ? ' selected="selected" ' : '';
                                ?>
                                <option value="<?php echo $category->cat_ID; ?>" <?php selected($category->cat_ID, $instance['selected_category']); ?> ><?php echo $category->cat_name; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <br /><br />
                        
                        <input type="radio" name="<?php echo $this->get_field_name('filter'); ?>" <?php checked('cats', $instance['filter']); ?> value="cats" /> <label for="<?php echo $this->get_field_id('filter_cats'); ?>">Show posts from  selected categories:</label>
                        <br /><span class="tt-widget-help">Category IDs ( e.g: 5,9,24 )</span>
                        <br /><input class="widefat" id="<?php echo $this->get_field_id('filter_cats'); ?>" name="<?php echo $this->get_field_name('filter_cats'); ?>" type="text" value="<?php echo esc_attr($instance['filter_cats']); ?>" />
                        
                        
                        <br /><br /><input type="radio" name="<?php echo $this->get_field_name('filter'); ?>" <?php checked('tags', $instance['filter']); ?> value="tags" /> <label for="<?php echo $this->get_field_id('filter_tags'); ?>">Show only posts tagged with:</label>
                        <br /><span class="tt-widget-help">Tag slugs ( e.g: computer,news,business-news )</span>
                        <br /><input class="widefat" id="<?php echo $this->get_field_id('filter_tags'); ?>" name="<?php echo $this->get_field_name('filter_tags'); ?>" type="text" value="<?php echo esc_attr($instance['filter_tags']); ?>" />
                        
                    </td>
                </tr>
                
            </table>
          </div>
        <?php 
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("Posts");'));
?>