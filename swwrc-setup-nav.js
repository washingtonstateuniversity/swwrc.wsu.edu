(function($){
		/**
		 * Sets up navigation system
		 */
		setup_nav = function(){
			// NAVIGATION
			// Tag location and hierarchy
			$(".main-menu ul,.main-menu ul").parents("li").addClass("parent");

			// Use "current" or "active" on active li elements. Parents of these elements will automatically
			// receive the "active" class. We check wildcards to accommodate inflexible platforms.
			$(".main-menu li[class*=current], .main-menu li[class*=active]").addClass("active").parents("li").addClass("active");
			$(".main-menu li a[class*=current], .main-menu li a[class*=active]").parents("li").addClass("active");

			$(".main-menu .active:not(:has(.active))").addClass("dogeared");

			// Couplets
			$(".main-menu li.parent > a").each( function() {
				var tar, title, classes, url;
				tar=$(this);

				title = ( tar.is("[title]")  ) ? tar.attr("title") : "Overview";
				title = ( tar.is("[data-overview]") ) ?tar.data("overview") : title;
				title = title.length > 0 ? title : "Overview"; // this is just triple checking that a value made it here.

				classes = "overview";
				if (tar.closest(".parent").is(".dogeared")) {
					classes += " dogeared";
				}
				url = tar.attr("href");
				if ( url !== "#" ) {
					tar.parent("li").children("ul").prepend("<li class='" + classes + "'></li>");
					tar.clone(true,true).appendTo( tar.parent("li").find("ul .overview:first") );
					tar.parent("li").find("ul .overview:first a").html(title);
				}

				// Disclosure
				tar.on("click",function(e) {
					e.preventDefault();
					tar.parent("li").siblings().removeClass("opened");
					tar.parent("li").toggleClass("opened");
				});

			});
			// External Links in nav
			$(".spine-navigation a[href^='http']:not([href*='"+window.location.hostname+"'])").addClass("external");

		}

		// swwrc_setup_nav is now available globally.
		window.setup_nav = swwrc_setup_nav;
})(jQuery);