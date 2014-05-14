var clicked = false, clickX;
$(document).on({
    'mousemove': function(e) {
        clicked && updateScrollPos(e);
    },
    'mousedown': function(e) {
        clicked = true;
        clickX = e.pageX;
        $('html').css('cursor', 'move');
    },
    'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
    }
});
var updateScrollPos = function(e) {
    $('html').css('cursor', 'move');
    $(window).scrollLeft($(window).scrollLeft() + (clickX - e.pageX));
}
//
var resize = function() {
	window.W = $(window).width();
	window.H = $(window).height();
	$('.main-event').each(function() {
		var array = [];
			$(this).find('.main-text').children('h1, p').each(function() {
				array.push($(this).width());
			});
			window.textWidth = Math.max.apply(null, array);
		if ($(this).children('img').length>0) {
			window.imageWidth = window.H * 0.42;
			$(this).width(window.imageWidth + window.textWidth + 30);
		}
		else {
			$(this).width(window.textWidth);
		}
	});
}
$(document).ready(function() {
	setTimeout(resize,50);
})
$(window).bind('resize',function() {
	resize();
})