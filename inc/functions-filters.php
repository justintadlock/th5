<?php
/**
 * Filters the theme adds.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Handle the header icon.
add_filter( 'hybrid_site_title', 'extant_site_title' );

# Custom body and post classes.
add_filter( 'body_class', 'extant_body_class' );
add_filter( 'post_class', 'extant_post_class' );
add_filter( 'comment_class', 'extant_comment_class' );

# Overwrite default image size for galleries.
add_filter( 'cleaner_gallery_defaults', 'extant_gallery_defaults', 5 );

# Filter the image sizes to choose from.
add_filter( 'image_size_names_choose', 'extant_image_size_names_choose', 5 );

# Removes core's embed meta. We're rolling our own.
remove_action( 'embed_content_meta', 'print_embed_comments_button' );
remove_action( 'embed_content_meta', 'print_embed_sharing_button'  );

# Embed wrap.
add_filter( 'embed_oembed_html', 'extant_maybe_wrap_embed', 10, 2 );

# Prev/Next comments link attributes.
add_filter( 'previous_comments_link_attributes', 'extant_prev_comments_link_attr' );
add_filter( 'next_comments_link_attributes',     'extant_next_comments_link_attr' );

add_filter( 'hybrid_get_theme_layout', 'th5_get_theme_layout' );

add_filter( 'breadcrumb_trail_items', 'th5_trail_items' );

add_filter( 'jetpack_implode_frontend_css', '__return_false' );
add_filter( 'jetpack_markdown_preserve_shortcodes', '__return_false' );

add_filter( 'nav_menu_link_attributes', 'extant_nav_menu_link_attr', 5 );
add_filter( 'nav_menu_css_class', 'extant_nav_menu_css_class', 5 );
add_filter( 'nav_menu_item_id', '__return_false', 5 );

remove_action( 'wp_head', 'edd_version_in_header' );

add_filter( 'hybrid_meta_generator', '__return_false' );
add_filter( 'the_generator', '__return_empty_string' );
remove_action( 'wp_head', 'wp_admin_bar_header' );

add_filter( 'navigation_markup_template', 'th5_navigation_markup_template', 5 );

function th5_navigation_markup_template( $template ) {

	return '<nav class="%1$s" role="navigation">
			<h2 class="%1$s__title screen-reader-text">%2$s</h2>
			%3$s
		</nav>';
}

function extant_nav_menu_css_class( $classes ) {

	$_classes[] = 'menu__item';

	$replacements = array(
		'current-menu-item',
		'current-menu-parent',
		'current-menu-ancestor',
	//	'current_page_item',
	//	'current_page_parent',
	//	'current_page_ancestor',
	);

	if ( array_intersect( $replacements, $classes ) )
		$_classes[] = 'menu__item--active';

	return $_classes;
}

function extant_nav_menu_link_attr( $attr ) {

	$attr['class'] = 'menu__anchor';

	return $attr;
}

function th5_get_theme_layout( $layout ) {

	if ( function_exists( 'mb_is_message_board' ) && mb_is_message_board() )
		return '1c-narrow';

	if ( is_front_page() || is_page( array( 'hybrid-core', 'club' ) ) || is_singular( array( 'theme', 'plugin' ) ) )
		return '1c-wide';

	if ( is_page() || is_singular( 'doc' ) )
		return '1c-narrow';

	return is_singular( 'post' ) ? '1c-narrow' : $layout;
}


add_filter( 'toot_testimonial_shortcode', 'th5_testimonial_shortcode', 10, 2 );

function th5_testimonial_shortcode( $html, $attr = array() ) {

	$defaults = array(
		'order'          => 'DESC',
		'orderby'        => 'date',
		'category'       => '',
		'class'          => 'testimonial'
	);

	$attr = shortcode_atts( $defaults, $attr );

	$query_args = array(
			'post_type'      => toot_get_testimonial_post_type(),
			'posts_per_page' => 1,
			'order'          => $attr['order'],
			'orderby'        => $attr['orderby'],
		);

	if ( $attr['category'] ) {

		$query_args['tax_query'] = array(
			array(
				'taxonomy' => toot_get_category_taxonomy(),
				'field'    => 'slug',
				'terms'    => array( $attr['category'] )
			)
		);
	}

	$loop = new WP_Query( $query_args );

	$html = '';

	while ( $loop->have_posts() ) :

		$loop->the_post();

		$html .= sprintf(
			'<blockquote class="%s">%s <footer class="testimonial-footer">%s%s</footer></blockquote>',
			esc_attr( $attr['class'] ),
			toot_get_testimonial_content(),
			toot_get_testimonial_image(),
			str_replace( '<a ', '<a target="_blank" ', toot_get_testimonial_cite() )
		);
	endwhile;

	wp_reset_postdata();

	return $html;
}

function th5_get_forum_archive_item() {

	$object = get_post_type_object( mb_get_forum_post_type() );

	return sprintf( '<a href="%s">%s</a>', esc_url( get_post_type_archive_link( $object->name ) ), mb_get_forum_label( 'archive_title' ) );
}

function th5_get_forum_user_archive_item() {

	return sprintf( '<a href="%s">%s</a>', mb_get_user_archive_url(), mb_get_user_archive_title() );
}

function th5_get_forum_role_archive_item() {

	return sprintf( '<a href="%s">%s</a>', mb_get_role_archive_url(), mb_get_role_archive_title() );
}

function th5_trail_items( $items ) {

	if ( mb_is_role_archive() ) {
		$items[] = th5_get_forum_archive_item();
		$items[] = th5_get_forum_user_archive_item();

		if ( is_paged() )
			$items[] = sprintf( '<a href="%s">%s</a>', mb_get_role_archive_url(), mb_get_role_archive_title() );

		else
			$items[] = mb_get_role_archive_title();
	}

	elseif ( mb_is_single_role() ) {
		$items[] = th5_get_forum_archive_item();
		$items[] = th5_get_forum_user_archive_item();
		$items[] = th5_get_forum_role_archive_item();

		if ( is_paged() )
			$items[] = sprintf( '<a href="%s">%s</a>', mb_get_role_url(), mb_get_single_role_title() );

		else
			$items[] = mb_get_single_role_title();
	}

	elseif ( mb_is_user_archive() ) {
		$items[] = th5_get_forum_archive_item();

		if ( is_paged() )
			$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_archive_url(), mb_get_user_archive_title() );

		else
			$items[] = mb_get_user_archive_title();
	}

	elseif ( mb_is_single_user() ) {
		$items[] = th5_get_forum_archive_item();
		$items[] = th5_get_forum_user_archive_item();

		if ( mb_is_user_page() ) {
			$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_url(), get_the_author_meta( 'display_name', mb_get_user_id() ) );

			if ( is_paged() ) {

				if ( mb_is_user_forums() )
					$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_forums_url(), mb_get_user_forums_title() );

				elseif ( mb_is_user_topics() )
					$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_topics_url(), mb_get_user_topics_title() );

				elseif ( mb_is_user_replies() )
					$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_replies_url(), mb_get_user_replies_title() );

				elseif ( mb_is_user_bookmarks() )
					$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_bookmarks_url(), mb_get_user_bookmarks_title() );

				elseif ( mb_is_user_forum_subscriptions() )
					$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_forum_subscriptions_url(), mb_get_user_forum_subscriptions_title() );

				elseif ( mb_is_user_topic_subscriptions() )
					$items[] = sprintf( '<a href="%s">%s</a>', mb_get_user_topic_subscriptions_url(), mb_get_user_topic_subscriptions_title() );

			} else {

				$items[] = mb_get_user_page_title();
			}

		} else {

			$items[] = mb_get_single_user_title();
		}
	} elseif ( mb_is_edit() ) {
		$items[] = th5_get_forum_archive_item();

		$items[] = mb_get_edit_page_title();

	} elseif ( mb_is_forum_login() ) {
		$items[] = th5_get_forum_archive_item();

		$items[] = mb_get_login_page_title();
	}

	return $items;
}

/**
 * Adds a class to the site title to handle the header icon.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_site_title() {

	return sprintf(
		'<h1 %s><a href="%s" rel="home"><span class="name">%s</span></a></h1>',
		hybrid_get_attr( 'site-title' ),
		esc_url( home_url() ),
		get_bloginfo( 'name' )
	);
}

/**
 * Adds custom body classes.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $classes
 * @return array
 */
