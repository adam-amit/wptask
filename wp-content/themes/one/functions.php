<?php
/**
 * One functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package One
 */

if ( ! function_exists( 'one_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function one_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on One, use a find and replace
		 * to change 'one' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'one', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'one' ),
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
		add_theme_support( 'custom-background', apply_filters( 'one_custom_background_args', array(
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
add_action( 'after_setup_theme', 'one_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function one_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'one_content_width', 640 );
}
add_action( 'after_setup_theme', 'one_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function one_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'one' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'one' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'one_widgets_init' );

define ('VERSION', '1.1');

function version_id() {
  if ( WP_DEBUG )
    return time();
  return VERSION;
}

/**
 * Enqueue scripts and styles.
 */
function one_scripts() {
	wp_enqueue_style( 'one-style', get_stylesheet_uri(), '', version_id() );

	wp_enqueue_script( 'one-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'one-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	/* Assets enqueued here */
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/assets/bootstrap-4.3.1-dist/css/bootstrap.min.css' );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/assets/bootstrap-4.3.1-dist/js/bootstrap.min.js', array('jquery'), '20151215', true );
	
	wp_enqueue_style( 'owl-carousel-style', get_template_directory_uri() . '/assets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css' );
	wp_enqueue_style( 'owl-carousel-default', get_template_directory_uri() . '/assets/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css' );
	wp_enqueue_script( 'owl-carousel-script', get_template_directory_uri() . '/assets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js', array('jquery'), '2.3.4', true);

	wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.00', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'one_scripts' );

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

/** Custom post type here **/
add_action( 'init', 'custom_post_type' );

function custom_post_type() {

	/** Service custom post type taxonomy **/
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => 'Technologies',
		'singular_name'		=> 'Technology',
		'menu_name'			=> 'Technologies',
		'add_new'			=> 'Add Technology',
		'add_new_item'		=> 'Add New Technology'
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'public'			=> true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'has_archive' 		=> true,
		'query_var'         => true,
		'rewrite' 			=> array('slug' => 'service/technology')
	);

	register_taxonomy( 'technology', 'service', $args );

	/** Services custom post type **/
	register_post_type( 'service', array(
		'labels'			 => generate_labels('Service'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'service' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-desktop',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	) );
	
	/** Testimonial custom post type **/
	register_post_type( 'testimonial', array(
		'labels'			 =>	generate_labels('Testimonial'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-testimonial',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	) );

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => 'Platform',
		'singular_name'		=> 'Platform',
		'menu_name'			=> 'Platforms',
		'add_new'			=> 'Add Platform',
		'add_new_item'		=> 'Add New Platform'
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'public'			=> true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'has_archive' 		=> true,
		'query_var'         => true,
		'rewrite' 			=> array('slug' => 'tesimonial/platform')
	);

	register_taxonomy( 'platform', 'testimonial', $args );

}

function generate_labels( $post_type ) {

	$labels = array(
		'name'              => $post_type . 's',
		'singular_name'		=> $post_type,
		'menu_name'			=> $post_type . 's',
		'add_new'			=> 'Add ' . $post_type,
		'add_new_item'		=> 'Add New ' . $post_type
	);
	
	return $labels;

}

/** Footer Options page **/
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

// For custom taxonomy permalink
// function wpa_course_post_link( $post_link, $id = 0 ){
//     $post = get_post($id);  
//     if ( is_object( $post ) ){
//         $terms = wp_get_object_terms( $post->ID, 'course' );
//         if( $terms ){
//             return str_replace( '%course%' , $terms[0]->slug , $post_link );
//         }
//     }
//     return $post_link;  
// }
// add_filter( 'post_type_link', 'wpa_course_post_link', 1, 3 );