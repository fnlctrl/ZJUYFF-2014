<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width, initial-scale=0.8, minimum-scale=0.8, maximum-scale=0.8'>
    <title>配音大赛 - 浙江大学青年电影节</title>
    <link rel="shortcut icon" href="favicon.png"/>
	<link rel='stylesheet' type='text/css' href='./css/global.css'>
	<link rel='stylesheet' type='text/css' href='./css/ui.css'>
	<link rel='stylesheet' type='text/css' href='./css/dub.css'>
	<link rel='stylesheet' type='text/css' href='./css/nav.css'>
    <script>
        try {
            var global_cfg = <?php echo json_encode($view_obj->global_cfg);?>;
        } catch (e) {
            var global_cfg = {"random_token":"error??? pu, we don't know."};
        }
        var page_cfg = <?php echo json_encode($view_obj->page_cfg);?>;
    </script>
	<script src='./js/jquery-2.1.0.min.js'></script>
	<script src='./js/global.js'></script>
	<script src='./js/dub.js'></script>
	<script src='./js/nav.js'></script>
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
	<div id='main-container'>
		<div id='main-intro-container'>
			<div id='main-intro'>
				<p id='main-intro-subtitle'>求是潮第七届「魅 · 声色」</p>
				<p id='main-intro-title'>配音大赛</p>
				<span id='main-intro-text1'>
					<p>旧影新词，以声启真。</p>
					<p>用你的声线重释一段对白，</p>
					<p>以你的思考演绎另一种精彩！</p>
					<p>恰到好处的声音是的游刃有余的磁极。</p>
					<p>现在你的面前，每一部都是聋哑的默片。</p>
					<p>你是玩家，所有人都是虔诚的听众。</p>	
					<p><br>二课加分、《指环王》英文原版全集、</p>
					<p>老式留声机——大奖等你拿！</p>
				</span>
				<span id='main-intro-text2'>
					<p>评选标准:</p>
					<p>语言清晰流畅准确，速度与画面基本一致，</p>
					<p>协调性好。</p>
					<p>自创内容与整个画面情景比较符合，</p>
					<p>情节完整，清晰。</p>
					<p>有独特的语言风格，较好传递配音者意图。</p>
					<p>创新性、可看性较强，能引起共鸣为佳。</p>
					<p>没有疑似抄袭内容，全部原创。</p>
				</span>
				<div id='main-intro-buttons'>
					<div id='main-intro-join' class='button'>我要参加</div>
					<div id='main-intro-vote' class='button' disabled>我要投票</div>
				</div>
			</div>
		</div>
		<div id='main-info-container'>
			<div class='main-info-item'>
				<img class='ring' id='main-ring-1' src='./img/dub-ring-1.svg'/>
				<p class='main-info-caption'>线上报名启动</p>
			</div>
			<div class='main-info-item'>
				<img class='ring' id='main-ring-2' src='./img/dub-ring-2.svg'/>
				<p class='main-info-caption'>文广现宣</p>
			</div>
			<div class='main-info-item'>
				<img class='ring' id='main-ring-3' src='./img/dub-ring-3.svg'/>
				<p class='main-info-caption'>作品上传截止<br>开始线上投票</p>
			</div>
			<div class='main-info-item'>
				<img class='ring' id='main-ring-4' src='./img/dub-ring-4.svg'/>
				<p class='main-info-caption'>投票截止<br>决赛通知</p>
			</div>
			<div class='main-info-item'>
				<img class='ring' id='main-ring-5' src='./img/dub-ring-5.svg'/>
				<p class='main-info-caption'>文广现宣<br>发放决赛门票</p>
			</div>
			<div class='main-info-item'>
				<img class='ring' id='main-ring-6' src='./img/dub-ring-6.svg'/>
				<p class='main-info-caption'>决赛</p>
			</div>
		</div>
		<img id='main-bg' src='./img/dub-bg.jpg'/>
		<form id='main-form-container'>
			<div id='main-form'>
				<p class='main-form-title'>团队信息</p>
				<input class='w120' type='text' name='team-name' placeholder='团队名称' required/>
				<input class='w330' type='text' name='team-slogan' placeholder='团队口号' required/>
				<p class='main-form-title'>成员信息(至多7人)</p>
				<input class='w120' type='text' name='name-captain' placeholder='队长姓名' required/>
				<input class='w120' type='text' name='mobile-captain' placeholder='手机' required/>
				<input class='w200' type='text' name='email-captain' placeholder='邮箱' required/><br>
				<input class='w120' type='text' name='name-teammate1' placeholder='队员姓名'/>
				<input class='w120' type='text' name='mobile-teammate1' placeholder='手机'/>
				<input class='w200' type='text' name='email-teammate1' placeholder='邮箱'/><br>
				<input class='w120' type='text' name='name-teammate2' placeholder='队员姓名'/>
				<input class='w120' type='text' name='mobile-teammate2' placeholder='手机'/>
				<input class='w200' type='text' name='email-teammate2' placeholder='邮箱'/><br>
				<input class='w120' type='text' name='name-teammate3' placeholder='队员姓名'/>
				<input class='w120' type='text' name='mobile-teammate3' placeholder='手机'/>
				<input class='w200' type='text' name='email-teammate3' placeholder='邮箱'/><br>
				<input class='w120' type='text' name='name-teammate4' placeholder='队员姓名'/>
				<input class='w120' type='text' name='mobile-teammate4' placeholder='手机'/>
				<input class='w200' type='text' name='email-teammate4' placeholder='邮箱'/><br>
				<input class='w120' type='text' name='name-teammate5' placeholder='队员姓名'/>
				<input class='w120' type='text' name='mobile-teammate5' placeholder='手机'/>
				<input class='w200' type='text' name='email-teammate5' placeholder='邮箱'/><br>
				<input class='w120' type='text' name='name-teammate6' placeholder='队员姓名'/>
				<input class='w120' type='text' name='mobile-teammate6' placeholder='手机'/>
				<input class='w200' type='text' name='email-teammate6' placeholder='邮箱'/><br>
				<p class='main-form-title'>参赛方式</p>
				<input type='radio' value='online' name='method' required/><span class='main-form-text'>上传视频</span>
				<input type='radio' value='live' name='method' required/><span class='main-form-text'>现场演出</span>
				<button id='main-form-submit' class='button' type='submit'>提交报名表</button>
				<br><br>
				<p class='main-form-text'>注:</p>
				<p class='main-form-text'>若选择"上传视频"，请在报名截止前将配音视频发送至tide@myqsc.com</p>
				<p class='main-form-text'>邮件标题格式: [配音大赛][团队名称][队长姓名]</p>
			</div>
		</form>
	</div>
</body>
</html>