function extant_body_class( $classes ) {

	return $classes;
}

function extant_post_alt_class( $classes ) {

		static $extant_post_alt;
		++$extant_post_alt;

		$classes[] = ( $extant_post_alt % 2 ) ? 'entry--odd' : 'entry--even';

		if ( extant_is_portrait() ) {

			$remainder = $extant_post_alt % 3;

			if ( 1 === $remainder )
				$classes[] = 'entry--one';

			if ( 2 === $remainder )
				$classes[] = 'entry--two';

			else if ( ! $remainder )
				$classes[] = 'entry--three';
		}

	return $classes;
}

/**
 * Adds custom post classes.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $classes
 * @return array
 */
function extant_post_class( $classes ) {

	//return $classes;

	$post = get_post();

	if ( $post ) {
		$_classes = array();

		$_classes[] = 'entry';

		$_classes[] = 'entry--type-' . get_post_type();

		if ( extant_is_sticky() )
			$_classes[] = 'entry--sticky';

		if ( ! is_singular() ) {
			if ( ! extant_is_sticky() ) {
				static $extant_post_alt;
				++$extant_post_alt;

				$_classes[] = ( $extant_post_alt % 2 ) ? 'entry--odd' : 'entry--even';

				if ( extant_is_portrait() || is_post_type_archive( 'plugin' ) ) {

					$remainder = $extant_post_alt % 3;

					if ( 1 === $remainder )
						$_classes[] = 'entry--one';

					if ( 2 === $remainder )
						$_classes[] = 'entry--two';

					else if ( ! $remainder )
						$_classes[] = 'entry--three';
				}

			}
		}

		return array_unique( array_merge( $_classes, $classes ) );
	}

	return $classes;
}

