<footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <nav class="footer-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'container'      => false,
                    'depth'          => 1,
                ));
                ?>
            </nav>

            <div class="site-info">
                <?php
                printf(
                    esc_html__('© %1$s %2$s. All rights reserved.', 'custom-theme'),
                    date('Y'),
                    get_bloginfo('name')
                );
                ?>
                <span class="sep"> | </span>
                <?php
                printf(
                    esc_html__('Powered by %s', 'custom-theme'),
                    '<a href="' . esc_url(__('https://wordpress.org/', 'custom-theme')) . '">WordPress</a>'
                );
                ?>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
