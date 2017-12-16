<?php
/**
 * "No power in the 'verse can stop me." - River Tam (Firefly)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for launching the theme and setup configuration.
 *
 * @since  1.0.0
 * @access public
 */
final class Extant_Theme {

	/**
	 * Directory path to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';

	/**
	 * Directory URI to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Initial theme setup.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir_path = trailingslashit( get_template_directory()     );
		$this->dir_uri  = trailingslashit( get_template_directory_uri() );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Load the Hybrid Core framework and theme files.
		require_once( $this->dir_path . 'lib/hybrid.php' );

		// Load theme includes.
		require_once( $this->dir_path . 'inc/functions-filters.php'   );
		require_once( $this->dir_path . 'inc/functions-icons.php'     );
		require_once( $this->dir_path . 'inc/functions-options.php'   );
		require_once( $this->dir_path . 'inc/functions-scripts.php'   );
		require_once( $this->dir_path . 'inc/functions-template.php'  );

		// Load Easy Digital Downloads files if plugin is active.
		if ( class_exists( 'Easy_Digital_Downloads' ) )
			require_once( $this->dir_path . 'inc/functions-edd.php' );
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Theme setup.
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ),  5 );

		// Register menus.
		add_action( 'init', array( $this, 'register_menus' ) );

		// Register image sizes.
		add_action( 'init', array( $this, 'register_image_sizes' ) );

		// Register layouts.
		add_action( 'hybrid_register_layouts', array( $this, 'register_layouts' ) );

		// Register scripts, styles, and fonts.
		add_action( 'wp_enqueue_scripts',    array( $this, 'register_scripts' ), 0 );
		add_action( 'enqueue_embed_scripts', array( $this, 'register_scripts' ), 0 );
	}

	/**
	 * The theme setup function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_setup() {

		// Custom Content Portfolio plugin.
		add_theme_support( 'custom-content-portfolio' );
		add_theme_support( 'message-board' );

		// Theme layouts.
		add_theme_support( 'theme-layouts', array( 'default' => 'grid-landscape', 'post_meta' => true  ) );

		// Breadcrumbs.
		add_theme_support( 'breadcrumb-trail' );

		// Template hierarchy.
		add_theme_support( 'hybrid-core-template-hierarchy' );

		// The best thumbnail/image script ever.
		add_theme_support( 'get-the-image' );

		// Nicer [gallery] shortcode implementation.
		add_theme_support( 'cleaner-gallery' );

		// Automatically add feed links to `<head>`.
		add_theme_support( 'automatic-feed-links' );

		// Post formats.
		add_theme_support(
			'post-formats',
			array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' )
		);

		// Remove admin bar bump styling.
		add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

		// Gutenberg.
		add_theme_support(
			'gutenberg',
			array( 'wide-images' => true )
		);

		// Handle content width for embeds and images.
		hybrid_set_content_width( 950 );
	}

	/**
	 * Registers nav menus.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_menus() {

		register_nav_menu( 'primary', _x( 'Primary', 'nav menu location', 'extant' ) );
		register_nav_menu( 'social',  _x( 'Social',  'nav menu location', 'extant' ) );
	}

	/**
	 * Registers image sizes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_image_sizes() {

		// Landscape sizes.
		set_post_thumbnail_size(                 240, 135, true );
		add_image_size( 'extant-landscape',      750, 422, true );
		add_image_size( 'extant-landscape-2x',  1500, 844,  true );

		// Sizes always used for sticky posts.
		add_image_size( 'extant-sticky',     950,  534, true );
		add_image_size( 'extant-sticky-2x', 1900, 1068, true );
	}

	/**
	 * Registers layouts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_layouts() {

		hybrid_register_layout(
			'grid-landscape',
			array(
				'label'          => esc_html__( 'Grid: Landscape', 'extant' ),
				'is_post_layout' => false,
				'image'          => hybrid_locate_theme_file( 'assets/dist/images/layouts/grid-landscape.png' )
			)
		);

		hybrid_register_layout(
			'1c-wide',
			array(
				'label'          => esc_html__( '1 Column: Wide', 'extant' ),
				'is_post_layout' => true,
				'post_types'     => array( 'page' ),
				'image'          => hybrid_locate_theme_file( 'assets/dist/images/layouts/1c.png' )
			)
		);

		hybrid_register_layout(
			'1c-narrow',
			array(
				'label'          => esc_html__( '1 Column: Narrow', 'extant' ),
				'is_post_layout' => true,
				'post_types'     => array( 'page' ),
				'image'          => hybrid_locate_theme_file( 'assets/dist/images/layouts/1c-narrow.png' )
			)
		);
	}

	/**
	 * Registers scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_scripts() {

		// Register fonts.
		hybrid_register_font( 'th5', array( 'family' => th5_get_font_families(), 'subset' => th5_get_font_subsets() ) );
	}
}

/**
 * Gets the instance of the `Extant_Theme` class.  This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function extant_theme() {
	return Extant_Theme::get_instance();
}

// Let's roll!
extant_theme();
