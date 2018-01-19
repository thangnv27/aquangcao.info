<?php get_header(); ?>

<div class="row content">
    <div class="col-sm-9 main">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumb">', '</div>');
        }
        ?>
        <?php while (have_posts()) : the_post(); ?>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="row product-info">
                <div class="col-sm-5">
                    <div class="product-info-img">
                        <img style="border-radius:10px;" alt="<?php the_title(); ?>" data-zoom-image="<?php echo get_image_url(); ?>" src="<?php echo get_image_url(); ?>" title="<?php the_title(); ?>" id="zoom">
                    </div>
                </div>
                <div class="col-sm-7 detail-product">
                    <?php echo get_post_meta(get_the_ID(), 'product_des', true); ?>
                    <div class="share">
                        <?php show_share_socials(); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="post-content">
                <?php the_content(); ?>
                <?php endwhile; // end of the loop. ?>
                <div class="fb-comments mt20" data-width="100%" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light"></div> 
                <div class="relate">
                    <div class="titlecat">
                        <h2>
                            <span>Sản phẩm liên quan</span>
                        </h2>
                    </div>
                    <div class="listproduct">
                        <?php
                            $taxonomy = 'product_category';
                            $terms = get_the_terms(get_the_ID(), $taxonomy);
                            $terms_id = array();
                            foreach ($terms as $term) {
                                array_push($terms_id, $term->term_id);
                            }
                            $loop = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => 4,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'id',
                                        'terms' => $terms_id,
                                    )
                                ),
                                'post__not_in' => array(get_the_ID()),
                            ));
                            while ($loop->have_posts()) : $loop->the_post();
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
                        wp_reset_query();
                        ?>
                    </div>
                </div>
            </div>      
    </div>
    <div class="col-sm-3 sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>