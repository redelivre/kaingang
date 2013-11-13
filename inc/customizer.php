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


	/**
	 * Customize Image Reloaded Class
	 *
	 * Extend WP_Customize_Image_Control allowing access to uploads made within
	 * the same context
	 * 
	 */
	class My_Customize_Image_Reloaded_Control extends WP_Customize_Image_Control {
		/**
		 * Constructor.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Image_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 */
		public function __construct( $manager, $id, $args = array() ) {
		
		parent::__construct( $manager, $id, $args );
		       
		}
		
		/**
		* Search for images within the defined context
		* If there's no context, it'll bring all images from the library
		* 
		*/
		public function tab_uploaded() {
		$my_context_uploads = get_posts( array(
		    'post_type'  => 'attachment',
		    'meta_key'   => '_wp_attachment_context',
		    'meta_value' => $this->context,
		    'orderby'    => 'post_date',
		    'nopaging'   => true,
		) );
		
		?>
		
		<div class="uploaded-target"></div>
		
		<?php
		if ( empty( $my_context_uploads ) )
		    return;
		
		foreach ( (array) $my_context_uploads as $my_context_upload )
		    $this->print_tab_image( esc_url_raw( $my_context_upload->guid ) );
		}
		
	}


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

	// Branding section
	$wp_customize->add_section( 'kaingang_branding', array(
		'title'    => __( 'Branding', 'kaingang' ),
		'priority' => 30,
	) );
	
	// Branding: Logo settings
	$wp_customize->add_setting( 'kaingang_logo', array(
		'capability'  => 'edit_theme_options',
	) );
	
    $wp_customize->add_control( new My_Customize_Image_Reloaded_Control( $wp_customize, 'kaingang_logo', array(
        'label'   	=> __( 'Logo', 'kaingang' ),
        'section'	=> 'kaingang_branding',
        'settings' 	=> 'kaingang_logo',
        'context'	=> 'kaingang-custom-logo'
    ) ) );

    // Color section: link color
    $wp_customize->add_setting( 'kaingang_link_color', array(
        'default'     => '#cc0033',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kaingang_link_color', array(
        'label'      => __( 'Link Color', 'kaingang' ),
        'section'    => 'colors',
        'settings'   => 'kaingang_link_color'
    ) ) );

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
			clip: rect(1px, 1px, 1px, 1px) !important;
			position: absolute !important;
		}
		<?php endif; ?>

        <?php
        $link_color = get_theme_mod( 'kaingang_link_color' );
		if ( ! empty( $link_color ) && $link_color != '#cc0033' ) : ?>
	        a,
	        a:visited {
	        	color: <?php echo $link_color; ?>;
	        }
        <?php endif; ?>
	</style> 
	<!-- /Customizer options -->
	<?php
}
add_action( 'wp_head', 'kaingang_customize_css' );
?>