<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Set our Customizer default options
*/
if ( ! function_exists( 'awaiken_generate_defaults' ) ) {
	function awaiken_generate_defaults() {
		global $SOLOR_STORAGE;

		return apply_filters( 'awaiken_customizer_defaults', $SOLOR_STORAGE );
	}
}


/**
 * Customizer Setup and Custom Controls
 *
 */

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class awaiken_initialise_customizer_settings {
	// Get our default values
	private $defaults;

	public function __construct() {
		// Get our Customizer defaults
		$this->defaults = awaiken_generate_defaults();


		// Register sections
		add_action( 'customize_register', array( $this, 'awaiken_add_customizer_sections' ) );
		
		// Register general control
		add_action( 'customize_register', array( $this, 'awaiken_register_general_options_controls' ) );
		
		// Register portfolio control
		add_action( 'customize_register', array( $this, 'awaiken_register_portfolio_options_controls' ) );

		// Register blog control
		add_action( 'customize_register', array( $this, 'awaiken_register_blog_options_controls' ) );
		
		// Register footer control
		add_action( 'customize_register', array( $this, 'awaiken_register_footer_options_controls' ) );
		
	}


	/**
	 * Register the Customizer sections
	 */
	public function awaiken_add_customizer_sections( $wp_customize ) {
		
		// Add section general options
		$wp_customize->add_section( 'general_options' , array(
			'title'      => __( 'General Options', 'solor' ),
		) );
		
		// Add section portfolio options
		$wp_customize->add_section( 'portfolio_options' , array(
			'title'      => __( 'Project Options', 'solor' ),
		) );
		
		// Add section blog options
		$wp_customize->add_section( 'blog_options' , array(
			'title'      => __( 'Blog Options', 'solor' ),
		) );
		
		// Add section footer options
		$wp_customize->add_section( 'footer_options' , array(
			'title'      => __( 'Footer Options', 'solor' ),
		) );
		
	}
	
	/**
	 * Register general option controls
	 */

	public function awaiken_register_general_options_controls( $wp_customize ) {  
		
		$section	=	'general_options';
		
		// Preloader
		$wp_customize->add_setting( 'show_preloader',
			array(
				'default' => $this->defaults['show_preloader'],
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_switch_sanitization'
			)
		);
		
		$wp_customize->add_control( new Skyrocket_Toggle_Switch_Custom_control( $wp_customize, 'show_preloader',
			array(
				'label' => __( 'Preloader', 'solor' ),
				'description' => esc_html__( 'Display preloader while the page is loading.', 'solor' ),
				'section' => $section
			)
		) );
		
		// Tag line
		$wp_customize->add_setting( 'show_tagline_after_logo',
			array(
				'default' => $this->defaults['show_tagline_after_logo'],
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_switch_sanitization'
			)
		);
		$wp_customize->add_control( new Skyrocket_Toggle_Switch_Custom_control( $wp_customize, 'show_tagline_after_logo',
			array(
				'label' => __( 'Tagline', 'solor' ),
				'description' => esc_html__( 'Display Tagline after logo.', 'solor' ),
				'section' => $section
			)
		) );
		
		// Magic Cursor
		$wp_customize->add_setting( 'magic_cursor',
			array(
				'default' => $this->defaults['magic_cursor'],
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_switch_sanitization'
			)
		);
		$wp_customize->add_control( new Skyrocket_Toggle_Switch_Custom_control( $wp_customize, 'magic_cursor',
			array(
				'label' => __( 'Magic Cursor', 'solor' ),
				'description' => esc_html__( 'Show Magic Cursor.', 'solor' ),
				'section' => $section
			)
		) );
		
		
		// Smooth scrolling
		$wp_customize->add_setting( 'smooth_scrolling',
			array(
				'default' => $this->defaults['smooth_scrolling'],
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_switch_sanitization'
			)
		);
		$wp_customize->add_control( new Skyrocket_Toggle_Switch_Custom_control( $wp_customize, 'smooth_scrolling',
			array(
				'label' => __( 'Smooth Scrolling', 'solor' ),
				'description' => esc_html__( 'Smooth Scrolling Disable/Enable', 'solor' ),
				'section' => $section
			)
		) );
		
		// Preloader icon
		$wp_customize->add_setting( 'preloader_icon',
			array(
				'default' => $this->defaults['preloader_icon'],
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'preloader_icon',
			array(
				'label' => __( 'Preloader icon', 'solor' ),
				'description' => esc_html__( 'If you want to change the current loading icon, select it here.', 'solor' ),
				'section' => $section,
				'mime_type' => 'image',
				'button_labels' => array(
					'select' => __( 'Select File', 'solor' ),
					'change' => __( 'Change File', 'solor' ),
					'default' => __( 'Default', 'solor' ),
					'remove' => __( 'Remove', 'solor' ),
					'placeholder' => __( 'No file selected', 'solor' ),
					'frame_title' => __( 'Select File', 'solor' ),
					'frame_button' => __( 'Choose File', 'solor' ),
				)
			)
		) );
		
		// Header background image
		$wp_customize->add_setting( 'header_background_image',
			array(
				'default' => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'header_background_image',
			array(
				'label' => __( 'Header Background Image', 'solor' ),
				'description' => esc_html__( 'Header background image is intended for pages that are not created using Elementor.', 'solor' ),
				'section' => $section,
				'mime_type' => 'image',
				'button_labels' => array(
					'select' => __( 'Select File', 'solor' ),
					'change' => __( 'Change File', 'solor' ),
					'default' => __( 'Default', 'solor' ),
					'remove' => __( 'Remove', 'solor' ),
					'placeholder' => __( 'No file selected', 'solor' ),
					'frame_title' => __( 'Select File', 'solor' ),
					'frame_button' => __( 'Choose File', 'solor' ),
				)
			)
		) );
		
	}
	
	/**
	 * Register portfolio option controls
	 */
	
	public function awaiken_register_portfolio_options_controls( $wp_customize ) { 
			
		$section	=	'portfolio_options';

		// Blog page title 
		$wp_customize->add_setting( 'portfolio_page_title', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'portfolio_page_title', array(
			'type' => 'text',
			'section' => $section,
			'label'       => esc_html__( 'Project Page Archive Title', 'solor' ),
		) );
		
		// Header background image
		$wp_customize->add_setting( 'portfolio_page_header_background_image',
			array(
				'default' => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'portfolio_page_header_background_image',
			array(
				'label' => __( 'Header Background Image', 'solor' ),
				'description' => esc_html__( 'Header background image for portfolio archive and single pages that are not created using Elementor.', 'solor' ),
				'section' => $section,
				'mime_type' => 'image',
				'button_labels' => array(
					'select' => __( 'Select File', 'solor' ),
					'change' => __( 'Change File', 'solor' ),
					'default' => __( 'Default', 'solor' ),
					'remove' => __( 'Remove', 'solor' ),
					'placeholder' => __( 'No file selected', 'solor' ),
					'frame_title' => __( 'Select File', 'solor' ),
					'frame_button' => __( 'Choose File', 'solor' ),
				)
			)
		) );
		
		// Archive page layout
		$wp_customize->add_setting( 'portfolio_archive_page_layout', array(
		  'default' => $this->defaults['portfolio_archive_page_layout'],
		   'sanitize_callback' => 'sanitize_text_field',
		) );
		
		$wp_customize->add_control( 'portfolio_archive_page_layout', array(
			  'label'          => __( 'Project Archive Page Layout', 'solor' ),
			  'section' => $section,
			  'settings' => 'portfolio_archive_page_layout',
			  'type' => 'radio',
			  'choices' => array(
				'full-width'   => __( 'Full Width', 'solor' ),
				'with-sidebar'  => __( 'With Sidebar', 'solor' )
			  ),
		) );
		
		// Archive page single page layout
		$wp_customize->add_setting( 'portfolio_single_page_layout', array(
		  'default' => $this->defaults['portfolio_single_page_layout'],
		   'sanitize_callback' => 'sanitize_text_field',
		) );
		
		$wp_customize->add_control( 'portfolio_single_page_layout', array(
			  'label'          => __( 'Project Single Layout', 'solor' ),
			  'section' => $section,
			  'settings' => 'portfolio_single_page_layout',
			  'type' => 'radio',
			  'choices' => array(
				'full-width'   => __( 'Full Width', 'solor' ),
				'with-sidebar'  => __( 'With Sidebar', 'solor' )
			  ),
		) );
		
	}
	
	/**
	 * Register blog option controls
	 */
	
	public function awaiken_register_blog_options_controls( $wp_customize ) { 
			
		$section	=	'blog_options';

		// Blog page title 
		$wp_customize->add_setting( 'blog_page_title', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'blog_page_title', array(
			'type' => 'text',
			'section' => $section,
			'label'       => esc_html__( 'Blog Page Title', 'solor' ),
		) );
		
		//Header Background Image
		$wp_customize->add_setting( 'blog_page_header_background_image',
			array(
				'default' => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'blog_page_header_background_image',
			array(
				'label' => __( 'Header Background Image', 'solor' ),
				'description' => esc_html__( 'Header background image for blog archive and single page.', 'solor' ),
				'section' => $section,
				'mime_type' => 'image',
				'button_labels' => array(
					'select' => __( 'Select File', 'solor' ),
					'change' => __( 'Change File', 'solor' ),
					'default' => __( 'Default', 'solor' ),
					'remove' => __( 'Remove', 'solor' ),
					'placeholder' => __( 'No file selected', 'solor' ),
					'frame_title' => __( 'Select File', 'solor' ),
					'frame_button' => __( 'Choose File', 'solor' ),
				)
			)
		) );
		
		// Archive page layout
		$wp_customize->add_setting( 'archive_page_layout', array(
		  'default' => $this->defaults['archive_page_layout'],
		   'sanitize_callback' => 'sanitize_text_field',
		) );
		
		$wp_customize->add_control( 'archive_page_layout', array(
			  'label'          => __( 'Archive Page Layout', 'solor' ),
			  'section' => $section,
			  'settings' => 'archive_page_layout',
			  'type' => 'radio',
			  'choices' => array(
				'full-width'   => __( 'Full Width', 'solor' ),
				'with-sidebar'  => __( 'With Sidebar', 'solor' )
			  ),
		) );
		
		// Archive page single page layout
		$wp_customize->add_setting( 'blog_single_page_layout', array(
		  'default' => $this->defaults['blog_single_page_layout'],
		   'sanitize_callback' => 'sanitize_text_field',
		) );
		
		$wp_customize->add_control( 'blog_single_page_layout', array(
			  'label'          => __( 'Blog Single Layout', 'solor' ),
			  'section' => $section,
			  'settings' => 'blog_single_page_layout',
			  'type' => 'radio',
			  'choices' => array(
				'full-width'   => __( 'Full Width', 'solor' ),
				'with-sidebar'  => __( 'With Sidebar', 'solor' )
			  ),
		) );
		
		// Social Sharing
		$wp_customize->add_setting( 'social_sharing',
			array(
				'default' => $this->defaults['social_sharing'],
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_text_sanitization'
			)
		);
		$wp_customize->add_control( new Skyrocket_Pill_Checkbox_Custom_Control( $wp_customize, 'social_sharing',
			array(
				'label' => __( 'Social Sharing', 'solor' ),
				'description' => esc_html__( 'Choose the social network you want to display in the social share box.', 'solor' ),
				'section' => $section,
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => true,
				),
				'choices' => array(
					'facebook' => esc_attr__( 'Facebook', 'solor' ),
					'twitter' => esc_attr__( 'Twitter', 'solor' ),
					'whatsapp' => esc_attr__( 'Whatsapp', 'solor' ),
					'linkedin' => esc_attr__( 'LinkedIn', 'solor' ),
					'reddit' => esc_attr__( 'Reddit', 'solor' ),
					'tumblr' => esc_attr__( 'Tumblr', 'solor' ),
					'pinterest' => esc_attr__( 'Pinterest', 'solor' ),
					'vk' => esc_attr__( 'vk', 'solor' ),
					'email' => esc_attr__( 'Email', 'solor' ),
					'telegram' => esc_attr__( 'Telegram', 'solor' ),
				)
			)
		) );

	}
	
	/**
	 * Register footer controls
	 */
	
	public function awaiken_register_footer_options_controls( $wp_customize ) { 
		
		$section	=	'footer_options';
		
		//Footer logo
		$wp_customize->add_setting( 'footer_logo',
			array(
				'default' => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'footer_logo',
			array(
				'label' => __( 'Footer Logo', 'solor' ),
				'section' => $section,
				'mime_type' => 'image',
				'button_labels' => array(
					'select' => __( 'Select File', 'solor' ),
					'change' => __( 'Change File', 'solor' ),
					'default' => __( 'Default', 'solor' ),
					'remove' => __( 'Remove', 'solor' ),
					'placeholder' => __( 'No file selected', 'solor' ),
					'frame_title' => __( 'Select File', 'solor' ),
					'frame_button' => __( 'Choose File', 'solor' ),
				)
			)
		) );
		
		// Copyright text
		$wp_customize->add_setting( 'footer_copyright_text',
			array(
				'default' => $this->defaults['footer_copyright_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'wp_kses_post'
			)
		);
		$wp_customize->add_control( 'footer_copyright_text',
			array(
				'label' => __( 'Copyright Text', 'solor' ),
				'section' => $section,
				'type' => 'textarea',
			)
		);
		
		// Social media URLs
		$wp_customize->add_setting( 'social_urls',
			array(
				'default' => $this->defaults['social_urls'],
				'transport' => 'refresh',
				'sanitize_callback' => 'skyrocket_url_sanitization'
			)
		);
		$wp_customize->add_control( new Skyrocket_Sortable_Repeater_Custom_Control( $wp_customize, 'social_urls',
			array(
				'label' => __( 'Social URLs', 'solor' ),
				'description' => esc_html__( 'Enter the social profile URLs.', 'solor' ),
				'section' => $section,
				'button_labels' => array(
					'add' => __( 'Add Row', 'solor' ),
				)
			)
		) );
		
	}
	
}

/**
 * Load all our Customizer Custom Controls
 */
require_once SOLOR_THEME_DIR . '/inc/customizer/custom-controls.php';

/**
 * Initialise our Customizer settings
 */
$awaiken_settings = new awaiken_initialise_customizer_settings();
