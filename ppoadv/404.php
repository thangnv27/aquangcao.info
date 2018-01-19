<?php get_header(); ?>

<div class="row content">
    <div class=" col-md-9 main">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumb">', '</div>');
        }
        ?>
            <h1 class="post-title">Liên kết không tồn tại!</h1>
            <div class="post-content">
                Liên kết bạn truy cập đã bị xóa hoặc không tại!
            </div>

    </div>
    <div class="col-md-3 sidebar">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>