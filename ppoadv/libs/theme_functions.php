<?php

add_action('wp_ajax_nopriv_' . getRequest('action'), getRequest('action'));
add_action('wp_ajax_' . getRequest('action'), getRequest('action'));

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ppo_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'ppo'), max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'ppo_wp_title', 10, 2);



/* ---------------------------------------------------------------------------- */
# add a favicon to blog
/* ---------------------------------------------------------------------------- */

function add_blog_favicon() {
    $favicon = get_option('favicon');
    if (trim($favicon) == "") {
        echo '<link rel="icon" href="' . get_bloginfo('siteurl') . '/favicon.ico" type="image/x-icon" />' . "\n";
    } else {
        echo '<link rel="icon" href="' . $favicon . '" type="image/x-icon" />' . "\n";
    }
}

add_action('wp_head', 'add_blog_favicon');

/* ---------------------------------------------------------------------------- */
# Add Google Analytics to blog
/* ---------------------------------------------------------------------------- */

function add_blog_google_analytics() {
    $GAID = get_option(SHORT_NAME . '_gaID');
    if ($GAID and $GAID != ''):
        echo <<<HTML
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '$GAID']);
    _gaq.push(['_trackPageview']);
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
HTML;
    endif;
}
/*----------------------------------------------------------------------------*/
# Add Header Code
/*----------------------------------------------------------------------------*/
function add_header_code(){
    echo stripslashes(get_option(SHORT_NAME . '_headerCode'));
}
add_action('wp_head', 'add_header_code');
/*----------------------------------------------------------------------------*/
# Add Footer Code
/*----------------------------------------------------------------------------*/
function add_footer_code(){
    echo stripslashes(get_option(SHORT_NAME . '_footerCode'));
}
add_action('wp_footer', 'add_footer_code');
/* ---------------------------------------------------------------------------- */
add_action('wp_head', 'add_blog_google_analytics');
/* ---------------------------------------------------------------------------- */
# Add Facebook JS SDK
/* ---------------------------------------------------------------------------- */

function add_fb_jssdk() {
    echo <<<HTML
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=2.4";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
HTML;
}

add_action('wp_footer', 'add_fb_jssdk');
/* ---------------------------------------------------------------------------- */
# Check current category has children
/* ---------------------------------------------------------------------------- */

function category_has_children() {
    global $wpdb;
    $term = get_queried_object();
    $category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
    if ($category_children_check) {
        return true;
    } else {
        return false;
    }
}

/* ---------------------------------------------------------------------------- */
# Get the current category id if we are on an archive/category page
/* ---------------------------------------------------------------------------- */

function getCurrentCatID() {
    global $wp_query;
    if (is_category() || is_single()) {
        $cat_ID = get_query_var('cat');
    }
    return $cat_ID;
}

/* ----------------------------------------------------------------------------------- */
# Redefine user notification function
/* ----------------------------------------------------------------------------------- */
if (!function_exists('custom_wp_new_user_notification')) {

    function custom_wp_new_user_notification($user_id, $plaintext_pass = '') {
        $user = new WP_User($user_id);

        $user_login = $user->user_login;
        $user_email = $user->user_email;

        $message = sprintf(__('New user registration on %s:'), get_option('blogname')) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

        @wp_mail(
                        get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message
        );

        if (empty($plaintext_pass))
            return;

        $login_url = wp_login_url();

        $message = sprintf(__('Hi %s,'), $user->display_name) . "\r\n\r\n";
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
        $message .= ($login_url == "") ? wp_login_url() : $login_url . "\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n";

        @wp_mail(
                        $user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message
        );
    }

}

if (!function_exists('set_html_content_type')) {

    function set_html_content_type() {
        return 'text/html';
    }

}

/* GET THUMBNAIL URL */

function get_image_url($show = true, $size="full") {
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, $size);
    $image_url = $image_url[0];
    if ($show) {
        if ($image_url != "") {
            echo $image_url;
        } else {
            bloginfo('stylesheet_directory');
            echo "/images/no_image_available.jpg";
        }
    } else {
        if ($image_url != "") {
            return $image_url;
        } else {
            return get_bloginfo('stylesheet_directory') . "/images/no_image_available.jpg";
        }
    }
}

/**
 * Get post thumbnail url
 * 
 * @param integer $post_id
 * @param type $size
 * @return string
 */
function get_post_thumbnail_url($post_id, $size = 'full') {
    return wp_get_attachment_url(get_post_thumbnail_id($post_id, $size));
}

/**
 * Rewrite URL
 * @param string $lang_code Example: vn, en...
 * @param bool $show TRUE or FALSE
 * @return string
 */
function ppo_multilang_permalink($lang_code, $show = false) {
    $uri = getCurrentRquestUrl();
    $siteurl = get_bloginfo('siteurl');
    $end = substr($uri, strlen($siteurl));
    if (!isset($_GET['lang'])) {
        $uri = $siteurl . "/" . $lang_code . $end;
    }
    if ($show) {
        echo $uri;
    }
    return $uri;
}

/* PAGE NAVIGATION */

function getpagenavi($arg = null) {
    ?>
    <div class="paging">
        <?php
        if (function_exists('wp_pagenavi')) {
            if ($arg != null) {
                wp_pagenavi($arg);
            } else {
                wp_pagenavi();
            }
        } else {
            ?>
            <div><div class="inline"><?php previous_posts_link('<') ?></div><div class="inline"><?php next_posts_link('>') ?></div></div>
        <?php } ?>
            
    </div>
    <?php
}

/* END PAGE NAVIGATION */

/**
 * Ouput share social with addThis widget
 */
function show_share_socials() {
    echo <<<HTML
<div class="share-social-box">
    <div class="addthis_toolbox addthis_default_style">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
        <a class="addthis_counter addthis_pill_style"></a>
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e5a517830ae061f"></script>
</div>
HTML;
}

/**
 * Ouput DISQUS comments form
 */
function show_comments_form_disqus() {
    $site_shortname = get_option(SHORT_NAME . "_disqus_shortname");
    echo <<<HTML
<div class="disqus-comment-box">
    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '{$site_shortname}'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
</div>
HTML;
}

// Add custom text sizes in the font size drop down list of the rich text editor (TinyMCE) in WordPress
// $initArray is a variable of type array that contains all default TinyMCE parameters.
// Value 'theme_advanced_font_sizes' or 'fontsize_formats' needs to be added, 
// if an overwrite to the default font sizes in the list, is needed.

function tinymce_customize_text_sizes($initArray) {
    $initArray['fontsize_formats'] = "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 48px";
    return $initArray;
}

// Assigns customize_text_sizes() to "tiny_mce_before_init" filter
add_filter('tiny_mce_before_init', 'tinymce_customize_text_sizes');

/**
 * Remove WordPress Logo
 */
function ppo_admin_bar_remove() {
        global $wp_admin_bar;

        /* Remove their stuff */
        $wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'ppo_admin_bar_remove', 0);