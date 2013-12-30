<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Kaingang
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function kaingang_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'kaingang_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function kaingang_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() )
		$classes[] = 'group-blog';

	if ( is_singular() )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'kaingang_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function kaingang_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'kaingang_enhanced_image_navigation', 10, 2 );

/**
 * Filter wp_title to print a neat <title> tag based on what is being viewed.
 */
function kaingang_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'kaingang' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'kaingang_wp_title', 10, 2 );

/**
 * Change excerpt length in archives
 * 
 * @param  integer $length The default length
 * @return integer New excerpt length
 */
function kaingaing_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'kaingaing_excerpt_length' );

/**
 * Get 'kaingang_logo' ID and use it to define the default logo size
 * 
 * @param  string $value The attachment guid, which is the full imagem URL
 * @return string $value The new image size for 'kaingang_logo'
 */
function kaingang_get_customizer_logo_size( $value ) {
	global $wpdb;

    if ( ! is_numeric( $value ) ) {
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid = %s ORDER BY post_date DESC LIMIT 1;", $value ) );
        if ( ! is_wp_error( $attachment_id ) && wp_attachment_is_image( $attachment_id ) )
            $value = $attachment_id;
    }

    $image_attributes = wp_get_attachment_image_src( $value, 'feature-archive--small' );
    $value = $image_attributes[0];

	return $value;
}
add_filter( 'theme_mod_kaingang_logo', 'kaingang_get_customizer_logo_size', 99 );