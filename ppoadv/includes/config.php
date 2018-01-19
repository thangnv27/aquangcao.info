<?php

//$basename = basename($_SERVER['PHP_SELF']);
//if (!in_array($basename, array('plugins.php', 'update.php', 'upgrade.php'))) {
//    ob_start();
//    ob_start("ob_gzhandler");
//}
/* ----------------------------------------------------------------------------------- */
# Set default timezone
/* ----------------------------------------------------------------------------------- */
date_default_timezone_set('Asia/Ho_Chi_Minh');
/* ----------------------------------------------------------------------------------- */
# Definition
/* ----------------------------------------------------------------------------------- */
if (!defined('THEME_NAME'))
    define('THEME_NAME', "Theme");
if (!defined('SHORT_NAME'))
    define('SHORT_NAME', "ppo");
if (!defined('MENU_NAME'))
    define('MENU_NAME', SHORT_NAME . "_settings");
/* ----------------------------------------------------------------------------------- */
# Theme Options
/* ----------------------------------------------------------------------------------- */
$pages = get_pages();
$page_list = array();
foreach ($pages as $page) {
    $page_list[$page->ID] = $page->post_title;
}
$categories = get_categories(array('hide_empty' => 0));
$category_list = array();
foreach ($categories as $category) {
    $category_list[$category->term_id] = $category->name;
}

$sliders = ppo_find_layersliders();
$slider_list = array(0 => "No Slider");
foreach ($sliders as $slide) {
    $slider_list[$slide->id] = $slide->name;
}

