<?php
/**
 * Functions for use within theme templates.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

add_filter( 'th_insert_post_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ),   5  );
add_filter( 'th_insert_post_content', array( $GLOBALS['wp_embed'], 'autoembed'     ),   5  );
add_filter( 'th_insert_post_content',                              'wptexturize',       10 );
add_filter( 'th_insert_post_content',                              'convert_smilies',   15 );
add_filter( 'th_insert_post_content',                              'convert_chars',     20 );
add_filter( 'th_insert_post_content',                              'wpautop',           25 );
add_filter( 'th_insert_post_content',                              'do_shortcode',      30 );
add_filter( 'th_insert_post_content',                              'shortcode_unautop', 35 );

function th5_is_edd_page() {

	if ( is_admin() || ! function_exists( 'edd_is_checkout' ) )
		return false;

	return edd_is_checkout() ||
	       edd_is_success_page() ||
	       edd_is_failed_transaction_page() ||
	       is_singular( 'download' ) ||
	       is_post_type_archive( 'download' ) ||
	       is_tax( 'download_category' ) ||
	       is_tax( 'download_tag' );
}

function th5_plans_url() {

	return esc_url( th5_get_plans_url() );
}

function th5_get_plans_url() {

	return home_url( '#plans-pricing' );
}

add_shortcode( 'th_post_content', 'th_post_content_shortcode' );

function th_post_content_shortcode( $attr ) {

	$attr = shortcode_atts( array( 'post_id' => 0 ), $attr );

	return apply_filters(
		'th_insert_post_content',
		get_post_field( 'post_content', absint( $attr['post_id'] ), 'display' )
	);
}

// apply_filters( 'edd_get_bundled_products', array_filter( $this->bundled_downloads ), $this->ID )

add_filter( 'edd_get_bundled_products', 'th5_get_bundled_downloads', 95, 2 );

function th5_get_bundled_downloads( $downloads, $download_id ) {

	if ( current_user_can( 'edit_product', $download_id ) || current_user_can( 'download_club_content' ) ) {
		return $downloads;
	}

	$has_m = get_post_meta( $download_id, '_edd_members_length_enabled', true );

	if ( $has_m )
		return array();

	return $downloads;
}

//add_filter( 'edd_download_files', 'th5_download_files', 10, 2 );
//'return apply_filters( 'edd_download_files', $this->files, $this->ID, $variable_price_id );

function th5_download_files( $files, $download_id ) {

	if ( edd_members_is_membership_valid( get_current_user_id() ) )
		return $files;


	$has_m = get_post_meta( $download_id, '_edd_members_length_enabled', true );

	if ( $has_m )
		return array();

var_dump( $download_id );

	return $files;
}



//add_filter( 'edd_get_payment_meta__edd_payment_meta', 'th5_get_payment_meta', 95, 2 );

function th5_get_payment_meta( $meta, $payment_id ) {

	if ( edd_members_is_membership_valid( get_current_user_id() ) )
		return $meta;

	if ( isset( $meta['downloads'] ) && is_array( $meta['downloads'] ) ) {

		$new_downloads = $meta['downloads'];

		foreach ( $meta['downloads'] as $key => $download ) {

			$has_m = get_post_meta( $download['id'], '_edd_members_length_enabled', true );

			if ( $has_m )
				unset( $new_downloads[ $key ] );
		}

		$meta['downloads'] = $new_downloads;
	}

	if ( isset( $meta['cart_details'] ) && is_array( $meta['cart_details'] ) ) {

		$new_cart_details = $meta['cart_details'];

		foreach ( $meta['cart_details'] as $key => $download ) {

			$has_m = get_post_meta( $download['id'], '_edd_members_length_enabled', true );

			if ( $has_m )
				unset( $new_cart_details[ $key ] );
		}

		$meta['cart_details'] = $new_cart_details;
	}

	return $meta;
}

/*
$payment = edd_get_payment( $args['payment'] );
$download_id = $args['download'];
$downloads = edd_get_payment_meta_downloads( $args['payment'] );

$access = false;

if ( $downloads ) {
	foreach ( $downloads as $dwld ) {

		if ( $download_id == $dwld ) {
			$access = true;
			break;
		}
	}
}

var_dump( $access );

//var_dump( edd_get_payment( $args['payment'] ) );
wp_die( var_dump( '' ) );
*/


