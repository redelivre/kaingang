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
		<div class="wrap clear">
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
				<h1 class="menu-toggle"><span class="icon-menu"><?php _e( 'Menu', 'kaingang' ); ?></span></h1>
				<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'kaingang' ); ?></a>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .main-navigation -->
		</div><!-- .wrap -->
	</header><!-- .site-header -->

	<?php if ( is_home() ) : ?>
		<div class="feature flexslider js-flexslider">
			<?php
	        $featured_posts = new WP_Query( array( 'posts_per_page' => 4 ) );
	        
	        if ( $featured_posts->have_posts() ) : ?>
		        <div class="flexslider-slides">
			        <?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
			        	<div class="flexslider-slide-wrapper">
			        		<?php if ( has_post_thumbnail() ) : ?>
			        		<?php the_post_thumbnail( 'feature-main', array( 'class' => 'flexslider-image' ) ); ?>
				        	<?php endif; ?>
				        	<div class="wrap">
					        	<article <?php post_class(); ?>>
					        		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					        	</article>
				        	</div>
			        	</div>
			        <?php
			        endwhile;
			        wp_reset_postdata();
			        ?>
			    </div><!-- .flexslider-slides -->
			<?php endif; ?>
		</div><!-- .feature -->
	
		<div class="extra-bar box clear">
			<div class="wrap">
				<?php
				$social = get_option( 'campanha_social_networks' );
				if ( isset( $social ) && ! empty ( $social ) ) : ?>
					<div class="social-networks">
						<h6><?php _e( 'Find us', 'kaingang' ); ?></h6>
						<?php
						foreach ( $social as $key => $value ) :
							if ( ! empty( $value) ) : ?>
								<a class="social-link" href="<?php echo esc_url( $value ); ?>"><span class="icon icon-<?php echo $key; ?>"></span></a>
							<?php
							endif;
						endforeach;
						?>
					</div><!-- .social networks -->
				<?php endif; ?>
				<div class="search-form-wrapper">
					<h6><?php _e( 'Search for:', 'kaingang' ); ?></h6>
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	<?php endif; // is_home() ?>

	<div id="content" class="site-content wrap">
