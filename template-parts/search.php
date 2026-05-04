<?php if ( !defined( 'ABSPATH' ) ) { exit; } ?>

<main id="content" class="site-main">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
			wp_link_pages();
			comments_template();
		}
	} ?>
</main>
