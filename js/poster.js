var pid = 1;
var baseUrl = 'http://localhost/ZJUYFF/';

$(document).ready(function() {
	var data = new Data(),
	    view = new View(data);
	view.setElement();
	view.createCurrentPoster();
	view.fillPosters();

	$(window).bind('load resize', function() {view.setElement();});
	$('#submit-container').submit(data.postPoster);
	$('#main-info-submit').click(view.clickSubmit);
	$('#submit-back-button').click(view.clickBack);
	$('#main-info-vote').bind('click', view.vote);
	$('#vote-submit-back').bind('click', view.voteBack);
	$('#vote-submit-button').click(view.postVote);
	$('#left-button, #right-button').bind('click', view.slide);
	$('.file').bind('change', view.showSubmitImg);
});

function View(data) {
// set element width and height
	var that = this;
	var speed = 400;
	var clock = 0;
	var star = new Array;
	var submitPartFlag = false;
	this.setElement = function() {
		this.w = $(window).width(),
		this.h = $(window).height();
		this.containerHeight = this.h - 60;
		this.posterH = (this.containerHeight / 2),
		this.posterW = (this.containerHeight / 6 * 2),
		this.sw = (this.containerHeight / 3 * 2);
		this.mainInfoPosition = $('#main-info-container').position().left;

		this.mainInfoPosition = $('#main-info-container').position().left;
		$('#main-info-container').css('left', this.mainInfoPosition.toString() + 'px');

		$('#container').height(this.containerHeight);
		$('#main-info-container').width(this.sw);	
		$('#submit-container').width(this.mainInfoPosition);
		$('#submit-poster').width(this.posterW).height(this.posterH).css('left', (this.mainInfoPosition - this.posterW).toString() + 'px');
		$('#submit-origin-poster').width(this.posterW).height(this.posterH);
	}

	this.clickSubmit = function() {
		if (submitPartFlag == false) {
			var current = $('#main-info-content');
			var next = $('#main-submit-info');
			$('#submit-container').animate({height: '100%'}, 500);
			$(this).text('返回');
			submitPartFlag = true;
		}
		else {
			var next = $('#main-info-content');
			var current = $('#main-submit-info');
			$('#submit-container').animate({height: '0'}, 500);
			$(this).text('我要参加');
			submitPartFlag = false;
		}
		current.animate({left: 300, opacity: 0}, speed * 1.2);
		next.animate({left: 0, opacity: 1}, speed * 1.2);
	}

	this.clickBack = function() {
		$('#main-info').fadeIn('200', function() {
			$('#main-submit-info').fadeOut(200);
		});
		$('#submit-container').slideUp(800);
	}

	this.showSubmitImg = function() {
		var oFReader = new FileReader();
		var itself = this;
		oFReader.onload = function (oFREvent) {
		  $(itself).next().attr('src', oFREvent.target.result);
		};
		
		if (this.files.length === 0) { return; }
		var oFile = this.files[0];
		if (!oFile.type.match('image.jpeg')) { 
			alert("请选择JPG格式"); 
			oFile = {};
			this.value = null;
			return; 
		}
		oFReader.readAsDataURL(oFile);
	}

	this.fillPosters = function() {
		// create posters on the left
		var leftPosition = this.mainInfoPosition - this.sw,
				leftCount = parseInt(leftPosition / this.posterW) + 1;
		for (var i = 0; i<leftCount; i++) {
			leftPosition -= this.posterW;
			this.createPosters(leftPosition, 'left');
		}
		// create posters on the right
		var rightPosition = this.mainInfoPosition + this.sw,
		    rightCount = parseInt((this.w - rightPosition) / this.posterW) + 1;
		for (var i = 0; i<rightCount; i++) {
				this.createPosters(rightPosition, 'right');
			rightPosition += this.posterW;
		}
	}

// insert current poster
	this.createCurrentPoster = function() {
		var posterData = data.getPoster();
		var currentPoster = document.createElement('div'),
				currentImg = document.createElement('img'),
				currentHover = document.createElement('div'),
				currentTitle = document.createElement('div');
		$(currentPoster).data(posterData);
		$(currentPoster).height(this.containerHeight).width(this.sw);
		$(currentPoster).css({
			position: 'absolute',
			left: (this.mainInfoPosition - this.sw).toString() + 'px',
		});
		$(currentPoster).attr({
			id: 'current-poster',
			class: 'posters'
		});
		$('#poster-container').prepend(currentPoster);

		$(currentImg).attr('src', 'img/1.jpg').width('100%').height('100%');
		$(currentPoster).append(currentImg);

		$(currentHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover').css({
				background: '#000',
				opacity: '0',
				bottom: 0,
				position: 'absolute'
		});
		$(currentPoster).prepend(currentHover);

		$(currentTitle).text('<' + 'Film Name' + '>').css({
				'font-size': '20px',
				'font-weight': 'bold',
				position: 'absolute',
				top: '40%',
				'text-align': 'center',
				width: '100%'
		});
		$(currentHover).prepend(currentTitle);
		$(currentPoster).bind('mouseenter', currentHover, that.posterOver);
		$(currentPoster).bind('mouseleave', currentHover, that.posterOut);
		$(currentPoster).bind('click', that.posterClick);
	}

	this.createPosters = function(position, dir) {
			var posterTop = document.createElement('div'),
					posterBottom = document.createElement('div'),
					posterTopImg = document.createElement('img'),
					posterBottomImg = document.createElement('img'),
					posterTopHover = document.createElement('div'),
					posterBottomHover = document.createElement('div'),
					posterTopTitle = document.createElement('div'),
					posterBottomTitle = document.createElement('div');
		// main div
			$(posterTop).width(this.posterW).height(this.posterH);
			$(posterBottom).width(this.posterW).height(this.posterH);
			$(posterTop).css({
				position: 'absolute',
				left: position.toString() + 'px',
				top: 0
			});
			$(posterTop).attr({
				class: 'posters'
			});
	
			$(posterBottom).css({
				position: 'absolute',
				left: position.toString() + 'px',
				top: this.posterH.toString() + 'px'
			});
			$(posterBottom).attr({
				class: 'posters'
			});
			if (dir == 'right')
				$('#poster-container').append(posterTop).append(posterBottom);
			else 
				$('#poster-container').prepend(posterBottom).prepend(posterTop);
		// img div
			$(posterTopImg).attr('src', 'img/1.jpg').width('100%').height('100%');
			$(posterBottomImg).attr('src', 'img/1.jpg').width('100%').height('100%');
			$(posterTop).append(posterTopImg);
			$(posterBottom).append(posterBottomImg);
		// hover div
			$(posterTopHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover').css({
				background: '#000',
				opacity: '0',
				bottom: 0,
				position: 'absolute'
			});
			$(posterBottomHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover').css({
				background: '#000',
				opacity: '0',
				bottom: 0,
				position: 'absolute'
			});
			$(posterTop).prepend(posterTopHover);
			$(posterBottom).prepend(posterBottomHover);
		// hover title div
			$(posterTopTitle).text('<' + 'Film Name' + '>').css({
				'font-size': '20px',
				'font-weight': 'bold',
				position: 'absolute',
				top: '40%',
				'text-align': 'center',
				width: '100%'
			});
			$(posterBottomTitle).text('<' + 'Film Name' + '>').css({
				'font-size': '20px',
				'font-weight': 'bold',
				position: 'absolute',
				top: '40%',
				'text-align': 'center',
				width: '100%'
			});
			$(posterTopHover).prepend(posterTopTitle);
			$(posterBottomHover).prepend(posterBottomTitle);

			$(posterTop).bind('mouseenter', posterTopHover, that.posterOver);
			$(posterBottom).bind('mouseenter', posterBottomHover, that.posterOver);
			$(posterTop).bind('mouseleave', posterTopHover, that.posterOut);
			$(posterBottom).bind('mouseleave', posterBottomHover, that.posterOut);
			$(posterTop).bind('click', that.posterClick);
			$(posterBottom).bind('click', that.posterClick);
	}

	this.posterOver = function(e) {
		if ($(this).height() <= that.posterH + 1)
		$(e.data).animate({opacity: 0.4}, speed / 2);
	}

	this.posterOut = function(e) {
		$(e.data).animate({opacity: 0}, speed / 2);
	}

	this.showMainInfo = function() {
		$('.posters').each(function(index) {
			var left = $(this).position().left;
			if (left>that.mainInfoPosition-that.posterW)
				$(this).animate({left: '+=' + that.sw}, speed);
		});
		$('#main-info-container').css('display', 'block');
	}

	this.vote = function() {
		$('.poster-button').fadeIn(400);
		$('#main-info').fadeOut(400);
		$('#vote-container').animate({left: 0}, 400);
		that.voteStar();
		that.refreshVote($('#current-poster').data('id'));
	}

	this.voteBack = function() {
		$('.poster-button').fadeOut(400);
		$('#main-info').fadeIn(400);
		$('#vote-container').animate({left: -400}, 400);

	}

	this.slide = function() {
		// judge if the first click
		if (that.clock == 1) return;
		that.clock = 1;
		if ($('#main-info-container').css('display') !== 'none') {
			if (this.id == 'left-button')
				that.slideInitial('left', speed);
			else
				that.slideInitial('right', speed);
			return;
		}
		// create firstly, move secondly
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
				$(this).animate({
					left: '+=' + that.posterW}, 
					speed,
					function() {
						that.clock = 0;
				});
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
				$(this).animate({
					left: '-=' + that.posterW}, 
					speed,
					function() {
						that.clock = 0;
				});
			});
		}
	}

	this.slideInitial = function(dir ,speed) {
		if (dir == 'left') {
			var left = $('.posters').first().position().left;
			if (left + 2 * that.sw>=0) {
				left -= that.posterW;
				that.createPosters(left, 'left');
				left -= that.posterW;
				that.createPosters(left, 'left');
			}
			$('.posters').each(function() {
				var left = $(this).position().left;
				if (left<=that.mainInfoPosition)
					$(this).animate({
						left: '+=' + that.sw}, 
						speed,
						function() {
							that.clock = 0;
					});
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
				if (left>that.mainInfoPosition)
					$(this).animate({
						left: '-=' + that.sw}, 
						speed,
						function() {
							that.clock = 0;
						});
			});
		}
		setTimeout(function() {
			$('#main-info-container').css('display', 'none');
		}, speed);
	}

	this.posterClick = function() {
		if ($(this).attr('id') === 'current-poster')
			return;
		var itself = this,
		    id = 1;
		var left = $(this).position().left;
		if ($('#current-poster').position().left < left) {
			if (left >= that.mainInfoPosition-2 && left <= that.mainInfoPosition) 
				$('.posters').animate({
					left: '-=' + that.posterW},
					speed
				);
		}
		else {
			if (left < that.mainInfoPosition && left > that.mainInfoPosition - that.sw)
				$('.posters').animate({
					left: '-=' + that.posterW},
					speed
				);
		}
		that.refreshVote(id);

		$(this).filter('.poster-hover').delay(speed).animate({opacity: 0}, speed / 2);
		setTimeout(function() {
			that.clickSlide(itself);
		}, speed);
	}

	this.clickSlide =	function(itself) {
		var posters = $('.posters'),
		    currentPoster = $('#current-poster')[0];
		var top = $(itself).position().top,
		    left = $(itself).position().left,
		    h = $(itself).height(),
		    w = $(itself).width();

		for (var i = 0; i<posters.length; i++) {
			if (posters[i] === itself)
				var index = i;
			if (posters[i] === currentPoster)
				currentPoster = i;
		}

		if (top == 0) {
			if ($('#current-poster').position().left < left) {
				$(itself).animate({
					width: w * 2,
					height: h * 2,
					left: '-=' + that.posterW}, 
					speed
				);
				$('#current-poster').animate({
					width: w,
					height: h},
					speed
				);
				// 判断main-info 是否在两者之间
				if ($('#main-info-container').css('display') != 'none' && $('#current-poster').position().left < that.mainInfoPosition && that.mainInfoPosition < left) {
					for (var i = currentPoster+1; i< index; i++) {
						if ($(posters[i]).position().left < that.mainInfoPosition)
							if ($(posters[i]).position().top == 0)
								$(posters[i]).animate({left: '-=' + that.posterW}, speed);
							else {
								$(posters[i]).animate({left: '-=' + that.sw}, speed);
								$(posters[i-1]).before(posters[i]);
							}
						else {
							if ($(posters[i]).position().top == 0)
								$(posters[i]).animate({left: '-=' + (that.posterW + that.sw)}, speed);
							else {
								$(posters[i]).animate({left: '-=' + (2 * that.sw)}, speed);
								$(posters[i-1]).before(posters[i]);
							}
						}
					}
					if (left > that.mainInfoPosition && left <= that.mainInfoPosition + that.sw)
						$(posters).animate({left: '+=' + that.posterW}, speed);
					$(itself).next().animate({left: '-=' + (2 * that.sw)}, speed);
				}
				else {
					for (var i = currentPoster+1; i< index; i++) {
						if ($(posters[i]).position().top == 0)
							$(posters[i]).animate({left: '-=' + that.posterW}, speed);
						else {
							$(posters[i]).animate({left: '-=' + that.sw}, speed);
							$(posters[i-1]).before(posters[i]);
						}
					}
					$(itself).next().animate({left: '-=' + that.sw}, speed);
				}

				$(itself).before($(itself).next()[0]);
			}
			else {
				$(itself).animate({
					width: w * 2,
					height: h * 2,}, 
					speed
				);
				$('#current-poster').animate({
					width: w,
					height: h,
					left: '+=' + that.posterW},
					speed
				);
				// 判断main-info 是否在两者之间
				if ($('#main-info-container').css('display') != 'none' && $('#current-poster').position().left > that.mainInfoPosition && that.mainInfoPosition > left) {
					for (var i = index+1; i<currentPoster; i++) {
						if ($(posters[i]).position().left > that.mainInfoPosition) {
							if ($(posters[i]).position().top == 0) {
								$(posters[i]).animate({left: '+=' + that.posterW}, speed);
								$(posters[i-1]).before(posters[i]);
							}
							else 
								$(posters[i]).animate({left: '+=' + that.sw}, speed);
						}
						else {
							if ($(posters[i]).position().top == 0) {
								$(posters[i]).animate({left: '+=' + (that.posterW + that.sw)}, speed);
								$(posters[i-1]).before(posters[i]);
							}
							else 
								$(posters[i]).animate({left: '+=' + 2 * that.sw}, speed);
						}
					}
				}
				else {
					for (var i = index+1; i<currentPoster; i++) {
						if ($(posters[i]).position().top == 0) {
							$(posters[i]).animate({left: '+=' + that.posterW}, speed);
							$(posters[i-1]).before(posters[i]);
						}
						else 
							$(posters[i]).animate({left: '+=' + that.sw}, speed);
					}
				}

				$(posters[currentPoster-1]).before(posters[currentPoster]);
			}
		}
		else {
			if ($('#current-poster').position().left < left) {
				$(itself).animate({
					width: w * 2,
					height: h * 2,
					left: '-=' + that.posterW,
					top: '-=' + that.posterH}, 
					speed
				);
				$('#current-poster').animate({
					width: w,
					height: h,
					top: '+=' + that.posterH},
					speed
				);
				// 判断main-info 是否在两者之间
				if ($('#main-info-container').css('display') != 'none' && $('#current-poster').position().left < that.mainInfoPosition && that.mainInfoPosition < left) {
					for (var i = currentPoster+1; i< index; i++) {
						if ($(posters[i]).position().left < that.mainInfoPosition) {
							if ($(posters[i]).position().top == 0) {
								$(posters[i]).animate({left: '-=' + that.sw}, speed);
								$(posters[i-1]).before(posters[i]);
							}
							else 
								$(posters[i]).animate({left: '-=' + that.posterW}, speed);
						}
						else {
							if ($(posters[i]).position().top == 0) {
								$(posters[i]).animate({left: '-=' + 2 * that.sw}, speed);
								$(posters[i-1]).before(posters[i]);
							}
							else 
								$(posters[i]).animate({left: '-=' + (that.posterW + that.sw)}, speed);
						}
					}
					if (left > that.mainInfoPosition && left <= that.mainInfoPosition + that.sw)
						$(posters).animate({left: '+=' + that.posterW}, speed);
				}
				else {
					for (var i = currentPoster+1; i< index; i++) {
						if ($(posters[i]).position().top == 0) {
							$(posters[i]).animate({left: '-=' + that.sw}, speed);
							$(posters[i-1]).before(posters[i]);
						}
						else 
							$(posters[i]).animate({left: '-=' + that.posterW}, speed);
					}
				}
			}
			else {
				$(itself).animate({
					width: that.sw,
					height: that.containerHeight,
					top: '-=' + that.posterH}, 
					speed
				);
				$('#current-poster').animate({
					width: that.posterW,
					height: that.posterH,
					top: '+=' + that.posterH,
					left: '+=' + that.posterW},
					speed
				);
				// 判断main-info 是否在两者之间
				if ($('#main-info-container').css('display') != 'none' && $('#current-poster').position().left > that.mainInfoPosition && that.mainInfoPosition > left) {
					for (var i = index+1; i<currentPoster; i++) {
						if ($(posters[i]).position().left > that.mainInfoPosition) {
							if ($(posters[i]).position().top == 0) {
								$(posters[i]).animate({left: '+=' + that.sw}, speed);
							}
							else {
								$(posters[i]).animate({left: '+=' + that.posterW}, speed);
								$(posters[i-1]).before(posters[i]);
							}
						}
						else {
								if ($(posters[i]).position().top == 0) {
								$(posters[i]).animate({left: '+=' + 2 * that.sw}, speed);
							}
							else {
								$(posters[i]).animate({left: '+=' + (that.posterW + that.sw)}, speed);
								$(posters[i-1]).before(posters[i]);
							}
						}
					}
					$(itself).prev().animate({left: '+=' + 2 * that.sw}, speed);
				}
				else {
					for (var i = index+1; i<currentPoster; i++) {
						if ($(posters[i]).position().top == 0) {
							$(posters[i]).animate({left: '+=' + that.sw}, speed);
						}
						else {
							$(posters[i]).animate({left: '+=' + that.posterW}, speed);
							$(posters[i-1]).before(posters[i]);
						}
					}
				}
				$(itself).prev().animate({left: '+=' + that.sw}, speed);
				$(posters[index-1]).before(posters[index]);
			}
		}
		if ($('#main-info-container').css('display') == 'none')
			setTimeout(that.showMainInfo, speed);
		$('#current-poster').removeAttr('id');
		$(itself).attr('id', 'current-poster');
	}

	this.voteStar = function() {
		for (var i = 1; i<=5; i++) {
			star[i] = $('#vote-s' + i + ' .star');
			for (var j = 0; j<5; j++) {
				$(star[i][j]).bind('mouseover', {i: i, j: j}, hover);
				$(star[i][j]).bind('mouseout', {i: i, j: j}, clear);
				$(star[i][j]).bind('click', {i: i, j: j}, click);
			}
		}

		function hover(e)  {
			clear(e);
			for (var j = 0; j<=e.data.j; j++)
				$(star[e.data.i][j]).find('path').attr('fill', '#1dade5').attr('stroke', '#1dade5');
		}
		function clear(e) {
			for (var j = data.vote[e.data.i - 1]; j<5; j++)
				$(star[e.data.i][j]).find('path').attr('fill', 'rgba(0,0,0,0)').attr('stroke', 'white');
		}
		function click(e) {
			data.vote[e.data.i - 1] = e.data.j + 1;
		}
	}

	this.refreshVote = function(id) {
		data.vote['id'] = id;
		$('#vote-id').val('');
		for (var i = 0; i<5; i++)
			data.vote[i] = 0;
		for (var i = 1; i<=5; i++) 
			for (var j = 0; j<5; j++) 
				$(star[i][j]).find('path').attr('fill', 'rgba(0,0,0,0)').attr('stroke', 'white');
	}
	
	this.postVote = function() {
		var id = $('#vote-id').val();
		if (id.length != 10)
			alert("请填写正确的学号");
		else data.postVote();
	}
}

function Data() {
	var that = this;
	this.posterData = {};
	this.vote = [0, 0, 0, 0, 0];
	this.vote.id = 2;

	this.postPoster = function(e) {
		e.preventDefault();
		var settings = {
			target: "#submit-container",
			method: 'POST',
			url: baseUrl + 'upload.php',
			dataType: 'json'
		};
		$('#submit-container').ajaxSubmit(settings);
	}

	this.getPoster = function() {
		var settings = {
			type: 'GET',
			url: baseUrl + 'getinfo.php?id=' + pid,
			dataType: 'json',
			success: function(data) {
				that.posterData = data;
				that.posterData.status = 'success';
				return that.posterData;
			},
			error: function() {
				that.posterData = {};
				that.posterData.status = 'error';
			}
		};
		return $.ajax(settings);
	}

	this.postVote = function() {
		var settings = {
			type: 'POST',
			url: baseUrl + 'score.php',
			dataType: 'json',
			data: {
				id: that.vote['id'],
				s1: that.vote[0],
				s2: that.vote[1],
				s3: that.vote[2],
				s4: that.vote[3],
				s5: that.vote[4],
				stuid: $('#vote-id').val()
			}
		};
		$.ajax(settings);
	}
}