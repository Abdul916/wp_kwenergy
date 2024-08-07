<?php
/**
 * The template for displaying pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) :
	the_post();

$secondary_image = get_post_meta(get_the_ID(), 'awaiken_secondary_image', true);
if(empty($secondary_image)) {
	$background_image 	= get_theme_mod( 'portfolio_page_header_background_image' );
	if($background_image) {
		$background_image 	= 	wp_get_attachment_image_src( $background_image , 'full' );
		if(isset($background_image[0])) {
			$secondary_image	=	$background_image[0];
		}
	}
	else{
		$background_image 	= get_theme_mod( 'header_background_image','' );
		if($background_image) {
			$background_image 	= 	wp_get_attachment_image_src( $background_image , 'full' );
			if(isset($background_image[0])) {
				$secondary_image	=	$background_image[0];
			}
		}
	}
}

$single_page_layout	=	get_theme_mod( 'portfolio_single_page_layout', 'full-width' );
if($single_page_layout == 'full-width') {
	$column = 'col-md-12';
}
else{
	$column = 'col-md-9';
}

?>
<main id="content" <?php post_class( 'site-main' ); ?>>
	<div class="page-header" <?php if($secondary_image) { ?> style="background-image: url('<?php echo esc_url($secondary_image); ?>')" <?php } ?>>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-box">
						<?php the_title( '<h1 class="text-anime">', '</h1>' ); ?>
						<?php do_action('solor_action_get_breadcrumb');		?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-single-post single-page">
		<div class="container">
			<div class="row">
					<?php
						if ( has_post_thumbnail() ) {
							printf( '<div class="col-md-12"><div class="post-featured-image"><a href="%s"><figure class="image-anime">%s</figure></a></div></div>', esc_url( get_permalink() ), get_the_post_thumbnail( $post, 'large' ) );
						}
					?>
				
				<div class="<?php echo esc_attr( $column ); ?>">
					<div class="post-content">
						<div class="post-entry solor-block-style">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
					</div>
					<?php 
							if ( comments_open() || get_comments_number() ) :
							echo '<div class="comment-box">';
								comments_template();
							echo '</div>';
							endif;
					?>
				</div>
				<?php 
					if($single_page_layout == 'with-sidebar'):
						get_sidebar('portfolio');
					endif;
				?>
			</div>
		</div>
	</div>
</main>
<?php
endwhile;
