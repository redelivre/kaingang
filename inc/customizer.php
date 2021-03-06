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
		'transport'	 => 'postMessage'
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

    // Branding section
	$wp_customize->add_section( 'kaingang_events', array(
		'title'    => __( 'Events', 'kaingang' ),
		'priority' => 30,
	) );

    $wp_customize->add_setting( 'kaingang_display_events', array(
		'capability'	=> 'edit_theme_options',
		'default'		=> true,
		'transport'		=> 'postMessage'
	) );

	$wp_customize->add_control( 'kaingang_display_events', array(
		'label'    => __( 'Display events list on Home', 'kaingang' ),
		'section'  => 'kaingang_events',
		'type'     => 'checkbox',
		'settings' => 'kaingang_display_events'
	) );



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

	// Feature section
	$wp_customize->add_section( 'kaingang_feature', array(
		'title'    => __( 'Destaque', 'kaingang' ),
		'priority' => 60,
	) );

	$wp_customize->add_setting( 'kaingang_feature_thumbnail_size', array(
	    'default'    => 'feature-main',
	) );

	$wp_customize->add_control( 'kaingang_feature_thumbnail_size', array(
	    'label'    => __( 'Proporção da foto', 'kaingang' ),
	    'section'  => 'kaingang_feature',
	    'type'     => 'radio',
	    'choices'  => array(
	    				'feature-main'			=> __( 'Padrão', 'kaingang' ),
	    				'feature-main--3x2' 	=> __( '3:2', 'kaingang' ),
	    				'feature-main--4x3' 	=> __( '4:3', 'kaingang' ),
	    				'feature-main--16x9'	=> __( '16:9', 'kaingang' )
	    			),
	    'priority' => 5,
	    'settings' => 'kaingang_feature_thumbnail_size'
	) );

	// Footer section
	$wp_customize->add_section( 'kaingang_footer', array(
		'title'    => __( 'Footer', 'kaingang' ),
		'priority' => 60,
	) );
	
	// Footer section: footer text
	$wp_customize->add_setting( 'kaingang_footer_text', array(
		'default'    	=> get_option( 'name' ),
		'capability'  	=> 'edit_theme_options',
		'transport' 	=> 'postMessage'
	) );

    $wp_customize->add_control( 'kaingang_footer_text', array(
		'label'    => __( 'Footer Text', 'kaingang' ),
		'section'  => 'kaingang_footer',
		'settings' => 'kaingang_footer_text'
	) );
    
    // Footer section: footer credits text
    $wp_customize->add_setting( 'kaingang_footer_credits_text', array(
    	'default'    	=> sprintf( __( 'Proudly powered by %s', 'kaingang' ), 'WordPress' ),
    	'capability'  	=> 'edit_theme_options',
    	'transport' 	=> 'postMessage'
    ) );
    
    $wp_customize->add_control( 'kaingang_footer_credits_text', array(
    	'label'    => __( 'Footer Credits Text', 'kaingang' ),
    	'section'  => 'kaingang_footer',
    	'settings' => 'kaingang_footer_credits_text'
    ) );
    
    // Footer section: footer credits link
    $wp_customize->add_setting( 'kaingang_footer_credits_link', array(
    	'default'    	=> "http://wordpress.org/",
    	'capability'  	=> 'edit_theme_options',
    	'transport' 	=> 'postMessage'
    ) );
    
    $wp_customize->add_control( 'kaingang_footer_credits_link', array(
    	'label'    => __( 'Footer Credits Link', 'kaingang' ),
    	'section'  => 'kaingang_footer',
    	'settings' => 'kaingang_footer_credits_link'
    ) );

	// Add postMessage support for site title and description for the Theme Customizer.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	/**
	* Add options for header customization
	* @author: Henrique M.
	* @todo: Need to review language files, currently only display in portuguese.
	*/
	$wp_customize->add_section('kaingang_header', array(
		'title' => __('Cabeçalho', 'kaingang'),
		'priority' => 5
	));
	
	//header background color	
	$wp_customize->add_setting('kaingang_header_bgcolor', array(
		'default' => ''
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kaingang_header_bgcolor_control', array(
		'label' => __('Cor de fundo', 'kaingang'),
		'section' => 'kaingang_header',
		'settings' => 'kaingang_header_bgcolor'
	)));
	
	//header background image
	$wp_customize->add_setting('kaingang_header_image', array(
		'default' => ''
	));
	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kaingang_header_image_control', array(
		'label' => __('Imagem de fundo', 'kaingang'),
		'section' => 'kaingang_header',
		'settings' => 'kaingang_header_image'
	)));
	
	// header options
	$wp_customize->add_setting('kaingang_header_type', array(
		'default' => '1'
	));
	
	$wp_customize->add_control('header_style', array(
		'label' => __('Estrutura', 'kaingang'),
		'section' => 'kaingang_header',
		'settings' => 'kaingang_header_type',
		'type' => 'radio',
		'choices' => array(
				'1' => 'Menu ao lado do logo',
				'2' => 'Menu abaixo da imagem do cabeçalho'
			)
	));
	
	//Typography
	$wp_customize->add_section( 'kaingang_typography', array(
		'title'    => __( 'Typography (beta)', 'guarani' ),
		'priority' => 30,
	) );
   
    $wp_customize->add_setting( 'kaingang_font_main', array(
      'sanitize_callback' => 'kaingang_font_values'
    ) );

    $wp_customize->add_control( 'kaingang_font_main', array(
        'label'    => __( 'Main Font', 'kaingang' ),
        'section'  => 'kaingang_typography',
        'type'     => 'select',
        'choices'  => array(
        	'default' 				=> __( 'Default', 'kaingang' ),
        	'Amaranth:400,700' 		=> __( 'Amaranth', 'kaingang' ),
        	'Arvo:400,700,400' 		=> __( 'Arvo', 'kaingang' ),
        	'Lato:400,700' 			=> __( 'Lato', 'kaingang' ),
        	'Noticia+Text:400,700' 	=> __( 'Noticia Text', 'kaingang' ),
        	'Special+Elite:400' 	=> __( 'Special Elite', 'kaingang' )
 		),
        'priority' => 5,
        'setting' => 'kaingang_font_main'
    ) );
    
    // Comments FB
    $wp_customize->add_section( 'kaingang_fb_comments', array(
    		'title'    => __( 'Comentários via Facebook', 'kaingang' ),
    		'priority' => 30,
    ) );
    $wp_customize->add_setting( 'kaingang_display_fb_comments', array(
    		'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'kaingang_display_fb_comments', array(
    		'label'    => __( 'Exibe a caixa de comentários do Facebook', 'kaingang' ),
    		'section'  => 'kaingang_fb_comments',
    		'type'     => 'checkbox',
    		'settings' => 'kaingang_display_fb_comments'
    ) );
    
    $wp_customize->add_setting( 'kaingang_social_display_icons', array(
    	'capability' => 'edit_theme_options',
    	'default' => 1
    ) );
    
    $wp_customize->add_control( 'kaingang_social_display_icons', array(
    	'label'    => __( 'Exibe icones das redes sociais internos do Kaingang', 'kaingang' ),
    	'section'  => 'kaingang_header',
    	'type'     => 'checkbox',
    	'settings' => 'kaingang_social_display_icons',
    ) );

    $wp_customize->add_setting( 'kaingang_display_search', array(
    	'capability' => 'edit_theme_options',
    	'default' => 1
    ) );
    
    $wp_customize->add_control( 'kaingang_display_search', array(
    	'label'    => __( 'Exibe área de busca no cabeçalho', 'kaingang' ),
    	'section'  => 'kaingang_header',
    	'type'     => 'checkbox',
    	'settings' => 'kaingang_display_search',
    ) );
    
}
add_action( 'customize_register', 'kaingang_customize_register' );

