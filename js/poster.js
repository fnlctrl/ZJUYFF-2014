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
	$('#vote-submit-button').bind('click', view.postVote);
	$('#left-button, #right-button').bind('click', view.slide);
	$('.file').bind('change', view.showSubmitImg);
});

function View(data) {
// set element width and height
	var that = this;
	var speed = 200;
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

	this.showSubmitImg = function() {
		var oFReader = new FileReader();
		var itself = this;
		oFReader.onload = function (oFREvent) {
		  $(itself).next().attr('src', oFREvent.target.result);
		};

		if (this.files.length === 0) { return; }
		var oFile = this.files[0];
		if (!oFile.type.match('image.jpeg')) { 
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

		$(currentImg).attr('src', 'upload/img1_' + data.posterData[pid].id + '.jpg').width('100%').height('100%');
		$(currentPoster).append(currentImg);

		$(currentHover).width('100%').height(that.posterH / 5 * 2).addClass('poster-hover');
		$(currentPoster).prepend(currentHover);

		$(currentTitle).text('<' + data.posterData[pid].name + '>').addClass('poster-hover-title');
		$(currentHover).prepend(currentTitle);
		$(currentPoster).bind('mouseenter', currentHover, that.posterOver);
		$(currentPoster).bind('mouseleave', currentHover, that.posterOut);
		// $(currentPoster).bind('click', that.posterClick);
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
			position: 'absolute',
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
			position: 'absolute',
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

	this.hideMainInfo = function() {
		$('.posters').each(function(index, el) {
			var left = $(this).position().left;
			if (left > that.mainInfoPosition) {
				left -= 400;
				$(this).css('left', left + 'px');
			}
			setTimeout(function() {
				$('#main-info-container').css('display', 'none');
			}, speed);
		});
	}

	this.showMainInfo = function() {
		$('.posters').each(function(index, el) {
			var left = $(this).position().left;
			if (left >= that.mainInfoPosition) {
				left += 400;
				$(this).css('left', left + 'px');
			}
			setTimeout(function() {
				$('#main-info-container').css('display', 'block');
			}, speed);
		});
	}

	this.slide = function() {
		if (this.id == 'left-button')
			var delta = -400;
		else
			var delta = 400;

		if (delta < 0) {
			var left = $('.posters:last').position().left;
			if (left < that.w) {
				if (data.posterData.length <= pid) {
					showNotice("已经没有海报啦T T");
					return;
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
			if (left + that.posterW > 0) {
				if (data.posterData.length <= pid) {
					showNotice("已经没有海报啦T T");
					return;
				}
				else {
					that.createTopPosters(left, "left");
					that.createBottomPosters(left, "left");
					that.createTopPosters(left, "left");
					that.createBottomPosters(left, "left");
				}
			}
		}
		that.hideMainInfo();
		$('.posters').each(function(index, el) {
			var left = $(this).position().left + delta;
			$(this).css('left', left + 'px');
		});
	}

	this.slideProperPosition = function() {

	}

	this.posterOver = function(e) {
		if ($(this).height() <= that.posterH + 1)
			$(e.data).animate({opacity: '0.6'}, 200);
	}

	this.posterOut = function(e) {
		$(e.data).animate({opacity: 0}, 200);
	}

/*Vote part
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
		if (id.length != 10)
			showNotice("请填写正确的学号");
		else data.postVote();
	}
}

function Data() {
	var that = this;
	this.posterData = [];
	this.vote = [0, 0, 0, 0, 0];
	this.vote.id = 2;

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