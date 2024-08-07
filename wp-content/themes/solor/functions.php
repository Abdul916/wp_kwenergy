<?php
/**
 * Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SOLOR_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'SOLOR_THEME_DIR', get_template_directory() );
define( 'SOLOR_THEME_URL', get_template_directory_uri() );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

// Theme storage
// Attention! Must be in the global namespace to compatibility with WP-CLI
//-------------------------------------------------------------------------
$GLOBALS['SOLOR_STORAGE'] = array(
		'blog_icon_default' => SOLOR_THEME_URL.'/assets/images/icon-blog.svg',
		'social_sharing' => 'facebook,twitter,linkedin',
		'social_urls' => 'https://www.instagram.com/,https://www.facebook.com/,https://www.youtube.com/,https://twitter.com/',
		'show_preloader' => 0,
		'show_tagline_after_logo' => 0,
		'magic_cursor' => 1,
		'footer_copyright_text' => '',
		'smooth_scrolling' => 0,
		'archive_page_layout' => 'full-width',
		'blog_single_page_layout' => 'full-width',
		'header_background_image' => '',
		'preloader_icon' => '',
		'blog_page_header_background_image' => '',
		'portfolio_page_title' => '',
		'portfolio_page_header_background_image' => '',
		'portfolio_archive_page_layout' => 'full-width',
		'portfolio_single_page_layout' => 'full-width',
);

if ( ! function_exists( 'solor_theme_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function solor_theme_setup() {
	
		register_nav_menus( 
			array( 
					'header' => esc_html__( 'Header', 'solor' ) ,
					'footer' => esc_html__( 'Footer', 'solor' ) 
				 )		
		);
		

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'editor-styles' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 350,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
		
		/*
		 * Gutenberg wide images.
		 */
		add_theme_support( 'align-wide' );
		
		/**
        * Load textdomain.
        */
        load_theme_textdomain( 'solor', SOLOR_THEME_DIR . '/languages' );

		
		
		if ( is_admin() ) { 
			add_editor_style( array('assets/css/css-variable.css', 'assets/css/all.min.css', 'style-editor.css' ) );
		}

	}

}
add_action( 'after_setup_theme', 'solor_theme_setup' );




/**
 * Enqueue styles
 */
if ( ! function_exists( 'solor_theme_load_styles' ) ) {
	function solor_theme_load_styles() {
		
		if( get_option( 'solor_demo_imported' ) != 1 ) {
			
			wp_enqueue_style( 'theme-font-rajdhani', "https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap", array(), SOLOR_THEME_VERSION );	
			wp_enqueue_style( 'theme-font-rubik', "https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap", array(), SOLOR_THEME_VERSION );	
			wp_enqueue_style( 'theme-css-variable', SOLOR_THEME_URL . '/assets/css/css-variable.css', array(), SOLOR_THEME_VERSION );
			wp_enqueue_style( 'slicknav', SOLOR_THEME_URL . '/assets/css/slicknav.min.css', array(), SOLOR_THEME_VERSION );
		}
		
		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		}
		
		
		wp_enqueue_style( 'fontawesome-6.4.0', SOLOR_THEME_URL . '/assets/css/all.min.css', array(), SOLOR_THEME_VERSION );
		wp_enqueue_style( 'bootstrap-5.3.2', SOLOR_THEME_URL . '/assets/css/bootstrap.min.css', array(), SOLOR_THEME_VERSION );
		wp_enqueue_style( 'theme-style', SOLOR_THEME_URL . '/style.css', array('bootstrap-5.3.2','fontawesome-6.4.0'), SOLOR_THEME_VERSION );
		
	}
}
add_action( 'wp_enqueue_scripts', 'solor_theme_load_styles',999 );

/**
 * Enqueue scripts
 */
