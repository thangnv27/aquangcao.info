<?php
/* ----------------------------------------------------------------------------------- */
# adds the plugin initalization scripts that add styles and functions
/* ----------------------------------------------------------------------------------- */
if (!current_theme_supports('deactivate_layerslider'))
    require_once( "config-layerslider/config.php" ); //layerslider plugin
######## BLOCK CODE NAY LUON O TREN VA KHONG DUOC XOA ##########################
include 'includes/config.php';
include 'libs/HttpFoundation/Request.php';
include 'libs/HttpFoundation/Response.php';
include 'libs/HttpFoundation/Session.php';
include 'libs/custom.php';
include 'libs/common-scripts.php';
include 'libs/meta-box.php';
include 'libs/theme_functions.php';
include 'libs/theme_settings.php';
######## END: BLOCK CODE NAY LUON O TREN VA KHONG DUOC XOA ##########################
include 'includes/product.php';
include 'includes/partner.php';
if (is_admin()) {
    $basename_excludes = array('plugin-install.php', 'plugin-editor.php', 'themes.php', 'theme-editor.php', 'import.php', 'export.php');
//    if (in_array($basename, $basename_excludes)) {
//        wp_redirect(admin_url());
//    }
    
    //add_action('admin_menu', 'custom_remove_menu_pages');
//    add_action('admin_menu', 'remove_menu_editor', 102);
}

/**
 * Remove admin menu
 */
function custom_remove_menu_pages() {
//    remove_menu_page('edit-comments.php');
//    remove_menu_page('plugins.php');
//    remove_menu_page('tools.php');
}

function remove_menu_editor() {
    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('plugins.php', 'plugin-editor.php');
    remove_submenu_page('options-general.php', 'options-writing.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
    remove_submenu_page('options-general.php', 'options-media.php');
}

/* ----------------------------------------------------------------------------------- */
# Setup Theme
/* ----------------------------------------------------------------------------------- */
if (!function_exists("ppo_theme_setup")) {

    function ppo_theme_setup() {
        ## Enable Links Manager (WP 3.5 or higher)
//        add_filter('pre_option_link_manager_enabled', '__return_true');

        if (function_exists('add_theme_support')) {
            ## Post Thumbnails
            add_theme_support('post-thumbnails');
            ## Post formats
            add_theme_support('post-formats', array('image'));
        }

        add_image_size('440x255', 440, 255, true);
        add_image_size('slider', 300, 220, true);
        add_image_size('thumb', 300, 200, true);

        /* if (function_exists('add_image_size')) {
          add_image_size('thumbnail176', 176, 176, FALSE);
          } */

        ## Register menu location
        register_nav_menus(array(
            'primary' => 'Menu primary',
        ));
    }

}
/* ---------------------------------------------------
  Register Sidebars
  ---------------------------------------------------- */
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => __('Sidebar', 'ppotext'),
        'id' => 'sidebar',
        'description' => __('Sidebar Widget Area', 'ppotext'),
        'before_widget' => '',
        'after_widget' => "",
        'before_title' => '',
        'after_title' => '',
    ));
}

add_action('after_setup_theme', 'ppo_theme_setup');


/* ----------------------------------------------------------------------------------- */
# Unset size of post thumbnails
/* ----------------------------------------------------------------------------------- */

function ppo_filter_image_sizes($sizes) {
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['large']);

    return $sizes;
}

add_filter('intermediate_image_sizes_advanced', 'ppo_filter_image_sizes');
/*
  function ppo_custom_image_sizes($sizes){
  $myimgsizes = array(
  "image-in-post" => __("Image in Post"),
  "full" => __("Original size")
  );

  return $myimgsizes;
  }

  add_filter('image_size_names_choose', 'ppo_custom_image_sizes');
 */

//PPO Feed all post type

function ppo_feed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = get_post_types();
    return $qv;
}

add_filter('request', 'ppo_feed_request');

/* ----------------------------------------------------------------------------------- */
# Register menu location
/* ----------------------------------------------------------------------------------- */

function admin_add_custom_js() {
    ?>
    <script type="text/javascript">/* <![CDATA[ */
        jQuery(function ($) {
            var area = new Array();

            $.each(area, function (index, id) {
                //tinyMCE.execCommand('mceAddControl', false, id);
                tinyMCE.init({
                    selector: "textarea#" + id,
                    height: 400
                });
                $("#newmeta-submit").click(function () {
                    tinyMCE.triggerSave();
                });
            });

            $(".submit input[type='submit']").click(function () {
                if (typeof tinyMCE != 'undefined') {
                    tinyMCE.triggerSave();
                }
            });

        });
        /* ]]> */
    </script>
    <?php

}

add_action('admin_print_footer_scripts', 'admin_add_custom_js', 99);

function pre_get_image_url($url, $show = true) {
    if (trim($url) == "")
        $url = get_template_directory_uri() . "/images/no_image_available.jpg";
    if ($show)
        echo $url;
    else
        return $url;
}

/* ----------------------------------------------------------------------------------- */
# Custom search
/* ----------------------------------------------------------------------------------- */
//add_action('pre_get_posts', 'custom_search_filter');

function custom_search_filter($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_archive) {
            $term = get_queried_object();
            $term_id = $term->term_id;
            $tag_meta = get_option("cat_$term_id");
            if ($tag_meta['cat_style'] == "grid") {
                $query->set('posts_per_page', 12);
            }
        }
    }
    return $query;
}

/*
  add_filter('posts_where', 'title_like_posts_where');

  function title_like_posts_where($where){
  global $wpdb, $wp_query;
  if($wp_query->is_search){
  $where = str_replace("AND ((ppo_postmeta.meta_key =", "OR ((ppo_postmeta.meta_key =", $where);
  }
  return $where;
  }
 */

function get_attachment_id_from_src($image_src) {
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !current_user_can('editor') && !is_admin()) {
        show_admin_bar(false);
    }
}

//fetch new from ppo.vn
add_action('wp_dashboard_setup', 'ppo_remove_dashboard_widgets');

function ppo_remove_dashboard_widgets() {
    global $wp_meta_boxes;
    // remove unnecessary widgets
    // var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
    unset(
            $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'], $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'], $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
    );
}


add_action('login_head', 'custom_login_logo');

function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { 
        background-image:url(' . get_bloginfo('stylesheet_directory') . '/images/logo.jpg) !important; 
            background-size: 160px!important;
            width: 160px!important;
            height: 100px!important;
            }
    </style>';
}

add_action('login_headerurl', 'custom_login_link');

function custom_login_link() {
    return get_bloginfo('siteurl');
}

add_action('login_headertitle', 'custom_login_title');

function custom_login_title() {
    return get_bloginfo('name');
}