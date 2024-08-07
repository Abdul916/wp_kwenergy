<?php
/**
 * The template for displaying header.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<header id="masthead" class="main-header">
	<div class="header-sticky">
		<nav class="navbar navbar-expand-lg">
			<div class="container">
				
				<a class="navbar-brand" href="<?php echo esc_url( home_url('/') ); ?>">
					<?php	
						if ( has_custom_logo( $blog_id = 0 ) ) {
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
							?>
							<img src="<?php echo esc_url($image[0]); ?>" class="logo" alt="<?php bloginfo( 'name' ); ?>">
							<?php 
						}else {
					?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1><?php echo esc_html( get_bloginfo ( 'name' ) ); ?></h1>
						<?php else: ?>
							<h2><?php echo esc_html( get_bloginfo ( 'name' ) ); ?></h2>
						<?php endif; ?>
					<?php 
						}
					?>
					<?php if ( get_theme_mod( 'show_tagline_after_logo', 0 ) ) { ?>
						<span><?php echo esc_html( get_bloginfo ( 'description' ) ); ?></span>
					<?php } ?>
				</a>

				<?php //if ( has_nav_menu('header') ) : ?>
						<?php wp_nav_menu( [ 
								'theme_location' => 'header', 
								'container_class'=>'collapse navbar-collapse main-menu', 
								'menu_class' => 'navbar-nav mr-auto', 
								'li_class'  => 'nav-item', 
								'a_tag_class'  => 'nav-link', 
								'fallback_cb' => 'solor_fallback' ] 
							); 
						?>
				<?php //endif; ?>
			

				<div class="navbar-toggle"></div>
			</div>
		</nav>

		<div class="responsive-menu"></div>
	</div>
</header>
