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

		<div class="entry-share entry-meta-box clear">
			<?php $post_permalink = get_permalink(); ?>
			<div class="share-list">
				<span class="meta-title"><?php _e( 'Share', 'kaingang' ); ?></span>
	            <a class="social-link share-twitter" title="<?php _e( 'Share on Twitter', 'guarani' ); ?>" href="http://twitter.com/intent/tweet?original_referer=<?php echo $post_permalink; ?>&text=<?php echo $post->post_title; ?>&url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"><span class="icon icon-twitter"></span></a>
	            <a class="social-link share-facebook" title="<?php _e( 'Share on Facebook', 'guarani' ); ?>" href="https://www.facebook.com/sharer.php?u=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"><span class="icon icon-facebook"></span></a>
	            <a class="social-link share-googleplus" title="<?php _e( 'Share on Google+', 'guarani' ); ?>" href="https://plus.google.com/share?url=<?php echo $post_permalink; ?>" rel="nofollow" target="_blank"><span class="icon icon-google"></span></a>
	        </div><!-- .share-list -->
        
        	<div class="share-shortlink">
        		<span class="meta-title"><?php _e( 'Link', 'kaingang' ); ?></span><input type="text" title="<?php _e( 'Click to copy the permalink', 'kaingang' ); ?>" value="<?php if ( $shortlink = wp_get_shortlink( $post->ID ) ) echo $shortlink; else the_permalink(); ?>" onclick="this.focus(); this.select();" readonly="readonly" />
        	</div><!-- .share-shortlink -->
        </div><!-- .entry-share -->
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
