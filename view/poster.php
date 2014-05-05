<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>海报扮演 - 浙江大学青年电影节</title>
	<link rel="shortcut icon" href="favicon.png"/>
    <link rel="stylesheet" type="text/css" href="./css/global.css">
	<link rel="stylesheet" type="text/css" href="./css/ui.css">
	<link rel="stylesheet" type="text/css" href="./css/poster.css">
	<link rel="stylesheet" type="text/css" href="./css/nav.css">
    <script>
        try {
            var global_cfg = <?php echo json_encode($view_obj->global_cfg);?>;
        } catch (e) {
            var global_cfg = {"random_token":"none_error"};
        }
        var page_cfg = <?php echo json_encode($view_obj->page_cfg);?>;
    </script>
	<script src="./js/jquery-2.1.0.min.js"></script>
	<script src="./js/jquery.form.min.js"></script>
	<script src="./js/global.js"></script>
	<script src="./js/poster.js"></script>
	<script src="./js/nav.js"></script>
</head>
<body>
	<div id='nav-bar'>
		<div id='nav-sections'>
			<ul>
				<li><a href='dub' id='nav-dub'>配音大赛</a></li>
				<li><a href='poster' id='nav-poster'>海报扮演</a></li>
				<li>
					<a href='forum' id='nav-forum' class='comingsoon' onclick='return false'>
						<span>论坛讲座</span>
						<div class='comingsoon-text'>COMING<br>SOON</div>
					</a>
				</li>
				<li>
					<a href='show' id='nav-show' class='comingsoon' onclick='return false'>
						<span>放映单元</span>
						<div class='comingsoon-text'>COMING<br>SOON</div>
					</a>
				</li>
			</ul>
		</div>
		<img id='nav-menu-icon' class='svg' src='img/menu.svg'/>
		<a id='nav-logo' href='./'><img class='svg' src='img/FilmFestivalLogo.svg'/></a>
		<div id='nav-name'><img class='svg' src='img/ZJU YOUTH FILM FESTIVAL.svg'/></div>
	</div>
	<div id='nav-menu'>
		<div class='menu-item comingsoon' id='menu-timeline'>
			<img id='menu-timeline-icon' class='svg left' src='./img/menu-timeline.svg'/>
			<a class='left' href='' onclick='return false'><span>时间轴</span><div class='comingsoon-text'>COMING<br>SOON</div></a>
		</div>
		<div class='menu-item comingsoon' id='menu-map'>
			<img id='menu-map-icon' class='svg left' src='./img/menu-map.svg'/>
			<a class='left' href='' onclick='return false'><span>地图</span><div class='comingsoon-text'>COMING<br>SOON</div></a>
		</div>
		<div class='menu-item comingsoon' id='menu-filmguide'>
			<img id='menu-filmguide-icon' class='svg left' src='./img/menu-filmguide.svg'/>
			<a class='left' href='' onclick='return false'><span>观影指南</span><div class='comingsoon-text'>COMING<br>SOON</div></a>
		</div>
	</div>
	<div id="container">
		<form id="submit-container" action="upload.php">
			<div id="submit-info">
				<p class='submit-info-title'>参赛信息</p>
				<input class='w380' type="text" name="name" placeholder="电影名称" required>
				<p class='submit-info-title'>成员信息(至多7人)</p>
				<input class='w120' type="text" name="name1" placeholder="队长姓名" required>
				<input class='w120' type="text" name="stuid1" placeholder="学号" required>
				<input class='w120' type="text" name="contact1" placeholder="手机" required>
				<input class='w120' type="text" name="name2" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid2" placeholder="学号">
				<input class='w120' type="text" name="contact2" placeholder="手机">
				<input class='w120' type="text" name="name3" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid3" placeholder="学号">
				<input class='w120' type="text" name="contact3" placeholder="手机">
				<input class='w120' type="text" name="name4" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid4" placeholder="学号">
				<input class='w120' type="text" name="contact4" placeholder="手机">
				<input class='w120' type="text" name="name4" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid4" placeholder="学号">
				<input class='w120' type="text" name="contact4" placeholder="手机">
				<input class='w120' type="text" name="name5" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid5" placeholder="学号">
				<input class='w120' type="text" name="contact5" placeholder="手机">
				<input class='w120' type="text" name="name6" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid6" placeholder="学号">
				<input class='w120' type="text" name="contact6" placeholder="手机">
				<input class='w120' type="text" name="name7" placeholder="队员姓名">
				<input class='w120' type="text" name="stuid7" placeholder="学号">
				<input class='w120' type="text" name="contact7" placeholder="手机">
				<p class="submit-info-title">作品介绍</p>
				<textarea class="w380" maxlength="140" placeholder="140字以内" name="introduction"></textarea>
				<button class="button" type="submit">提交</button>
			</div>
			<div id="submit-poster">
				<p id="submit-poster-title">参赛作品</p>
				<input id="submit-poster-button" class="file" type="file" name="img1">
				<img>
				<div id="submit-poster-content">
					<p>长宽比2:3</p>
					<p>JPG,PNG,BMP,GIF<br>格式静态图片</p>
					<p>(3MB以内)</p>
				</div>
			</div>
			<div id="submit-origin-poster">
				<p id="submit-origin-poster-title">原版海报</p>
				<input id="submit-origin-poster-button" class="file" type="file" name="img2">
				<img>
			</div>
		</form>
		<div id="main-info-container">
			<div id="main-info">
				<p id="main-info-subtitle">浙江大学第二届青年电影节</p>
				<p id="main-info-title">海报扮演大赛</p>
				<span id="main-info-content">
					<p>曾经无数次幻想成为胶片中的主角
					<p>这一次，请拿起手中的相机</p>
					<p>换上新装</p>
					<p>戴上面具</p>
					<p>成为心中最爱的人物</p>
					<p>把你的面庞印刻在独属于自己的海报中</p>
				</span>
				<span id="main-submit-info">
					<p>参赛奖品:</p>
					<p>电影节精美纪念品+第二课堂加分</p>
					<br>
					<p>截止时间:</p>
					<p>5月5日晚23:59分</p>
				</span>
				<div id="main-info-submit" class="button">我要参加</div>
				<div id="main-info-vote" class="button">我要投票</div>
			</div>
			<div id="vote-container">
				<div id="vote-content">
					<p>每个求是潮通行证只有一次投票机会，</p>
					<p>提交后无法更改</p>
				</div>
				<div id="vote-box">
					<div class="vote-box" id="vote-s1">
						<p>创新维度</p>
						<div class="star-box">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
						</div>
						<span class="vote-average"></span>
					</div>
					<div class="vote-box" id="vote-s2">
						<p>逼真维度</p>
						<div class="star-box">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
						</div>
						<span class="vote-average"></span>
					</div>
					<div class="vote-box" id="vote-s3">
						<p>技术维度</p>
						<div class="star-box">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
						</div>
						<span class="vote-average"></span>
					</div>
					<div class="vote-box" id="vote-s4">
						<p>艺术维度</p>
						<div class="star-box">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
						</div>
						<span class="vote-average"></span>
					</div>
					<div class="vote-box" id="vote-s5">
						<p>出位维度</p>
						<div class="star-box">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
							<img class="svg star" src="./img/star.svg">
						</div>
						<span class="vote-average"></span>
					</div>
				</div>
				<div id="vote-id-container">投票前请先登录求是潮通行证</div>
				<div id="vote-submit" class="button vote-submit-button"></div>
				<div id="vote-submit-back" class="button vote-submit-button">返回</div>
			</div>
		</div>
		<div id="poster-container">
		</div>
		<div id="left-button" class="poster-button"></div>
		<div id="right-button" class="poster-button"></div>
		<div id="scale-button"></div>
		<div id="current-poster-info">
			<div id="current-poster-hover-title">小组成员</div>
			<div id="current-poster-hover-content"></div>
		</div>
	</div>
	<div id="full-screen">
		<div id="full-screen-container">
			<img id="full-screen-poster">
			<img id="full-screen-origin">
		</div>
	</div>
</body>
</html>
