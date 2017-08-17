( function( $ ) {
	$( ".swwrc-tag-filters" ).on( "change", "input:checkbox", function() {
		var $filter_container = $( this ).closest( ".swwrc-tag-filters" ),
			classes = [],
			$posts = $filter_container.next( "div" ).find( "article" );

		$filter_container.find( "input:checkbox:checked" ).each( function() {
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
