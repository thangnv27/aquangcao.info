<?php

/* ----------------------------------------------------------------------------------- */
# Create post_type
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_product_post_type');

function create_product_post_type() {
    $args = array(
        'labels' => array(
            'name' => __('Sản phẩm'),
            'singular_name' => __('Sản phẩm'),
            'add_new' => __('Thêm mới'),
            'add_new_item' => __('Add new Product'),
            'new_item' => __('New Product'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Product'),
            'view' => __('View Product'),
            'view_item' => __('View Product'),
            'search_items' => __('Search Products'),
            'not_found' => __('No Product found'),
            'not_found_in_trash' => __('No Product found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title','thumbnail','editor'
        ),
        'rewrite' => array('slug' => 'product', 'with_front' => false),
        'can_export' => true,
        'description' => __('Product description here.')
    );

    register_post_type('product', $args);
}

/* ----------------------------------------------------------------------------------- */
# Create taxonomy
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_product_taxonomies');

function create_product_taxonomies() {
    register_taxonomy('product_category', 'product', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Chuyên mục sản phẩm'),
            'singular_name' => __('Chuyên mục sản phẩm'),
            'add_new' => __('Thêm mới'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
        'rewrite' => array( 'slug' => 'product-cat' ),
    ));
}

/* ----------------------------------------------------------------------------------- */
# Meta box
/* ----------------------------------------------------------------------------------- */

$product_meta_box = array(
    'id' => 'product-meta-box',
    'title' => 'Thông tin',
    'page' => 'product',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Mô tả ngắn',
            'desc' => '',
            'id' => 'product_des',
            'type' => 'textarea',
            'std' => '',
        )
        ));
// Add product meta box
if (is_admin()) {
    add_action('admin_menu', 'product_add_box');
    add_action('save_post', 'product_add_box');
    add_action('save_post', 'product_save_data');
}

/**
 * Add meta box
 * @global array $product_meta_box
 */
function product_add_box() {
    global $product_meta_box;
    add_meta_box($product_meta_box['id'], $product_meta_box['title'], 'product_show_box', $product_meta_box['page'], $product_meta_box['context'], $product_meta_box['priority']);
}

/**
 * Callback function to show fields in product meta box
 * @global array $product_meta_box
 * @global Object $post
 */
function product_show_box() {
    // Use nonce for verification
    global $product_meta_box, $post;
    custom_output_meta_box($product_meta_box, $post);
}

/**
 * Save data from product meta box
 * @global array $product_meta_box
 * @param int $post_id
 * @return 
 */
function product_save_data($post_id) {
    global $product_meta_box;
    custom_save_meta_box($product_meta_box, $post_id);
}

