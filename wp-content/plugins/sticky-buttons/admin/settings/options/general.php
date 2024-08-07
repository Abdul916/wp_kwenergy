<?php
/**
 * Main Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$status = array(
	'id'   => 'menu_status',
	'name' => 'param[status]',
	'type' => 'checkbox',
	'val'  => isset( $param['status'] ) ? $param['status'] : 0,
);

$status_help = array(
	'text' => __( 'If check - the menu not displayed on the frontend. If uncheck - the menu will show on the frontend.', 'sticky-buttons' ),
);

$test_mode = array(
	'id'   => 'test_mode',
	'name' => 'param[test_mode]',
	'type' => 'checkbox',
	'val'  => isset( $param['test_mode'] ) ? $param['test_mode'] : 0,
);

$test_mode_help = array(
	'text' => __( 'If test mode is enabled, the form will show for admin only.', 'sticky-buttons' ),
);


$show_option = array(
	'all'        => esc_attr__( 'All posts and pages', 'sticky-buttons' ),
	'shortecode'      => esc_attr__( 'Where shortcode is inserted', 'sticky-buttons' ),
);

$show = array(
	'id'     => 'show',
	'name'   => 'param[show]',
	'type'   => 'select',
	'val'    => isset( $param['show'] ) ? $param['show'] : 'all',
	'option' => $show_option,
	'func'   => 'showchange(this);',
	'sep'    => 'p',
);

$show_help = array(
	'text' => esc_attr__( 'Choose a condition to target to specific content.', 'sticky-buttons' ),
);