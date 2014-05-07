<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width, initial-scale=0.8, minimum-scale=0.8, maximum-scale=0.8'>
	<title>浙江大学青年电影节</title>
    <link rel="shortcut icon" href="favicon.png"/>
    <link rel='stylesheet' type='text/css' href='./css/global.css'>
	<link rel='stylesheet' type='text/css' href='./css/map.css'>
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
	<script src='./js/nav.js'/></script>
	<script src='./js/map.js'/></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=v7GyMQK42jBpPZnCI3KH4gpD"></script>
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
		<div class='menu-item' id='menu-timeline' onclick="location.reload();location.href='timeline'">
			<img id='menu-timeline-icon' class='svg left' src='./img/menu-timeline.svg'/>
			<span>时间轴</span>
		</div>
		<div class='menu-item' id='menu-map' onclick="location.reload();location.href='map'">
			<img id='menu-map-icon' class='svg left' src='./img/menu-map.svg'/>
			<span>地图</span>
		</div>
	</div>
	<div id='main-container'>
		<div id='zjumap'></div>
	</div>
</body>
</html>
