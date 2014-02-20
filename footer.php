<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Kaingang
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrap">
			<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
			<div id="tertiary" class="widget-area widget-area--footer clear" role="complementary">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div><!-- .widget-area -->
			<?php endif; ?>

			<div class="site-info">
				<?php do_action( 'kaingang_credits' ); ?>
				<div class="site-text">
					<?php 
					if ( $footer_text = get_theme_mod( 'kaingang_footer_text' ) ) {
						echo get_theme_mod( 'kaingang_footer_text' );
					}
					?>
				</div>
				<div class="site-credits">
					<a href="http://wordpress.org/" rel="generator"><?php printf( __( 'Proudly powered by %s', 'kaingang' ), 'WordPress' ); ?></a>
				</div><!-- .site-credits -->
			</div><!-- .site-info -->
		</div><!-- .wrap -->
	</footer><!-- .site-footer -->
</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>