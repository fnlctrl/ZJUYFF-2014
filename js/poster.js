$(document).ready(function() {
	var view = new View();
	view.setElement();
	view.createCurrentPoster();
	view.fillPosters();
	$(window).bind('load resize', function() {
		view.setElement();
	});
	$('#main-info-submit').click(function() {
		$('#submit-container').slideDown(800);
	});

	$('#submit-back-button').click(function() {
		$('#submit-container').slideUp(800);
	});

	$('#main-info-vote').bind('click', function() {
		$('.poster-button').fadeIn(400);
	});
	$('#left-button, #right-button').bind('click', view.slide);
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
		this.mainInfoPosition = $('#main-info-container').position().left;
		$('#main-info-container').css('left', this.mainInfoPosition.toString() + 'px');

		$('#container').height(this.containerHeight);
		$('#main-info-container').width(this.sw);	
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
		var leftPosition = $('.posters').first().position().left - this.sw,
				leftCount = parseInt(leftPosition / this.posterW) + 1;
		for (var i = 0; i<leftCount; i++) {
			leftPosition -= this.posterW;
			this.createPosters(leftPosition, 'left');
		}
		// create posters on the right
		var rightPosition = this.mainInfoPosition+ this.sw,
		    rightCount = parseInt((this.w - rightPosition) / this.posterW) + 1;
		for (var i = 0; i<rightCount; i++) {
				this.createPosters(rightPosition, 'right');
			rightPosition += this.posterW;
		}
	}

	this.createPosters = function(position, dir) {
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
		if (dir == 'right')
			$('#poster-container').append(posterTop).append(posterBottom);
		else 
			$('#poster-container').prepend(posterTop).prepend(posterBottom);
	}

	this.showMainInfo = function() {
		$('.posters').each(function(index) {
			var left = $(this).position().left;
			if (left>that.mainInfoPosition)
				$(this).animate({left: '+=' + that.sw}, 800);
		});
		$('#main-info-container').animate({
				left: '+=' + that.sw}, 
				800,
				function() {
					$('#main-info-container').css('display', 'block');
		});
	}

	this.hideMainInfo = function() {
		$('#main-info-container').css({
			left: '-=' + that.sw,
			display: 'none'
		});
	}

	this.slide = function() {
		var speed = 800;
		if (this.id == 'left-button') {
			var left = $('.posters').first().position().left;
			if (left + 2 * that.sw>=0) {
				left -= that.posterW;
				that.createPosters(left, 'left');
				left -= that.posterW;
				that.createPosters(left, 'left');
			}
			$('.posters').each(function(index) {
				var left = $(this).position().left;
				$(this).animate({left: '+=' + that.sw}, speed);
			});
		}
		else {
			var right = $('.posters').last().position().left + that.posterW;
				if (right - that.sw<that.w) {
					that.createPosters(right, 'right');
					right += that.posterW;
					that.createPosters(right, 'right');
				}
			$('.posters').each(function() {
				var left = $(this).position().left;
				$(this).animate({left: '-=' + that.sw}, speed);
			});
		}
		setTimeout(function() {
			if ($('#main-info-container').css('display') !== 'none')
			that.hideMainInfo();
		}, speed)
	}


}
