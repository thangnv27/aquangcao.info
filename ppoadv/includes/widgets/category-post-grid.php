<?php

class Category_Post_Grid_Widget extends WP_Widget {

    function Category_Post_Grid_Widget() {
        $widget_ops = array('classname' => 'cat-post-grid-widget', 'description' => 'Bài viết được bình luân nhiều nhất.');
        $control_ops = array('id_base' => 'cat_post_grid_widget');
        $this->WP_Widget('cat_post_grid_widget', 'PPO: Category Posts Grid', $widget_ops, $control_ops);
    }

    /**
     * Displays category posts widget on blog.
     *
     * @param array $instance current settings of widget .
     * @param array $args of widget area
     */
    function widget($args, $instance) {
        global $post;
        extract($args);

        $term_id = trim($instance["cat"]);
        $category_info = get_category($term_id);
        // If not title, use the name of the category.
        if (!$instance["widget_title"]) {
            $instance["widget_title"] = $category_info->name;
        }
        
        echo $before_widget;
        // Widget title
        echo $before_title;
        echo '<div class="title_active title">';
        echo '<a title="' . $instance["widget_title"] . '" href="' . get_category_link($term_id) . '">' . $instance["widget_title"] . '</a>';
        echo '</div>';
        echo '<ul class="sub_c">';
        wp_list_categories(array(
            'title_li' => '',
            'child_of' => $term_id
        ));
        echo '</ul>';
        echo $after_title;
        
        $cat_posts = new WP_Query(array(
            'showposts' => $instance["num"],
            'cat' => $term_id,
        ));
        $count = 1;
        
        echo "<div class='cat-post-grid-widget'>";
        while ($cat_posts->have_posts()) : $cat_posts->the_post();
            if($count %3 == 0){
                echo '<div class="items mr0">';
            }else{
                echo '<div class="items">';
            }
        ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <img title="<?php the_title(); ?>" alt="<?php the_title(); ?>" src="<?php get_image_url(true, '200x150'); ?>" width="100%" height="150" />
                </a>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h3><?php the_title(); ?></h3></a>
            </div>
            <?php
            if($count %3 == 0){
                echo '<div class="clear"></div>';
            }
            $count++;
        endwhile;
        wp_reset_query();
        ?>
        </div>
        <div class="clear"></div>
        <?php
        $tag_meta = get_option("cat_$term_id");
        $ad_cat1 = trim($tag_meta['ad_cat1']);
        $ad_cat2 = trim($tag_meta['ad_cat2']);
        if (!empty($ad_cat1)) {
            echo "<div class='ad-cat-bottom mr8'>$ad_cat1</div>";
        }
        if (!empty($ad_cat2)) {
            echo "<div class='ad-cat-bottom'>$ad_cat2</div>";
        }

        echo $after_widget;
    }

    /**
     * Form processing...
     *
     * @param array $new_instance of widget .
     * @param array $old_instance of widget .
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['cat'] = $new_instance['cat'];
        $instance['num'] = $new_instance['num'];
        return $instance;
    }

    /**
     * The configuration form.
     *
     * @param array $instance of widget to display already stored value .
     * 
     */
    function form($instance) {
        ?>		
        <p>
            <label for="<?php echo $this->get_field_id("widget_title"); ?>">Tiêu đề</label>
            <input class="widefat" id="<?php echo $this->get_field_id("widget_title"); ?>" name="<?php echo $this->get_field_name("widget_title"); ?>" type="text" value="<?php echo esc_attr($instance["widget_title"]); ?>" />
        </p>
        <p>
            <label>Chuyên mục</label><br />
            <?php wp_dropdown_categories(array('name' => $this->get_field_name("cat"), 'show_option_all' => 'All', 'hide_empty' => 0, 'selected' => $instance["cat"])); ?>
        </p>
        <p>
            <label>Số tin</label><br />
            <input class="widefat" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo intval($instance["num"]); ?>" />
        </p>
        <?php
    }

}
