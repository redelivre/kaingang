<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Kaingang
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<?php edit_post_link( __( 'Edit', 'kaingang' ), '<span class="edit-link">', '</span>' ); ?>
				</header><!-- .entry-header -->

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-image">
						<?php the_post_thumbnail( 'feature-singular' ); ?>
					</div><!-- .entry-image -->
				<?php endif ?>

				<div class="entry-content">
					<ul class="entry-event">
						<?php if ( $date_start = get_post_meta( $post->ID, '_data_inicial', true ) ) : ?>
						<li class="event-date">
							<span class="meta-title"><?php _ex( 'Date', 'Agenda', 'kaingang' ); ?></span>
							<?php
							$date_end = get_post_meta( $post->ID, '_data_final', true );
							if ( $date_end && $date_end != $date_start ) :
								/* translators: Initial & final date for the event */
								printf(
									'%1$s to %2$s',
									date( get_option( 'date_format' ), strtotime( $date_start ) ),
									date( get_option( 'date_format' ), strtotime( $date_end ) )
								);
							else :
								echo date( get_option( 'date_format' ), strtotime( $date_start ) );
							endif;
							?>
						</li>
						<?php endif; ?>
						
						<?php if ( $time = get_post_meta( $post->ID, '_horario', true ) ) : ?>
						<li class="event-time"><span class="meta-title"><?php _ex( 'Time', 'Agenda', 'kaingang' ); ?></span><?php echo $time; ?></li>
						<?php endif; ?>
						
						<?php if ( $location = get_post_meta( $post->ID, '_onde', true ) ) : ?>
						<li class="event-location"><span class="meta-title"><?php _ex( 'Location', 'Agenda', 'kaingang' ); ?></span><?php echo $location; ?></li>
						<?php endif; ?>
						
						<?php if ( $link = get_post_meta( $post->ID, '_link', true ) ) : ?>
						<li class="event-link"><span class="meta-title"><?php _ex( 'More info', 'Agenda', 'kaingang' ); ?></span><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_url( $link ); ?></a></li>
						<?php endif; ?>
					</ul>
					<?php the_content(); ?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'kaingang' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->

				<footer class="entry-meta entry-meta--footer">
					<?php kaingang_social_share(); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-## -->

			<?php kaingang_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>