function th5_forum_formatting_url() {

	echo esc_url( home_url( 'board/topics/how-to-format-forum-content' ) );
}

/**
 * Wrapper function for checking if a post is sticky.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function extant_is_sticky() {

	if ( is_singular() || is_paged() )
		return false;

	if ( function_exists( 'ccp_is_project_archive' ) && ccp_is_project_archive() && ccp_is_project_sticky() )
		return true;

	else if ( is_home() && is_sticky() )
		return true;

	return false;
}

/**
 * Outputs the featured image.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function extant_featured_image( $args = array() ) {

	echo extant_get_featured_image( $args );
}

/**
 * Returns the featured image.  This is just a wrapper for the `get_the_image()` function
 * with our custom defaults for this theme setup.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return string
 */
function extant_get_featured_image( $args = array() ) {

	$defaults = array(
		'size'         => extant_get_featured_size(),
		'srcset_sizes' => array( extant_get_featured_size_2x() => '2x' ),
		'order'        => array( 'featured' ),
		'min_width'    => extant_get_featured_min_width(),
		'before'       => '<div class="featured-media">',
		'after'        => '</div>',
		'echo'         => false
	);

	$image = get_the_image( wp_parse_args( $args, $defaults ) );

	return $image ? $image : extant_get_featured_fallback();
}

/**
 * Returns the featured image size to use.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_size() {

	return extant_is_sticky() ? 'extant-sticky' : 'extant-landscape';
}

/**
 * Returns the featured image 2x size to use.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_size_2x() {

	return sprintf( '%s-2x', extant_get_featured_size() );
}

/**
 * Returns the featured image size required min. width.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function extant_get_featured_min_width() {

	return extant_is_sticky() ? 950 : 750;
}

/**
 * Returns the featured image size recommended height.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function extant_get_featured_rec_height() {

	return 422;
}

/**
 * Prints the the post format permalink.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_post_format_permalink() {
	echo extant_get_post_format_permalink();
}

/**
 * Prints the the post comments link.  Wrapper for `comments_popup_link()`.  This function
 * doesn't output anything if there are no comments and comments are closed.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_comments_link( $args = array() ) {

	if ( ! get_comments_number() && ! comments_open() )
		return;

	$defaults = array(
		'zero'      => false,
		'one'       => false,
		'more'      => false,
		'css_class' => 'comments-link',
		'none'      => false,
		'before'    => '',
		'after'     => ''
	);

	$args = wp_parse_args( $args, $defaults );

	echo $args['before'];

	comments_popup_link( $args['zero'], $args['one'], $args['more'], $args['css_class'], $args['none'] );

	echo $args['after'];
}

/**
 * Returns the post permalink (URL) with the post format as the link text.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_post_format_permalink() {

	$format = get_post_format();

	return $format ? sprintf( '<a href="%s" class="post-format-permalink"><span class="screen-reader-text">%s</span></a>', esc_url( get_permalink() ), get_post_format_string( $format ) ) : '';
}

/**
 * Prints the comment parent link.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function extant_comment_parent_link( $args = array() ) {

	echo extant_get_comment_parent_link( $args );
}

/**
 * Returns the comment parent link.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return string
 */
