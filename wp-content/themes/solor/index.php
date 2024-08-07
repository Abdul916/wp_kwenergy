<?php
/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

if ( is_page() ) {
	get_template_part( 'template-parts/page' );
} elseif ( is_singular('awaiken-portfolio') ) {
	get_template_part( 'template-parts/single-portfolio' );
} elseif ( is_singular() ) {
	get_template_part( 'template-parts/single' );
} elseif ( is_post_type_archive('awaiken-portfolio') ) {
	get_template_part( 'template-parts/archive-portfolio' );
} elseif ( is_archive() || is_home() ) {
	get_template_part( 'template-parts/archive' );
} elseif ( is_search() ) {
	get_template_part( 'template-parts/search' );
} else {
	get_template_part( 'template-parts/404' );
}

get_footer();