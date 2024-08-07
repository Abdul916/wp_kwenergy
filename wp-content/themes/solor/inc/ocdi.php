<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('admin_head', 'solor_admin_head');
function solor_admin_head() {
  echo '<style>
    .ocdi-install-plugins-content-content,
.ocdi-install-plugins-content-header,
.ocdi-imported-footer a:first-of-type
{
		    display: none;
	}
  </style>';
}

function solor_ocdi_before_content_import( $selected_import ) {
	update_option( 'elementor_experiment-e_font_icon_svg', 'inactive' );
}
add_action( 'ocdi/before_content_import', 'solor_ocdi_before_content_import' );

function solor_ocdi_plugin_intro_text( $default_text ) {
    $default_text = '<div class="ocdi__intro-text"><p>Importing demo data (post, pages, images, theme settings, etc.) is the quickest and easiest way to set up your new theme. It allows you to simply edit everything instead of creating content and layouts from scratch.</p></div>';
 
    return $default_text;
}
add_filter( 'ocdi/plugin_intro_text', 'solor_ocdi_plugin_intro_text' );

function solor_ocdi_import_files() {
  return array(
    array(
      'import_file_name'           => 'Demo',
      'import_file_url'            => 'https://demo.awaikenthemes.com/solor/dummy-data/solor.xml',
	  'import_widget_file_url'     => 'https://demo.awaikenthemes.com/solor/dummy-data/widgets.wie',
      'import_customizer_file_url' => 'https://demo.awaikenthemes.com/solor/dummy-data/customizer.dat',
	  'import_preview_image_url'   => 'https://demo.awaikenthemes.com/solor/dummy-data/demo.jpg',
      'preview_url'                => 'https://demo.awaikenthemes.com/solor/',
    )
  );
}
add_filter( 'ocdi/import_files', 'solor_ocdi_import_files' );


function solor_ocdi_after_import_setup() {
	
	// Assign menus to their locations.
	$header_menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
	update_option( 'solor_demo_imported', 1, 'no' );
	
	if( isset($header_menu->term_id) ){
		set_theme_mod( 'nav_menu_locations', array(
				'header' => $header_menu->term_id,
			)
		);
	}
	
	if( isset($footer_menu->term_id) ){
		set_theme_mod( 'nav_menu_locations', array(
				'footer' => $footer_menu->term_id
			)
		);
	}
	
	 // Get the front page.
	  $front_page = get_posts(
		[
		  'post_type'              => 'page',
		  'title'                  => 'Home',
		  'post_status'            => 'all',
		  'numberposts'            => 1,
		  'update_post_term_cache' => false,
		  'update_post_meta_cache' => false,
		]
	  );
	 
	  if ( ! empty( $front_page ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page[0]->ID );
	  }
	  
	  // Get the blog page.
	  $blog_page = get_posts(
		[
		  'post_type'              => 'page',
		  'title'                  => 'Blog',
		  'post_status'            => 'all',
		  'numberposts'            => 1,
		  'update_post_term_cache' => false,
		  'update_post_meta_cache' => false,
		]
	  );
	
	 if ( ! empty( $blog_page ) ) {
		update_option( 'page_for_posts', $blog_page[0]->ID );
	  }
	
	
	  // Get elementor Kit.
	  $kit_page = get_posts(
		[
		  'post_type'              => 'elementor_library',
		  'title'                  => 'Solor - Default Kit',
		  'post_status'            => 'all',
		  'numberposts'            => 1,
		  'update_post_term_cache' => false,
		  'update_post_meta_cache' => false,
		]
	  );
	
	 if ( ! empty( $kit_page ) ) {
		update_option( 'elementor_active_kit', $kit_page[0]->ID );
	  }


}
add_action( 'ocdi/after_import', 'solor_ocdi_after_import_setup' );