<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width, initial-scale=0.8, minimum-scale=0.8, maximum-scale=0.8'>
	<title>浙江大学青年电影节</title>
    <link rel="shortcut icon" href="favicon.png"/>
    <link rel='stylesheet' type='text/css' href='./css/global.css'>
	<link rel='stylesheet' type='text/css' href='./css/main.css'>
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
	<script src='./js/main.js'/></script>
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
		<div id='main-intro' class='slide slide-selected shadow'>
			<div class='shade shade-selected'></div>
			<img id='main-intro-logo' class='svg' src='./img/main-logo-big.svg'/>
			<div id='main-intro-title'><span style='color:#008cce'>浙江大学</span><br>第二届<br>青年电影节</div>
			<div id='main-intro-word'>
				<h2><span style='color:#008cce'>5月4日 - 5月24日</span></h3>
				你会相信，<br>
				银幕宠幸的不止是眼睛，
				大师爱慕的不会是繁杂流景。<br>
				这酝酿数月的圣餐的桌布上，绝不仅仅是那几部电影。<br>
				浙江大学第二届青年电影节，<br>
				让我们一起心无旁骛地沉迷。
			</div>
		</div>
		<div id='main-show' class='slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='main-title'>放映单元</div>
		</div>
		<div id='main-forum' class='slide shadow'>
			<div id='main-forum-icon' class='main-icon'><img class='svg' src='./img/main-forum.svg'/></div>
			<div class='main-title'>论坛讲座</div>
		</div>
		<div id='main-poster' class='slide shadow'>
			<div id='main-poster-icon' class='main-icon'><img class='svg' src='./img/main-poster.svg'/></div>
			<div class='main-title'>海报扮演大赛</div>
			<div class='main-word'>
				<p>曾经无数次游走在光与影的边缘，</p>
				<p>曾经无数次幻想成为胶片中的主角。</p>
				<p>这一次，请拿起手中的相机，</p>
				<p>换上新装，戴上面具，成为心中最爱的人物，</p>
				<p>把你的面庞印刻在独属于自己的海报中。</p>
				<br>
				<a href='./poster'>More...</a>
			</div>
			<img id='main-poster-bg' class='main-bg' src='./img/main-poster-bg.jpg'/>
		</div>
		<div id='main-dub' class='slide shadow'>
			<div id='main-dub-icon' class='main-icon'><img class='svg' src='./img/main-dub.svg'/></div>
			<div class='main-title'>配音大赛</div>
			<div class='main-word'>
				<p>旧影新词 以声启真。</p>
				<p>用你的声线重释一段对白，</p>
				<p>以你的思考演绎另一种精彩！</p>
				<p>恰到好处的声音是的游刃有余的磁极。</p>
				<p>现在你的面前，每一部都是聋哑的默片。</p>
				<p>你是玩家，所有人都是虔诚的听众。</p>
				<br>
				<a href='./dub'>More...</a>
			</div>
			<img id='main-poster-bg' class='main-bg' src='./img/main-dub-bg.jpg'/>
		</div>
	</div>
	<div id='footer-container'>
		<div id='footer-logo'><img src='./img/ZJU YOUTH FILM FESTIVAL_bold.svg' class='svg'/></div>
		<div id='footer-column-container'>
			<div class='footer-column'>
				<p class='footer-title'>主办</p>
				<a href='http://www.xgb.zju.edu.cn/'>浙江大学党委学工部</a>
				<p class='footer-title'>承办</p>
				<a href='http://www.qsc.zju.edu.cn/'>浙江大学求是潮</a>
			</div>
			<div class='footer-column'>
				<p class='footer-title'>合作单位</p>
				<p><a href='http://site.douban.com/211516/' target='_blank'>后窗放映</a></p>
				<p><a href='http://site.douban.com/177837/' target='_blank'>瓢虫映像</a></p>
				<p><a href='http://site.douban.com/afhangzhou/' target='_blank'>杭州法语联盟</a></p>
				<p><a href='http://www.cmic.zju.edu.cn/' target='_blank'>浙江大学传媒学院</a></p>
				<p><a href='http://www.zjicm.edu.cn/' target='_blank'>浙江传媒学院</a></p>
				<p><a href='http://www.zjut.edu.cn/' target='_blank'>浙江工业大学</a></p>
				<p><a href='http://www.hzedcm.com/' target='_blank'>E动传媒</a></p>
				<p><a href='http://hzdaily.hangzhou.com.cn/dskb/html/2014-04/05/node_85.htm' target='_blank'>都市快报</a></p>
			</div>
			<div class='footer-column'>
				<p class='footer-title'>关注我们</p>
				<a href='http://weibo.com/3427611600'><img class='svg' src='./img/footer-weibo-icon.svg'/></a>
				<a href='http://page.renren.com/601378976/'><img class='svg' src='./img/footer-renren-icon.svg'/></a>
				<p class='footer-title'>联系我们</p>
				<p>tide@myqsc.com</p>
			</div>
		</div>
		<p id='footer-copyright'>© 2014 浙江大学求是潮</p>
	</div>
</body>
</html>
