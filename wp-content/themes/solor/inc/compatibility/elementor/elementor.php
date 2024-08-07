<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'admin_menu', 'solor_elementor_free_menu', 999 );

function solor_elementor_free_menu() {
		// Exit is Elementor PRO is loaded
		if ( function_exists( 'elementor_pro_load_plugin' ) ) {
			return;
		}
		remove_submenu_page( 'elementor', 'e-form-submissions' );
		remove_submenu_page( 'elementor', 'elementor_custom_fonts' );
		remove_submenu_page( 'elementor', 'elementor_custom_icons' );
		remove_submenu_page( 'elementor', 'elementor_custom_code' );
		remove_submenu_page( 'elementor', 'go_elementor_pro' );
}


/**
 * Register new Elementor widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function solor_register_new_widgets( $widgets_manager ) {

	require_once SOLOR_THEME_DIR . '/inc/compatibility/elementor/widgets/site-logo.php';
	require_once SOLOR_THEME_DIR . '/inc/compatibility/elementor/widgets/portfolio.php';

	$widgets_manager->register( new \Ata_Widget_Site_Logo() );
	$widgets_manager->register( new \Ata_Widget_Portfolio() );

}
add_action( 'elementor/widgets/register', 'solor_register_new_widgets' );


/**
 * Register css for elementor editor.
 */
add_action( 'elementor/editor/after_enqueue_styles', 'solor_elementor_css' );
	
function solor_elementor_css() {
	wp_enqueue_style( 'solor-elementor-editor', SOLOR_THEME_URL . '/assets/css/elementor-editor.css', array(), SOLOR_THEME_VERSION );
}