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
	//Dynamically assign height
	function sizeContent() {
		var newHeight = $(window).height() + "px";
		$(".banner-container").css("height", newHeight);
		$("#videobg" ).css('height',newHeight );
	}

	$(document).ready(function() {
		var newHeight = $(window).height() + "px";
		$(".banner-container").css("height", newHeight);
		$('#' + window.wsu_video_background.id).css('height', newHeight ).videoBG({
			mp4: window.wsu_video_background.mp4,
			ogv: window.wsu_video_background.ogv,
			webm: window.wsu_video_background.webm,
			poster: window.wsu_video_background.poster,
			scale: window.wsu_video_background.scale,
			zIndex: window.wsu_video_background.zIndex
		});
		//Every resize of window
		$(window).resize(sizeContent);
	});
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