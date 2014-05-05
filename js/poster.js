var pid = 0;
var baseUrl = '';

$(document).ready(function() {
	var data = new Data(),
	    view = new View(data);

	$(window).bind('load resize', function() {
		view.setElement();
		view.fillPosters();
	});
	$('#submit-container').submit(data.postPoster);
	$('#main-info-submit').bind('click', view.clickSubmit);
	$('#main-info-vote').bind('click',view.vote)
	$('#vote-submit-back').bind('click', view.voteBack);
	$('#vote-submit').bind('click', view.postVote);
	$('#left-button, #right-button').bind('click', view.slide);
	$('#scale-button').bind('click', view.scale);
	$('.file').bind('change', view.showSubmitImg);
});

function View(data) {
// set element width and height
	var that = this;
	var speed = 200;
	var moveSpeed = 120;
	var lock = 0;
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

		
		$('#full-screen-container').width(2 * that.sw + 20);
		$('#scale-button').css('left', that.mainInfoPosition - 90);
		$('#submit-container').width(this.mainInfoPosition);
		$('#submit-poster').width(this.posterW).height(this.posterH).css('left', (this.mainInfoPosition - this.posterW).toString() + 'px');
		$('#submit-origin-poster').width(this.posterW).height(this.posterH);
		if (window.global_cfg.userobj)
			$('#vote-submit').text('提交');
		else
			$('#vote-submit').text('登录');
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

	this.showSubmitImg = function() {
		var oFReader = new FileReader();
		var itself = this;
		oFReader.onload = function (oFREvent) {
		  $(itself).next().attr('src', oFREvent.target.result);
		};

		if (this.files.length === 0) { return; }
		var oFile = this.files[0];
		if (!oFile.type.match('image')) { 
			showNotice("请选择JPG格式图片"); 
			oFile = {};
			this.value = null;
			return; 
		}
		oFReader.readAsDataURL(oFile);
	}

	this.fillPosters = function() {
		// create posters on the left
		pid = 0;
		$('.posters').remove();
		that.createCurrentPoster();
		var leftPosition = that.mainInfoPosition - that.sw,
				leftCount = parseInt(leftPosition / that.posterW) + 1;
		for (var i = 0; i<leftCount; i++) {
			leftPosition -= that.posterW;
			that.createBottomPosters(leftPosition, 'left');
			that.createTopPosters(leftPosition, 'left');
		}
		// create posters on the right
		var rightPosition = that.mainInfoPosition + 400,
		    rightCount = parseInt((that.w - rightPosition) / that.posterW) + 1;
		for (var i = 0; i<rightCount; i++) {
			that.createTopPosters(rightPosition, 'right');
			that.createBottomPosters(rightPosition, 'right');
			rightPosition += that.posterW;
		}
	}

// insert current poster
	this.createCurrentPoster = function() {
		var currentPoster = document.createElement('div'),
				currentImg = document.createElement('img'),
				currentHover = document.createElement('div'),
				currentTitle = document.createElement('div');
		$(currentPoster).data('data', data.posterData[pid]);
		that.insertCurrentInfo(data.posterData[pid]);
		$(currentPoster).append($('#current-poster-info'));

		$(currentPoster).height(this.containerHeight).width(this.sw);
		$(currentPoster).css({
			left: (this.mainInfoPosition - this.sw).toString() + 'px',
			top: 0
		});
		$(currentPoster).attr({
			id: 'current-poster',
			class: 'posters'
		});
		$('#poster-container').prepend(currentPoster);

		$(currentImg).attr('src', 'upload/img1_' + data.posterData[pid].id + '.jpg').width('100%').height('100%');
		$(currentPoster).append(currentImg);

		$(currentHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover');
		$(currentPoster).prepend(currentHover);

		$(currentTitle).text('<' + data.posterData[pid].name + '>').addClass('poster-hover-title');
		$(currentHover).prepend(currentTitle);
		$(currentPoster).bind('mouseenter', currentHover, that.posterOver);
		$(currentPoster).bind('mouseleave', currentHover, that.posterOut);
		$(currentPoster).bind('click', that.posterClick);
		pid++;
	}

	this.createTopPosters = function(position, dir) {
		if (data.posterData.length <= pid) 
			return;
		var posterTop = document.createElement('div'),
				posterTopImg = document.createElement('img'),
				posterTopHover = document.createElement('div'),
				posterTopTitle = document.createElement('div'),
				poster = $(posterTop);
		poster.data('data', data.posterData[pid]);
	// main div
		poster.width(that.posterW).height(that.posterH);
		poster.css({
			left: position.toString() + 'px',
			top: 0
		});
		poster.attr({
			class: 'posters'
		});

		if (dir == 'right')
			$('#poster-container').append(posterTop);
		else 
			$('#poster-container').prepend(posterTop);
	// img div
		$(posterTopImg).attr('src', 'upload/img1_' + data.posterData[pid].id + '.jpg').width('100%').height('100%');
		poster.append(posterTopImg);
	// hover div
		$(posterTopHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover');
		poster.prepend(posterTopHover);
	// hover title div
		$(posterTopTitle).text('<' + data.posterData[pid].name + '>').addClass('poster-hover-title');
		$(posterTopHover).prepend(posterTopTitle);

		poster.bind('mouseenter', posterTopHover, that.posterOver);
		poster.bind('mouseleave', posterTopHover, that.posterOut);
		poster.bind('click', that.posterClick);
		pid++
	}

	this.createBottomPosters = function(position, dir) {
		if (data.posterData.length <= pid) 
			return;
		var	posterBottom = document.createElement('div'),
				posterBottomImg = document.createElement('img'),
				posterBottomHover = document.createElement('div'),
				posterBottomTitle = document.createElement('div'),
				poster = $(posterBottom);
		poster.data('data', data.posterData[pid]);
	// main part
		poster.width(that.posterW).height(that.posterH);
		poster.css({
			left: position.toString() + 'px',
			top: that.posterH.toString() + 'px'
		});
		poster.attr({
			class: 'posters'
		});

		if (dir == 'right')
			$('#poster-container').append(posterBottom);
		else 
			$('#poster-container').prepend(posterBottom);
	// img div
		$(posterBottomImg).attr('src', 'upload/img1_' + data.posterData[pid].id + '.jpg').width('100%').height('100%');
		poster.append(posterBottomImg);
	// hover div
		$(posterBottomHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover');
		poster.prepend(posterBottomHover);
	// hover title div
		$(posterBottomTitle).text('<' + data.posterData[pid].name + '>').addClass('poster-hover-title');
		$(posterBottomHover).prepend(posterBottomTitle);

		poster.bind('mouseenter', posterBottomHover, that.posterOver);
		poster.bind('mouseleave', posterBottomHover, that.posterOut);
		poster.bind('click', that.posterClick);
		pid++;
	}

	this.showMainInfo = function() {
		$('.posters').each(function(index, el) {
			var left = $(this).position().left;
			if (left + 1 >= that.mainInfoPosition) {
				left += 400;
				$(this).css('left', left + 'px');
			}
			$('#main-info-container').css('display', 'block');
		});
	}

	this.hideMainInfo = function(delta) {
		if (delta > 0) {
			delta = 400;
			$('.posters').each(function(index, el) {
				var left = $(this).position().left;
				if (left < that.mainInfoPosition) {
					left += delta;
					$(this).css('left', left + 'px');
				}
				setTimeout(function() {
					$('#main-info-container').css('display', 'none');
				}, 400);
			});
		}
		else {
			delta = -400; 
			$('.posters').each(function(index, el) {
				var left = $(this).position().left;
				if (left >= that.mainInfoPosition) {
					left += delta;
					$(this).css('left', left + 'px');
				}
				setTimeout(function() {
					$('#main-info-container').css('display', 'none');
				}, 400);
			});
		}
	}
/*
	this.scale = function() {
		$('#full-screen-poster').attr('src', 'upload/img1_' + $('#current-poster').data('data') + '.jpg');
	}*/

	this.slide = function() {
		if (that.lock == 1) return;
		that.lock = 1;
		setTimeout(function() {
			that.lock = 0;
		}, 400);
		if (this.id == 'left-button')
			var delta = that.posterW;
		else
			var delta = -that.posterW;

		if (delta < 0) {
			var left = $('.posters:last').position().left;
			if (left + that.posterW <= that.w) {
				showNotice("已经没有海报啦T T");
				return;
			}
			if (left < that.w) {
				if (data.posterData.length <= pid) {
					showNotice("已经没有海报啦T T");
				}
				else {
					left += that.posterW;
					that.createTopPosters(left, "right");
					that.createBottomPosters(left, "right");
					that.createTopPosters(left, "right");
					that.createBottomPosters(left, "right");
				}
			}
		} 
		else {
			var left = $('.posters:first').position().left;
			if (left >= 0) {
				showNotice("已经没有海报啦T T");
				return;
			}
			if (left + that.posterW > 0) {
				if (data.posterData.length <= pid) {
					showNotice("已经没有海报啦T T");
				}
				else {
					left -= that.posterW;
					that.createTopPosters(left, "left");
					that.createBottomPosters(left, "left");
					that.createTopPosters(left, "left");
					that.createBottomPosters(left, "left");
				}
			}
		}
		if ($('#main-info-container').css('display') != 'none') {
			that.hideMainInfo(delta);
		}
		else {
			$('.posters').each(function(index, el) {
				var left = $(this).position().left + delta;
				$(this).css('left', left + 'px');
			});
		}
	}

	this.slideProperPosition = function(target) {
		var targetLoc = $(target).position(),
		    currentLeft = $('#current-poster').position().left,
		    posters = $('.posters');
		if (targetLoc.left < currentLeft)
			var delta = (that.mainInfoPosition - that.sw) - targetLoc.left;
		else
			var delta = (that.mainInfoPosition - that.posterW) - targetLoc.left;
		if (delta == 0) return;

		if ($('#main-info-container').css('display') == 'none') {
			for (var i = 0; i < posters.length; i++) {
				var left = $(posters[i]).position().left;
				$(posters[i]).css('left', left + delta);
			}
		}
		else {
			for (var i = 0; i < posters.length; i++) {
				var left = $(posters[i]).position().left;
				if (delta > 0) {
					if (left < that.mainInfoPosition)
						$(posters[i]).css('left', left + delta);
					else
						$(posters[i]).css('left', left + delta - 400);
				}
				else {
					if (left > that.mainInfoPosition)
						$(posters[i]).css('left', left + delta);
					else 
						$(posters[i]).css('left', left + delta + 400);
				}
			}
		}
	}

	this.posterClick = function() {
		if (this === $('#current-poster')[0] || that.lock == 1) return;
		var target = this;
		that.lock = 1;
		$('#scale-button').css('display', 'none');
		that.slideProperPosition(target);
		setTimeout(function() {
			that.clickSlide(target);
		}, 400);
		data.vote.id = $(target).data('id');
		that.insertCurrentInfo($(target).data('data'));
		$(target).append($('#current-poster-info'));
	}

	this.clickSlide = function(target) {
		var targetLoc = $(target).position(),
		    currentLeft = $('#current-poster').position().left,
		    posters = $('.posters');
		var movePosters = [];

		for (var i = 0; i < posters.length; i++) {
			if (posters[i] === target || posters[i] === $('#current-poster')[0])
				continue;
			var loc = $(posters[i]).position();
			if (currentLeft < targetLoc.left) {
				var delta = Math.round((targetLoc.left - loc.left) / that.posterW);
				if (loc.left > targetLoc.left + 1 || loc.left + 1 < currentLeft)
					continue;
			}
			else {
				var delta = Math.round((loc.left - targetLoc.left) / that.posterW);
				if (loc.left + 1 < targetLoc.left || loc.left > currentLeft + 1)
					continue;
			}
			if (delta == 0) 
				movePosters[0] = posters[i];
			else {
				if (targetLoc.top == 0) {
					if (loc.top == 0)
						movePosters[delta * 2 - 1] = posters[i];
					else 
						movePosters[delta * 2] = posters[i];
				}
				else {
					if (loc.top == 0)
						movePosters[delta * 2] = posters[i];
					else 
						movePosters[delta * 2 - 1] = posters[i];
				}
			}
		}

		$(target).width(that.sw).height(that.containerHeight);
		if (currentLeft < targetLoc.left) {
			$(target).css({
				top: 0,
				left: targetLoc.left - that.posterW
			});
			setTimeout(function() {
				that.clickMove(movePosters, -that.sw, 0, target, targetLoc.top);
			}, moveSpeed);
		}
		else {
			$(target).css({
				top: 0
			});
			setTimeout(function() {
				that.clickMove(movePosters, that.sw, 0, target, targetLoc.top);
			}, moveSpeed);
		}
	}

	this.clickMove = function(posters, delta, i, target, top) {
		if (posters.length == 0)
			setTimeout(function() {
				that.changeCurrentPoster(target, oriDelta, top);
			}, moveSpeed / 2);
		var loc = $(posters[i]).position();
		var oriDelta = delta;
		if (i > 0 && i < posters.length - 1)
			delta /= 2;
		if (loc.top == 0) {
			$(posters[i]).css({
				top: that.posterH,
				left: loc.left + delta
			});
		}
		else {
			$(posters[i]).css({
				top: 0,
				left: loc.left + delta
			});
		}
		if (i < posters.length - 1)
			setTimeout(function() {
				that.clickMove(posters, oriDelta, i + 1, target, top);
			}, moveSpeed);
		else 
			setTimeout(function() {
				that.changeCurrentPoster(target, oriDelta, top);
			}, moveSpeed / 2);
	}

	this.changeCurrentPoster = function(target, delta, top) {
		var currentPoster = $('#current-poster');
		if (top == 0)
			currentPoster.css('top', that.posterH);
		if (delta > 0) {
			currentPoster.css('left', currentPoster.position().left + that.posterW);			
		}
		currentPoster.width(that.posterW).height(that.posterH);
		currentPoster.removeAttr('id');
		$(target).attr('id', 'current-poster');
		$('#scale-button').css('display', 'block');
		setTimeout(function() {
			that.showMainInfo();
			that.lock = 0;
		}, 400);
	}

	this.posterOver = function(e) {
		if ($(this).height() <= that.posterH + 1)
			$(e.data).animate({opacity: '0.6'}, 200);
		else 
			$('#current-poster-info').css('display', 'block').stop().animate({opacity: '0.6'}, 200);
	}

	this.posterOut = function(e) {
		$(e.data).animate({opacity: 0}, 200);
		$('#current-poster-info').css('display', 'none').stop().animate({opacity: '0'}, 200);
	}

	this.insertCurrentInfo = function(data) {
		var text = '';
		$('#current-poster-hover-content').text();
		for (var i = 0; i < data.members; i++) {
			text += " <" + data.m[i].name + "> ";
		}
		$('#current-poster-hover-content').text(text);
	}
/*
Vote part
*/
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
		if (!window.global_cfg.userobj) {
			showNotice("请先登录求是潮通行证");
			window.location.href = 'goLogin?redir=poster';
		}
		else {
			for (var i = 0; i < 5; i++) {
				if (data.vote[i] == 0) {
					showNotice("评分不能为0");
					return;
				}
			}
			data.postVote(that.voteAverage);
		}
	}

	this.voteAverage = function(voteData) {
		var div = $('.vote-average');
		for (var i = 0; i < 5; i++) {
			$(div[i]).text(voteData.vote_result[i].average_score);
		}
	}
}

function Data() {
	var that = this;
	this.posterData = [];
	this.vote = [0, 0, 0, 0, 0];

	// Ramdomize posters
	(function() {
		var i = page_cfg.poster.length, 
		    n;

		while (--i >= 0) {
			n = Math.floor(Math.random() * i);
			that.posterData[that.posterData.length] = page_cfg.poster[n];
			page_cfg.poster.splice(n, 1);
		}
	})();

	this.postPoster = function(e) {
		e.preventDefault();
		var settings = {
			target: "#submit-container",
			method: 'POST',
			url: baseUrl + 'index.php?ajax=json&action=submit_poster&random_token=' + window.global_cfg.random_token,
			dataType: 'json',
			success: function(data) {
				$('#submit-container button').removeAttr('disabled');
				if (data.code == 0) {
					showNotice("恭喜你！提交成功！");
				}
				else {
					showNotice("错误：" + data.msg);
				}
			},
			error: function(data) {
				showNotice("错误：" + data.msg);
				$('#submit-container button').removeAttr('disabled');

			}
		};
		$('#submit-container').ajaxSubmit(settings);
		$('#submit-container button').attr('disabled', 'true');
	}

	this.postVote = function(voteAverage) {
		var settings = {
			type: 'POST',
			url: baseUrl + 'postervote?ajax=json',
			dataType: 'json',
			data: {
				id: that.vote['id'],
				slug: ["vote1", "vote2", "vote3", "vote4", "vote5"],
				score: {
					vote1: that.vote[0],
					vote2: that.vote[1],
					vote3: that.vote[2],
					vote4: that.vote[3],
					vote5: that.vote[4],
				},
				random_token: window.global_cfg.random_token
			},
			success: function(data) {
				if (data.code == 0) {
					showNotice(data.msg);
					voteAverage(data);
				}
				else {
					showNotice("错误：" + data.msg);
				}
			},
			error: function(data) {
				showNotice("错误：" + data.msg);
			}
		};
		$.ajax(settings);
	}
}