/**
 * Wraps embeds with `.embed-wrap` class.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function extant_wrap_embed_html( $html ) {

	return $html && is_string( $html ) ? sprintf( '<div class="embed-wrap">%s</div>', $html ) : $html;
}

/**
 * Checks embed URL patterns to see if they should be wrapped in some special HTML, particularly
 * for responsive videos.
 *
 * @author     Automattic
 * @link       http://jetpack.me
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @param  string  $url
 * @return string
 */
function extant_maybe_wrap_embed( $html, $url ) {

	if ( ! $html || ! is_string( $html ) || ! $url )
		return $html;

	$do_wrap = false;

	$patterns = array(
		'#http://((m|www)\.)?youtube\.com/watch.*#i',
		'#https://((m|www)\.)?youtube\.com/watch.*#i',
		'#http://((m|www)\.)?youtube\.com/playlist.*#i',
		'#https://((m|www)\.)?youtube\.com/playlist.*#i',
		'#http://youtu\.be/.*#i',
		'#https://youtu\.be/.*#i',
		'#https?://(.+\.)?vimeo\.com/.*#i',
		'#https?://(www\.)?dailymotion\.com/.*#i',
		'#https?://dai.ly/*#i',
		'#https?://(www\.)?hulu\.com/watch/.*#i',
		'#https?://wordpress.tv/.*#i',
		'#https?://(www\.)?funnyordie\.com/videos/.*#i',
		'#https?://vine.co/v/.*#i',
		'#https?://(www\.)?collegehumor\.com/video/.*#i',
		'#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
	);

	$patterns = apply_filters( 'extant_maybe_wrap_embed_patterns', $patterns );

	foreach ( $patterns as $pattern ) {

		$do_wrap = preg_match( $pattern, $url );

		if ( $do_wrap )
			return extant_wrap_embed_html( $html );
	}

	return $html;
}

/**
 * Adds a custom class to the previous comments link.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function extant_prev_comments_link_attr( $attr ) {

	return $attr .= ' class="prev-comments-link"';
}

/**
 * Adds a custom class to the next comments link.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function extant_next_comments_link_attr( $attr ) {

	return $attr .= ' class="next-comments-link"';
}

function extant_comment_class( $classes ) {

	$classes[] = 'thread__item';

	return $classes;
}

/**
 * Changes the default gallery thumbnail size.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $defaults
 * @return array
 */
function extant_gallery_defaults( $defaults ) {

	$defaults['size'] = 'grid-portrait' === hybrid_get_global_layout() ? 'extant-portrait-thumb' : 'post-thumbnail';

	return $defaults;
}

/**
 * Filters the WordPress image selector to add custom image sizes.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $sizes
 * @return array
 */
function extant_image_size_names_choose( $sizes ) {

	$sizes['extant-landscape']      = esc_html__( 'Landscape',           'extant' );
	$sizes['post-thumbnail']        = esc_html__( 'Landscape Thumbnail', 'extant' );
	$sizes['extant-portrait']       = esc_html__( 'Portrait',            'extant' );
	$sizes['extant-portrait-thumb'] = esc_html__( 'Portrait Thumbnail',  'extant' );

	return $sizes;
}


function th4_template_include( $template ) {

	if ( is_singular( array( 'topic', 'doc' ) ) ) {

		if ( ! current_user_can( 'view_club_content' ) )
			$template = locate_template( array( 'templates/club-content-no.php', 'club-content-no.php' ) );
	}

	return $template;
}

add_filter( 'template_include', 'th4_template_include', 95 );

