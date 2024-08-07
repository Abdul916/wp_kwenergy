<?php
/**
 * The template for displaying sidebar.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="col-md-3">
	<div class="sidebar-widget">
		<?php if ( is_active_sidebar( 'main-sidebar' )  ) : ?>
			<?php dynamic_sidebar( 'main-sidebar' ); ?>
		<?php endif; ?>
	</div>
</div>