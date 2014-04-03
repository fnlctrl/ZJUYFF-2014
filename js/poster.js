$(document).ready(function() {
	var view = new View();
	view.setElement();
	window.onresize = view.setElement;
	view.createCurrentPoster();
	view.fillPosters();
	$('#main-info-submit').click(function() {
		$('#submit-container').slideDown(800);
	});

	$('#submit-back-button').click(function() {
		$('#submit-container').slideUp(800);
	});

	$('#main-info-vote').bind('click', view.hideMainInfo);
	$('#left-button').bind('click', view.slide);
	$('#right-button').bind('click', view.slide);
});

function View() {
// set element width and height
	var that = this;
	this.setElement = function() {
		this.w = $(window).width(),
		this.h = $(window).height();
		this.containerHeight = this.h-60;
		this.posterH = (this.containerHeight / 2),
		this.posterW = (this.containerHeight / 6 * 2),
		this.sw = (this.containerHeight / 3 * 2);
		this.mainInfo = $('#main-info-container');
		this.mainInfoPosition = this.mainInfo.position().left;
		this.mainInfo.css('left', this.mainInfoPosition.toString() + 'px');

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
			left: (this.mainInfoPosition - this.sw).toString() + 'px',
		});
		$(currentPoster).attr({
			id: 'current-poster',
			class: 'posters',
			/******test code******/
			src: './img/1.jpg' 
			/******test code******/
		});
		$('#poster-container').prepend(currentPoster);
	}

	this.fillPosters = function() {
		// create posters on the left
		var leftPosition = this.mainInfoPosition - this.sw,
				leftCount = parseInt(leftPosition / this.posterW) + 1;
		for (var i = 0; i<leftCount; i++) {
			leftPosition -= this.posterW;
			var posters = this.createPosters(leftPosition);
			$('#poster-container').prepend(posters.top).prepend(posters.bottom);
		}
		// create posters on the right
		var leftPosition = this.mainInfoPosition + this.sw,
		    rightCount = parseInt((this.w - leftPosition) / this.posterW) + 1;
		for (var i = 0; i<rightCount; i++) {
			var posters = this.createPosters(leftPosition);
			$('#poster-container').append(posters.top).append(posters.bottom);
			leftPosition += this.posterW;
		}
	}

	this.createPosters = function(position) {
		var posterTop = document.createElement('img'),
				posterBottom = document.createElement('img');
		$(posterTop).width(this.posterW).height(this.posterH);
		$(posterBottom).width(this.posterW).height(this.posterH);
		$(posterTop).css({
			position: 'absolute',
			left: position.toString() + 'px',
			top: 0
		});
		$(posterTop).attr({
			class: 'posters',
		});

		$(posterBottom).css({
			position: 'absolute',
			left: position.toString() + 'px',
			top: this.posterH.toString() + 'px'
		});
		$(posterBottom).attr({
			class: 'posters',
		});
		return {
			top: posterTop, 
			bottom: posterBottom
		}
	}

	this.hideMainInfo = function() {
		$('.posters').each(function(index) {
			var left = $(this).position().left;
			if (left>that.mainInfoPosition)
				$(this).animate({left: '-=' + that.sw}, 1000);
		});
		$('#main-info-container').animate({left: '-=' + that.sw}, 1000);
	}

	this.slide = function() {
		if (this.id == 'left-button')
			$('.posters').each(function(index) {
				var left = $(this).position().left;
				$(this).animate({left: '+=' + that.posterW}, 1000);
			});
		else
			$('.posters').each(function() {
				var left = $(this).position().left;
				$(this).animate({left: '-=' + that.posterW}, 1000);
			});
	}
}
