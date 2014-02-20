<?php
/**
 * @package Kaingang
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear box media' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-image">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'feature-archive' ); ?></a>
		</div><!-- .entry-image -->
	<?php endif ?>
	<div class="entry-body">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php if ( $post->post_type == 'post' ) : ?>
			<div class="entry-meta">
				<?php kaingang_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div><!-- .entry-body -->
</article><!-- #post-## -->
