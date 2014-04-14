$(window).bind('load resize scroll',function() {
	window.H = $(window).height();
	window.W = $(window).width();
	if ($('.slide-selected').width()>$('.slide-selected').height()) {
		$('.main-bg').width($('.slide-selected').width()+100).css('height','');
	}
	else {
		$('.main-bg').height($('.slide-selected').height()+100).css('width','');
	}
	$('.slide').mouseenter(function() {
		$(this).find('.main-bg').css('transform','scale(1.05)');
	}).mouseleave(function() {
		$(this).find('.main-bg').css('transform','scale(1)');
	});
	$('.slide').click(function() {
		$('.slide-selected').removeClass('slide-selected');
		$('.main-title-selected').removeClass('main-title-selected');
		$('.main-icon-selected').removeClass('main-icon-selected');
		$(this).addClass('slide-selected');
		$(this).find('.main-title').addClass('main-title-selected');
		$(this).find('.main-icon').addClass('main-icon-selected');
		///Set z-index of main-logo-big
		if ($('#main-intro').hasClass('slide-selected')==false)　{
			$('#main-intro-logo').css('z-index',1);
		}
		else {
			$('#main-intro-logo').css('z-index',0);
		}
		$('.slide').each(function() {
			if ($(this).hasClass('slide-selected')) {
				$(this).find('.main-word').css({'width':'370px','right':'0'});
			}
			else {
				$(this).find('.main-word').css({'width':'0','right':'-100px'});
			}
		})
		//Add <a> to main-title-selected
		if ($('#main-dub').hasClass('slide-selected')) {
			$('#main-dub').find('.main-title').wrap("<a href='./dub'></a>");
			var dubHasLink = true;
		}
		else {
			if (dubHasLink) {
				$('#main-dub').find('.main-title').unwrap();
				dubHasLink = false;
			}
		}
		if ($('#main-poster').hasClass('slide-selected')) {
			$('#main-poster').find('.main-title').wrap("<a href='./poster'></a>");
			var posterHasLink = true;
		}
		else {
			if (posterHasLink) {
				$('#main-poster').find('.main-title').unwrap();
				posterHasLink = false;
			}
		}
	})
	if (window.W>850) {
		// $('.slide').animate({height:window.H-60},{duration:100,queue:false});
		$('#footer-container').height(320);
		$('#footer-column-container').width(600).css('margin-left','-300px');
		$('.slide-small').removeClass('slide-small');
		$('.main-icon-small').removeClass('main-icon-small');
		$('.main-title-small').removeClass('main-title-small');	
		if (window.H-60 > 450) {
			$('body').height(window.H+320);
			var sildeSizeUnit = (window.H-60)/110;
			if (sildeSizeUnit < 6) {
				$('#main-intro-word').css({'font-size':sildeSizeUnit*3});
				$('#main-intro-title').css({'font-size':sildeSizeUnit*10});
			}
			else {
				$('#main-intro-word').css({'font-size':'20px'});
				$('#main-intro-title').css({'font-size':'60px'});
			}
		}
		else {
			$('#main-intro-word').css({'font-size':'12px'});
			$('#main-intro-title').css({'font-size':'40px'});
			$('body').height(450+320+60);
		}
	}
	else if (window.W<850) {
		$('body').height(60+5*450+520);
		$('#footer-container').height(520);
		$('#footer-column-container').width(200).css('margin-left','-100px');
		$('.slide').addClass('slide-small');
		$('.main-icon').addClass('main-icon-small');
		$('.main-title').addClass('main-title-small');
		$('#main-intro-word').animate({'font-size':'12px'},{duration:100,queue:false});
		$('#main-intro-title').animate({'font-size':'40px'},{duration:100,queue:false});
	};
});