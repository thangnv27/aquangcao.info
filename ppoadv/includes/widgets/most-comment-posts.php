<?php

class Most_Comment_Posts_Widget extends WP_Widget {

    function Most_Comment_Posts_Widget() {
        $widget_ops = array('classname' => 'most-comment-posts', 'description' => 'Bài viết được bình luân nhiều nhất.');
        $control_ops = array('id_base' => 'most_comment_posts_widget');
        $this->WP_Widget('most_comment_posts_widget', 'PPO: Bình luận nhiều nhất', $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array('title' => 'Bình luận nhiều nhất', 'num' => 10);
        $instance = wp_parse_args((array) $instance, $defaults);

        $display = '<p><label for="' . $this->get_field_id('title') . '">Tiêu đề:</label>
			<input id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" />
		</p>';
        $display .= '<p><label for="' . $this->get_field_id('num') . '">Số lượng tin:</label>
			<input id="' . $this->get_field_id('num') . '" name="' . $this->get_field_name('num') . '" value="' . $instance['num'] . '" />
		</p>';
        print $display;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num'] = intval($new_instance['num']);
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        if(!$instance['num'])
            $instance['num'] = 10;

        print $before_widget;
        if ($title) {
            print $before_title . $title . $after_title;
        }
        ?>
         <ul>
            <?php
            $posts = new WP_Query(array(
                'orderby' => 'comment_count',
                'posts_per_page' => $instance['num'],
                'order' => 'DESC'
            ));
            while ($posts->have_posts()) : $posts->the_post();?>		
                <li>
                    <div class="img_sidebar">
                        <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
                            <img width="150" height="135" src="<?php get_image_url(true, '150x135'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                        </a>
                    </div>
                    <div class="info_s">
                        <h6>
                            <a title="<?php the_permalink(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h6>
                        <div class="user_post">
                            <span class="date"><i class="fa fa-clock-o"></i> <?php the_time('d-m-Y'); ?></span>
                            <span class="com"><i class="fa fa-comments"></i> <?php print get_comments_number(); ?></span>
                        </div>
                    </div>
                    <div class="clear"></div>
                </li>
                <?php endwhile;wp_reset_query();?>
        </ul>
        <?php
        print $after_widget;
    }

}
