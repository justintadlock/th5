<?php
/**
 * Helper functions and filters for scripts, styles, and fonts.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Load scripts, styles, and fonts.
add_action( 'wp_enqueue_scripts', 'th5_enqueue', 5 );

add_action( 'wp_head', 'th5_main_bg', 26 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

add_filter( 'edd_is_ajax_disabled', 'th5_edd_is_ajax_disabled' );

function th5_edd_is_ajax_disabled( $is_disabled ) {

	return th5_is_edd_page() ? $is_disabled : true;
}

function th5_main_bg() {

	if ( ! ( is_front_page() && ! is_home() ) && ! is_page( 'th' ) )
		return; ?>

	<style type="text/css">.site__overlay {
		position:              absolute;
		width:                 100%;
		height:                600px;
		background:            url(<?php echo get_template_directory_uri(); ?>/assets/dist/img/front-page-009.jpg) no-repeat 0 0;
		background-attachment: fixed;
	}</style>

<?php }

/**
 * Returns an array of the font families to load from Google Fonts.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function th5_get_font_families() {

	return array(
	//	'source-code-pro'  => 'Source+Code+Pro',
		'josefin-sans'     => 'Josefin+Sans:400,700',
		'playfair-display' => 'Playfair+Display:400,400i'
	);
}

/**
 * Returns an array of the font subsets to include.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function th5_get_font_subsets() {

	return array( 'latin' );
}

/**
 * Loads scripts, styles, and fonts on the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function th5_enqueue() {
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	$version = hybrid_is_script_debug() ? time() : wp_get_theme()->get( 'Version' );


	if ( is_singular( array( 'theme', 'plugin' ) ) ) {

		wp_enqueue_script( 'lightgallery', get_template_directory_uri() . '/assets/dist/lightgallery/js/lightgallery.min.js', null, '1.0.1', true );
		wp_enqueue_style(  'lightgallery', get_template_directory_uri() . '/assets/dist/lightgallery/css/lightgallery.min.css', null, '1.0.1' );
	}

	// Load scripts.
	wp_enqueue_script( 'th5', get_template_directory_uri() . '/assets/dist/js/theme.min.js', null, $version, true );

	// Load fonts.
	hybrid_enqueue_font( 'th5' );

	// Load styles.
	wp_enqueue_style( 'th5', get_template_directory_uri() . '/style.min.css', null, $version );

	// Disables the Jetpack Grunion contact form stylesheet.
	wp_deregister_style( 'grunion.css' );
	wp_deregister_style( 'grid-columns' );
}

/**
 * Returns a stylesheet file.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the stylesheet file (without the extension).
 * @param  string  $path   The folder to look for the stylesheet in.
 * @param  string  $where  template|stylesheet
 * @return string
 */
function extant_get_style_uri( $name, $path = 'css', $where = 'template' ) {

	$suffix = hybrid_get_min_suffix();
	$path   = 'stylesheet' === $where ? '%2$s/' . $path : '%1$s/' . $path;

	$dir = trailingslashit( hybrid_sprintf_theme_dir( $path ) );
	$uri = trailingslashit( hybrid_sprintf_theme_uri( $path ) );

	return $suffix && file_exists( "{$dir}{$name}{$suffix}.css" ) ? "{$uri}{$name}{$suffix}.css" : "{$uri}{$name}.css";
}

/**
 * Returns a stylesheet file from the child theme.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the stylesheet file (without the extension).
 * @param  string  $path   The folder to look for the stylesheet in.
 * @return string
 */
function extant_get_child_style_uri( $name, $path = 'css' ) {

	return extant_get_style_uri( $name, $path, 'stylesheet' );
}

/**
 * Returns a script file.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the script file (without the extension).
 * @param  string  $path   The folder to look for the script in.
 * @param  string  $where  template|stylesheet
 * @return string
 */
function extant_get_script_uri( $name, $path = 'js', $where = 'template' ) {

	$suffix = hybrid_get_min_suffix();
	$path   = 'stylesheet' === $where ? '%2$s/' . $path : '%1$s/' . $path;

	$dir = trailingslashit( hybrid_sprintf_theme_dir( $path ) );
	$uri = trailingslashit( hybrid_sprintf_theme_uri( $path ) );

	return $suffix && file_exists( "{$dir}{$name}{$suffix}.js" ) ? "{$uri}{$name}{$suffix}.js" : "{$uri}{$name}.js";
}

/**
 * Returns a script file from the child theme.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the script file (without the extension).
 * @param  string  $path   The folder to look for the script in.
 * @return string
 */
function extant_get_child_script_uri( $name, $path = 'js' ) {

	return extant_get_script_uri( $name, $path, 'stylesheet' );
}
