	<header id="masthead" class="site-header" role="banner" style="background: <?php echo get_theme_mod('kaingang_header_bgcolor'); ?>">
		<div class="wrap clear">
			<div class="site-branding">
				<a href="<?php echo home_url(); ?>">
					<img src="<?php echo get_theme_mod('kaingang_header_image'); ?>" alt="" />
				</a>
			</div>

			
		</div><!-- .wrap -->
		
		<div class="wrap clear">
			<nav id="site-navigation-header-2" class="main-navigation header-2" role="navigation">
				<h1 class="menu-toggle"><span class="icon-menu"><?php _e( 'Menu', 'kaingang' ); ?></span></h1>
				<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'kaingang' ); ?></a>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .main-navigation -->
		</div>
	</header><!-- .site-header -->