<?php
/**
 * Cornerstone Main functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cornerstone_Main
 */

// ACF PRO SETUP

// include_once('advanced-custom-fields/acf.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path( $path ) {
     // update path
    $path = get_stylesheet_directory() . '/acfp/';
    // return
    return $path;
}
 
// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {
    // update path
    $dir = get_stylesheet_directory_uri() . '/acfp/';
    // return
    return $dir;
}

// 3. Hide ACF field group menu item
// add_filter('acf/settings/show_admin', '__return_false');

// 4. Include ACF
include_once( get_stylesheet_directory() . '/acfp/acfp.php' );

// Google Maps API key
function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyBPL_70m6Amg9Tej-BHQVE0fZons4Jl1PY');
}

add_action('acf/init', 'my_acf_init');

// END ACF SETUP

if ( ! function_exists( 'cornerstone_main_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cornerstone_main_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Cornerstone Main, use a find and replace
		 * to change 'cornerstone-main' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cornerstone-main', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'cornerstone-main' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'cornerstone_main_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'cornerstone_main_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cornerstone_main_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cornerstone_main_content_width', 640 );
}
add_action( 'after_setup_theme', 'cornerstone_main_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cornerstone_main_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'cornerstone-main' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cornerstone-main' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'cornerstone_main_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cornerstone_main_scripts() {

	// *** CSS ***

	wp_enqueue_style( 'cornerstone-main-style', get_stylesheet_uri() );

	wp_enqueue_script( 'cornerstone-main-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	// Fontawesome
	wp_enqueue_style( 'fontawesome', get_template_directory_uri().'/dist/css/fa/css/font-awesome.min.css' );

	// Google Fonts
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Open+Sans:300,300i,400,400i,700,800' );

	// Foundation Grid
	wp_enqueue_style( 'foundation', get_template_directory_uri().'/dist/css/foundation.css' );

	// Main and Front Page CSS
	wp_enqueue_style( 'main', get_template_directory_uri().'/dist/css/main.css' );
	if (is_front_page()) wp_enqueue_style( 'front', get_template_directory_uri().'/dist/css/front.css' );


	// *** JS ***

	wp_enqueue_script( 'cornerstone-main-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// JQuery (FOOTER)
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_enqueue_script( 'jquery' );

    // GSAP
	wp_enqueue_script( 'GSAP', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js', false, false, true);

	// ScrollMagic
	wp_enqueue_script( 'scrollmagic-main', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', false, false, true);
	wp_enqueue_script( 'scrollmagic-gsap', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js', false, false, true);
	wp_enqueue_script( 'scrollmagic-indicators', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', false, false, true);

	// Slick Slider
	wp_enqueue_script( 'slick', get_template_directory_uri().'/dist/js/slick.min.js', false, false, true );

	// ImagesLoaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri().'/dist/js/imagesloaded.pkgd.min.js', false, false, true );

	// Main and Front JS
	wp_enqueue_script( 'main-js', get_template_directory_uri().'/dist/js/main.js', false, false, true );
	if (is_front_page()) wp_enqueue_script( 'front-js', get_template_directory_uri().'/dist/js/front.js', false, false, true );
}
add_action( 'wp_enqueue_scripts', 'cornerstone_main_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
