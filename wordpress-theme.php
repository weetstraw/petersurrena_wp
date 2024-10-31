/*
Theme Name: My Custom Theme
Theme URI: https://example.com/my-custom-theme
Author: Your Name
Author URI: https://example.com
Description: A clean and modern WordPress theme
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: my-custom-theme
*/

// style.css (Main theme stylesheet)
/* Main styles will go here */

// functions.php
<?php
if (!defined('ABSPATH')) exit;

// Theme Setup
function my_custom_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-custom-theme'),
        'footer' => __('Footer Menu', 'my-custom-theme'),
    ));
}
add_action('after_setup_theme', 'my_custom_theme_setup');

// Enqueue scripts and styles
function my_custom_theme_scripts() {
    wp_enqueue_style('my-custom-theme-style', get_stylesheet_uri());
    wp_enqueue_script('my-custom-theme-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');

// header.php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="site-header">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) :
                the_custom_logo();
            else :
            ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
            <?php endif; ?>
        </div>
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id' => 'primary-menu',
            ));
            ?>
        </nav>
    </header>

<?php
// index.php
?>
<?php get_header(); ?>

<main class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                </header>
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>
            <?php
        endwhile;
        
        the_posts_navigation();
    else :
        ?>
        <p><?php esc_html_e('No posts found.', 'my-custom-theme'); ?></p>
        <?php
    endif;
    ?>
</main>

<?php get_footer(); ?>

<?php
// single.php
?>
<?php get_header(); ?>

<main class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                <div class="entry-meta">
                    <?php
                    printf(
                        esc_html__('Posted on %s', 'my-custom-theme'),
                        get_the_date()
                    );
                    ?>
                </div>
            </header>
            <div class="entry-content">
                <?php
                the_content();
                wp_link_pages();
                ?>
            </div>
        </article>
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
    endwhile;
    ?>
</main>

<?php get_footer(); ?>

<?php
// footer.php
?>
    <footer class="site-footer">
        <nav class="footer-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_id' => 'footer-menu',
            ));
            ?>
        </nav>
        <div class="site-info">
            <?php
            printf(
                esc_html__('© %d %s. All rights reserved.', 'my-custom-theme'),
                date('Y'),
                get_bloginfo('name')
            );
            ?>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>

<?php
// sidebar.php
?>
<aside class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>

<?php
// archive.php
?>
<?php get_header(); ?>

<main class="site-main">
    <header class="archive-header">
        <?php
        the_archive_title('<h1 class="archive-title">', '</h1>');
        the_archive_description('<div class="archive-description">', '</div>');
        ?>
    </header>
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;
        
        the_posts_navigation();
    else :
        get_template_part('template-parts/content', 'none');
    endif;
    ?>
</main>

<?php get_footer(); ?>
