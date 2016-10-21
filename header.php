<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content" class="site-content wrap">
 *
 * @package Kaingang
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
	<?php $kaingang_fonts = get_theme_mod('kaingang_font_main'); ?>
	<style>
		body{
			font-family: '<?php echo $kaingang_fonts['name']; ?>';
		}
	</style>
</head>

<?php $header_class = kaingang_load_header(); ?>

<body <?php body_class($header_class); ?>>

<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<?php if ( is_home() ) : ?>
		<div class="feature flexslider js-flexslider">
			<?php
	        $featured_posts = new WP_Query( array( 'posts_per_page' => 5, 'meta_key' => '_home', 'meta_value' => 1, 'ignore_sticky_posts' => 1 ) );
	        
	        if ( $featured_posts->have_posts() ) : ?>
		        <div class="flexslider-slides">
			        <?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
			        	<div class="flexslider-slide-wrapper">
			        		<?php
			        		// Gets the selected aspect ratio chosen on Customizer
			        		if ( has_post_thumbnail() ) :
			        			the_post_thumbnail( get_theme_mod( 'kaingang_feature_thumbnail_size' ), array( 'class' => 'flexslider-image' ) );
				        	endif;
				        	?>
				        	<div class="wrap">
					        	<article <?php post_class(); ?>>
					        		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					        	</article>
				        	</div>
			        	</div>
			        <?php
			        endwhile;
			        wp_reset_postdata();
			        ?>
			    </div><!-- .flexslider-slides -->
			<?php endif; ?>
		</div><!-- .feature -->
		
		<?php
		$display_search = get_theme_mod('kaingang_display_search', '1') == 1;
		$display_social = get_theme_mod('kaingang_social_display_icons', '1') == 1;
		if($display_search || $display_social)
		{
			?>
			<div class="extra-bar box clear">
				<div class="wrap">
					<?php
					if($display_social)
					{
						$social = get_option( 'campanha_social_networks' );
						if ( isset( $social ) && ! empty ( $social ) && is_array($social) && count($social) > 0 ) : ?>
							<div class="social-networks">
								<h6><?php _e( 'Find us', 'kaingang' ); ?></h6>
								<?php
								foreach ( $social as $key => $value ) :
									if ( ! empty( $value) ) : ?>
										<a class="social-link" href="<?php echo esc_url( $value ); ?>"><span class="icon icon-<?php echo $key; ?>"></span></a>
									<?php
									endif;
								endforeach;
								?>
							</div><!-- .social networks -->
						<?php endif;
					}
					if($display_search)
					{
						?>
						<div class="search-form-wrapper">
							<h6><?php _e( 'Search for:', 'kaingang' ); ?></h6>
							<?php get_search_form(); ?>
						</div><?php
					}
					?>
				</div>
			</div><?php 
		}
	endif; // is_home() ?>

	<div id="content" class="site-content wrap">
