<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content" class="site-content wrap">
 *
 * @package Kaingang
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="wrap">
			<div class="site-branding">
				<?php
				// Check if there's a custom logo
                $logo = get_theme_mod( 'kaingang_logo' );
                if ( isset( $logo ) && ! empty( $logo ) ) : ?>
	                <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
	                    <img class="site-logo" src="<?php echo $logo; ?>" alt="Logo <?php bloginfo ( 'name' ); ?>" />
	                </a>
            	<?php endif; ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h1 class="menu-toggle"><?php _e( 'Menu', 'kaingang' ); ?></h1>
				<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'kaingang' ); ?></a>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .main-navigation -->
		</div><!-- .wrap -->
	</header><!-- .site-header -->

	<div id="content" class="site-content wrap">
