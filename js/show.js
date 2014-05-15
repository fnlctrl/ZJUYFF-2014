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
var setTextWidth = function() {
	$('.slide').each(function() {
		var imgWidth = $(this).find('img').width();
		$(this).find('.main-text').width(1000 - imgWidth - 150);
	});
}
var setInfoPos = function() {
	var imageWidth = $('.main-poster').width();
	$('.main-info').each(function() {
		$(this).width(imageWidth - 40).css({'bottom':-$(this).height()});
	})
}
$(window).bind('load resize scroll',function() {
	window.H = $(window).height();
	window.W = $(window).width();
	$('#main-container').height(window.H - 60);
	setTimeout(function() {
		setInfoPos();
		setTextWidth();
	},10);
	$('.slide').click(function() {
		$('.slide-selected').removeClass('slide-selected');
		$('.main-title-selected').removeClass('main-title-selected');
		$('.main-icon-selected').removeClass('main-icon-selected');
		$(this).addClass('slide-selected');
		$(this).find('.main-title').addClass('main-title-selected');
		$(this).find('.main-icon').addClass('main-icon-selected');
		$('.slide').each(function() {
			if ($(this).hasClass('slide-selected')) {
				$(this).find('.shade').css('opacity',0);
			}
			else {
				$(this).find('.shade').css('opacity',1);
			}
		})
		if ($('#main-truffaut').hasClass('slide-selected')) {
			$('#main-truffaut-text').css('opacity',1);
		}
		else {
			$('#main-truffaut-text').css('opacity',0);
		}
		$('.slide-selected').mouseover(function(event){
			if ($(this).attr('id') != 'main-truffaut') {
				var $this = $(this);
				var $poster = $(this).find('.main-poster');
				var $info = $(this).find('.main-info');
				var x1 = $poster.offset().left;
				var x2 = x1 + $poster.width();
				var y1 = 60;
				if ((event.pageX > x1) & (event.pageX < x2) & (event.pageY > y1)) {
					$info.css({'bottom':'0'});
				}
				else {
					$info.css({'bottom':-$info.height()});
			}
		}
		}).mouseleave(function() {
			var $this = $(this)
			var $poster = $(this).find('.main-poster');
			var $info = $(this).find('.main-info');
			$info.css('bottom',-$info.height());
		})
	})
	//
	// if (window.H > 900) {
	// 	$('#main-truffaut-bg').css('top',0);
	// }
	// else {
	// 	$('#main-truffaut-bg').css('top','-50%');
	// }
});