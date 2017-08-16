( function( $ ) {
	$( ".swwrc-tag-filters" ).on( "change", "input:checkbox", function() {
		var classes = [],
			$posts = $( this ).closest( ".swwrc-tag-filters" ).next( "div" ).find( "article" );

		$( ".swwrc-tag-filters input:checkbox:checked" ).each( function() {
			classes.push( "." + $( this ).val() );
		} );

		if ( classes.length >= 0 ) {
			$posts.not( classes.join( "," ) ).hide( 250 );
			$posts.filter( classes.join( "," ) ).show( 250 );
		} else {
			$posts.show( 250 );
		}
	} );
}( jQuery ) );
