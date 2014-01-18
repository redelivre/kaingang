/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site description
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Link color
	wp.customize( 'kaingang_link_color', function( value ) {
        value.bind( function( to ) {
            $( 'a' ).css( 'color', to );
        } );
    } );

    // Events list
    wp.customize( 'kaingang_display_events', function( value ) {
        value.bind( function( to ) {
            if ( to === false ) {
                $( '.events' ).css( 'display', 'none' );
                
            }
            else {
                $( '.events' ).css( 'display', 'block' );
            }
        } );
    } );

    // Color scheme
    wp.customize( 'kaingang_color_scheme', function( value ) {
        value.bind( function( to ) {
            if ( to == 'light' ) {
                $( '.site-header, .site-footer' ).css( 'background-color', '#fff' );
                $( '.site-description, .site-footer' ).css( 'color', '#000' );
            }
            else {
                $( '.site-header, .site-footer' ).css( 'background-color', '#000' );
                $( '.site-description, .site-footer' ).css( 'color', '#fff' );
                $( '.widget-area--footer + .site-info' ).css( 'border-color', '#222' );
            }
        } );
    } );

    // Footer text
	wp.customize( 'kaingang_footer_text', function( value ) {
		value.bind( function( to ) {
			$( '.site-text' ).text( to );
		} );
	} );
} )( jQuery );
