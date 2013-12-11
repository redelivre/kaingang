<?php
/**
 * The template for displaying the Agenda archive
 *
 * @package Kaingang
 * @since  1.0
 */

get_header(); ?>

	<section id="primary" class="content-area content-area--full">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header box">
				<h1 class="page-title">
					<?php post_type_archive_title(); ?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<div class="events-list">

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php kaingang_the_event(); ?>
			<?php endwhile; ?>

			</div><!-- events-list -->

			<?php kaingang_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
