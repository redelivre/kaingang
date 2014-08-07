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
					<div class="entry-meta">
						<?php kaingang_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php edit_post_link( __( 'Edit', 'kaingang' ), '<span class="edit-link">', '</span>' ); ?>
				</header><!-- .entry-header -->

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-image">
						<?php the_post_thumbnail( 'feature-singular' ); ?>
					</div><!-- .entry-image -->
				<?php endif ?>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'kaingang' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->

				<footer class="entry-meta entry-meta--footer">
					<?php
					/* translators: used between list items, there is a space after the comma */
			        $category_list = get_the_category_list( __( ', ', 'kaingang' ) );

					/* translators: used between list items, there is a space after the comma */
					$tag_list = get_the_tag_list( '', __( ', ', 'kaingang' ) );

					if ( ! empty( $tag_list ) ) : ?>
						<div class="entry-tag entry-meta-box">
							<?php echo '<span class="meta-title">' . __( 'Tags', 'kaingang' ) . '</span>' . $tag_list; ?>
						</div>
					<?php
					endif;

					if ( ! empty( $category_list ) ) : ?>
						<div class="entry-category entry-meta-box">
							<?php echo '<span class="meta-title">' . __( 'Categories', 'kaingang' ) . '</span>' . $category_list; ?>
						</div>
					<?php endif; ?>

					<?php kaingang_social_share(); ?>
					
				</footer><!-- .entry-meta -->
			</article><!-- #post-## -->

			<?php kaingang_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();

			if( get_theme_mod('quizumba_display_fb_comments') == 1 )
				{ ?> 
				<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light" data-width="100%"></div>
			<?php }	
		endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>