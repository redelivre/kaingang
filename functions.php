<?php
/**
 * Kaingang functions and definitions
 *
 * @package Kaingang
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 672; /* pixels */

if ( ! function_exists( 'kaingang_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function kaingang_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Kaingang, use a find and replace
	 * to change 'kaingang' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kaingang', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * New image sizes
	 */
	add_image_size( 'feature-main', 1280, 300, true );
	add_image_size( 'feature-singular', 704, 350, true );
	add_image_size( 'feature-archive', 370, 270, true );
	add_image_size( 'feature-archive--small', 255, 168, true );
	add_image_size( 'feature-main', 1280, 300, true );
	add_image_size( 'feature-main--3x2', 680, 453, true );
	add_image_size( 'feature-main--4x3', 680, 510, true );
	add_image_size( 'feature-main--16x9', 680, 383, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'kaingang' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'audio', 'aside', 'gallery', 'image', 'link', 'quote', 'video' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'kaingang_custom_background_args', array(
		'default-color' => '959595',
		'default-image' => '',
	) ) );
}
endif; // kaingang_setup
add_action( 'after_setup_theme', 'kaingang_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function kaingang_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Home Sidebar', 'kaingang' ),
		'id'            => 'sidebar-main',
		'description'	=> __( 'The main sidebar, displayed on the front page', 'kaingang' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s box">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Internal Sidebar', 'kaingang' ),
		'id'            => 'sidebar-internal',
		'description'	=> __( 'The secondary sidebar, displayed internally', 'kaingang' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s box">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'kaingang' ),
		'id'            => 'sidebar-footer',
		'description'	=> __( 'Appears on your footer', 'kaingang' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'kaingang_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function kaingang_scripts() {

	// Normalize.css
	wp_register_style( 'kaingang-normalize', get_template_directory_uri() . '/css/normalize.css', array(), '2.1.3' );
	wp_enqueue_style( 'kaingang-normalize' );

	// Main style
	wp_enqueue_style( 'kaingang-style', get_stylesheet_uri() );

	// Google Fonts
	$kaingang_fonts = get_theme_mod('kaingang_font_main', array());
	
	if(is_array($kaingang_fonts) && array_key_exists('url', $kaingang_fonts))
	{
		wp_register_style( 'kaingang-fonts', "http://fonts.googleapis.com/css?family={$kaingang_fonts['url']}" );
		wp_enqueue_style ( 'kaingang-fonts' );
	}

	// FlexSlider
	wp_register_style( 'kaingang-flexslider', get_template_directory_uri() . '/css/flexslider.css', array() );
	wp_enqueue_style( 'kaingang-flexslider' );
	wp_enqueue_script( 'kaingang-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), '2.2.0', true );

	wp_enqueue_script( 'kaingang-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'kaingang-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'kaingang-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'kaingang_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load post2home for featured posts
 */
require get_template_directory() . '/inc/hacklab_post2home/hacklab_post2home.php';

function kaingang_footer_scripts() {
	?> 
	<!-- FlexSlider -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
		    jQuery('.js-flexslider').flexslider({
				animation: "slide",
				selector: ".flexslider-slides > .flexslider-slide-wrapper",
				prevText: "",
				nextText: ""
			});
		});
	</script>
	<?php
}
add_action( 'wp_footer', 'kaingang_footer_scripts' );

/**
* Load the header type defined in wordpress customizer
* @author Henrique
*
*/
function kaingang_load_header(){
	$header_type = get_theme_mod('kaingang_header_type');
	if($header_type == 2){
		$header_class = "header-type-2";
		get_template_part('layouts/header', '2');
	} else {
		$header_class = "header-type-1";
		get_template_part('layouts/header', '1');
	}
	
	return $header_class;
}

/**
 * Add Facebook scripts for the theme
 *
 * @todo Create an option page (or maybe in Customizer) to insert App ID
 */
function kaingang_fb_comments_box() {

	$fb_appid = get_theme_mod( 'kaingang_facebook_appid' );
	?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=<?php echo $fb_appid; ?>&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<script>
		var siteLeadUrl = "<?php echo get_template_directory_uri() . "/js/site-lead.js" ?>";
		if(typeof Modernizr !== 'undefined')
		{
			Modernizr.load({
		        test: Modernizr.mq("only screen and (min-width:64.063em)"),
		        yep: siteLeadUrl
			});
		}
	</script>

	<?php
}
add_action( 'wp_footer', 'kaingang_fb_comments_box' );

/**
 * Add Facebook OpenGraph meta properties
 */
function kaingang_fb_opengraph() {
	$fb_appid = get_theme_mod( 'kaingang_facebook_appid' );

	if ( ! empty ( $fb_appid ) ) {
		echo '<meta property="fb:app_id" content="' . $fb_appid . '"/>';
	}	
}
add_action( 'wp_head', 'kaingang_fb_opengraph' );
