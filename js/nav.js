$(document).ready(function() {
	$('body').on('click','#nav-menu-icon',function() {
		var w = $('#nav-menu').width()
		if (w==0) {
			$('#nav-menu').animate({width:150},200);
			$('#nav-menu-icon').find('path').css('fill','#ef821e');
		}
		else {
			$('#nav-menu').animate({width:0},200);
			$('#nav-menu-icon').find('path').css('fill','');
		}
	});
	$(document).click(function(e) {
		var w = $('#nav-menu').width();
		var h = $('#nav-menu').height();
		if (w>0 && !(e.pageX<w && e.pageY>60 && e.pageY<h+60)) {
			$('#nav-menu').animate({width:0}, 200);
			$('#nav-menu-icon').find('path').css('fill','');
		}
	});
	$('.comingsoon').mouseenter(function() {
		$(this).find('span').animate({top:100},{duration:200,queue:false})
		$(this).find('div').animate({top:0},{duration:200,queue:false})
	}).mouseleave(function() {
		$(this).find('span').animate({top:0},{duration:200,queue:false})
		$(this).find('div').animate({top:100},{duration:200,queue:false})
	});
});
$(window).bind('load resize',function() {
	window.H = $(window).height();
	window.W = $(window).width();
	if (window.W<850) {
		$('#nav-name').animate({right:0},{
			duration: 200,
			queue: false
		});
		$('#nav-logo').animate({
			right:0,
			marginRight:0
		},{
			duration: 200,
			queue: false,
		});
		$('#nav-sections').animate({
			marginRight:"-154px"
		},{
			duration: 200,
			queue: false,
		});
	}
	else {
		$('#nav-name').animate({right:"50%"},{
			duration: 200,
			queue: false
		});
		$('#nav-logo').animate({
			right:"50%",
			marginRight:"-30px"
		},{
			duration: 200,
			queue: false
		});
		$('#nav-sections').animate({
			marginRight:"50"
		},{
			duration: 200,
			queue: false,
		});
	}
});
