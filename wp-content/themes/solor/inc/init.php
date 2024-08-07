<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once SOLOR_THEME_DIR . '/inc/functions.php';
require_once SOLOR_THEME_DIR . '/inc/compatibility/elementor/elementor.php';
require_once SOLOR_THEME_DIR . '/inc/compatibility/elementor/modify-default-control.php';
require_once SOLOR_THEME_DIR . '/inc/compatibility/elementskit-lite.php';


require_once SOLOR_THEME_DIR . '/inc/breadcrumbs.php';
require_once SOLOR_THEME_DIR . '/inc/ocdi.php';

require_once SOLOR_THEME_DIR . '/inc/customizer/customizer.php';
require_once SOLOR_THEME_DIR . '/inc/required-plugins.php';


if(is_admin()) {
require_once SOLOR_THEME_DIR . '/inc/admin/admin.php';
}
