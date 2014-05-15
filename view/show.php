<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width, initial-scale=0.8, minimum-scale=0.8, maximum-scale=0.8'>
	<title>浙江大学青年电影节</title>
    <link rel="shortcut icon" href="favicon.png"/>
    <link rel='stylesheet' type='text/css' href='./css/global.css'>
	<link rel='stylesheet' type='text/css' href='./css/show.css'>
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
	<script src='./js/show.js'/></script>
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
				<li><a href='show' id='nav-show'>放映单元</a></li>
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
		<div class='main-green slide slide-selected shadow'>
			<div id='main-show-icon' class='main-icon main-icon-selected'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade' style='opacity:0'></div>
			<div class='main-title main-title-selected'>算命</div>
			<img class='main-poster' src='./img/filmposters/算命.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>　　历百程孤独半生，40多岁的时候碰到石珍珠——她因为残障，在老家倍受虐待，两人从此开始一起生活；他们住在北方某个城乡结合地带，历百程以替人算命维生。来找他算命的主顾常常是妓女，她们都各怀心事；因为冬天太冷，又碰上扫黄打非，老两口回到老家青龙。在那里，他们去过石珍珠的娘家，又回到历百程的老宅。</p>
				<p> 　　春天的时候，他们重新上路，赶赴庙会，等待时来运转……</p>
				<p>　　以长卷的篇幅，中国传统小说章回体的形式，《算命》的场景随人物转徙，在不同的地域空间提供的社会背景中，让人看到小人物微不足道，颠沛流离的人生以及其 中的人情世故。</p> 
				<p>　　在这个过程中，它试图洞彻人性。《算命》对残障和社会边缘人物的呈现，从不同角度，但象《麦收》一样，充满了道德挑战的味道。</p>
				<h3>选片理由</h3>
				<p>　　中国当代社会底层人物的现状和生存状况。片中每个在挣扎中生存的人物都让人难忘。视角克制，没有煽情和说教。细节丰富，既有可笑之处，也有感人之时。更多是让人默默叹惋。优秀的独立纪录片，展示中国最平凡最边缘人群状态。</p>
				<h3>放映场次</h3>
				<p>5月5日＼小剧场B座209＼18:30-21:00</p>
			</div>
			<div class='main-info'>
				<h3>导演　 主演</h3>
				<p>徐童　　历百程 / 石珍珠</p>
				<h3></h3>
				<p></p>
				<h3>荣获奖项</h3>
				<p>
					2011 第13届台北电影节——亚洲面面观单元<br>
					2011 西班牙－中国纪录电影交流展(依比利亚当代艺术中心)<br>
					2011 亚洲纪录片论坛——印度加尔各答<br>
					2011 现代艺术博物馆(MOMA)纪录片双周展——美国纽约<br>
					2011 第40届鹿特丹国际电影节——光明未来单元<br>
					2010 亚洲影评人联盟奖(NETPAC)<br>
					2010 第5届REEL CHINA当代中国纪录片双年展——美国纽约<br>
					2010 第29届温哥华国际电影节<br>
					2010 首尔数字电影节<br>
					2010 北京首届青年独立影像年度展<br>
					2010 香港华语纪录片节——长片组亚军<br>
					2010 第7届中国纪录片交流周——评委会奖<br>
					2009 第6届中国独立影像年度展CIFF——年度十佳纪录片<br>
					……<br>
				</p>
			</div>
		</div>
		<div class='main-blue slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade'></div>
			<div class='main-title'>郎在对门唱山歌</div>
			<img class='main-poster' src='./img/filmposters/郎在对门唱山歌.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>　　刘小漾从小喜欢音乐，为了能考上音乐学院，父亲刘在水聘请紫阳县剧团的冯冈做辅导。他们在学习过程中逐渐萌发了感情。几年后，小漾毕业，回到了县城。 张学锋与小漾青梅竹马，双方家长都希望他们交往，但小漾不同意，她因此与父亲大闹一场。一天，刘在水让小漾送喝醉的张学锋回宿舍。小漾醒来时，发现自己与张学峰睡在床上。她仓皇而逃。更令她伤心的是，她发现冯冈和他的表姐之间有暧昧的关系。她无法接受，就与张学锋在一起了。</p>
				<h3>选片理由</h3>
				<p>　　章明的影片不同于其它新生代的影片沉浸于喧闹的都市，他的影片反映了中国最具代表性的普通人的生活，对当代城镇普通人的命运给予深切的关注。《她们的名字叫红》获得上海国际电影节评委会大奖，《郎在对门唱山歌》同样获得上海国际电影节最佳女演员。影片质量上乘，充满人文关怀。</p>
				<h3>放映场次</h3>
				<p>5月11日＼图书馆三楼文化空间＼13:00-15:00</p>
			</div>
			<div class='main-info'>
				<h3>制片</h3><p>段鹏</p>
				<h3>编剧、导演</h3><p>章明</p>
				<h3>主演</h3><p>杰珂 / 吕星辰 / 冯国庆 / 孙凯 / 贾秀兰</p>
				<h3>荣获奖项</h3>
				<p>
					第14届上海国际电影节金爵奖 最佳影片(提名) 章明
					第14届上海国际电影节金爵奖 最佳女演员 吕星辰
					第12届华语电影传媒大奖最佳新演员(提名) 吕星辰
				</p>
			</div>
		</div>
		<div class='main-red slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade'></div>
			<div class='main-title'>她们的名字叫红</div>
			<img class='main-poster' src='./img/filmposters/她们的名字叫红.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>　　在三峡大坝的一个旅游船上，来自美国的青年卢卡斯（菲利普•伯卡特 饰）遇到王红（代汝茜 饰），她是一个很有抱负的空姐。卢卡斯立刻就决定把船票扔掉，开始追求这个可爱的女孩儿，可是到了巫山以后他发现王红找不到。邬警官（廖希 饰）承诺帮他找，但他一直忙自己的事，无暇顾及。功夫不负有心人，卢卡斯找到了王红，可是他俩并没有幸福地生活在一起。原因有两个：一个跟县里报社 宣传部的年轻女干事李红（邹琼帝 饰）有关、另一个是卢卡斯的护照过期了，这两个原因迫使卢卡斯必须回国。在美国他不得不重新考虑自己对王红的热情。
				</p>
				<h3>选片理由</h3>
				<p>　　章明的影片不同于其它新生代的影片沉浸于喧闹的都市，他的影片反映了中国最具代表性的普通人的生活，对当代城镇普通人的命运给予深切的关注。《她们的名字叫红》获得上海国际电影节评委会大奖，《郎在对门唱山歌》同样获得上海国际电影节最佳女演员。影片质量上乘，充满人文关怀。</p>
				<h3>放映场次</h3>
				<p>5月11日＼图书馆三楼文化空间＼15:15-17:15</p>
			</div>
			<div class='main-info'>
				<h3>导演</h3>
				<p>章明</p>
				<h3>编剧</h3>
				<p>秦海燕 / 章明</p>
				<h3>制片</h3>
				<p>李向红</p>
				<h3>主演</h3>
				<p>思远 / 代汝茜 / 邹琼帝 / 廖希</p>
				<h3>荣获奖项</h3>
				<p>上海国际电影节评委会特别大奖</p>
			</div>
		</div>
		<div class='main-orange slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade'></div>
			<div class='main-title'>归途列车</div>
			<img class='main-poster' src='./img/filmposters/归途列车.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>
					　　1990年，家住四川广安区回龙村的张昌华和陈素琴两夫妻为了能让家里过上更好的日子，也为了让张琴和张阳姐弟能接受良好的教育，有朝一日可以摆脱像他们一样在农村的艰苦生活，毅然离开一对幼年的双子女去广州打工。他们辛苦的赚钱往家里寄钱，几年才能回去和家人团聚一次过一个年。平时只能姥姥生活的姐弟对他们早已产生了生疏感和冷漠。但女人张琴像很多这个年纪的叛逆少年一样，不听劝告毅然退学，重蹈了父母的覆辙，从村里离家去广东打工……
				</p>
				<h3>选片理由</h3>
				<p>
					　　在娱乐煽情泛滥的年代，记录了中国的真实场景——春运人潮。中国年轻一代的价值观随着时代的变迁，和老一辈产生了极大的冲突。镜语精准多特写，代际之间穿插进行，人物性格鲜明表意明确，有完整的戏剧冲突结构，可看性极高。获《青年电影手册》2011年年度纪录片大奖及第33届“新闻及纪录片艾美奖” 最佳纪录片奖和最佳长篇商业报道等奖项。
				</p>
				<h3>放映场次</h3>
				<p>5月16日＼(改至)建工之家＼15:00-17:00</p>
			</div>
			<div class='main-info'>
				<h3>导演　　制片</h3>
				<p>范立欣　　韩轶</p>
				<h3>主演</h3>
				<p>陈素琴 / 张昌华 / 张琴</p>
				<h3>荣获奖项</h3>
				<p>
					2011 美国导演协会奖提名<br>
					2011《青年电影手册》年年度纪录片大奖<br>
					2010 圣丹斯电影节官方收录<br>
					2010 戛纳电视节亚洲尖兵奖<br>
					2010 洛杉矶影评人协会最佳纪录片奖<br>
					2010 维多利亚电影节最佳纪录片奖<br>
					2010 加拿大基尼奖<br>
					2009 阿姆斯特丹国际纪录片电影节最佳纪录长片奖<br>
					2009 RIDM电影节加拿大最佳电影<br>
					2009 英国同一世界媒体大奖<br>
					2009 旧金山国际电影节最佳纪录片金门奖<br>
					2009 洛杉矶亚美电影节评审团大奖、最佳摄影奖<br>
					2009 圣丹斯电影节评审团大奖提名<br>
					2009 巴黎Cinema du Réel电影节收录<br>
					第33届“新闻及纪录片艾美奖” 最佳纪录片奖和最佳长篇商业报道<br>
					……<br>
				</p>
			</div>
		</div>
		<div class='main-black slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade'></div>
			<div class='main-title'>千锤百炼</div>
			<img class='main-poster' src='./img/filmposters/千锤百炼.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>
					　　本片讲述了四川会理一个拳击教练和他的两个年轻徒弟的故事。齐漠祥是中国最早的职业拳击手，退役后一直在会理挑选适合拳击运动的孩子。拳击是他的信仰，为了拳击，他并不在意艰苦的条件和独身的生活。在他的精心调教下，门生何宗礼和缪云飞获得了一系列成绩，被选入省队，准备国家级比赛。齐漠祥虽然离开职业拳坛很久了，但他依然怀揣梦想，希望重新参加职业比赛，夺取金腰带称号。年近四十，齐漠祥开始努力恢复训练，准备参加在会理举办的WBC拳王争霸赛……
				</p>
				<h3>选片理由</h3>
				<p>
					　　获49届台北金马影展金马奖最佳纪录片，情节设计巧妙，完全不会让人感到生硬。剪辑和配乐流畅精确。不同于以往体育竞技片对于理想与励志情结的表现，本片更多的是无奈、是唏嘘，用轮回的方式展现赤裸裸的现实。不煽情、不罗嗦，结尾的戛然而止恰到好处，展示了中国青年的不同生活状态。
				</p>
				<h3>放映场次</h3>
				<p>5月17日＼(改至)建工之家＼14:00-16:00</p>
			</div>
			<div class='main-info'>
				<h3>导演</h3>
				<p>张侨勇</p>
				<h3>制片</h3>
				<p>韩轶</p>
				<h3>主演</h3>
				<p>齐漠祥 / 何宗礼 / 缪云飞 / 赵忠 / 叶新春</p>
				<h3>荣获奖项</h3>
				<p>
					第49届台北金马影展金马奖 最佳纪录片<br>
					第4届豆瓣电影鑫像奖鑫豆单元 最佳纪录长片(提名)<br>
				</p>
			</div>
		</div>
		<div class='main-red slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade'></div>
			<div class='main-title'>活着</div>
			<img class='main-poster' src='./img/filmposters/活着.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>
					　　叶红梅和祝俊生是汶川地震中幸存的一对夫妻，不幸的是，他们8岁的女儿在这场大地震中遇难。像叶红梅夫妇一样的家庭还有很多，2009年他们大多住在临时板房区等待家园重建，同时也希望能再次生育一个孩子，让死去的那个生命"轮回"到新生命中。叶红梅已经40岁，她却依然放弃领养而选择了试管婴儿受孕，这条再次孕育的路却十分不顺利。叶红梅的身体有些吃不消，不菲的营养费也让这个刚经历过灾难的家庭感到吃力。丈夫祝俊生却一直坚定的想要再生一个女儿，自从女儿遇难后他的内心一直为没能救出女儿而内疚不已，他渴望救赎。新生命会如夫妻俩期待那样降临吗？
				</p>
				<h3>选片理由</h3>
				<p>
					　　入围2011阿姆斯特丹国际纪录片节，一部纪念汶川地震的电影。铭记苦难，感恩生死。生命若不能停止，生活终需向前。再次让人看到面对苦难时女性的优势，男人可能会萎靡自责不知所措，女性却包容坚韧。导演说：生命无常，生命有常。一部会让大学生反思自己生存状态，珍惜现在生活的纪录片。
				</p>
				<h3>放映场次</h3>
				<p>5月18日＼小剧场B座209＼18:30-20:30</p>
			</div>
			<div class='main-info'>
				<h3>导演</h3>
				<p>范俭</p>
				<h3>制片</h3>
				<p>梁为超</p>
				<h3>荣获奖项</h3>
				<p>
					2011 中国（广州）国际纪录片节评审团特别奖<br>
					2011 阿姆斯特丹国际纪录片节 入围
				</p>
			</div>
		</div>
		<div class='main-green slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='shade'></div>
			<div class='main-title'>锤子镰刀都休息</div>
			<img class='main-poster' src='./img/filmposters/锤子镰刀都休息.jpg'/>
			<div class='main-text'>
				<h3>剧情简介</h3>
				<p>
					　　俩个做坏事的人遇到一个做坏事的人，他们团结起来一起做坏事，由于软弱他们做不成坏事。一个有信仰的人在几个做坏事人的周围生活着。这个电影讲的是一把锤子被包裹上毛巾的故事。我要拍的是一种软弱，这种软弱 随处可见，谁都有。在荒废的环境里一个荒唐的故事。 
				</p>
				<h3>放映场次</h3>
				<p>5月23日＼建工之家＼18:30-21:00</p>
			</div>
			<div class='main-info'>
				<h3>导演、编剧</h3>
				<p>耿军</p>
				<h3>主演</h3>
				<p>徐刚 / 张志勇 / 薛宝鹤 / 小二</p>
			</div>
		</div>
		<div id='main-truffaut' class='main-white slide shadow'>
			<div id='main-show-icon' class='main-icon'><img class='svg' src='./img/main-show.svg'/></div>
			<div class='main-title'>致敬特吕弗</div>
			<h2 id='main-truffaut-text'> 一个顽童，<br>吃下一个甜甜圈，<br>炸翻这个电影圈。<br>他还在安静而桀骜地砸吧着嘴。</h2>
			<img id='main-truffaut-bg' src='./img/show_bg_truffaut.jpg'>
			<a href='truffaut'><img id='main-truffaut-enter' src='./img/show_truffaut_enter.svg' class='svg'/></a>
		</div>
	</div>
</body>
</html>
