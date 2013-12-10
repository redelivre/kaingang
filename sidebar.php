<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Kaingang
 */
?>
	<div id="secondary" class="widget-area widget-area--sidebar" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>

		<?php 
		$sidebar = ( is_home() ) ? 'sidebar-main' : 'sidebar-internal'; ?>
		<?php if ( ! dynamic_sidebar( $sidebar ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h3 class="widget-title"><?php _e( 'Archives', 'kaingang' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h3 class="widget-title"><?php _e( 'Meta', 'kaingang' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
