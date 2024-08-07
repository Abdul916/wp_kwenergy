<?php
/**
 * The template for displaying singular post-types: posts and user-defined custom post types.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$blog_single_page_layout	=	get_theme_mod( 'blog_single_page_layout', 'full-width' );
if($blog_single_page_layout == 'full-width') {
	$column = 'col-md-12';
}
else{
	$column = 'col-md-9';
}


while ( have_posts() ) :
	the_post();
	$secondary_image = get_post_meta(get_the_ID(), 'awaiken_secondary_image', true);
	if(empty($secondary_image)) {
		$background_image 	= get_theme_mod( 'blog_page_header_background_image' );
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
?>
<main id="content" <?php post_class( 'site-main' ); ?>>
	<div class="page-header" <?php if($secondary_image) { ?> style="background-image: url('<?php echo esc_url($secondary_image); ?>')" <?php } ?>>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-box">
						<?php the_title( '<h1 class="text-anime">', '</h1>' ); ?>
						<div class="post-meta">
							<ul>
								<li><?php echo get_the_date(); ?></li>
								<li>
								<?php
									printf( '<a href="%s">%s %s</a>',  esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ),esc_html( 'By', 'solor' ), get_the_author() );
								?>
								</li>
								<li>
								<?php
									printf( '%s %s', esc_html( 'In', 'solor' ), get_the_category_list(', ') );
								?>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-single-post">
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

						<div class="row">
							<div class="col-lg-8">
								<div class="post-tags">
								<?php the_tags( '<span class="tag-links">' . esc_html__( 'Tagged : ', 'solor' ), null, '</span>' ); ?>
								</div>
							</div>

							<div class="col-lg-4">
								<?php do_action('solor_action_social_sharing'); ?>
							</div>
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
					if($blog_single_page_layout == 'with-sidebar'):
						get_sidebar();
					endif;
				?>
			</div>
		</div>
	</div>
</main>
<?php
endwhile;
