<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add animation control to elementor heading widget
add_action( 'elementor/element/heading/section_title/before_section_end', function( $element, $args ) {

	$element->add_control(
		'solor_animation_heading_style',
		[
			'label' => __( 'solor - Animation', 'solor' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => [
				'' => __( 'None', 'solor' ),
				'style-1' => __( 'Style 1', 'solor' ),
				'style-2' => __( 'Style 2', 'solor' ),
			],
			'prefix_class' => 'solor-heading-animation solor-animation-heading-',
			'default' => 'none',
		]
	);
}, 10, 2 );


// Add animation control to elementor image widget
add_action( 'elementor/element/image/section_image/before_section_end', function( $element, $args ) {

	$element->add_control(
		'solor_animation_image_style',
		[
			'label' => __( 'solor - Animation', 'solor' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => [
				'' => __( 'None', 'solor' ),
				'style-1' => __( 'Reveal Style 1', 'solor' ),
			],
			'prefix_class' => 'solor-image-animation solor-animation-image-',
			'default' => 'none',
		]
	);
}, 10, 2 );