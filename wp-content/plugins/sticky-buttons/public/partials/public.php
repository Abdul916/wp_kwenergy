<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! empty( $param['menu_1']['item_type'] ) ) {
	$count_i = count( $param['menu_1']['item_type'] );
} else {
	$count_i = 0;
}


if ( $count_i > 0 ) {
	$position  = isset( $param['position'] ) ? ' ' . $param['position'] : ' -left-center';
	$shape     = isset( $param['shape'] ) ? ' ' . $param['shape'] : ' -square';
	$size      = ' -medium';
	$space     = ! empty( $param['space'] ) ? ' -space' : '';


	$menu_add_classes = $position . $shape . $size . $space ;

	$menu = '<ul class="sticky-buttons' . $menu_add_classes . '" id="sticky-buttons-' . $id . '">';

	for ( $i = 0; $i < $count_i; $i ++ ) {

		$menu .= '<li>';

		$icon = '<span class="sb-icon ' . $param['menu_1']['item_icon'][ $i ] . '"></span>';

		$button_class = $param['menu_1']['button_class'][ $i ];
		$class_add    = ! empty( $button_class ) ? ' class="' . $button_class . '"' : '';
		$button_id    = $param['menu_1']['button_id'][ $i ];
		$id_add       = ! empty( $button_id ) ? ' id="' . $button_id . '"' : '';
		$link_param   = $id_add . $class_add;

		$tooltip_text = $param['menu_1']['item_tooltip'][ $i ];

		$tooltip = ! empty( $tooltip_text ) ? '<span class="sb-label">' . $tooltip_text . '</span>' : '';

		$item_type = $param['menu_1']['item_type'][ $i ];

		$link   = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
		$menu   .= '<a href="' . $link . '" ' . $link_param . '>';
		$menu   .= $icon . $tooltip;
		$menu   .= '</a>';

		$menu .= '</li>';
	}
	$menu .= '</ul>';
}


