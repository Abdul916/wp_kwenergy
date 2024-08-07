<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
* Secondary Image Meta box for post, page 
*/
class Awaiken_Secondary_Image_Meta_Box
{

    public static function add()
    {
        // define post types to show
        $screens = ['post', 'page','awaiken-portfolio'];

        foreach ($screens as $screen) {

            add_meta_box(
                'awaiken_secondary_image',
                __('Secondary Image', 'solor-themes-addons'),
                [self::class, 'post_page_icon_html'],
                $screen,
                'side',
                'high'
            );

          
        }
    }

    public static function post_page_icon_html( $post )
    {
        self::load_assets();
		$icon = self::get_meta($post, 'awaiken_secondary_image');
        $meta = ($icon) ? esc_url($icon) : '';
		$remove_icon_style = ($meta) ? 'display:block' : 'display:none';
        ?>
        <div class="aw-uploader">
			<?php echo wp_nonce_field( 'awaiken_secondary_image_nonce_action', 'awaiken_secondary_image_nonce_name', true, false ); ?>
            <p>
				<input type="hidden" name="awaiken_secondary_image" id="post_page_icon_hidden" class="meta-image" value="<?php echo esc_url($meta); ?>">
                <input type="button" class="button image-upload" value="Choose Image">
            </p>
            <div class="image-preview"> <span id="remove_post_page_icon" style="cursor:pointer;<?php echo esc_attr($remove_icon_style); ?>">X</span> <img id="post_page_icon_preview" src="<?php echo esc_url($meta); ?>" style="width:200px"></div>
        </div>
        <?php

    }

   
    public static function save($post_id)
    {
		
		if ( ! isset( $_POST['awaiken_secondary_image_nonce_name'] ) ) {
			return;
		}
		
		// check nonce
		if ( ! wp_verify_nonce( $_POST['awaiken_secondary_image_nonce_name'], 'awaiken_secondary_image_nonce_action' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
      
		if ( array_key_exists( 'awaiken_secondary_image', $_POST ) ) {

			update_post_meta(
				$post_id,
				'awaiken_secondary_image',
				esc_url($_POST['awaiken_secondary_image'])
			);
		}
      
    }

    public static function load_assets()
    {
        wp_enqueue_script('awaiken-meta-media', SOLOR_ADDONS_URL . 'assets/js/meta-media.js', '', false, true);
    }

    public static function get_meta($post, $fieldname)
    {
        if (isset($post) && !empty($fieldname)) {

            return get_post_meta($post->ID, $fieldname, true);

        }

    }

}
add_action('add_meta_boxes', ['Awaiken_Secondary_Image_Meta_Box', 'add']);
add_action('save_post', ['Awaiken_Secondary_Image_Meta_Box', 'save']);