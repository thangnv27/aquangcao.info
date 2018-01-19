<?php get_header(); ?>
<div class="row content">
    <div class="col-sm-9 main">
        <div class="homeproduct">
            <?php
            $taxonomy = 'product_category';
            $categories = get_categories(array(
                'title_li' => '',
                'show_option_none' => '',
                'taxonomy' => $taxonomy,
                'parent' => '0',
                'hide_empty' => 0,
                'show_count' => 0,
            ));
            foreach ($categories as $category):
                ?>
                <div class="showproduct">
                    <div class="titlecat">
                        <h2><a href="<?php echo get_term_link($category->term_id, $taxonomy); ?>"><?php the_field('product_cat_icons', $category); ?><?php echo $category->name; ?></a></h2>
                    </div>
                    <div class="clearfix"></div>

                    <div class="listproduct"><!-- list product-->
                        <?php
                        $categories = get_categories(array(
                            'title_li' => '',
                            'show_option_none' => '',
                            'taxonomy' => $taxonomy,
                            'parent' => $category->term_id,
                            'hide_empty' => 0,
                            'show_count' => 0,
                        ));
                        foreach ($categories as $category):
                            ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 box">
                                <div class="thumbnail pdt">
                                    <div class="productimg">
                                        <div class="image"> 
                                            <a class="preview" href="<?php echo get_term_link($category->term_id, $taxonomy); ?>" rel="<?php the_field('product_cat_images', $category); ?>" title="<?php echo $category->name; ?>" class="preview">
                                                <img src="<?php the_field('product_cat_images', $category); ?>" class="img-responsive" alt="<?php echo $category->name; ?>">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="caption">
                                        <h3>
                                            <a href="<?php echo get_term_link($category->term_id, $taxonomy); ?>">
                                                <?php echo $category->name; ?>
                                            </a>
                                        </h3>
                                        <p>
                                            <?php echo $category->description; ?>
                                        </p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div><!--//end listproduct-->
                </div>
                <!-- end showproduct-->
                <div class="clearfix"></div>
            <?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-sm-3 sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>