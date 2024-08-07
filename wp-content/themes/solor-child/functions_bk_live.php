<?php

defined( 'ABSPATH' ) || exit;

function solor_child_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'theme-style' ), SOLOR_THEME_VERSION ); 
}
add_action( 'wp_enqueue_scripts', 'solor_child_theme_enqueue_styles' );


// Step 1: Register the custom query var
add_filter('query_vars', 'add_custom_query_var');
function add_custom_query_var($vars) {
    $vars[] = 'sort_by_brand';
    return $vars;
}

// Step 2: Modify the WooCommerce query
add_action('woocommerce_product_query', 'sort_products_by_brand');
function sort_products_by_brand($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    $sort_by_brand = get_query_var('sort_by_brand');
    
    if ($sort_by_brand) {
        $tax_query = (array) $query->get('tax_query');
        
        $tax_query[] = array(
            'taxonomy' => 'pwb-brand',
            'field' => 'slug',
            'terms' => $sort_by_brand,
        );
        
        $query->set('tax_query', $tax_query);
    }
}

// Step 3: Add sorting option to the WooCommerce sort dropdown
add_filter('woocommerce_catalog_orderby', 'add_brand_sorting_option');
function add_brand_sorting_option($sortby) {
    $sortby['sort_by_brand'] = __('Sort by brand', 'your-text-domain');
    return $sortby;
}

// Modify the sort dropdown link
add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');
function custom_woocommerce_get_catalog_ordering_args($args) {
    if (isset($_GET['orderby']) && $_GET['orderby'] == 'sort_by_brand') {
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
        $args['meta_key'] = 'pwb-brand';
    }

    return $args;
}




