<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Kaingang
 */

if ( ! function_exists( 'kaingang_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function kaingang_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation box';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'kaingang' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'kaingang' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'kaingang' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'kaingang' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'kaingang' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // kaingang_content_nav

if ( ! function_exists( 'kaingang_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function kaingang_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'kaingang' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'kaingang' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'kaingang' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'kaingang' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'kaingang' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kaingang' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for kaingang_comment()

if ( ! function_exists( 'kaingang_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function kaingang_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'kaingang_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'kaingang_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and first category.
 */
function kaingang_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$category = get_the_category();

	if ( $category ) {
		$category_string = '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a>';

		printf( '%1$s <span class="sep">&middot;</span> %2$s',
			$time_string,
			$category_string
		);
	}
	else {
		printf( '%1$s',
			$time_string
		);
	}
	 
}
endif;

if ( ! function_exists( 'kaingang_the_event' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function kaingang_the_event() {
	global $post;
	?>
	<div class="col-4">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="event">
		    	<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-image entry-image--event">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'feature-archive--small' ); ?></a>
					</div><!-- .entry-image--event -->
				<?php endif ?>
				<h3 class="entry-title entry-title--event"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="entry-content">
			        <ul class="entry-event">
						<?php if ( $date_start = get_post_meta( $post->ID, '_data_inicial', true ) ) : ?>
						<li class="event-date">
							<?php
							// The date format
							$date_format = 'd/m/y';

							// End date
							$date_end = get_post_meta( $post->ID, '_data_final', true );
							
							if ( $date_end && $date_end != $date_start ) :
								/* translators: Initial & final date for the event */
								printf(
									'%1$s to %2$s',
									date( $date_format, strtotime( $date_start ) ),
									date( $date_format, strtotime( $date_end ) )
								);
							else :
								echo date( $date_format, strtotime( $date_start ) );
							endif;
							?>
						</li>
						<?php endif; ?>
						
						<?php if ( $time = get_post_meta( $post->ID, '_horario', true ) ) : ?>
						<li class="event-time"><?php echo $time; ?></li>
						<?php endif; ?>
						
						<?php if ( $location = get_post_meta( $post->ID, '_onde', true ) ) : ?>
						<li class="event-location"><?php echo $location; ?></li>
						<?php endif; ?>
					</ul>
				</div><!-- .entry-content -->
			</div><!-- .event -->
		</article><!-- #post-## -->
	</div>
    <?php
}
endif;

/**
 * Add a container with social links
 */
function kaingang_social_share() {
	global $post;
	?>
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
<?php
}

/**
 * Returns true if a blog has more than 1 category
 */
function kaingang_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so kaingang_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so kaingang_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in kaingang_categorized_blog
 */
function kaingang_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'kaingang_category_transient_flusher' );
add_action( 'save_post',     'kaingang_category_transient_flusher' );
