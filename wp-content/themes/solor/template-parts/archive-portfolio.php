<?php
/**
 * The template for displaying archive pages.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $SOLOR_STORAGE;
$archive_page_layout	=	get_theme_mod( 'portfolio_archive_page_layout', $SOLOR_STORAGE['portfolio_archive_page_layout'] );
if($archive_page_layout == 'full-width') {
	$column = 'col-md-12';
}
else{
	$column = 'col-md-9';
}
$background_image 	= get_theme_mod( 'portfolio_page_header_background_image', $SOLOR_STORAGE['portfolio_page_header_background_image'] );
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
						<h1 class="entry-title"><?php 
									$solor_blog_title_text = solor_get_archive_title();
									echo wp_kses_data( $solor_blog_title_text ); ?></h1>
						<?php
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
						<?php do_action('solor_action_get_breadcrumb'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-content">
		<div class="page-blog-archive">
			<div class="container">
				<div class="row">
					<div class="<?php echo esc_attr( $column ); ?>">
						<div class="row">
					<?php
					while ( have_posts() ) {
						the_post();
						$post_link = get_permalink();
						?>
						<div class="col-lg-3 col-md-6">
							<div class="project-item">
								<?php
									if ( has_post_thumbnail() ) {
										printf( '<div class="project-image"><a href="%s"><figure>%s</figure></a></div>', esc_url( $post_link ), get_the_post_thumbnail( $post, 'large' ) );
									}
								?>

								<div class="project-content">
									<?php
										printf( '<h2><a href="%s">%s</a></h2>', esc_url( $post_link ), wp_kses_post( get_the_title() ) );
										
										$category 	= '';
										$terms	 	= get_the_terms( $post->ID, 'awaiken-portfolio-category' ); 
										if ( ! empty( $terms ) ) {
											foreach($terms as $term) {
												$category = $term->name;
												break;
											}
										}
										if($category) {
									?>
									<p><?php echo esc_html($category); ?></p>
									<?php } ?>
								</div>

								<div class="project-link">
									<a href="<?php echo esc_url( $post_link ); ?>"> <img src="<?php echo SOLOR_THEME_URL; ?>/assets/images/icon-link.svg" alt=""></a>
								</div>
							</div>
						</div>
					<?php } ?>
							<div class="col-md-12">
								<?php
									echo get_the_posts_pagination( array(
											'mid_size' => 2,
											'prev_text' => '<i class="fa-solid fa-arrow-left-long"></i>',
											'next_text' => '<i class="fa-solid fa-arrow-right-long"></i>',
										) );
								?>
							</div>
						</div>
					</div>
				<?php 
					if($archive_page_layout == 'with-sidebar'):
						get_sidebar('portfolio');
					endif;
				?>
				</div>
			</div>
		</div>
	</div>
</main>
