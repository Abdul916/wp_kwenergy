<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'solor_is_built_with_elementor' ) ) {
	function solor_is_built_with_elementor() {
		$is_elementor_active = false;
		if ( did_action( 'elementor/loaded' ) ) { 
			$post_id = get_the_ID();
			if($post_id) {
				$is_elementor_active = Elementor\Plugin::instance()->db->is_built_with_elementor( $post_id );
			}
		}
		return $is_elementor_active;
	}
}

/**
* Menu fallback
*/

function solor_fallback( $args ) {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Initialize var to store fallback html.
	$fallback_output = '';

	// Menu container opening tag.
	$show_container = false;
	if ( $args['container'] ) {
		/**
		 * Filters the list of HTML tags that are valid for use as menu containers.
		 *
		 * @since WP 3.0.0
		 *
		 * @param array $tags The acceptable HTML tags for use as menu containers.
		 *                    Default is array containing 'div' and 'nav'.
		 */
		$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		if ( is_string( $args['container'] ) && in_array( $args['container'], $allowed_tags, true ) ) {
			$show_container   = true;
			$class            = $args['container_class'] ? ' class="menu-fallback-container ' . esc_attr( $args['container_class'] ) . '"' : ' class="menu-fallback-container"';
			$id               = $args['container_id'] ? ' id="' . esc_attr( $args['container_id'] ) . '"' : '';
			$fallback_output .= '<' . $args['container'] . $id . $class . '>';
		}
	}

	// The fallback menu.
	$class            = $args['menu_class'] ? ' class="menu-fallback-menu ' . esc_attr( $args['menu_class'] ) . '"' : ' class="menu-fallback-menu"';
	$id               = $args['menu_id'] ? ' id="' . esc_attr( $args['menu_id'] ) . '"' : '';
	$fallback_output .= '<ul' . $id . $class . '>';
	$fallback_output .= '<li class="nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="nav-link" title="' . esc_attr__( 'Add a menu', 'solor' ) . '">' . esc_html__( 'Add a menu', 'solor' ) . '</a></li>';
	$fallback_output .= '</ul>';

	// Menu container closing tag.
	if ( $show_container ) {
		$fallback_output .= '</' . $args['container'] . '>';
	}

	// if $args has 'echo' key and it's true echo, otherwise return.
	if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
		echo wp_kses_post( $fallback_output );
	} else {
		return $fallback_output;
	}
}



/**
 * Archive page title
 */

if ( ! function_exists( 'solor_get_archive_title' ) ) {
	function solor_get_archive_title() {

		if ( is_front_page() ) {
			$title = esc_html__( 'Home', 'solor' );
		} elseif ( is_home() ) {
			$title = get_theme_mod( 'blog_page_title' );
			if(empty($title)) {
				$title = esc_html__( 'Blog', 'solor' );
			}
		} elseif ( is_author() ) {
			$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
			// Translators: Add the author's name to the title
			$title = sprintf( esc_html__( 'Author: %s', 'solor' ), $curauth->display_name );
		} elseif ( is_404() ) {
			$title = esc_html__( 'URL not found', 'solor' );
		} elseif ( is_search() ) {
			// Translators: Add the author's name to the title
			$title = sprintf( esc_html__( 'Search: %s', 'solor' ), get_search_query() );
		} elseif ( is_day() ) {
			// Translators: Add the queried date to the title
			$title = sprintf( esc_html__( 'Daily Archives: %s', 'solor' ), get_the_date() );
		} elseif ( is_month() ) {
			// Translators: Add the queried month to the title
			$title = sprintf( esc_html__( 'Monthly Archives: %s', 'solor' ), get_the_date( 'F Y' ) );
		} elseif ( is_year() ) {
			// Translators: Add the queried year to the title
			$title = sprintf( esc_html__( 'Yearly Archives: %s', 'solor' ), get_the_date( 'Y' ) );
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			// Translators: Add the tag's name to the title
			$title = sprintf( esc_html__( 'Tag: %s', 'solor' ), single_tag_title( '', false ) );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} 
		elseif ( is_post_type_archive('awaiken-portfolio') ) {
			$title = get_theme_mod( 'portfolio_page_title' );
			if(empty($title)) {
				$title = esc_html__( 'Our Projects', 'solor' );
			}
			
		}
		elseif ( is_post_type_archive() ) {
			$obj   = get_queried_object();
			$title = ! empty( $obj->labels->all_items ) ? $obj->labels->all_items : '';
		} elseif ( is_attachment() ) {
			// Translators: Add the attachment's name to the title
			$title = sprintf( esc_html__( 'Attachment: %s', 'solor' ), get_the_title() );
		} elseif ( is_single() || is_page() ) {
			$title = get_the_title();
		} else {
			$title = get_the_title();
		}
		return apply_filters( 'solor_filter_get_archive_title', $title );
	}
}