function extant_get_comment_parent_link( $args = array() ) {

	$link = '';

	$defaults = array(
		'text'   => '%s', // Defaults to comment author.
		'depth'  => 2,    // At what level should the link show.
		'before' => '',
		'after'  => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( $args['depth'] <= $GLOBALS['comment_depth'] ) {

		$parent = get_comment()->comment_parent;

		if ( 0 < $parent ) {

			$url  = esc_url( get_comment_link( $parent ) );
			$text = sprintf( $args['text'], get_comment_author( $parent ) );

			$link = sprintf( '%s<a class="comment-parent-link" href="%s">%s</a>%s', $args['before'], $url, $text, $args['after'] );
		}
	}

	return apply_filters( 'extant_comment_parent_link', $link, $args );
}

/**
 * Returns an SVG fallback.  Used when there is no featured image.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_fallback() {

	$style = '';

	if ( 'plugin' === get_post_type() ) {

		$color = get_post_meta( get_the_ID(), 'color', true );

		if ( $color )
			$style = sprintf( ' style="background:#%s;"', esc_attr( trim( $color, '#' ) ) );
	}

	$svg = sprintf(
		'<div class="featured-media"><a href="%s">
			<?xml version="1.0"?>
			<svg class="svg-featured" width="%s" height="%s" viewBox="0 0 950 534"' . $style . '>
				<rect class="svg-shape" x="400" y="192.5" rx="8" ry="8" width="150" height="150" transform="rotate(45 475 267.5)" />
				<text class="svg-icon" x="475" y="267.5" text-anchor="middle" alignment-baseline="central" dominant-baseline="central">%s</text>
			</svg>
		</a></div>',
		esc_url( get_permalink() ),
		esc_attr( extant_get_featured_min_width() ),
		esc_attr( extant_get_featured_rec_height() ),
		extant_get_featured_svg_icon()
	);

	return apply_filters( 'extant_get_featured_fallback', $svg );
}

/**
 * Returns the featured SVG fallback icon.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_svg_icon() {

	$options   = extant_map_featured_icons();
	$icon      = $options['standard'];
	$type      = get_post_type();

	$icon_keys = array( $type );

	if ( 'plugin' === $type )
		return extant_get_font_icon_text( th5_get_plugin_icon() );

	if ( post_type_supports( $type, 'post-formats' ) ) {

		$format = get_post_format() ? : 'standard';

		$icon_keys[] = "{$type}-{$format}";
		$icon_keys[] = $format;
	}

	foreach ( $icon_keys as $i ) {

		if ( isset( $options[ $i ] ) ) {

			$icon = $options[ $i ];
			break;
		}
	}

	return apply_filters( 'extant_featured_svg_icon', extant_get_font_icon_text( $icon ) );
}

function th5_get_plugin_icon() {

	$icon = get_post_meta( get_the_ID(), 'icon', true );

	return $icon ? "fa-{$icon}" : 'fa-plug';
}

/**
 * Maps post the post format or type to a specific font icon class.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_map_featured_icons() {

	$icons = array(
		// Post type.
		'attachment'        => 'fa-picture-o',
		'download'          => 'fa-download',
		'page'              => 'fa-file-text-o',
		'plugin'            => 'fa-plug',
		'theme'             => 'fa-paint-brush',

		// Post format.
	//	'aside'             => 'fa-paperclip',
	//	'audio'             => 'fa-volume-up',
	//	'chat'              => 'fa-comments',
		'gallery'           => 'fa-picture-o',
	//	'image'             => 'fa-camera-retro',
	//	'link'              => 'fa-link',
	//	'quote'             => 'fa-quote-right',
		'standard'          => 'fa-pencil',
	//	'status'            => 'fa-map-pin',
	//	'video'             => 'fa-play-circle'
	);

	// Developers, array key can be `{$type}-{$format}`, `{$format}`, or `{$type}`.
	return apply_filters( 'extant_map_featured_icons', $icons );
}

/**
 * Returns the header icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_header_i() {

	return extant_get_font_icon_html( extant_get_header_icon() );
}

/**
 * Returns the primary menu icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_primary_i() {

	return extant_get_font_icon_html( extant_get_menu_primary_icon() );
}

/**
 * Returns the secondary menu icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_secondary_i() {

	return extant_get_font_icon_html( extant_get_menu_secondary_icon() );
}

/**
 * Returns the search menu icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_search_i() {

	return extant_get_font_icon_html( extant_get_menu_search_icon() );
}

/**
 * Returns an array of the available layout types.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_layout_types() {

	return array(
		'full'  => esc_html__( 'Full Width', 'extant' ),
		'boxed' => esc_html__( 'Boxed',      'extant' )
	);
}

/**
 * Whitelist validation function to check whether a layout type is valid.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_validate_layout_type( $type ) {

	$types = extant_get_layout_types();

	return isset( $types[ $type ] ) ? $type : 'full';
}

function th5_get_buynow_details() {

	$download_id = absint( get_post_meta( get_the_ID(), 'edd_download_id', true ) );

	if ( $download_id ) {

		if ( is_user_logged_in() && ( current_user_can( 'download_club_content' ) || edd_has_user_purchased( get_current_user_id(), $download_id ) ) ) {

			return array( 'url' => home_url( 'account' ), 'text' => 'Download' );

		} else if ( edd_item_in_cart( $download_id ) ) {

			return array( 'url' => edd_get_checkout_uri(), 'text' => 'Checkout' );
		} else {

			return array( 'url' => th5_get_download_checkout_url( $download_id ), 'text' => sprintf( 'Buy Now - $%s', edd_get_download_price( $download_id ) ) );
		}
	}

	return false;
}



function th5_get_maybe_download_plugin_details() {

	$download_id = absint( get_post_meta( get_the_ID(), 'edd_download_id', true ) );

	if ( $download_id ) {

		if ( is_user_logged_in() && edd_has_user_purchased( get_current_user_id(), $download_id ) ) {
			$text = 'Download';
			$url = th5_get_download_history_url();
		} else if ( edd_item_in_cart( $download_id ) ) {
			$text = 'Checkout';
			$url  = edd_get_checkout_uri();
		} else {
			$text = 'Purchase - $' . edd_get_download_price( $download_id );
			$url  = th5_get_download_checkout_url( $download_id );
		}
	} else {
		$text = 'Download';
		$url  = th5_get_plugin_download_url();
	}

	return array( 'text' => $text, 'url' => $url );
}

function th5_get_download_checkout_url( $download_id ) {
	return add_query_arg( array( 'edd_action' => 'add_to_cart', 'download_id' => $download_id ), home_url( 'checkout' ) );
}

function th5_get_download_history_url() {
	return home_url( 'checkout/download-history' );
}

function th5_get_membership_download_id() {

	return 2329; // localhost
	return 6769; // themehybrid
}

function th5_get_club_signup_name( $price_id ) {

	return edd_get_price_option_name( th5_get_membership_download_id(), $price_id );
}

function th5_get_club_signup_price( $price_id ) {

	return edd_get_price_option_amount( th5_get_membership_download_id(), $price_id );
}

function th5_get_club_signup_url( $price_id ) {

	return add_query_arg(
		array(
			'edd_action'            => 'add_to_cart',
			'download_id'           => th5_get_membership_download_id(),
			'edd_options[price_id]' => $price_id
		),
		home_url( 'checkout' )
	);
}

function th5_get_club_signup_link( $price_id ) {

	$url  = th5_get_club_signup_url( $price_id );
	$name = th5_get_club_signup_name( $price_id );

	return sprintf( '<a class="membership-option" href="%s">%s</a>', $url, $name );
}

function th5_get_club_signup_button( $price_id ) {

	$url   = th5_get_club_signup_url( $price_id );
	$price = th5_get_club_signup_price( $price_id );

	return sprintf( '<a class="membership-option-button" href="%s">Join Now For $%s</a>', $url, $price );
}

function th5_pagination( $args = array() ) {
	echo th5_get_pagination( $args );
}

function th5_get_pagination( $args = array() ) {
	$navigation = '';

	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {

		$args = wp_parse_args( $args, array(
			'mid_size'           => 1,
			'prev_text'          => _x( 'Previous', 'previous set of posts' ),
			'next_text'          => _x( 'Next', 'next set of posts' ),
			'screen_reader_text' => __( 'Posts navigation' ),
		) );

		$args['type'] = 'array';

		// Set up paginated links.
		$_links = paginate_links( $args );

		$links = '<ul class="pagination__items">';

		foreach ( $_links as $page_link ) {

			$classes  = array( 'pagination__item' );
			$_classes = array();

			preg_match( "/<(?:a|span)(.+?)>(.+?)<\/(?:a|span)>/i", $page_link, $matches );

			if ( ! empty( $matches ) && isset( $matches[1] ) && isset( $matches[2] ) ) {

				$attr = wp_kses_hair( trim( $matches[1] ), array( 'http', 'https' ) );

				if ( ! empty( $attr['class'] ) ) {

					$_classes = explode( ' ', $attr['class']['value'] );

					if ( in_array( 'prev', $_classes ) )
						$classes[] = 'pagination__item--prev';

					elseif ( in_array( 'next', $_classes ) )
						$classes[] = 'pagination__item--next';

					elseif ( in_array( 'current', $_classes ) )
						$classes[] = 'pagination__item--current';
				}

				$item = '';

				if ( ! empty( $attr['href'] ) ) {
					$item = sprintf( '<a href="%s" class="pagination__anchor pagination__anchor--link">%s</a>', esc_url( $attr['href']['value'] ), esc_html( $matches[2] ) );

				} else {
					$item = sprintf(
						'<span class="pagination__anchor pagination__anchor--%s">%s</span>',
						in_array( 'pagination__item--current', $classes ) ? 'current' : 'dots',
						esc_html( $matches[2] )
					);
				}

				$links .= sprintf( '<li class="%s">%s</li>', esc_attr( join( ' ', $classes ) ), $item );
			}
		}

		$links .= '</ul>';

		if ( $links ) {
			$navigation = _navigation_markup( $links, 'pagination', $args['screen_reader_text'] );
		}
	}

	return $navigation;
}


function th5_link_pages( $args = array() ) {
	global $page, $numpages, $multipage, $more;

	$defaults = array(
		'container'       => 'div',
		'container_class' => 'pagination',
		'list_tag'        => 'ul',
		'list_class'      => 'pagination__items',
		'item_tag'        => 'li',
		'item_class'      => 'pagination__item',
		'link_class'      => 'pagination__anchor',
		'title_tag'       => 'h2',
		'title_class'     => 'pagination__title',
		'link_text'       => '%s',
		'title_text'      => __( 'Pages:' )
	);

	$args = wp_parse_args( $args, $defaults );

	$out   = '';
	$title = '';

	if ( $multipage ) {

		for ( $i = 1; $i <= $numpages; $i++ ) {

			if ( $i != $page || ! $more && 1 == $page ) {
				$link = str_replace( '>', 'class="%1$s %1$s--link">', _wp_link_page( $i ) ) . '%2$s</a>';
			} else {
				$link = '<span class="%1$s %1$s--current">%2$s</a>';
			}

			$link = sprintf( $link, esc_attr( $args['link_class'] ), esc_html( sprintf( $args['link_text'], $i ) ) );

			$out .= sprintf(
				'<%1$s class="%2$s">%3$s</%1$s>',
				tag_escape( $args['item_tag'] ),
				esc_attr( $args['item_class'] ),
				$link
			);
		}

		if ( $args['title_text'] )
			$title = sprintf( '<%1$s class="%2$s">%3$s</%1$s>', tag_escape( $args['title_tag'] ), esc_attr( $args['title_class'] ), esc_html( $args['title_text'] ) );

		$out = sprintf(
			'<%1$s class="%2$s">%3$s<%4$s class="%5$s">%6$s</%4$s></%1$s>',
			tag_escape( $args['container'] ),
			esc_attr( $args['container_class'] ),
			$title,
			tag_escape( $args['list_tag'] ),
			esc_attr( $args['list_class'] ),
			$out
		);
	}

	echo $out;
}

