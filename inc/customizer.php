<?php
/**
 * Kaingang Theme Customizer
 *
 * @package Kaingang
 * @since  Kaingang 1.0
 */

/**
 * Implement Kaingang theme options into Theme Customizer
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
			
			foreach ( (array) $my_context_uploads as $my_context_upload ) {
			    $this->print_tab_image( esc_url_raw( $my_context_upload->guid ) );
			}
		}
	}

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
	
	// Branding section: logo uploader
	$wp_customize->add_setting( 'kaingang_logo', array(
		'capability'  		=> 'edit_theme_options',
		'sanitize_callback' => 'kaingang_callback_logo_size'
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
        'transport'  => 'postMessage'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kaingang_link_color', array(
        'label'      => __( 'Link Color', 'kaingang' ),
        'section'    => 'colors',
        'settings'   => 'kaingang_link_color'
    ) ) );

    // Color section: color scheme
	$wp_customize->add_setting( 'kaingang_color_scheme', array(
	    'default'    => 'light',
	    'transport'  => 'postMessage'
	) );

	$wp_customize->add_control( 'kaingang_color_scheme', array(
	    'label'    => __( 'Color Scheme', 'kaingang' ),
	    'section'  => 'colors',
	    'type'     => 'radio',
	    'choices'  => array( 'light' => __( 'Light', 'kaingang' ), 'dark' => __( 'Dark', 'kaingang' ) ),
	    'priority' => 5,
	    'settings' => 'kaingang_color_scheme'
	) );

	// Footer section
	$wp_customize->add_section( 'kaingang_footer', array(
		'title'    => __( 'Footer', 'kaingang' ),
		'priority' => 60,
	) );
	
	// Footer section: footer text
	$wp_customize->add_setting( 'kaingang_footer_text', array(
		'default'    => get_option( 'name' ),
		'capability'  	=> 'edit_theme_options',
	) );

    $wp_customize->add_control( 'kaingang_footer_text', array(
		'label'    => __( 'Footer Text', 'kaingang' ),
		'section'  => 'kaingang_footer',
		'settings' => 'kaingang_footer_text'
	) );

	// Add postMessage support for site title and description for the Theme Customizer.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'kaingang_footer_text' )->transport = 'postMessage';
	$wp_customize->get_setting( 'kaingang_display_header_text' )->transport = 'postMessage';
	

}
add_action( 'customize_register', 'kaingang_customize_register' );

/**
 * Get 'kaingang_logo' ID and use it to define the default logo size
 * 
 * @param  string $value The attachment guid, which is the full imagem URL
 * @return string $value The new image size for 'quizumba_logo'
 */
function kaingang_callback_logo_size( $value ) {
    global $wpdb;

    if ( empty( $value ) )
        return $value;

    if ( ! is_numeric( $value ) ) {
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid = %s ORDER BY post_date DESC LIMIT 1;", $value ) );
        if ( ! is_wp_error( $attachment_id ) && wp_attachment_is_image( $attachment_id ) )
            $value = $attachment_id;
    }

    $image_attributes = wp_get_attachment_image_src( $value, 'feature-archive--small' );
    $value = $image_attributes[0];

    return $value;
}

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
		<?php
		$color_scheme = get_theme_mod( 'kaingang_color_scheme' );
		if ( isset( $color_scheme ) && $color_scheme == 'dark' ) : ?>
			.site-header,
			.site-footer {
				background-color: #000;
				color: #fff;
			}

			.main-navigation ul ul {
				background: #000;
			}

			.widget-area--footer + .site-info {
				border-color: #222;
			}
		<?php endif; ?>

		<?php if ( get_theme_mod( 'kaingang_display_header_text' ) == '' ) : ?>
			/* Header text */
			.site-title,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		<?php else : ?>
			.site-title,
			.site-description {
				clip: auto;
				position: relative;
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

/**
 * Add Customizer inside Appearance submenu
 *
 * @since  Kaingaing 1.0
 */
function kaingang_admin_customizer_menu_link() {

	global $menu;

    if ( current_user_can( 'edit_theme_options' ) ) {
        add_theme_page( __( 'Customize', 'default' ), __( 'Customize', 'default' ), 'edit_theme_options', 'customize.php' );
    }

}
add_action ( 'admin_menu', 'kaingang_admin_customizer_menu_link', 99 );
?>