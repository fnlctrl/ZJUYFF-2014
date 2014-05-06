<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width, initial-scale=0.8, minimum-scale=0.8, maximum-scale=0.8'>
	<title>浙江大学青年电影节</title>
    <link rel="shortcut icon" href="favicon.png"/>
    <link rel='stylesheet' type='text/css' href='./css/global.css'>
	<link rel='stylesheet' type='text/css' href='./css/timeline.css'>
	<link rel='stylesheet' type='text/css' href='./css/nav.css'>
    <script>
        try {
            var global_cfg = <?php echo json_encode($view_obj->global_cfg);?>;
        } catch (e) {
            var global_cfg = {"random_token":"none_error"};
        }
        var page_cfg = <?php echo json_encode($view_obj->page_cfg);?>;
    </script>
	<script src='./js/jquery-2.1.0.min.js'></script>
	<script src='./js/global.js'/></script>
	<script src='./js/timeline.js'/></script>
	<script src='./js/nav.js'/></script>
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
		<div class='menu-item' id='menu-map'>
			<img id='menu-map-icon' class='svg left' src='./img/menu-map.svg'/>
			<a class='left' href='map'><span>地图</span></a>
		</div>
		<div class='menu-item comingsoon' id='menu-filmguide'>
			<img id='menu-filmguide-icon' class='svg left' src='./img/menu-filmguide.svg'/>
			<a class='left' href='' onclick='return false'><span>观影指南</span><div class='comingsoon-text'>COMING<br>SOON</div></a>
		</div>
	</div>
	<div id='main-container'>
		<div class='main-day'>
			<h2>5月4日</h2>
			<div class='main-event'>
				<img src='./img/timeline/告诉他们我乘白鹤去了.jpg'/>
				<p>《告诉他们，<br>我乘白鹤去了》<br>(开幕式)<br>国际会议中心 225<br>18:30-21:00</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月5日</h2>
			<div class='main-event'>
				<img src='./img/timeline/算命.jpg'/>
				<p>《算命》<br>小剧场B座209<br>18:30-21:00</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月9日</h2>
			<div class='main-event'>
				<img src='./img/timeline/四百击.jpg'/>
				<p>《四百击》<br>小剧场B座209<br>14:00-17:00</p>
			</div>
			<div class='main-event'>
				<img src='./img/timeline/日以作夜.jpg'/>
				<p>《日以作夜》<br>小剧场B座209<br>18:30-21:00</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月10日</h2>
			<div class='main-event'>
				<img src='./img/timeline/最后一班地铁.jpg'/>
				<p>《最后一班地铁》<br>小剧场B座209<br>14:00-17:00</p>
			</div>
			<div class='main-event'>
				<img src='./img/timeline/最后一班地铁.jpg'/>
				<p>杭州法语联盟<br>电影分析学者讲座<br>建工之家<br>14:00-17:00</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月11日</h2>
			<div class='main-event'>
				<img src='./img/timeline/郎在对门唱山歌.jpg'/>
				<p>《郎在对门唱山歌》<br>图书馆三楼文化空间<br>13:00-15:00</p>
			</div>
			<div class='main-event'>
				<img src='./img/timeline/她们的名字叫红.jpg'/>
				<p>《她们的名字叫红》<br>图书馆三楼文化空间<br>15:15-17:15</p>
			</div>
			<div class='main-event'>
				<img src='./img/timeline/最后一班地铁.jpg'/>
				<p>北京电影学院教授<br>章明讲座<br>图书馆三楼文化空间<br>19:00-20:30</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月16日</h2>
			<div class='main-event'>
				<img src='./img/timeline/归途列车.jpg'/>
				<p>《归途列车》<br>图书馆三楼文化空间<br>15:00-17:00</p>
			</div>
			<div class='main-event'>
				<img src='./img/timeline/最后一班地铁.jpg'/>
				<p>独立纪录片制片人韩轶<br>及影评人卫西谛讲座<br>图书馆三楼文化空间<br>19:00-20:30</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月17日</h2>
			<div class='main-event'>
				<img src='./img/timeline/千锤百炼.jpg'/>
				<p>《千锤百炼》<br>图书馆三楼文化空间<br>14:00-16:00</p>
			</div>
			<div class='main-event'>
				<img src='./img/timeline/最后一班地铁.jpg'/>
				<p>配音大赛决赛及<br>海报扮演大赛展示和颁奖<br>国际会议中心 223<br>18:30-21:00</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月18日</h2>
			<div class='main-event'>
				<img src='./img/timeline/活着.jpg'/>
				<p>《活着》<br>小剧场B座209<br>18:30-20:30</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月23日</h2>
			<div class='main-event'>
				<img src='./img/timeline/锤子镰刀都休息.jpg'/>
				<p>《锤子镰刀都休息》<br>建工之家<br>18:30-21:00</p>
			</div>
		</div>
		<div class='main-day'>
			<h2>5月24日</h2>
			<div class='main-event'>
				<img src='./img/timeline/最后一班地铁.jpg'/>
				<p>闭幕式暨<br>微电影展映和高校论坛<br>图书馆三楼文化空间<br>18:30-21:30</p>
			</div>
		</div>
	</div>
</body>
</html>
