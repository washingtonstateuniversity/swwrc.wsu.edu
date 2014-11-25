(function($){
	$(document).ready(function(){
	(function($){
		var menuul = $(".main-menu ul");

		$('.mobilenav').click(function() {
			if(menuul.hasClass('shownav')){
				menuul.removeClass('shownav');
			} else {
				menuul.addClass('shownav');
			}
			return(false);
		});
	}(jQuery));

(function($){
$(document).ready(sizeContent);
//Every resize of window
$(window).resize(sizeContent);
//Dynamically assign height
function sizeContent() {
    var newHeight = $(window).height() + "px";
    $(".videobg").css("height", newHeight);
}
}(jQuery));



(function($) {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
			function checkposi(e,jObj){
				var distance = $('.videobg').height() + $('.home nav').height();
				var touch = e.touches[0] || e.changedTouches[0];
				var y = touch.pageY - touch.clientY;
				
				if(y>distance) {
					$('.home nav').removeClass('navreg').addClass('navfix');
				} else {
					$('.home nav').removeClass('navfix').addClass('navreg');
				}
			}
			document.addEventListener('scroll', function(e){checkposi(e,$("html"))});
			document.addEventListener('touchstart', function(e){checkposi(e,$("html"))});
			document.addEventListener('touchmove',  function(e){checkposi(e,$("html"))});
			document.addEventListener('touchend', function(e){checkposi(e,$("html"))});
		}else{
			$(window).scroll(function() {
				var distance = $('.videobg').height() + $('.home nav').height();
				if($(this).scrollTop() > distance) {
					$('.home nav').removeClass('navreg').addClass('navfix');
				} else {
					$('.home nav').removeClass('navfix').addClass('navreg');
				}
			});
		}
	}(jQuery));
	});
})(jQuery);