<?php
/**
 * codeGreen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package codeGreen
 */
 
if ( ! function_exists( 'codegreen_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function codegreen_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on codeGreen, use a find and replace
		 * to change 'codegreen' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'codegreen', get_template_directory() . '/languages' );

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
		//add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'codegreen' ),
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
		//add_theme_support( 'custom-background', apply_filters( 'codegreen_custom_background_args', array(
		//	'default-color' => 'ffffff',
		//	'default-image' => '',
		//) ) );

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
add_action( 'after_setup_theme', 'codegreen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function codegreen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'codegreen_content_width', 640 );
}
add_action( 'after_setup_theme', 'codegreen_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function codegreen_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'codegreen' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'codegreen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2><div class="widget-content">',
	) );
}
add_action( 'widgets_init', 'codegreen_widgets_init' );

/**
 * Fix empty widget titles
 */
function codegreen_fix_widget_title($title) {
    if (empty($title)) {
        $title = ' '; //Set title to a single space to force rendering all widget elements
    }
    
    return $title;
}
add_filter('widget_title', 'codegreen_fix_widget_title');

/**
 * Enqueue scripts and styles.
 */
function codegreen_scripts() {
    wp_enqueue_style( 'nimbus-mono-font', get_template_directory_uri() . '/fonts/nimbus-mono/nimbus-mono.css', array(), null );
    wp_enqueue_style( 'source-code-pro-font', get_template_directory_uri() . '/fonts/source-code-pro/source-code-pro.css', array(), null );
    wp_enqueue_style( 'codegreen-bootstrap', get_template_directory_uri() . '/lib/bootstrap/css/bootstrap.min.css', array(), null );
	wp_enqueue_style( 'codegreen-style', get_stylesheet_uri(), array('codegreen-bootstrap', 'nimbus-mono-font', 'source-code-pro-font'), null );
    wp_enqueue_script( 'codegreen-jquery', get_template_directory_uri() . '/lib/jquery/jquery.min.js', array(), null );
    wp_enqueue_script( 'codegreen-load-bootstrap', get_template_directory_uri() . '/js/load-bootstrap.js', array('codegreen-jquery'), null);
    wp_enqueue_script( 'codegreen-menu-search-form', get_template_directory_uri() . '/js/menu-search-form.js', array('codegreen-jquery'), null);
    wp_enqueue_script( 'codegreen-resize-header', get_template_directory_uri() . '/js/resize-header.js', array('codegreen-jquery'), null);
}
add_action( 'wp_enqueue_scripts', 'codegreen_scripts' );

/**
 * Scss compiler configuration callback
 */
function codegreen_configure_scss_compiler($scss) {
    $scss->setFormatter('Leafo\ScssPhp\Formatter\Expanded');
}

/**
 * Compile SCSS files
 */
function codegreen_compile_styles_scss() {
    ScssCompiler::compileFile( get_stylesheet_directory() . '/style.scss', get_stylesheet_directory() . '/style.css', 'codegreen_configure_scss_compiler' );
}
//add_action( 'init', 'codegreen_compile_styles_scss' ); //Compile styles on every page load

/**
 * Register search page url.
 */
function codegreen_register_search_page_url() {
    add_rewrite_rule('search-page$', 'index.php?search-page=', 'top');
    add_rewrite_tag('%search-page%', '[^&]+');
}
add_action( 'init', 'codegreen_register_search_page_url' );

/**
 * Check if search-page was requested and load custom search page template if needed.
 */
function codegreen_load_search_page_template( $template ) {
    if ( get_query_var( 'search-page', null ) !== null ) {
        return get_template_directory() . '/search-page.php';
    } else {
        return $template;
    }
}
add_filter( 'template_include', 'codegreen_load_search_page_template' );

/**
 * Replace excerp more
 */
function codegreen_replace_excerp_more() {
    return ' [&hellip;]<p><a class="more-link" href="' . get_permalink() . '">' . codegreen_read_more( get_the_title() ) . '</a></p>';
}
add_filter ( 'excerpt_more', 'codegreen_replace_excerp_more' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
 * Scss compiler wrapper.
 */
require get_template_directory() . '/inc/scss-compiler.php';

/**
 * Scss options menu.
 */
 require get_template_directory() . '/inc/scss-settings.php';