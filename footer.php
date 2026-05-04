<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

if ( !function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( 'footer' ) ) {
    $site_name = get_bloginfo( 'name' ); ?>
    <footer class="site-footer">
        <p><?php echo $site_name; ?></p>
    </footer>
<?php }

wp_footer(); ?>

</body>
</html>