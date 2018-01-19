<?php

/* ----------------------------------------------------------------------------------- */
# Create post_type
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_partner_post_type');

function create_partner_post_type() {
    $args = array(
        'labels' => array(
            'name' => __('Partners'),
            'singular_name' => __('Partners'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Partner'),
            'new_item' => __('New Partner'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Partner'),
            'view' => __('View Partner'),
            'view_item' => __('View Partner'),
            'search_items' => __('Search Partners'),
            'not_found' => __('No Partner found'),
            'not_found_in_trash' => __('No Partner found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title','thumbnail',
//            'editor'
        ),
        'rewrite' => array('slug' => 'partner', 'with_front' => false),
        'can_export' => true,
        'description' => __('Partner description here.')
    );

    register_post_type('partner', $args);
}

/* ----------------------------------------------------------------------------------- */
# Create taxonomy
/* ----------------------------------------------------------------------------------- */
//add_action('init', 'create_partner_taxonomies');

function create_partner_taxonomies() {
    register_taxonomy('partner_category', 'partner', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Partner Categories'),
            'singular_name' => __('Partner Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
        'rewrite' => array( 'slug' => 'partner-cat' ),
    ));
}

/* ----------------------------------------------------------------------------------- */
# Meta box
/* ----------------------------------------------------------------------------------- */

$partner_meta_box = array(
    'id' => 'partner-meta-box',
    'title' => 'Thông tin',
    'page' => 'partner',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Website',
            'desc' => '',
            'id' => 'partner_website',
            'type' => 'text',
            'std' => '',
        )
        ));
// Add partner meta box
if (is_admin()) {
    add_action('admin_menu', 'partner_add_box');
    add_action('save_post', 'partner_add_box');
    add_action('save_post', 'partner_save_data');
}

/**
 * Add meta box
 * @global array $partner_meta_box
 */
function partner_add_box() {
    global $partner_meta_box;
    add_meta_box($partner_meta_box['id'], $partner_meta_box['title'], 'partner_show_box', $partner_meta_box['page'], $partner_meta_box['context'], $partner_meta_box['priority']);
}

/**
 * Callback function to show fields in partner meta box
 * @global array $partner_meta_box
 * @global Object $post
 */
function partner_show_box() {
    // Use nonce for verification
    global $partner_meta_box, $post;
    custom_output_meta_box($partner_meta_box, $post);
}

/**
 * Save data from partner meta box
 * @global array $partner_meta_box
 * @param int $post_id
 * @return 
 */
function partner_save_data($post_id) {
    global $partner_meta_box;
    custom_save_meta_box($partner_meta_box, $post_id);
}