$options = array(
    'general' => array(
        "name" => "General",
        array("id" => "ppo_opt",
            "std" => "general",
            "type" => "hidden"),
        array("name" => "Site Options",
            "type" => "title",
            "desc" => ""),
        array("type" => "open"),
        array("name" => "Keywords meta",
            "desc" => "Enter the meta keywords for all pages. These are used by search engines to index your pages with more relevance.",
            "id" => "keywords_meta",
            "std" => "",
            "type" => "text"),
        array("name" => "Favicon",
            "desc" => "An icon associated with a particular website, and typically displayed in the address bar of a browser viewing the site. Size: 16x16",
            "id" => "favicon",
            "std" => "",
            "type" => "text",
            "btn" => true),
        array("name" => "Logo",
            "desc" => "Size: 234x40",
            "id" => "sitelogo",
            "std" => "",
            "type" => "text",
            "btn" => true),
        array("name" => "Home Slider",
            "desc" => "",
            "id" => "home_slider",
            "std" => "",
            "type" => "select",
            "options" => $slider_list),
        array("name" => "Logo footer",
            "desc" => "Size: 234x40",
            "id" => "footerlogo",
            "std" => "",
            "type" => "text",
            "btn" => true),
        array("type" => "close"),
        array("name" => "Information",
            "type" => "title",
            "desc" => ""),
        array("type" => "open"),
        array("name" => "Đơn vị chủ thể",
            "desc" => "Ví dụ: Công ty CP ABC",
            "id" => "unit_owner",
            "std" => "",
            "type" => "text"),
        array("name" => "Địa chỉ",
            "desc" => "Địa chỉ trụ sở công ty/văn phòng/cửa hàng...",
            "id" => "info_address",
            "std" => "",
            "type" => "text"),
        array("name" => "Email",
            "desc" => "",
            "id" => "info_email",
            "std" => "",
            "type" => "text"),
        array("name" => "Điện thoại",
            "desc" => "",
            "id" => "info_tel",
            "std" => "",
            "type" => "text"),
        array("name" => "Số Fax",
            "desc" => "",
            "id" => "info_fax",
            "std" => "",
            "type" => "text"),
        array("name" => "Website",
            "desc" => "",
            "id" => "info_website",
            "std" => "",
            "type" => "text"),
        array("type" => "close"),
        array("name" => "Hỗ trợ",
            "type" => "title",
            "desc" => ""),
        array("type" => "open"),
        array("name" => "Tên hỗ trợ 1",
            "desc" => "",
            "id" => SHORT_NAME . "_supportname_1",
            "std" => '',
            "type" => "text"),
        array("name" => "Số hotline 1",
            "desc" => "",
            "id" => SHORT_NAME . "_hotline_1",
            "std" => '',
            "type" => "text"),
        array("name" => "Skype 1",
            "desc" => "",
            "id" => SHORT_NAME . "_skype_1",
            "std" => '',
            "type" => "text"),
        array("name" => "Yahoo 1",
            "desc" => "",
            "id" => SHORT_NAME . "_yahoo_1",
            "std" => '',
            "type" => "text"),
        array("name" => "Tên hỗ trợ 2",
            "desc" => "",
            "id" => SHORT_NAME . "_supportname_2",
            "std" => '',
            "type" => "text"),
        array("name" => "Số hotline 2",
            "desc" => "",
            "id" => SHORT_NAME . "_hotline_2",
            "std" => '',
            "type" => "text"),
        array("name" => "Skype 2",
            "desc" => "",
            "id" => SHORT_NAME . "_skype_2",
            "std" => '',
            "type" => "text"),
        array("name" => "Yahoo 2",
            "desc" => "",
            "id" => SHORT_NAME . "_yahoo_2",
            "std" => '',
            "type" => "text"),
        array("type" => "close"),
        array("name" => "Footer",
            "type" => "title",
            "desc" => ""),
        array("type" => "open"),
        array("name" => "Giới thiệu",
            "desc" => "Giới thiệu ở cuối trang",
            "id" => SHORT_NAME . "_footer_intro",
            "std" => '',
            "type" => "textarea",
            "editor" => array(
                'wyswig' => true,
                'rows' => 5
            )),
        array("type" => "close"),
        array("type" => "submit"),
    ),
    'theme-options' => array(
        "name" => "Theme Options",
        array("id" => "ppo_opt",
            "std" => "theme-options",
            "type" => "hidden"),
        array("name" => "Tuỳ chọn chuyên mục",
            "type" => "title",
            "desc" => "",
        ),
        array("type" => "open"),
        array("name" => "Dự án",
            "desc" => "Chọn chuyên mục dự án",
            "id" => SHORT_NAME . "_cat_project",
            "std" => '',
            "type" => "select",
            "options" => $category_list),
        array("type" => "close"),
        array("name" => "Tuỳ chọn trang",
            "type" => "title",
            "desc" => "",
        ),
        array("type" => "open"),
        array("name" => "Shortcode liên hệ",
            "desc" => "",
            "id" => SHORT_NAME . "_contact",
            "std" => '',
            "type" => "text"),
        array("name" => "Trang truyền thông",
            "desc" => "",
            "id" => SHORT_NAME . "_page_truyen_thong",
            "std" => '',
            "type" => "select",
            "options" => $page_list),
        array("name" => "Trang danh sách tin ảnh",
            "desc" => "",
            "id" => SHORT_NAME . "_page_image",
            "std" => '',
            "type" => "select",
            "options" => $page_list),
        array("name" => "Trang Chuyển giao công nghệ",
            "desc" => "",
            "id" => SHORT_NAME . "_tech_transfer",
            "std" => '',
            "type" => "select",
            "options" => $page_list),
        array("name" => "Trang Đăng ký nhu cầu công nghệ",
            "desc" => "",
            "id" => SHORT_NAME . "_reg_tech_need",
            "std" => '',
            "type" => "select",
            "options" => $page_list),
        array("type" => "close"),
        
        array("name" => "Tùy chọn khác",
            "type" => "title",
            "desc" => "Tìm chỉnh website.",
        ),
        array("type" => "open"),
        array("name" => "Tin nổi bật",
            "desc" => "Ẩn/Hiển thị tin nổi bật",
            "id" => SHORT_NAME . "_show_vip_news",
            "std" => '',
            "type" => "checkbox"),
        array("name" => "Liên hệ",
            "desc" => "Short code form liên hệ",
            "id" => SHORT_NAME . "_contact_info",
            "std" => '',
            "type" => "text"),
        array("name" => "Fixed menu",
            "desc" => "Menu chính của bạn sẽ luôn dính ở phía trên trình duyệt.",
            "id" => SHORT_NAME . "_fixedMenu",
            "std" => '',
            "type" => "checkbox"),
        array("name" => "Google Analytics",
            "desc" => "Google Analytics. Ví dụ: UA-40210538-1",
            "id" => SHORT_NAME . "_gaID",
            "std" => "UA-40210538-1",
            "type" => "text"),
        array("name" => "Google maps",
            "desc" => "Dán đoạn mã của Google maps vào đây. Kích thước 500 x 600",
            "id" => SHORT_NAME . "_gmaps",
            "std" => '<iframe width="500" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=vi&amp;geocode=&amp;q=S%E1%BB%91+104+Ng%C3%B5+189+Ho%C3%A0ng+Hoa+Th%C3%A1m,+Ng%C3%B5+189,+Li%E1%BB%85u+Giai,+Ba+Dinh+District,+Hanoi,+Vietnam&amp;aq=&amp;sll=21.040036,105.819889&amp;sspn=0.011656,0.021136&amp;ie=UTF8&amp;hq=S%E1%BB%91+104+Ng%C3%B5+189+Ho%C3%A0ng+Hoa+Th%C3%A1m,&amp;hnear=Ng%C3%B5+189,+%C4%90%E1%BB%99i+C%E1%BA%A5n,+Ba+%C4%90%C3%ACnh,+H%C3%A0+N%E1%BB%99i,+Vi%E1%BB%87t+Nam&amp;ll=21.04172,105.820717&amp;spn=0.046621,0.084543&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=1398663498302061535&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=vi&amp;geocode=&amp;q=S%E1%BB%91+104+Ng%C3%B5+189+Ho%C3%A0ng+Hoa+Th%C3%A1m,+Ng%C3%B5+189,+Li%E1%BB%85u+Giai,+Ba+Dinh+District,+Hanoi,+Vietnam&amp;aq=&amp;sll=21.040036,105.819889&amp;sspn=0.011656,0.021136&amp;ie=UTF8&amp;hq=S%E1%BB%91+104+Ng%C3%B5+189+Ho%C3%A0ng+Hoa+Th%C3%A1m,&amp;hnear=Ng%C3%B5+189,+%C4%90%E1%BB%99i+C%E1%BA%A5n,+Ba+%C4%90%C3%ACnh,+H%C3%A0+N%E1%BB%99i,+Vi%E1%BB%87t+Nam&amp;ll=21.04172,105.820717&amp;spn=0.046621,0.084543&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=1398663498302061535" style="color:#0000FF;text-align:left">Xem Bản đồ cỡ lớn hơn</a></small>',
            "type" => "textarea"),
        array("name" => "Header Code",
            "desc" => "Phần này cho phép đặt các mã code vào đầu trang.",
            "id" => SHORT_NAME . "_headerCode",
            "std" => '',
            "type" => "textarea"),
        array("name" => "Footer Code",
            "desc" => "Phần này cho phép đặt các mã code vào cuối trang.",
            "id" => SHORT_NAME . "_footerCode",
            "std" => '',
            "type" => "textarea"),
        array("type" => "close"),
        array("type" => "submit"),
    ),
    'social-options' => array(
        "name" => "Socials",
        array("id" => "ppo_opt",
            "std" => "social-options",
            "type" => "hidden"),
        array("name" => "Theo dõi trên mạng xã hội",
            "type" => "title",
            "desc" => ""),
        array("type" => "open"),
        array("name" => "Facebook",
            "desc" => "Nhập URL page của bạn trên facebook.",
            "id" => SHORT_NAME . "_fbURL",
            "std" => "",
            "type" => "text"),
        array("name" => "Google plus",
            "desc" => "Nhập URL page của bạn trên Google plus.",
            "id" => SHORT_NAME . "_googlePlusURL",
            "std" => "",
            "type" => "text"),
        array("name" => "Twitter",
            "desc" => "Nhập URL page của bạn trên Twitter.",
            "id" => SHORT_NAME . "_twitterURL",
            "std" => "",
            "type" => "text"),
        array("name" => "Linked In",
            "desc" => "Nhập URL page của bạn trên Linked In.",
            "id" => SHORT_NAME . "_linkedInURL",
            "std" => "",
            "type" => "text"),
        array("name" => "Youtube",
            "desc" => "Nhập URL page của bạn trên Youtube.",
            "id" => SHORT_NAME . "_youtubeURL",
            "std" => "",
            "type" => "text"),
        array("name" => "Pinterest",
            "desc" => "Nhập URL page của bạn trên Pinterest.",
            "id" => SHORT_NAME . "_pinterestURL",
            "std" => "",
            "type" => "text"),
        array("type" => "close"),
        array("name" => "Apps",
            "type" => "title",
            "desc" => ""),
        array("type" => "open"),
        array("name" => "Facebook App ID",
            "desc" => "Nhập ID App Facebook quản lý comment, chia sẻ...",
            "id" => SHORT_NAME . "_appFBID",
            "std" => '',
            "type" => "text"),
        array("name" => "DISQUS Site Shortname",
            "desc" => "Nhập site shortname của bạn trên DISQUS để theo dõi và quản lý bình luận.",
            "id" => SHORT_NAME . "_disqus_shortname",
            "std" => '',
            "type" => "text"),
        array("type" => "close"),
        array("type" => "submit"),
    ),
);