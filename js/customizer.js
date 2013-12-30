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

    // Footer text
	wp.customize( 'kaingang_footer_text', function( value ) {
		value.bind( function( to ) {
			$( '.site-text' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'kaingang_display_header_text', function( value ) {
		value.bind( function( to ) {
			console.log(to);
			if ( false === to ) {
				console.log('n exibir');
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				console.log('exibir');
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
			}
		} );
	} );
} )( jQuery );
