<?php
/**
 * The template for displaying 404 pages (not found).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$background_image 	= get_theme_mod( 'header_background_image','' );
if($background_image) {
	$background_image 	= 	wp_get_attachment_image_src( $background_image , 'full' );
	if(isset($background_image[0])) {
		$background_image	=	$background_image[0];
	}
}

?>
<main id="content" class="site-main">

	<div class="page-header" <?php if($background_image) { ?> style="background-image: url('<?php echo esc_url($background_image); ?>')" <?php } ?>>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-box">
						<h1 class="text-anime"><?php echo esc_html__( 'Page Not Found.', 'solor' ); ?></h1>
						<?php do_action('solor_action_get_breadcrumb');		?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-404">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="page-not-found-box">
						<div class="not-found-image wow fadeInUp">
						<img src="<?php echo SOLOR_THEME_URL; ?>/assets/images/image-404.svg" alt="">
						</div>

						<h2 class="text-anime"><?php echo esc_html__( 'Oops! Sorry, we could not find the Page', 'solor' ); ?></h2>
						<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-default wow fadeInUp" data-wow-delay="0.5s"><?php echo esc_html__( 'Back To Home', 'solor' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>
