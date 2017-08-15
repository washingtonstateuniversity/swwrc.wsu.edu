( function( $ ) {

	// Fire the videoBG plugin using data stored with the pageview.
	$( document ).ready( function() {
		$( "#" + window.wsu_video_background.id ).videoBG( {
			mp4: window.wsu_video_background.mp4,
			ogv: window.wsu_video_background.ogv,
			webm: window.wsu_video_background.webm,
			poster: window.wsu_video_background.poster,
			scale: window.wsu_video_background.scale,
			zIndex: window.wsu_video_background.zIndex
		} );
	} );

	function checkposi( e ) {
		if ( typeof e.touches === "undefined" && typeof e.changedTouches === "undefined" ) {
			return;
		}

		var distance = $( ".videobg" ).height() + $( ".home nav" ).height();
		var touch = e.touches[ 0 ] || e.changedTouches[ 0 ];
		var y = touch.pageY - touch.clientY;

		if ( y > distance ) {
			$( ".home nav" ).removeClass( "navreg" ).addClass( "navfix" );
		} else {
			$( ".home nav" ).removeClass( "navfix" ).addClass( "navreg" );
		}
	}

	if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test( navigator.userAgent ) ) {
		document.addEventListener( "scroll", function( e ) {
			checkposi( e, $( "html" ) );
		} );
		document.addEventListener( "touchstart", function( e ) {
			checkposi( e, $( "html" ) );
		} );
		document.addEventListener( "touchmove", function( e ) {
			checkposi( e, $( "html" ) );
		} );
		document.addEventListener( "touchend", function( e ) {
			checkposi( e, $( "html" ) );
		} );
	} else {
		var $menu = $( ".home .main-menu" ),
			menu_top = $menu.offset().top;

		$( window ).scroll( function() {
			if ( $( window ).scrollTop() > menu_top ) {
				$menu.removeClass( "navreg" );
			} else {
				$menu.addClass( "navreg" );
			}
		} );
	}
}( jQuery ) );