if ( ! function_exists( 'solor_theme_load_scripts' ) ) {
	function solor_theme_load_scripts() {
		global $SOLOR_STORAGE;
		if( get_theme_mod( 'smooth_scrolling', $SOLOR_STORAGE['smooth_scrolling'] ) ) { 
			wp_enqueue_script( 'SmoothScroll', SOLOR_THEME_URL . '/assets/js/SmoothScroll.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		}
		
	
		if( get_option( 'solor_demo_imported' ) != 1 ) {
			wp_enqueue_script( 'slicknav', SOLOR_THEME_URL . '/assets/js/jquery.slicknav.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		}
		
		
		wp_enqueue_script( 'gsap', SOLOR_THEME_URL . '/assets/js/gsap.min.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		if( get_theme_mod( 'magic_cursor', $SOLOR_STORAGE['magic_cursor'] ) ) { 
		wp_enqueue_script( 'magiccursor', SOLOR_THEME_URL . '/assets/js/magiccursor.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		}
		
		wp_enqueue_script( 'splitType', SOLOR_THEME_URL . '/assets/js/splitType.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		wp_enqueue_script( 'ScrollTrigger', SOLOR_THEME_URL . '/assets/js/ScrollTrigger.min.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		wp_enqueue_script( 'theme-js', SOLOR_THEME_URL . '/assets/js/function.js', array( 'jquery' ), SOLOR_THEME_VERSION, true );
		
		// js for comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}
}
add_action( 'wp_enqueue_scripts', 'solor_theme_load_scripts' );


/**
 * Register widget area.
 */
if ( ! function_exists( 'solor_widgets_init' ) ) {
	function solor_widgets_init() {
		
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'solor' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'solor' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		
		register_sidebar( array(
			'name'          => esc_html__( 'Service sidebar', 'solor' ),
			'id'            => 'services-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your services sidebar.', 'solor' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Portfolio sidebar', 'solor' ),
			'id'            => 'portfolio-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your project sidebar.', 'solor' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		
	}
}
add_action( 'widgets_init', 'solor_widgets_init' );

/**
	Include required file
*/
require_once SOLOR_THEME_DIR . '/inc/init.php';



/**
	Register action
*/
add_action( 'solor_action_get_breadcrumb', 'solor_get_breadcrumb' );
add_action( 'solor_action_social_sharing', 'solor_get_social_sharing_icons' );

function solor_get_social_sharing_icons() {
	$sharing_links = solor_generate_social_share_links();
	if($sharing_links) {
		echo '<div class="post-social-sharing">';
		echo wp_kses_post($sharing_links);
		echo '</div>';
	}
}


/*
 * Add class to body
*/
add_filter( 'body_class', 'solor_body_class' );
function solor_body_class( $classes ) {
	global $SOLOR_STORAGE;
	
    if( get_theme_mod( 'magic_cursor', $SOLOR_STORAGE['magic_cursor'] ) ) { 
        $classes[] = 'tt-magic-cursor';
    }
	
    return $classes;
}

add_action( 'wp_body_open', 'solor_wp_body_open' );

function solor_wp_body_open() {
	global $SOLOR_STORAGE;

	if( !is_admin() && get_theme_mod( 'show_preloader', $SOLOR_STORAGE['show_preloader'] ) ) { 
	
	$icon = get_theme_mod( 'preloader_icon', $SOLOR_STORAGE['preloader_icon'] );
	$preloader_icon = SOLOR_THEME_URL.'/assets/images/loader.svg';
	if ( !empty($icon) ) { 
		$preloader_icon = wp_get_attachment_image_src( $icon , 'full' );
		$preloader_icon = $preloader_icon[0];
	}
	?>
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="<?php echo esc_url($preloader_icon); ?>" alt=""></div>
		</div>
	</div>
	<?php 
	} 
	if( get_theme_mod( 'magic_cursor', $SOLOR_STORAGE['magic_cursor'] ) ) { 
	?>
	<div id="magic-cursor">
		<div id="ball"></div>
	</div>
	<?php 
	}
}


/*
* Add class to header menu li tag
*/

function solor_add_additional_class_on_li($classes, $item, $args) {
	if (property_exists($args, 'li_class')) {
        $classes[] = $args->li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'solor_add_additional_class_on_li', 1, 3);

/*
* Add class to header menu li a tag
*/

function solor_add_additional_class_to_a( $atts, $item, $args ) {
  if (property_exists($args, 'a_tag_class')) {
    $atts['class'] = $args->a_tag_class;
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'solor_add_additional_class_to_a', 1, 3 );
