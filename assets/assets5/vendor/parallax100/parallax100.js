<<<<<<< HEAD
(function($){
	"use strict";
    $.fn.extend({ 
         
        parallax100: function(options) {
            var defaults = {
            	speedScroll: 3
            }
 
            var options =  $.extend(defaults, options);
 
            return this.each(function() {

            	var obj = $(this);
				var bgParallax = $(obj);
			    var posWindow = $(window).scrollTop();
			    var hWindow = $(window).height();
			    var posParallax = $(obj).offset().top;
			    var hParallax = $(obj).outerHeight();
			    var x = 0;
			    var y = options.speedScroll;

			    var setPosParallax = function() {
			        if($(window).width() > 992) {  //&& $(this).outerHeight() < $(window).height()

			            x = $(obj).offset().top - $(window).scrollTop();

			            $(bgParallax).css('background-position','center '+(x/y)+'px');
			        }
			        else {
			            $(bgParallax).css('background-position','center', '0');
			        }
			    }

			    setPosParallax();

			    $(window).on('resize', function(){
			        setPosParallax();
			    });

			    $(window).on('scroll',function(){
			        setPosParallax();
			    });

            });
        }
    });
     
=======
(function($){
	"use strict";
    $.fn.extend({ 
         
        parallax100: function(options) {
            var defaults = {
            	speedScroll: 3
            }
 
            var options =  $.extend(defaults, options);
 
            return this.each(function() {

            	var obj = $(this);
				var bgParallax = $(obj);
			    var posWindow = $(window).scrollTop();
			    var hWindow = $(window).height();
			    var posParallax = $(obj).offset().top;
			    var hParallax = $(obj).outerHeight();
			    var x = 0;
			    var y = options.speedScroll;

			    var setPosParallax = function() {
			        if($(window).width() > 992) {  //&& $(this).outerHeight() < $(window).height()

			            x = $(obj).offset().top - $(window).scrollTop();

			            $(bgParallax).css('background-position','center '+(x/y)+'px');
			        }
			        else {
			            $(bgParallax).css('background-position','center', '0');
			        }
			    }

			    setPosParallax();

			    $(window).on('resize', function(){
			        setPosParallax();
			    });

			    $(window).on('scroll',function(){
			        setPosParallax();
			    });

            });
        }
    });
     
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
})(jQuery);