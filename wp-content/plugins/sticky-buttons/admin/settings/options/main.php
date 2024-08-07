<?php
/**
 * Main Settings param
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


// Position of the menu
$position = array(
	'id'     => 'position',
	'name'   => 'param[position]',
	'type'   => 'select',
	'val'    => isset( $param['position'] ) ? $param['position'] : '-left-center',
	'option' => array(
		'-left-center'   => esc_attr__( 'Left Center', 'sticky-buttons' ),
		'-right-center'  => esc_attr__( 'Right Center', 'sticky-buttons' ),
	),
);

// Menu position help
$position_help = array(
	'text' => esc_attr__( 'Specify position on screen.', 'sticky-buttons' ),
);

// Shape for menu item
$shape = array(
	'name'   => 'param[shape]',
	'class'  => '',
	'type'   => 'select',
	'val'    => isset( $param['shape'] ) ? $param['shape'] : '-square',
	'option' => array(
		'-square'  => esc_attr__( 'Square', 'sticky-buttons' ),
		'-rsquare' => esc_attr__( 'Rounded square', 'sticky-buttons' ),
		'-circle'  => esc_attr__( 'Circle', 'sticky-buttons' ),
		'-ellipse' => esc_attr__( 'Ellipse', 'sticky-buttons' ),
	),
);

// Shape help
$shape_help = array(
	'text' => esc_attr__( 'The shape of the buttons. It also determines the shape of the labels.',
		'sticky-buttons' ),
);

// Size
$size = array(
	'name'   => 'param[size]',
	'class'  => '',
	'type'   => 'select',
	'val'    => isset( $param['size'] ) ? $param['size'] : '-medium',
	'option' => array(
		'-medium' => esc_attr__( 'Medium', 'sticky-buttons' ),
	),
);

// Size help
$size_help = array(
	'text' => esc_attr__( 'Set the size for all buttons', 'sticky-buttons' ),
);

// Space
$space = array(
	'name'   => 'param[space]',
	'class'  => '',
	'type'   => 'select',
	'val'    => isset( $param['space'] ) ? $param['space'] : '-space',
	'option' => array(
		'-space' => esc_attr__( 'Yes', 'sticky-buttons' ),
		''       => esc_attr__( 'No', 'sticky-buttons' ),
	),
);

// Side Space help
$space_help = array(
	'text' => esc_attr__( 'If there should be space between buttons.', 'sticky-buttons' ),
);

// Label Animate
$animation = array(
	'name'   => 'param[animation]',
	'class'  => '',
	'type'   => 'select',
	'val'    => isset( $param['animation'] ) ? $param['animation'] : '',
	'option' => array(
		''             => esc_attr__( 'None', 'sticky-buttons' ),
	),
);

// Label Animate help
$animation_help = array(
	'text' => esc_attr__( 'The appearance effect of the button label', 'sticky-buttons' ),
);

// Shadow
$shadow = array(
	'name'   => 'param[shadow]',
	'class'  => '',
	'type'   => 'select',
	'val'    => isset( $param['shadow'] ) ? $param['shadow'] : '',
	'option' => array(
		''        => esc_attr__( 'No', 'sticky-buttons' ),
	),
);

// Side Space help
$shadow_help = array(
	'text' => esc_attr__( 'If there should be a shadow on buttons.', 'sticky-buttons' ),
);

$zindex = array(
	'name'   => 'param[zindex]',
	'type'   => 'number',
	'val'    => isset( $param['zindex'] ) ? round( $param['zindex'] ) : '9',
	'option' => array(
		'min'         => '0',
		'step'        => '1',
		'placeholder' => '9',
	),
);

// Z-index helper
$zindex_help = array(
	'text' => esc_attr__( 'The z-index property specifies the stack order of an element. An element with greater stack order is always in front of an element with a lower stack order.',
		'sticky-buttons' ),
);
