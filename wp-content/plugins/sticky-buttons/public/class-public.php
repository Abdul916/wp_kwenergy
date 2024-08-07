<?php
/**
 * Public Class
 *
 * @package     Wow_Plugin
 * @subpackage  Public
 * @author      Wow-Company <yoda@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

namespace sticky_buttons;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Wow_Plugin_Public
 *
 * @package wow_plugin
 *
 * @property array plugin   - base information about the plugin
 * @property array url      - home, pro and other URL for plugin
 * @property array rating   - website and link for rating
 * @property string basedir  - filesystem directory path for the plugin
 * @property string baseurl  - URL directory path for the plugin
 */
class Wow_Plugin_Public {

	private $plugin = '';
	private $url = '';
	private $rating = '';

	/**
	 * Setup to frontend of the plugin
	 *
	 * @param array $info general information about the plugin
	 *
	 * @since 1.0
	 */

	public function __construct( $info ) {

		$this->plugin = $info['plugin'];
		$this->url    = $info['url'];
		$this->rating = $info['rating'];

		add_shortcode( $this->plugin['shortcode'], array( $this, 'shortcode' ) );

		// Display on the site
		add_action( 'wp_footer', array( $this, 'display' ) );

	}

	/**
	 * Display a shortcode
	 *
	 * @param $atts
	 *
	 * @return false|string
	 */
	public function shortcode( $atts ) {
		extract( shortcode_atts( array( 'id' => "" ), $atts ) );
		$id = absint( $atts['id'] );

		global $wpdb;
		$table  = $wpdb->prefix . 'wow_' . $this->plugin['prefix'];
		$sSQL   = $wpdb->prepare( "select * from $table WHERE id = %d", $id );
		$result = $wpdb->get_results( $sSQL, 'OBJECT_K' );

		if ( empty( $result ) ) {
			return false;
		}

		$param = unserialize( $result[ $id ]->param );
		$check = $this->check( $param, $id );

		if ( $check === false ) {
			return false;
		}

		$menu = '';
		include( 'partials/public.php' );

		$this->include_style_script( $param, $id );

		return $menu;

	}

	private function include_style_script( $param, $id ) {
		$slug    = $this->plugin['slug'];
		$version = $this->plugin['version'];

		if ( empty( $param['disable_fontawesome'] ) ) {
			$url_icons = $this->plugin['url'] . 'vendors/fontawesome/css/fontawesome-all.min.css';
			wp_enqueue_style( $slug . '-fontawesome', $url_icons, null, '6.4.2' );
		}

		$pre_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$url_style = plugin_dir_url( __FILE__ ) . 'assets/css/style' . $pre_suffix . '.css';
		wp_enqueue_style( $slug, $url_style, null, $version );

		$inline_style = $this->style( $param, $id );
		wp_add_inline_style( $slug, $inline_style );


	}


	/**
	 * Display the Item on the specific pages, not via the Shortcode
	 */
	public function go_shortcode( $id ) {
		echo do_shortcode( '[' . esc_attr( $this->plugin['shortcode'] ) . ' id=' . absint( $id ) . ']' );
	}

	/**
	 * Display the Item on the specific pages, not via the Shortcode
	 */
	public function display() {
		global $wpdb;
		$table  = $wpdb->prefix . "wow_" . $this->plugin['prefix'];
		$result = $wpdb->get_results( "SELECT * FROM " . $table . " order by id asc" );
		if ( count( $result ) < 1 ) {
			return false;
		}

		foreach ( $result as $key => $val ) {
			$param   = unserialize( $val->param );
			$display = ! empty( $param['show'] ) ? $param['show'] : 'all';
			$id      = $val->id;
			if ( $display === 'all' ) {
				$this->go_shortcode( $id );
			}

		}

	}

	/**
	 * Create Inline style for elements
	 */
	public function style( $param, $id ) {
		if ( ! empty( $param['menu_1']['item_type'] ) ) {
			$count_i = count( $param['menu_1']['item_type'] );
		} else {
			$count_i = 0;
		}
		if ( $count_i > 0 ) {
			$css = '';
			$css .= '#sticky-buttons-' . $id . ' {';
			$css .= 'z-index:' . $param['zindex'] . ';';
			$css .= '}';
			for ( $i = 1; $i <= $count_i; $i ++ ) {
				$ii  = $i - 1;
				$css .= '#sticky-buttons-' . $id . ' li:nth-child(' . $i . ') .sb-icon {';
				$css .= 'color:' . $param['menu_1']['color'][ $ii ] . ';';
				$css .= 'background:' . $param['menu_1']['bcolor'][ $ii ] . ';';
				$css .= '}';
				$css .= '#sticky-buttons-' . $id . ' li:nth-child(' . $i . ') .sb-label {';
				$css .= 'color:' . $param['menu_1']['bcolor'][ $ii ] . ';';
				$css .= 'background:' . $param['menu_1']['color'][ $ii ] . ';';
				$css .= '}';
				$css .= '#sticky-buttons-' . $id . ' li:nth-child(' . $i . '):hover .sb-icon {';
				$css .= 'color:' . $param['menu_1']['bcolor'][ $ii ] . ';';
				$css .= 'background:' . $param['menu_1']['color'][ $ii ] . ';';
				$css .= '}';
			}

			return $css;

		}
	}


	private function check_status( $param ) {
		if ( ! empty( $param['status'] ) ) {
			return false;
		}

		return true;
	}

	private function check_test_mode( $param ) {
		if ( ! empty( $param['test_mode'] ) && ! current_user_can( 'administrator' ) ) {
			return false;
		}

		return true;
	}


	private function check( $param, $id ) {
		$check     = true;
		$check_arr = array(
			'status'    => $this->check_status( $param ),
			'test_mode' => $this->check_test_mode( $param ),
		);

		foreach ( $check_arr as $value ) {
			if ( $value === false ) {
				$check = false;
				break;
			}
		}

		return $check;
	}


}
