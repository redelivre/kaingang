<?php
/**
 * Home template file.
 *
 * @package Kaingang
 */

get_header(); ?>

	<div class="events-list box clear">
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

            $data_inicial = get_post_meta($post->ID, '_data_inicial', true);

            if ($data_inicial)
                $data_inicial = mysql2date(get_option('date_format'), $data_inicial, true);

            $data_final = get_post_meta($post->ID, '_data_final', true);
            if ($data_final)
                $data_final = mysql2date(get_option('date_format'), $data_final, true);
            ?>
            <div class="event">
            	<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-image--event">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'feature-event' ); ?></a>
					</div><!-- .entry-image--event -->
				<?php endif ?>
                <div class="event-date">
                    <?php echo $data_inicial; ?> 
                    <?php if ($data_inicial != $data_final): ?>
                        a <?php echo $data_final; ?>
                    <?php endif; ?>
                </div>
                <a href="<?php echo get_permalink( $post->ID ); ?>" title="<?php echo esc_attr( $post->post_title ); ?>"><?php echo $post->post_title; ?></a>
            </div><!-- .event -->
            
            <?php
        endwhile; endif;

        wp_reset_postdata();
        ?>
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