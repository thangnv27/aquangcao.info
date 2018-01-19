<?php

class Category_Post_List1_widget extends WP_Widget {

    function Category_Post_List1_widget() {
        parent::WP_Widget(false, $name = "Category Post List1", array('description' => 'Display post under particular category'));
    }

    /**
     * Displays category posts widget on blog.
     *
     * @param array $instance current settings of widget .
     * @param array $args of widget area
     */
    function widget($args, $instance) {
        global $post;
        $post_old = $post; // Save the post object.
        extract($args);

        $term_id = trim($instance["cat"]);
        $category_info = get_category($term_id);
        // If not title, use the name of the category.
        if (!$instance["widget_title"]) {
            $instance["widget_title"] = $category_info->name;
        }
        
        echo '<div class="col">';
        echo '<h4><a title="' . $instance["widget_title"] . '" href="' . get_category_link($term_id) . '">' . $instance["widget_title"] . '</a></h4>';
        ?>
            <div class="itemfirts">
            <?php
            $cat_posts = new WP_Query(array(
                //'showposts' => $instance["num"],
                'cat' => $term_id,
                'posts_per_page' => 6
            ));
            $count = 1;
            while ($cat_posts->have_posts()) : $cat_posts->the_post();
                if ($count == 1):
                    ?>						
                        <div class="items_bottom">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <img title="<?php the_title(); ?>" alt="<?php the_title(); ?>" src="<?php get_image_url(true, '440x255'); ?>" width="100%" height="110" />
                            </a>
                            <h6>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            </h6>
                        </div>
                    </div>
                    <div class="itemlast">
                <?php else : ?>
                    <div class="items_bottom">
                        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div>
                <?php
                endif;
                $count++;
            endwhile;
            wp_reset_query();
            echo '</div>';
        echo '</div>';
        $post = $post_old; // Restore the post object.
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
        <?php
    }

}
