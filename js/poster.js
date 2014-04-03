$(document).ready(function() {
	var view = new View();
	window.onresize = view.setElement();
	view.createCurrentPoster();
	$('#main-info-submit').click(function() {
		$('#submit-container').slideDown(800);
	});

	$('#submit-back-button').click(function() {
		$('#submit-container').slideUp(800);
	});
});

function View() {
// set element width and height
	this.setElement = function() {
		this.w = $(window).width(),
		this.h = $(window).height();
		this.containerHeight = this.h-60;
		this.posterH = (this.containerHeight / 2),
		this.posterW = (this.containerHeight / 6 * 2),
		this.sw = (this.containerHeight / 3 * 2);
		this.mainInfo = $('#main-info-container');
		this.mainInfoPosition = this.mainInfo.position();

		$('#container').height(this.containerHeight);
		this.mainInfo.width(this.sw);	
		$('#submit-poster').width(this.sw);
		$('#submit-container').width(this.sw + 360);
		$('#submit-origin-poster').width(this.sw / 8 * 3).height(this.sw / 16 * 9);
	}
// insert current poster
	this.createCurrentPoster = function() {
		var currentPoster = document.createElement('img');
		$(currentPoster).height(this.containerHeight).width(this.sw);
		$(currentPoster).css({
			position: 'absolute',
			left: (this.mainInfoPosition.left - this.sw).toString() + "px",
		});
		$(currentPoster).attr({
			id: 'current-poster',
			class: 'posters',
		});
		$('#poster-container').prepend(currentPoster);
	}

	this.createPosters = function(position) {
		var posterTop = document.createElement('img'),
				posterBottom = document.createElement('img');
		$(postertop).css({
			position: 'absolute',
			left: position.toString() + "px",
			top: 0
		});
		$(posterTop).attr({
			class: 'posters',
		});

		$(posterBottom).css({
			position: 'absolute',
			left: position.toString() + "px",
			top: this.posterH.toString() + "px"
		});
		$(posterBottom).attr({
			class: 'posters',
		});
	}
}
