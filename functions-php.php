<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Setup
function custom_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Enable support for the following post formats
    add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'custom-theme'),
        'footer'  => esc_html__('Footer Menu', 'custom-theme'),
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Enqueue scripts and styles
function custom_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('custom-theme-style', get_stylesheet_uri(), array(), '1.0.0');

    // Add custom fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap', array(), null);

    // Enqueue main JavaScript file
    wp_enqueue_script('custom-theme-scripts', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);

    // Add comment-reply script if needed
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');

// Register widget area
function custom_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'custom-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets_init');

// Custom excerpt length
function custom_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length');

// Custom excerpt "read more" text
function custom_excerpt_more($more) {
    return '... <a class="read-more" href="' . get_permalink(get_the_ID()) . '">' . 
           esc_html__('Read More', 'custom-theme') . '</a>';
}
add_filter('excerpt_more', 'custom_excerpt_more');

// Add custom image sizes
add_image_size('featured-large', 1200, 600, true);
add_image_size('featured-medium', 800, 400, true);

// Add body classes
function custom_body_classes($classes) {
    // Add page slug
    if (is_single() || is_page() && !is_front_page()) {
        global $post;
        $classes[] = $post->post_name;
    }
    return $classes;
}
add_filter('body_class', 'custom_body_classes');

// Custom login page logo
function custom_login_logo() {
    echo '<style type="text/css">
        #login h1 a {
            background-image: url(' . get_stylesheet_directory_uri() . '/images/logo.png);
            background-size: 300px 100px;
            width: 300px;
            height: 100px;
        }
    </style>';
}
add_action('login_head', 'custom_login_logo');

// Security: Remove WordPress version from head and feeds
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary header information
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Customize archive title
function custom_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    }
    return $title;
}
add_filter('get_the_archive_title', 'custom_archive_title');
