$(window).bind('load resize',function() {
	window.H = $(window).height();
	window.W = $(window).width();
	$('.slide').height(window.H-60);
	if (window.W<850) {
		$('body').height(60+5*(window.W/16*9)+520);
		$('#footer-container').height(520);
		$('#footer-column-container').width(200).css('margin-left','-100px');
		$('.slide').height(window.W/16*9);
		$('.slide').addClass('slide-small');
		$('.main-icon').addClass('main-icon-small');
		$('.main-title').addClass('main-title-small');
		$('#main-intro-word').animate({'font-size':'12px'},{duration:100,queue:false});
		$('#main-intro-title').animate({'font-size':'40px'},{duration:100,queue:false});
		$('.slide').click(function (){});
	}
	else if (window.W>850) {
		$('body').height(window.H+300);
		$('#footer-container').height(300);
		$('#footer-column-container').width(600).css('margin-left','-300px');
		$('#main-container').height(window.H-60);
		$('.slide-small').removeClass('slide-small');
		$('.main-icon-small').removeClass('main-icon-small');
		$('.main-title-small').removeClass('main-title-small');	
		if (window.H-60 > 450) {
			var sildeSizeUnit = (window.H-60)/100;
			if (sildeSizeUnit<6) {
				$('#main-intro-word').animate({'font-size':sildeSizeUnit*3},{duration:100,queue:false});
				$('#main-intro-title').animate({'font-size':sildeSizeUnit*10},{duration:100,queue:false});
			}
			else {
				$('#main-intro-word').animate({'font-size':'20px'},{duration:100,queue:false});
				$('#main-intro-title').animate({'font-size':'60px'},{duration:100,queue:false});
			}
		}
		else {
			$('#main-intro-word').animate({'font-size':'12px'},{duration:100,queue:false});
			$('#main-intro-title').animate({'font-size':'40px'},{duration:100,queue:false});
		}
		$('.slide').click(function () {
			$('.slide-selected').removeClass('slide-selected');
			$('.main-title-selected').removeClass('main-title-selected');
			$('.main-icon-selected').removeClass('main-icon-selected');
			$(this).addClass('slide-selected');
			$(this).find('.main-title').addClass('main-title-selected');
			$(this).find('.main-icon').addClass('main-icon-selected');
		});
	};
});