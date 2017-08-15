( function( $ ) {
	$( document ).ready( function() {
		var $mobile_header = $( ".mobilenav" ),
			$menu = $( ".main-menu ul" );

		// Toggle the mobile menu when it's clicked.
		$mobile_header.click( function( e ) {
			e.preventDefault();
			$menu.toggleClass( "shownav" );
		} );
	} );
}( jQuery ) );
