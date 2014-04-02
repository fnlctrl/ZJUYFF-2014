$(window).bind('load resize',function() {
	window.H = $(window).height();
	window.W = $(window).width();
	$('.slide').height(window.H-60);
	if (window.W<850) {
		$('body').height(60+5*(window.W/16*9));
		$('body').css('overflow-y','visible');
		$('.slide').height(window.W/16*9);
		$('.slide').addClass('slide-small');
		$('.main-icon').addClass('main-icon-small');
		$('.main-title').addClass('main-title-small');
	}
	else {
		$('body').height(window.H-60);
		$('body').css('overflow','hidden');
		$('body').height(window.H);
		$('.slide-small').removeClass('slide-small');
		$('.main-icon-small').removeClass('main-icon-small');
		$('.main-title-small').removeClass('main-title-small');
	};
});
$(document).ready(function() {
	$('.slide').hover(function () {
		$('.slide-selected').removeClass('slide-selected');
		$('.main-title-selected').removeClass('main-title-selected');
		$('.main-icon-selected').removeClass('main-icon-selected');
		$(this).addClass('slide-selected');
		$(this).find('.main-title').addClass('main-title-selected');
		$(this).find('.main-icon').addClass('main-icon-selected');
	});
});