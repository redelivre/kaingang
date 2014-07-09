<header id="masthead" class="site-header" role="banner" style="background: <?php echo $header_bg_color; echo ($header_bg_image) ? " url('{$header_bg_image}')" : ''; ?> no-repeat;">
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