/**
 * Set our Social Icons URLs.
 */
if ( ! function_exists( 'solor_social_icons_list' ) ) {
	function solor_social_icons_list() {

		$social_icons = array(
			array( 'url' => '500px.com', 'icon' => 'fab fa-500px', 'class' => 'fivehundredpx' ),
			array( 'url' => 'artstation.com', 'icon' => 'fab fa-artstation', 'class' => 'artstation' ),
			array( 'url' => 'behance.net', 'icon' => 'fab fa-behance', 'class' => 'behance' ),
			array( 'url' => 'bitbucket.org', 'icon' => 'fab fa-bitbucket', 'class' => 'bitbucket' ),
			array( 'url' => 'codepen.io', 'icon' => 'fab fa-codepen', 'class' => 'codepen' ),
			array( 'url' => 'deviantart.com', 'icon' => 'fab fa-deviantart', 'class' => 'deviantart' ),
			array( 'url' => 'discord.gg', 'icon' => 'fab fa-discord', 'class' => 'discord' ),
			array( 'url' => 'dribbble.com', 'icon' => 'fab fa-dribbble', 'class' => 'dribbble' ),
			array( 'url' => 'etsy.com', 'icon' => 'fab fa-etsy', 'class' => 'etsy' ),
			array( 'url' => 'facebook.com', 'icon' => 'fab fa-facebook-f', 'class' => 'facebook' ),
			array( 'url' => 'figma.com', 'icon' => 'fab fa-figma', 'class' => 'figma' ),
			array( 'url' => 'flickr.com', 'icon' => 'fab fa-flickr', 'class' => 'flickr' ),
			array( 'url' => 'foursquare.com', 'icon' => 'fab fa-foursquare', 'class' => 'foursquare' ),
			array( 'url' => 'github.com', 'icon' => 'fab fa-github', 'class' => 'github' ),
			array( 'url' => 'instagram.com', 'icon' => 'fab fa-instagram', 'class' => 'instagram' ),
			array( 'url' => 'kickstarter.com', 'icon' => 'fab fa-kickstarter-k', 'class' => 'kickstarter' ),
			array( 'url' => 'last.fm', 'icon' => 'fab fa-lastfm', 'class' => 'lastfm' ),
			array( 'url' => 'linkedin.com', 'icon' => 'fab fa-linkedin-in', 'class' => 'linkedin' ),
			array( 'url' => 'mastodon.social', 'icon' => 'fab fa-mastodon', 'class' => 'mastodon' ),
			array( 'url' => 'mastodon.art', 'icon' => 'fab fa-mastodon', 'class' => 'mastodon' ),
			array( 'url' => 'medium.com', 'icon' => 'fab fa-medium-m', 'class' => 'medium' ),
			array( 'url' => 'patreon.com', 'icon' => 'fab fa-patreon', 'class' => 'patreon' ),
			array( 'url' => 'pinterest.com', 'icon' => 'fab fa-pinterest-p', 'class' => 'pinterest' ),
			array( 'url' => 'quora.com', 'icon' => 'fab fa-quora', 'class' => 'Quora' ),
			array( 'url' => 'reddit.com', 'icon' => 'fab fa-reddit-alien', 'class' => 'reddit' ),
			array( 'url' => 'slack.com', 'icon' => 'fab fa-slack-hash', 'class' => 'slack.' ),
			array( 'url' => 'slideshare.net', 'icon' => 'fab fa-slideshare', 'class' => 'slideshare' ),
			array( 'url' => 'snapchat.com', 'icon' => 'fab fa-snapchat-ghost', 'class' => 'snapchat' ),
			array( 'url' => 'soundcloud.com', 'icon' => 'fab fa-soundcloud', 'class' => 'soundcloud' ),
			array( 'url' => 'spotify.com', 'icon' => 'fab fa-spotify', 'class' => 'spotify' ),
			array( 'url' => 'stackoverflow.com', 'icon' => 'fab fa-stack-overflow', 'class' => 'stackoverflow' ),
			array( 'url' => 'steamcommunity.com', 'icon' => 'fab fa-steam', 'class' => 'steam' ),
			array( 'url' => 't.me', 'icon' => 'fab fa-telegram', 'class' => 'Telegram' ),
			array( 'url' => 'tiktok.com', 'icon' => 'fab fa-tiktok', 'class' => 'tiktok' ),
			array( 'url' => 'tumblr.com', 'icon' => 'fab fa-tumblr', 'class' => 'tumblr' ),
			array( 'url' => 'twitch.tv', 'icon' => 'fab fa-twitch', 'class' => 'twitch' ),
			array( 'url' => 'twitter.com', 'icon' => 'fab fa-twitter', 'class' => 'twitter' ),
			array( 'url' => 'assetstore.unity.com', 'icon' => 'fab fa-unity', 'class' => 'unity' ),
			array( 'url' => 'unsplash.com', 'icon' => 'fab fa-unsplash', 'class' => 'unsplash' ),
			array( 'url' => 'vimeo.com', 'icon' => 'fab fa-vimeo-v', 'class' => 'vimeo' ),
			array( 'url' => 'weibo.com', 'icon' => 'fab fa-weibo', 'class' => 'weibo' ),
			array( 'url' => 'wa.me', 'icon' => 'fab fa-whatsapp', 'class' => 'WhatsApp' ),
			array( 'url' => 'youtube.com', 'icon' => 'fab fa-youtube', 'class' => 'youtube' ),
		);

		return apply_filters( 'solor_social_icons', $social_icons );
	}
}

