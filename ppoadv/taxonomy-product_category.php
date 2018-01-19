<?php get_header(); ?>

<div class="row content">
    <div class="col-sm-9 main">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumb">', '</div>');
        }
        ?>
        <div class="tax-des">
            <?php the_archive_description(); ?>
        </div>
        <div class="listproduct">
            <?php
            $taxonomy = 'product_category';
            $this_term = get_queried_object();
            $this_ID = $this_term->term_id;
            $args = array(
                'parent' => $this_ID,
                'hide_empty' => false,
            );
            $terms = get_terms($taxonomy, $args);
            if (!empty($terms)) :
                ?>
                <?php
                foreach ($terms as $term) :
                    ?>
                    <div class="col-md-4 col-sm-4 col-xs-12 box">
                        <div class="thumbnail pdt">
                            <div class="productimg">
                                <div class="image"> 
                                    <a title="<?php echo $term->name; ?>" href="<?php echo get_category_link($term); ?>" class="preview" rel="<?php the_field('product_cat_images', $term); ?>">
                                        <img alt="<?php echo $term->name; ?>" class="img-responsive" src="<?php the_field('product_cat_images', $term); ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3>
                                    <a title="<?php echo $term->name; ?>" href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a>
                                </h3>
                                <p><?php echo $term->description; ?></p>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            <?php else: ?>
                <?php
                global $wp_query;
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'product',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'id',
                            'terms' => $this_term->term_id,
                        )
                    ),
                    'posts_per_page' => 9,
                    'paged' => $paged,
                );
                query_posts($args);
                while (have_posts()) : the_post();
                    ?>
                    <div class="col-md-4 col-sm-4 col-xs-12 box">
                        <div class="thumbnail pdt">
                            <div class="productimg">
                                <div class="image"> 
                                    <a title="<?php the_title() ?>" href="<?php the_permalink(); ?>" class="preview" rel="<?php echo get_image_url(); ?>">
                                        <img alt="<?php the_title() ?>" class="img-responsive" src="<?php echo get_image_url(true, 'thumb'); ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3>
                                    <a title="<?php the_title() ?>" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                                </h3>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                ?>
                <?php getpagenavi(); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-3 sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>