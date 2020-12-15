/* global _wpCustomizeSettings, tinyMCE */
/**
 * File wp-customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );

	$( function() {
		'use strict';
		/**
		 * TinyMCE Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * {@link} https://github.com/maddisondesigns
		 */

		$( '.customize-control-tinymce-editor' ).each( function() {
			// Get the toolbar strings that were passed from the PHP Class
			const tinyMCEToolbar1String = _wpCustomizeSettings.controls[ $( this ).attr( 'id' ) ].skyrockettinymcetoolbar1;
			const tinyMCEToolbar2String = _wpCustomizeSettings.controls[ $( this ).attr( 'id' ) ].skyrockettinymcetoolbar2;

			wp.editor.initialize( $( this ).attr( 'id' ), {
				tinymce: {
					wpautop: true,
					toolbar1: tinyMCEToolbar1String,
					toolbar2: tinyMCEToolbar2String,
				},
				quicktags: true,
			} );
		} );

		$( document ).on( 'tinymce-editor-init', function( event, editor ) {
			editor.on( 'change', function() {
				tinyMCE.triggerSave();
				$( '#' + editor.id ).trigger( 'change' );
			} );
		} );
	} );
} )( jQuery );