/**
 * Get social media icons
 */
 
if ( ! function_exists( 'solor_get_social_media' ) ) {
	function solor_get_social_media() {
		global $SOLOR_STORAGE;
		$output = array();
		$social_icons = solor_social_icons_list();
		$social_urls = explode( ',', get_theme_mod( 'social_urls', $SOLOR_STORAGE['social_urls'] ) );

		foreach( $social_urls as $key => $value ) {
			if ( !empty( $value ) ) {
				$domain = str_ireplace( 'www.', '', parse_url( $value, PHP_URL_HOST ) );
				$index = array_search( strtolower( $domain ), array_column( $social_icons, 'url' ) );
				if( false !== $index ) {
					$output[] = sprintf( '<li class="%1$s"><a href="%2$s" target="_blank" ><i class="%3$s"></i></a></li>',
						$social_icons[$index]['class'],
						esc_url( $value ),
						$social_icons[$index]['icon']
					);
				}
				else {
					$output[] = sprintf( '<li class="nosocial"><a href="%1$s" target="_blank"><i class="%2$s"></i></a></li>',
						esc_url( $value ),
						'fas fa-globe'
					);
				}
			}
		}


		if ( !empty( $output ) ) {
			$output = apply_filters( 'solor_social_profile_list', $output );
			array_unshift( $output, '<ul class="social-icons">' );
			$output[] = '</ul>';
		}

		return implode( '', $output );
	}
}

/**
 * Social share links
 */
