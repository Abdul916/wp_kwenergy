<?php
/**
 * List of Items
 *
 * @package     Wow_Plugin
 * @subpackage  Admin/Items
 * @author      Wow-Company <yoda@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'class-list-table.php';

$list_table = new Wow_List_Table( $data, $this->plugin );
$list_table->prepare_items();
?>
<div class="wrap">
    <form method="post">
		<?php
		$list_table->search_box( esc_attr__( 'Search', 'sticky-buttons' ), $this->plugin['slug'] );
		$list_table->display();
		?>
        <input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>"/>
	    <?php wp_nonce_field( 'wowp_plugin_nonce', 'wowp_plugin_list_action' ); ?>
    </form>
</div>
