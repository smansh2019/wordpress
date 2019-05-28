(function($) {

	"use strict";

	$( document ).ready(function() {

		if ($('#wpadminbar').length > 0) {
		
			$('#header-main-fixed').css('top', $('#wpadminbar').height() + 'px');
			$('#wpadminbar').css('position', 'fixed');
		}

		$('#open-close-hdr-icon').on('click', function(e) {
      		$('#body-content-wrapper').toggleClass('header-main-fixed-closed');
    	});

    	if ( $(window).width() < 800 ) {
      		$('#open-close-hdr-icon').click();
    	}

    	$('#navmain > div > ul > li').each(
        	function() {
          		if ($(this).find('> ul.sub-menu').length > 0) {
            		$(this).prepend('<span class="sub-menu-item-toggle"></span>');
          		}
        	}
      	);

    	$('.sub-menu-item-toggle').on('click', function(e) {

			e.stopPropagation();

      		var subMenu = $(this).parent().find('> ul.sub-menu');

      		$('#navmain ul ul.sub-menu').not(subMenu).hide();
      		$('#navmain span.sub-menu-item-toggle').not(this).removeClass('sub-menu-item-toggle-expanded');
      		$(this).toggleClass('sub-menu-item-toggle-expanded');
      		subMenu.toggle();
      		subMenu.find('ul.sub-menu').toggle();
    	});

		$('#navmain > div').on('click', function(e) {
			e.stopPropagation();
			var parentOffset = $(this).parent().offset(); 
      		var relY = e.pageY - parentOffset.top;
    
      		if (relY < 36) {
        		$('ul:first-child', this).toggle(400);
      		}
		});

		$(window).scroll(function () {

			if ($(this).scrollTop() > 100) {

				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		});

		$('.scrollup').click(function () {
			
			$("html, body").animate({
				  scrollTop: 0
			  }, 600);

			return false;
		});

		if ( $(window).width() < 800 ) {
		
			$('#navmain > div > ul > li').each(
		       function() {
		         if ($(this).find('> ul.sub-menu').length > 0) {

		           $(this).prepend('<span class="sub-menu-item-toggle"></span>');
		         }
		       }
		     );

		   $('.sub-menu-item-toggle').on('click', function(e) {

		     e.stopPropagation();

		     var subMenu = $(this).parent().find('> ul.sub-menu');

		     $('#navmain ul ul.sub-menu').not(subMenu).hide();
		     $(this).toggleClass('sub-menu-item-toggle-expanded');
		     subMenu.toggle();
		     subMenu.find('ul.sub-menu').toggle();
		   });

		}

		$('#navmain > div').on('click', function(e) {

			e.stopPropagation();

			// toggle main menu
			if ( $(window).width() < 800 ) {

				var parentOffset = $(this).parent().offset(); 
				
				var relY = e.pageY - parentOffset.top;
			
				if (relY < 36) {
				
					$('ul:first-child', this).toggle(400);
				}
			}
		});
	});

})(jQuery);