function kaingang_font_values( $value ) {

    if ( $value == 'default' || is_array( $value ) )
    	return $value;

    // Font URL
    $new_value['url'] = $value;

	// Name
	$font_string = strstr( $value, ':', true );
    $new_value['name'] = str_replace( '+', ' ', $font_string );

    // Font weight
    $new_value['weight'] = strstr( $value, ':' );

    $value = $new_value;

    return $value;
}


/**
 * Get 'kaingang_logo' ID and use it to define the default logo size
 * 
 * @param  string $value The attachment guid, which is the full imagem URL
 * @return string $value The new image size for 'kaingang_logo'
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
			.site-footer,
			.extra-bar {
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
	        a:hover,
			a:focus,
			a:active {
				color: #959595;
			}

			button,
			html input[type="button"],
			input[type="reset"],
			input[type="submit"] {
				background-color: <?php echo $link_color; ?>;
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

	global $menu, $submenu;

    // Check if a Customize menu already exists
    $handle = 'customize.php';
    $customizer_menu = false;

    if( empty( $submenu ) ) {
      return;
    }

    foreach( $submenu as $k => $item ) {
        foreach( $item as $sm ) {
	        if( $handle == $sm[2] ) {
	            $customizer_menu = true;
			}
        }
    }
    
    if ( $customizer_menu === false && current_user_can( 'edit_theme_options' ) ) {
        add_theme_page( __( 'Customize', 'default' ), __( 'Customize', 'default' ), 'edit_theme_options', 'customize.php' );
    }

}
add_action ( 'admin_menu', 'kaingang_admin_customizer_menu_link', 99 );
?>