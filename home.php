<?php
/**
 * Home template file.
 *
 * @package Kaingang
 */

get_header(); ?>

	<div class="events box clear">
		<h3 class="page-title">Agenda</h3>
		<div class="events-list">
			
			<?php
			$args = array(
		        'posts_per_page' 	=> 4,
		        'post_type'			=> 'agenda',
		        'orderby' 			=> 'meta_value',
		        'meta_key'			=> '_data_inicial',
		        'order'				=> 'ASC',
		        'meta_query'		=> array(
		            array(
		                'key' => '_data_final',
		                'value' => date('Y-m-d'),
		                'compare' => '>=',
		                'type' => 'DATETIME'
		            )
		        )
		    );
	        
	        $events = new WP_Query( $args );
	        
	        if ( $events->have_posts() ) : while ( $events->have_posts() ) : $events->the_post();
	        	kaingang_the_event();
	        endwhile; endif;

	        wp_reset_postdata();
	        ?>
		</div>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php kaingang_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>