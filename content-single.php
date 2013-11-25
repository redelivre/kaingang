<?php
/**
 * @package Kaingang
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="entry-meta">
			<?php kaingang_posted_on(); ?>
		</div><!-- .entry-meta -->
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
			<div class="entry-meta__tag">
				<?php echo '<span class="meta-title">' . __( 'Tags', 'kaingang' ) . '</span>' . $tag_list; ?>
			</div>
		<?php
		endif;

		if ( ! empty( $category_list ) ) : ?>
			<div class="entry-meta__category">
				<?php echo '<span class="meta-title">' . __( 'Categories', 'kaingang' ) . '</span>' . $category_list; ?>
			</div>
		<?php endif; ?>
		<?php edit_post_link( __( 'Edit', 'kaingang' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
