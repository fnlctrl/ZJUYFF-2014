<!doctype>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin</title>
  <link rel="stylesheet" href="css/styles.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/moment.fn.js"></script>
  <script src="js/underscore-min.js"></script>
  <script src="js/myadmin.js"></script>
    <script>
        var global_cfg = <?php echo json_encode($view_obj->global_cfg);?>;
        var page_cfg = <?php echo json_encode($view_obj->page_cfg);?>;
    </script>
</head>
<body class="overview">
<?php
$view_obj = $view_obj->page_cfg;
echo '<h1 style="margin-left: 20px; font-weight: normal">';
echo $view_obj->view == 'dub' ? '配音大赛' : '海报扮演';
echo '</h1>';
?><span style="margin-left: 50px">当前报名人数：<?php echo count($view_obj->retarr);?></span>
<a id="exp-switch" style="margin-left: 40px; -webkit-user-select: none; -moz-user-select:none;  cursor: pointer; color: blue" onclick="switchAll();">全部展开</a> <?php if ($view_obj->view == 'poster') { ?><a href="myadmin?view=dub" style="margin-left: 20px">切换至配音大赛</a><?php } else { ?><a href="myadmin?view=poster" style="margin-left: 20px">切换至海报扮演</a><?php } ?>
<br>
  <pre>
<?php
if ($view_obj->view == 'dub') {
foreach ($view_obj->retarr as $value) {
?>
    <table id="obj-v<?php echo $value->id;?>">
        <tr class="name"><td><a href="#obj-v<?php echo $value->id;?>">队名</a></td><td><?php echo $value->team_name;?></td></tr>
        <tr class="method"><td>参赛方式 <a href="javascript:;" onclick="deleteWork('dub', <?php echo $value->id;?>, '<?php echo $value->team_name;?>')">删除</a></td><td><?php echo $value->method == 'online' ? '上传视频' : '现场演出';?></td></tr>
        <tr class="slogan"><td>参赛口号</td><td><?php echo $value->slogan;?></td></tr>
        <tr class="members"><td>团队人数</td><td><?php echo $value->members;?></td></tr>
        <tr class="time"><td>报名时间</td><td><?php echo $value->time;?></td></tr>
        <tr class="ip"><td>报名地址</td><td><?php echo $value->ip;?></td></tr>
<?php
    foreach ($value->teammate as $vvalue) {
?>
        <tr class="member-item"<?php if ($vvalue->leader == 1) echo ' must-disp="1" style="display: table-row"';?>><td>团队人员</td><td><?php echo $vvalue->name . ', ' . ($vvalue->leader ? '队长, ' : '') . $vvalue->phone . ', ' . $vvalue->email;?></td></tr>
<?php
    }
?>
    </table>
<?php
}

} else if ($view_obj->view == 'poster') {

foreach ($view_obj->retarr as $value) {
?>
    <table id="obj-v<?php echo $value->id;?>">
        <tr class="name"><td><a href="#obj-v<?php echo $value->id;?>">电影名称</a></td><td><?php echo $value->name;?> || <font color="green" style="font-size: 14px">得分：<?php echo $value->scores;?></font></td></tr>
        <tr class="members"><td>团队人数 <a href="javascript:;" onclick="deleteWork('poster', <?php echo $value->id;?>, '<?php echo $value->name;?>')">删除</a></td><td><?php echo $value->members;?></td></tr>
        <tr class="time"><td>报名时间</td><td><?php echo $value->time;?></td></tr>
        <tr class="ip"><td>报名地址</td><td><?php echo $value->ip;?></td></tr>
        <tr class="introduction"><td>作品介绍</td><td><?php echo $value->introduction;?></td></tr>
        <tr class="link-img1"><td>参赛作品</td><td><a href="<?php echo wrapImage(1, $value->id, isunknown($value->pictype1) ? $value->suffix1 : '.jpg');?>" target="_blank">点击查看参赛作品</a> <?php if (isunknown($value->pictype1)) echo "未知格式的图片";?></td></tr>
        <tr class="link-img2"><td>原版海报</td><td><a href="<?php echo wrapImage(2, $value->id, isunknown($value->pictype2) ? $value->suffix2 : '.jpg');?>" target="_blank">点击查看原版海报</a> <?php if (isunknown($value->pictype2)) echo "未知格式的图片";?></td></tr>
<?php
    foreach ($value->teammate as $vvalue) {
?>
        <tr class="member-item"<?php if ($vvalue->leader == 1) echo ' must-disp="1" style="display: table-row"';?>><td>团队人员</td><td><?php echo $vvalue->name . ', ' . ($vvalue->leader ? '队长, ' : '') . $vvalue->contact . ', ' . $vvalue->stuid;?></td></tr>
<?php
    }
?>
    </table>
<?php
}

}
?>
<?php
function wrapImage($type, $id, $suffix) {
    return 'upload/img' . $type . '_' . $id . $suffix;
}
?>
  </pre>
  <footer>
    <em>Admin for zjuyff</em>, from original joinus-admin by <a href="http://zenozeng.com" target="_blank">Zeno Zeng</a>, rewritten by <a href="http://www.senorsen.com" target="_blank">Senorsen</a>
  </footer>
</body>
</html>
