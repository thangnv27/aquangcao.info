<?php
/**
 * Template Name: Contact
 */
get_header();
?>

<div class="row content">
    <div class="col-sm-9 main">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumb">', '</div>');
        }
        ?>
        <?php while (have_posts()) : the_post(); ?>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="post-content row">
                <div class="col-sm-6">
                    <?php the_content(); ?>
                    <div class="gmap">
                        <?php echo stripslashes(get_option(SHORT_NAME . "_gmaps")); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo do_shortcode(stripcslashes(get_option(SHORT_NAME . "_contact"))); ?>
                </div>
            </div>

        <?php endwhile; // end of the loop.  ?>
    </div>
    <div class="col-sm-3 sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>