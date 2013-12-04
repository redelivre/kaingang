<?php
/**
 * @package Kaingang
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
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
				<span class="meta-title"><?php _e( 'Date', 'Agenda', 'kaingang' ); ?></span>
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
			<li class="event-time"><span class="meta-title"><?php _e( 'Time', 'Agenda', 'kaingang' ); ?></span><?php echo $time; ?></li>
			<?php endif; ?>
			
			<?php if ( $location = get_post_meta( $post->ID, '_onde', true ) ) : ?>
			<li class="event-location"><span class="meta-title"><?php _e( 'Location', 'Agenda', 'kaingang' ); ?></span><?php echo $location; ?></li>
			<?php endif; ?>
			
			<?php if ( $link = get_post_meta( $post->ID, '_link', true ) ) : ?>
			<li class="event-link"><span class="meta-title"><?php _e( 'More info', 'Agenda', 'kaingang' ); ?></span><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_url( $link ); ?></a></li>
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