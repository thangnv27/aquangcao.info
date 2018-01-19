<div class="partner owl-carousel">
    <?php
    $query = new WP_Query(array(
        'post_type' => 'partner',
        'posts_per_page' => -1
    ));
    while ($query->have_posts()) : $query->the_post();
        ?>
        <div class="item">
            <a href=" <?php echo get_post_meta(get_the_ID(), 'partner_website', true); ?>">
                <img src="<?php echo get_image_url(true,'slider'); ?>" />
            </a>
        </div>
        <?php
    endwhile;
    wp_reset_query();
    ?>
</div>
</div>
<!-- End Wrapper -->
<div class="clearfix"></div>
<div id="footer" class="footer">
    <div class="">
        <div class="col-sm-7">
            <h2 class="title-footer">Thông tin</h2>
            <?php echo stripslashes(get_option(SHORT_NAME . "_footer_intro")); ?>
        </div>
        <div class="col-sm-5">
            <h2 class="title-footer">Bản đồ</h2>
            <?php echo stripslashes(get_option(SHORT_NAME . "_gmaps")); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="coppyright">
        Copyright © 2015. All rights reserved. <?php bloginfo('sitename'); ?>
    </div>
</div>
</div>
<!-- End Container -->

<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-2.1.3.min.js"></script>
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/bootstrap.min.js"></script>
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.elevatezoom.js"></script>
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/owl.carousel.js"></script>
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-scrolltofixed-min.js"></script>
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/app.js"></script>
<script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=969065613152991";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
<?php wp_footer(); ?>
</body>
</html>
