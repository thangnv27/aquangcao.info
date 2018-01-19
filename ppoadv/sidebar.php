<div class="panel panel-primary ">
    <div class="panel-heading panel-heading-sp">
        <div class="title"><span aria-hidden="true" class="glyphicon glyphicon-earphone"></span>  Hỗ trợ trực tuyến</div>
    </div>
    <div class="panel-body">
        <div class="sp2"> 
            <div class="item phone">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/hotline.gif" alt="Hotline"/>
                Hotline:
                <div class="clearfix"></div>
                <div class="hotline">
                    <div class="titlename"><?php echo get_option(SHORT_NAME . "_supportname_1"); ?></div> 
                    <?php echo get_option(SHORT_NAME . "_hotline_1"); ?>  
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="item">
                <a href="skype:<?php echo get_option(SHORT_NAME . "_skype_1"); ?>?chat">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/skype.png" alt="skype icon"/>
                </a>
                <a href="ymsgr:sendim?<?php echo get_option(SHORT_NAME . "_yahoo_1"); ?>">
                    <img src="http://opi.yahoo.com/online?u=<?php echo get_option(SHORT_NAME . "_yahoo_1"); ?>&m=g&t=1" alt="yahoo icon" border=0  style="width: 120px" />
                </a>

            </div>
            <div class="clearfix"></div>
        </div>
        <div class="sp2">

            <div class="titlename"><?php echo get_option(SHORT_NAME . "_supportname_2"); ?></div>
            <div class="clearfix"></div>
            <div class="item phone"><?php echo get_option(SHORT_NAME . "_hotline_2"); ?></div>
            <div class="clearfix"></div>
            <div class="item">
                <a href="skype:<?php echo get_option(SHORT_NAME . "_skype_2"); ?>?chat">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/skype.png" alt="skype icon"/>
                </a>
                <a href="ymsgr:sendim?<?php echo get_option(SHORT_NAME . "_yahoo_2"); ?>">
                    <img src="http://opi.yahoo.com/online?u=<?php echo get_option(SHORT_NAME . "_yahoo_2"); ?>&m=g&t=1" alt="yahoo icon" border=0 style="width: 120px" />
                </a>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="panel panel-primary">
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
        <div class="list-category">
            <div class="panel-head">
                <div class="title"><a href="<?php echo get_term_link($category->term_id, $taxonomy); ?>"><?php echo $category->name; ?></a></div>
            </div>
            <?php
            $categories = get_categories(array(
                'title_li' => '',
                'show_option_none' => '',
                'taxonomy' => $taxonomy,
                'parent' => $category->term_id,
                'hide_empty' => 0,
                'show_count' => 0,
            ));
            if (!empty($categories)):
                echo '<ul class="sub-cat">';
                foreach ($categories as $category):
                    ?>
                    <li><a href="<?php echo get_term_link($category->term_id, $taxonomy); ?>"><?php echo $category->name; ?></a></li>
                    <?php
                endforeach;
                echo '</ul>';
            endif;
            ?>
        </div>
    <?php endforeach; ?>
</div><!--//panel-->
<?php if (!dynamic_sidebar('sidebar')) : ?>
<?php endif; // end sidebar widget area ?>


