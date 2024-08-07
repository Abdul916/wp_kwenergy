<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function solor_admin_css() {
	wp_enqueue_style( 'theme-heading-font-admin', "https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap", array(), SOLOR_THEME_VERSION );	
	wp_enqueue_style( 'theme-default-font-admin', "https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap", array(), SOLOR_THEME_VERSION );wp_enqueue_style( 'solor-admin', SOLOR_THEME_URL . '/assets/css/admin.css', array(), SOLOR_THEME_VERSION );	
}

// Hook the custom_admin_css function to the admin_enqueue_scripts action.
add_action('admin_enqueue_scripts', 'solor_admin_css', 11);