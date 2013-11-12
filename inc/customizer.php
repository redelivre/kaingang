<?php
/**
 * Kaingang Theme Customizer
 *
 * @package Kaingang
 * @since  Kaingang 1.0
 */

/**
 * Implements Kaingang theme options into Theme Customizer
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since  Kaingang 1.0
 */
function kaingang_customize_register( $wp_customize ) {

	// Add postMessage support for site title and description for the Theme Customizer.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Site title & tagline
	$wp_customize->add_setting( 'kaingang_display_header_text', array(
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'kaingang_display_header_text', array(
		'label'    => __( 'Display header text', 'kaingang' ),
		'section'  => 'title_tagline',
		'type'     => 'checkbox',
		'settings' => 'kaingang_display_header_text'
	) );


}
add_action( 'customize_register', 'kaingang_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function kaingang_customize_preview_js() {
	wp_enqueue_script( 'kaingang_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'kaingang_customize_preview_js' );

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 * 
 * Used for inline custom CSS
 *
 * @since Kaingang 1.0
 */
function kaingang_customize_css() {
	?>
	<!-- Customizer options -->
	<style type="text/css">
		<?php if ( get_theme_mod( 'kaingang_display_header_text' ) == '' ) : ?>
		/* Header text */
		.site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute !important;
		}
		<?php endif; ?>
	</style> 
	<!-- /Customizer options -->
	<?php
}
add_action( 'wp_head', 'kaingang_customize_css' );
?>