<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <title><?php wp_title('|', true, 'right'); ?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/owl.carousel.css" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            var is_fixed_menu = <?php echo (get_option(SHORT_NAME . "_fixedMenu")) ? 'true' : 'false'; ?>;
        </script>
        <?php wp_head(); ?>
    </head>
    <body>
        <div id="fb-root"></div>
        
        <!--MOBILE HEADER-->
        <div id="st-container" class="st-container">
            <div class="mobile-header clearfix mobile-unclicked" style="transform: translate(0px, 0px);">
                <div id="st-trigger-effects">
                    <button data-effect="st-effect-4" class="left-menu">
                        <div class="menu-icon">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </div>
                        <span><i class="fa fa-bars" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="title">
                    <?php
                    if(get_option('mobilelogo')){
                    ?>
                        <a title="<?php bloginfo("name"); ?>" href="<?php echo home_url(); ?>">
                            <img src="<?php echo get_option("mobilelogo"); ?>" alt="BIỂN QUẢNG CÁO RẺ" />
                        </a>
                    <?php
                    } else {
                    ?>
                        <p class="proxima"><a title="<?php bloginfo("name"); ?>" href="<?php echo home_url(); ?>">BIỂN QUẢNG CÁO RẺ</a></p>
                    <?php }?>
                </div>
    <!--            <div id="st-trigger-effects">
                    <button data-effect="st-effect-5" class="right-menu font22">
                        <i class="fa fa-thumbs-o-up"></i>
                    </button>
                </div>-->
            </div>

            <nav id="menu-4" class="st-menu st-effect-4">
                <form method="get" action="<?php echo home_url(); ?>" id="search_mini_form">
                    <div class="form-search">
                        <div class="searchcontainer"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            <input type="text" maxlength="128" class="input-text" value="" name="s" id="search" />
                        </div>
                    </div>
                </form>

                <?php
                wp_nav_menu(array(
                    'container' => '',
                    'theme_location' => 'primary',
                    'menu_class' => 'nav',
                    'menu_id' => '',
                ));
                ?>
            </nav>
        </div>
        <!--/MOBILE HEADER-->
    
        <div class="container">
            <div id="header" class="desktop-header row">
                <div class="col-sm-12 logo">
                    <a href="<?php bloginfo('siteurl'); ?>" title="<?php bloginfo("name"); ?>">
                        <img title="<?php bloginfo("name"); ?>" src="<?php echo stripslashes(get_option("sitelogo")); ?>" alt="<?php bloginfo("name"); ?>" class="img-responsive"/>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="wrapper">
                <div id="mainmenu" class="fixedHeader">
                    <?php
                    wp_nav_menu(array(
                        'container' => '',
                        'container_class' => '',
                        'theme_location' => 'primary'
                    ));
                    ?>
                </div>
       
                <div class="clearfix"></div>
                <div id="mainslider">
                    <?php
                    $slider_id = intval(get_option('home_slider'));
                    if ($slider_id > 0):
                        ?>
                        <!--BEGIN SLIDER-->
                        <div class="slider">
                            <?php echo do_shortcode('[layerslider id="' . $slider_id . '"]'); ?>
                        </div>
                        <!--END SLIDER-->
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>
                <div class="project owl-carousel">
                    <?php
                    $cat_project = get_option(SHORT_NAME . "_cat_project");
                    $query = new WP_Query(array('cat' => $cat_project, 'posts_per_page' => -1));
                    while ($query->have_posts()) : $query->the_post();
                        ?>
                        <div class="item">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_image_url(true,'slider'); ?>" />
                            </a>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
