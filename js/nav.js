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
});
$(window).bind('load resize',function() {
	window.h = $(window).height();
	window.w = $(window).width();
	if (window.w<850) {
		$('#nav-name').animate({right:0},{
			duration: 200,
			queue: false
		});
		$('#nav-logo').animate({
			right:0,
			marginRight:"10px"
		},{
			duration: 200,
			queue: false,
		});
		$('#nav-sections').animate({
			marginRight:"-168px"
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
			marginRight:"-24px"
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
