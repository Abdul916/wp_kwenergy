<?php 
/*
Plugin Name:  Solor Theme Addons
Plugin URI:   https://awaikenthemes.com
Description:  This plugin is intended for use with the Solor theme.
Version:      1.0
Author:       Awaiken Technology
Author URI:   https://awaiken.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  solor-themes-addons
Domain Path:  /languages
*/

define( 'SOLOR_ADDONS_URL', plugins_url( '/', __FILE__ ) );
define( 'SOLOR_ADDONS_PATH', plugin_dir_path( __FILE__ ) );


// Load translation.
add_action( 'init', 'solor_i18n' );

/**
 * Load the plugin text domain for translation.
 *
 * @since    1.0.0
 */
function solor_i18n() {
	load_plugin_textdomain( 'solor-themes-addons' );
}

/* Allow SVG upload */
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) {

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext' => $filetype['ext'],
      'type' => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function solor_allow_svg_upload( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'solor_allow_svg_upload' );


require SOLOR_ADDONS_PATH . 'includes/secondary-image.php';

// Creating the need help widget
class solor_need_help_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            "solor_need_help",
            __("Need Help", "solor-themes-addons"),
			[
                "description" => __(
                    "The widget is used to display a 'Need Help' box.",
                    "solor-themes-addons"
                ),
            ]
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters("widget_title", $instance["title"]);

		echo wp_kses_post( $args["before_widget"] );
		?>
		
		<div class="sidebar-cta-box wow fadeInUp">
			<?php if($instance['image']){ ?>
			<div class="cta-image">
				<figure class="image-anime">
					<img src="<?php echo esc_url( $instance['image'] ); ?>" alt="">
				</figure>
			</div>
			<?php } ?>
			
			<div class="cta-content">
				<div class="cta-icon">
					<i class="fa-solid fa-phone-volume"></i>
				</div>
				
				<?php if($instance['title']){ ?>
				<h3><?php echo sanitize_text_field( $instance['title'] ); ?></h3>
				<?php } ?>
				<?php if($instance['phonenumber']){ ?>
				<p><a href="tel:<?php echo sanitize_text_field( $instance['phonenumber'] ); ?>"><?php echo sanitize_text_field( $instance['phonenumber'] ); ?></a></p>
				<?php } ?>
			</div>
		</div>
		<?php
		echo wp_kses_post( $args["after_widget"] );
    }

    // Widget Backend
    public function form($instance)
    {
		
		/* Set up some default widget settings. */
		$defaults = array( 
			'title' 		 => esc_html__( 'Need Help? Talk with Expert', 'solor-themes-addons' ), 
			'image'			 => '',
			'phonenumber' 	 => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
        ?>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_attr_e( 'Image URL:', 'solor-themes-addons' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_url( $instance['image'] ); ?>" /><br />
			<small><?php esc_html_e( 'Please insert your image URL.', 'solor-themes-addons' ); ?></small>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'solor-themes-addons' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo sanitize_text_field( $instance['title'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phonenumber' ) ); ?>"><?php esc_attr_e( 'Phone Number:', 'solor-themes-addons' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phonenumber' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phonenumber' ) ); ?>" value="<?php echo sanitize_text_field( $instance['phonenumber'] ); ?>" />
		</p>
		

			<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance["title"] 		= (!empty($new_instance["title"]))? strip_tags($new_instance["title"])  : '';
        $instance["image"] 		= (!empty($new_instance["image"]))? strip_tags($new_instance["image"])  : '';
        $instance["phonenumber"] = (!empty($new_instance["calltext"]))? strip_tags($new_instance["phonenumber"])  : '';
        return $instance;
    }

    // Class solor_need_help_widget ends here
}

// Register and load the widget
function solor_load_widget()
{
    register_widget("solor_need_help_widget");
}
add_action("widgets_init", "solor_load_widget");




/*
* Portfolio CPT
*/
if(!class_exists('Awaiken_Portfolio')) { 
	class Awaiken_Portfolio {

		const CPT_SLUG = 'awaiken-portfolio';
		const TAXONOMY_CATEGORY_SLUG = 'awaiken-portfolio-category';

		public function register_data() {

			$labels = [
				'name' => esc_html_x( 'Portfolio', 'Portfolio', 'solor-themes-addons' ),
				'singular_name' => esc_html_x( 'Portfolio', 'Portfolio', 'solor-themes-addons' ),
				'menu_name' => esc_html_x( 'Portfolio', 'Portfolio', 'solor-themes-addons' ),
				'name_admin_bar' => esc_html__( 'Portfolio Item', 'solor-themes-addons' ),
				'archives' => esc_html__( 'Portfolio Item Archives', 'solor-themes-addons' ),
				'parent_item_colon' => esc_html__( 'Parent Item:', 'solor-themes-addons' ),
				'all_items' => esc_html__( 'All Items', 'solor-themes-addons' ),
				'add_new_item' => esc_html__( 'Add New Portfolio', 'solor-themes-addons' ),
				'add_new' => esc_html__( 'Add New', 'solor-themes-addons' ),
				'new_item' => esc_html__( 'New Portfolio', 'solor-themes-addons' ),
				'edit_item' => esc_html__( 'Edit Portfolio', 'solor-themes-addons' ),
				'update_item' => esc_html__( 'Update Portfolio', 'solor-themes-addons' ),
				'view_item' => esc_html__( 'View Portfolio', 'solor-themes-addons' ),
				'search_items' => esc_html__( 'Search Portfolios', 'solor-themes-addons' ),
				'not_found' => esc_html__( 'Not found', 'solor-themes-addons' ),
				'not_found_in_trash' => esc_html__( 'Not found in Trash', 'solor-themes-addons' ),
				'featured_image' => esc_html__( 'Featured Image', 'solor-themes-addons' ),
				'set_featured_image' => esc_html__( 'Set featured image', 'solor-themes-addons' ),
				'remove_featured_image' => esc_html__( 'Remove featured image', 'solor-themes-addons' ),
				'use_featured_image' => esc_html__( 'Use as featured image', 'solor-themes-addons' ),
				'insert_into_item' => esc_html__( 'Insert into Portfolio', 'solor-themes-addons' ),
				'uploaded_to_this_item' => esc_html__( 'Uploaded to this Portfolio', 'solor-themes-addons' ),
				'items_list' => esc_html__( 'Items list', 'solor-themes-addons' ),
				'items_list_navigation' => esc_html__( 'Items list navigation', 'solor-themes-addons' ),
				'filter_items_list' => esc_html__( 'Filter items list', 'solor-themes-addons' ),
			];

			$portfolio_slug = apply_filters( 'awaiken_portfolio_slug', 'portfolio' );

			$rewrite = [
				'slug' => $portfolio_slug,
				'with_front' => false,
			];

			$args = [
				'labels' => $labels,
				'public' => true,
				'menu_position' => 25,
				'menu_icon' => 'dashicons-format-image',
				'show_in_rest'       => true,
				'capability_type' => 'post',
				'supports' => [ 'title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments', 'revisions', 'page-attributes', 'custom-fields', 'elementor' ],
				'has_archive' => true,
				'rewrite' => $rewrite,
			];

			register_post_type( self::CPT_SLUG, $args );

			// Categories
			$portfolio_category_slug = apply_filters( 'awaiken_portfolio_category_slug', 'portfolio-category' );

			$rewrite = [
				'slug' => $portfolio_category_slug,
				'with_front' => false,
			];

			$args = [
				'hierarchical' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'show_admin_column' => true,
				'labels' => $labels,
				'rewrite' => $rewrite,
				'public' => true,
				'labels' => [
					'name' => esc_html_x( 'Categories', 'Portfolio', 'solor-themes-addons' ),
					'singular_name' => esc_html_x( 'Category', 'Portfolio', 'solor-themes-addons' ),
					'all_items' => esc_html_x( 'All Categories', 'Portfolio', 'solor-themes-addons' ),
				],
			];
			register_taxonomy( self::TAXONOMY_CATEGORY_SLUG, self::CPT_SLUG, $args );
		}

		public function __construct() {
			add_action( 'init', [ $this, 'register_data' ], 1 );
		}
	}
	/**
	 * initialize 
	 */
	$Awaiken_Portfolio = new Awaiken_Portfolio();
}