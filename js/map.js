$(window).bind('load',function() {
	 // 创建Map实例
	var map = new BMap.Map("zjumap",{minZoom:17,maxZoom:18});
	// 创建点坐标
	var centerPoint = new BMap.Point(120.093035, 30.310601);
	// 初始化地图,设置中心点坐标和地图级别。
	map.centerAndZoom(centerPoint,18);
	//启用滚轮放大缩小
	map.enableScrollWheelZoom();
	//设置地图样式
	var mapStyle ={ 
		features: ["road","building","water","land"],
	}
	map.setMapStyle(mapStyle);
	//添加默认缩放平移控件
	map.addControl(new BMap.NavigationControl());
	//添加标注信息,1为国会,2为建工,3为图书馆,4为小剧场
	var point1 = new BMap.Point(120.096759, 30.310005);
	var point2 = new BMap.Point(120.090309, 30.307588);
	var point3 = new BMap.Point(120.095375, 30.310005);
	var point4 = new BMap.Point(120.09268, 30.310013);
	var icon1 = new BMap.Icon('./img/map_conventionCenter.svg',new BMap.Size(80, 40));
	var icon2 = new BMap.Icon('./img/map_anzhong.svg',new BMap.Size(80, 40));
	var icon3 = new BMap.Icon('./img/map_library.svg',new BMap.Size(120, 40));
	var icon4 = new BMap.Icon('./img/map_theater.svg',new BMap.Size(40, 40));
	var marker1 = new BMap.Marker(point1,{icon: icon1}); 
	var marker2 = new BMap.Marker(point2,{icon: icon2}); 
	var marker3 = new BMap.Marker(point3,{icon: icon3}); 
	var marker4 = new BMap.Marker(point4,{icon: icon4}); 
	map.addOverlay(marker1); 
	map.addOverlay(marker2); 
	map.addOverlay(marker3); 
	map.addOverlay(marker4); 
	//设置信息窗口内容
	var content1 = "<div style='font-family:'Microsoft Yahei'>"+
		"<h2 style='margin:-0.1em 0 0 0'>国际会议中心 223</h2>"+
		"<h3 style='color:#0085c7;margin:15px 0 0 0'>配音大赛决赛及<br>海报扮演大赛展示和颁奖</h3>"+
		"<p style='font-size:14px'>5月17日<br>18:30-21:00</p>"+
	"</div>"
	var content2 = "<div style='font-family:'Microsoft Yahei';width:300px'>"+
		"<h2 style='margin:-0.1em 0 0 0'>建工之家</h2>"+
		"<h3 style='color:#e25520;margin:15px 0 0 0'>杭州法语联盟<br>电影分析学者讲座</h3>"+
		"<p style='font-size:14px;margin:0'>5月10日<br>18:30-21:00</p>"+
		"<h3 style='color:#00803c;margin:15px 0 0 0'>《锤子镰刀都休息》</h3>"+
		"<p style='font-size:14px'>5月23日<br>18:30-21:00</p>"+
	"</div>"
	var content3 = "<div style='font-family:'Microsoft Yahei';>"+
	"<h2 style='margin:-0.1em 0 0 0'>图书馆三楼文化空间</h2>"+
		"<div style='width:200px;float:left;'>"+
			"<h3 style='color:#00803c;margin:15px 0 0 0'>《郎在对门唱山歌》</h3>"+
			"<p style='font-size:14px'>5月11日<br>13:00-15:00</p>"+
			"<h3 style='color:#00803c;margin:15px 0 0 0'>《她们的名字叫红》</h3>"+
			"<p style='font-size:14px'>5月11日<br>15:15-17:15</p>"+
			"<h3 style='color:#e25520;margin:15px 0 0 0'>北京电影学院教授<br>章明讲座</h3>"+
			"<p style='font-size:14px'>5月11日<br>19:00-20:30</p>"+
			"<h3 style='color:#00803c;margin:15px 0 0 0'>《归途列车》</h3>"+
			"<p style='font-size:14px'>5月16日<br>15:00-17:00</p>"+
		"</div>"+
		"<div style='font-family:'Microsoft Yahei';width:100px;float:left'>"+
			"<h3 style='color:#e25520;margin:15px 0 0 0'>独立纪录片制片人韩轶<br>及影评人卫西谛讲座</h3>"+
			"<p style='font-size:14px'>5月16日<br>19:00-20:30</p>"+
			"<h3 style='color:#00803c;margin:15px 0 0 0'>《千锤百炼》</h3>"+
			"<p style='font-size:14px'>5月17日<br>14:00-16:00</p>"+
			"<h3 style='color:#0085c7;margin:15px 0 0 0'>闭幕式暨<br>微电影展映和高校论坛</h3>"+
			"<p style='font-size:14px'>5月24日<br>18:30-21:30</p>"+
		"</div>"+
	"</div>"
	var content4 = "<div style='font-family:'Microsoft Yahei';width:300px'>"+
		"<h2 style='margin:-0.1em 0 0 0'>小剧场B座209</h2>"+
		"<h3 style='color:#00803c;margin:15px 0 0 0'>《算命》</h3>"+
		"<p style='font-size:14px'>5月5日<br>18:30-21:00</p>"+
		"<h3 style='color:#00803c;margin:15px 0 0 0'>《四百击》</h3>"+
		"<p style='font-size:14px'>5月9日<br>14:00-17:00</p>"+
		"<h3 style='color:#00803c;margin:15px 0 0 0'>《日以作夜》</h3>"+
		"<p style='font-size:14px'>5月9日<br>18:30-21:00</p>"+
		"<h3 style='color:#00803c;margin:15px 0 0 0'>《最后一班地铁》</h3>"+
		"<p style='font-size:14px'>5月10日<br>14:00-17:00</p>"+
		"<h3 style='color:#00803c;margin:15px 0 0 0'>《活着》</h3>"+
		"<p style='font-size:14px'>5月18日<br>18:30-20:30</p>"+
	"</div>"
	//创建信息窗口对象并监听click事件
	var infoWindow1 = new BMap.InfoWindow(content1,{width:250}); 
	marker1.addEventListener("click", function(){
		this.openInfoWindow(infoWindow1);
		//图片加载完毕重绘infowindow
		// document.getElementById('imgDemo').onload = function (){
		// 	infoWindow1.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
		// }
	});
	var infoWindow2 = new BMap.InfoWindow(content2,{width:250}); 
	marker2.addEventListener("click", function(){
		this.openInfoWindow(infoWindow2);
	});
	var infoWindow3 = new BMap.InfoWindow(content3,{width:420,height:400}); 
	marker3.addEventListener("click", function(){
		this.openInfoWindow(infoWindow3);
	});
	var infoWindow4 = new BMap.InfoWindow(content4,{width:250,height:600}); 
	marker4.addEventListener("click", function(){
		this.openInfoWindow(infoWindow4);
	});
})
