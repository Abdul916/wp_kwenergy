<?php
/**
 * Display
 *
 * @package     Wow_Pluign
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once( 'options/display.php' );

?>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Font Awesome 5 style', 'sticky-buttons' ); ?>
    </legend>
    <div class="columns is-multiline">
        <div class="column is-4">
            <label class="checkbox label">
				<?php self::option( $disable_fontawesome ); ?><?php esc_attr_e( "Disable", 'sticky-buttons' ); ?><?php self::tooltip( $disable_fontawesome_help ); ?>
            </label>
        </div>
    </div>
</fieldset>
