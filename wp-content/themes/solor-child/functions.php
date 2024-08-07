<?php

defined( 'ABSPATH' ) || exit;

function solor_child_theme_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'theme-style' ), SOLOR_THEME_VERSION ); 
}
add_action( 'wp_enqueue_scripts', 'solor_child_theme_enqueue_styles' );

add_action('pre_get_posts', 'custom_sort_products_by_brand');
function custom_sort_products_by_brand($query) {
	if (is_admin() || ! $query->is_main_query()) {
		return;
	}
	if (is_product_category()) {
		$orderby = 'meta_value';
		$order = 'ASC';
		$query->set('meta_key', 'pwb-brand');
		$query->set('order', $order);
		$query->set('orderby', $orderby);
	}
}