if ( ! function_exists( 'solor_generate_social_share_links' ) ) {
	function solor_generate_social_share_links() {
		
		global $SOLOR_STORAGE;
		$social_sharing_links = explode( ',', get_theme_mod( 'social_sharing', $SOLOR_STORAGE['social_sharing'] ) );
		
		$output = array();
		$social_links_array = array();
		$link		= get_the_permalink();
		$title 		= get_the_title();
		$content	= get_the_content();
		$content 	= strip_shortcodes($content);
		$content 	= strip_tags($content);
		$image 		= '';
		
		if( has_post_thumbnail( get_the_ID() ) ) :
			$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
		endif;
		
		$social_links_array['facebook'] = array(
				'url'        => 'https://www.facebook.com/sharer.php?u=' . rawurlencode( $link ) . '&t=' . rawurlencode( $title ),
				'icon'		 => 'fab fa-facebook-f',
			);
		
		$social_links_array['twitter'] = array(
				'url'        => 'https://twitter.com/share?text=' . rawurlencode( html_entity_decode( $title, ENT_COMPAT, 'UTF-8' ) ) . '&url=' . rawurlencode( $link ),
				'icon'		 => 'fab fa-twitter',
			);
		
		$social_links_array['linkedin'] = array(
				'url'        => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&amp;title=' . rawurlencode( $title ) . '&amp;summary=' . rawurlencode( mb_substr( html_entity_decode( $content, ENT_QUOTES, 'UTF-8' ), 0, 256 ) ),
				'icon'		 => 'fab fa-linkedin-in',
			);
			
		$social_links_array['reddit'] = array(
				'url'        => 'https://reddit.com/submit?url=' . $link . '&amp;title=' . rawurlencode( $title ),
				'icon'		 => 'fab fa-reddit-alien',
			);
		
		$social_links_array['tumblr'] = array(
				'url' => 'https://www.tumblr.com/share/link?url=' . rawurlencode( $link ) . '&amp;name=' . rawurlencode( $title ) . '&amp;description=' . rawurlencode( $content ),
				'icon'		 => 'fab fa-tumblr',
			);
		
		
		$social_links_array['pinterest'] = array(
				'url' => 'https://pinterest.com/pin/create/button/?url=' . rawurlencode( $link ) . '&amp;description=' . rawurlencode( $content ) . '&amp;media=' . rawurlencode( $image ),
				'icon'		 => 'fab fa-pinterest-p',
			);
		
		$social_links_array['vk'] = array(
				'url'        => 'https://vkontakte.ru/share.php?url=' . rawurlencode( $link ) . '&amp;title=' . rawurlencode( $title ) . '&amp;description=' . rawurlencode( $content ),
				'icon'		 => 'fab fa-vk',
			);
		
		$social_links_array['email'] = array(
				'url'        => 'mailto:?subject=' . rawurlencode( $title ) . '&body=' . $link,
				'icon'		 => 'fas fa-envelope',
			);
		
		$social_links_array['whatsapp'] = array(
				'url'        => 'https://api.whatsapp.com/send?text=' . rawurlencode( $link ),
				'icon'		 => 'fab fa-whatsapp',
			);
		
		$social_links_array['stumbleupon'] = array(
				'url'        => 'https://www.stumbleupon.com/submit?url=' . rawurlencode( $link ) . '&amp;title=' . rawurlencode( $title ),
				'icon'		 => 'fab fa-stumbleupon',
			);

		$social_links_array['telegram'] = array(
				'url'        => 'https://telegram.me/share/url?url=' . rawurlencode( $link ) . '&amp;text=' . rawurlencode( $title ),
				'icon'		 => 'fab fa-telegram-plane',
			);
			
			$social_links_array['xing'] = array(
				'url'        => 'https://www.xing.com/social_plugins/share/new?sc_p=xing-share&amp;h=1&amp;url=' . rawurlencode( $link ),
				'icon'		 => 'fa-brands fa-square-xing',
			);
		foreach($social_sharing_links as $site) {
			if ( !empty( $site ) ) {
				$url = $social_links_array[$site]['url'];
				$icon = $social_links_array[$site]['icon'];
				$output[] = sprintf( '<li><a href="%1$s" rel="nofollow" target="_blank"><i class="%2$s"></i></a></li>',
							esc_url( $url ),
							esc_attr( $icon )
						);
			}
		}
		
		if ( !empty( $output ) ) {
			array_unshift( $output, '<ul>' );
			$output[] = '</ul>';
		}

		return implode( '', $output );
	}
}

add_action( 'admin_init', function() {
	if ( did_action( 'elementor/loaded' ) ) {
		remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
	}
}, 1 );
