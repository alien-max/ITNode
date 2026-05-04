<?php if ( !defined( 'ABSPATH' ) ) { exit; } ?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
		<div id="skip">
			<a href="courses/html-css/navigation/skip-navigation#content">
				<?php echo esc_html( 'Skip to content' ); ?>
			</a>
		</div>
	<?php
	if ( !function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( 'header' ) ) {
		$site_name = get_bloginfo( 'name' ); ?>
		<header class="site-header">
			<h1><?php echo $site_name; ?></h1>
		</header>
		<?php
	}
