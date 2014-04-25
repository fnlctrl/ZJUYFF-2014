var pid = 0;
var baseUrl = '';

$(document).ready(function() {
	var data = new Data(),
	    view = new View(data);
	view.setElement();
	view.fillPosters();

	$(window).bind('load resize', function() {
		view.setElement();
		view.fillPosters();
	});
	$('#submit-container').submit(data.postPoster);
	$('#main-info-submit').click(view.clickSubmit);
	$('#main-info-vote').bind('click',view.vote)
	$('#submit-back-button').click(view.clickBack);
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


		// $('#container').height(this.containerHeight);
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
			data.getPoster(leftPosition, 'left', that.createPosters);
		}
		// create posters on the right
		var rightPosition = that.mainInfoPosition + 400,
		    rightCount = parseInt((that.w - rightPosition) / that.posterW) + 1;
		for (var i = 0; i<rightCount; i++) {
				data.getPoster(rightPosition, 'right', that.createPosters);
			rightPosition += that.posterW;
		}
	}

// insert current poster
	this.createCurrentPoster = function() {
		var currentPoster = document.createElement('div'),
				currentImg = document.createElement('img'),
				currentHover = document.createElement('div'),
				currentTitle = document.createElement('div');
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

		$(currentImg).attr('src', 'img/temp-posters/' + pid + '-cos.jpg').width('100%').height('100%');
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
		// $(currentPoster).bind('click', that.posterClick);
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
			$(posterTop).width(that.posterW).height(that.posterH);
			$(posterBottom).width(that.posterW).height(that.posterH);
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
				top: that.posterH.toString() + 'px'
			});
			$(posterBottom).attr({
				class: 'posters'
			});
			if (dir == 'right')
				$('#poster-container').append(posterTop).append(posterBottom);
			else 
				$('#poster-container').prepend(posterBottom).prepend(posterTop);
		// img div
			$(posterTopImg).attr('src', 'img/temp-posters/' + pid + '-cos.jpg').width('100%').height('100%');
			$(posterBottomImg).attr('src', 'img/temp-posters/' + (pid-1) + '-cos.jpg').width('100%').height('100%');
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
	this.posterData = {};
	this.vote = [0, 0, 0, 0, 0];
	this.vote.id = 2;

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

	this.getPoster = function(position, dir, success) {
		if (17 < pid) 
			return;
		else if (17  == pid ) {
			showNotice("已经没有海报啦 > <");
			pid ++;
			return;
		}
		else if (17 - 1 == pid) {
			pid ++;
		}
		else {
			pid += 2;
		}
		success(position, dir);
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