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
            <div class="post-content">
                <?php the_content(); ?>
            </div>

        <?php endwhile; // end of the loop. ?>
    </div>
    <div class="col-sm-3 sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>